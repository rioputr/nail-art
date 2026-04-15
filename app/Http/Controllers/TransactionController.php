<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;

class TransactionController
{
    /**
     * Menampilkan halaman checkout/pembayaran.
     * @return \Illuminate\View\View
     */
    public function checkout()
    {
        $cartItems = session()->get('cart', []);
        $totalAmount = 0;
        foreach($cartItems as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }
        
        return view('transaction.checkout', compact('cartItems', 'totalAmount'));
    }

    /**
     * Memproses pembayaran dan membuat transaksi baru.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processCheckout(Request $request)
    {
        $request->validate([
            'phone' => 'nullable|string|max:20',
            'address' => 'required|string',
            'payment_method' => 'required',
        ]);

        $cartItems = session()->get('cart', []);
        if (empty($cartItems)) {
            return redirect()->route('shop.index')->with('error', 'Keranjang Anda kosong.');
        }

        $totalAmount = 0;
        foreach($cartItems as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }

        // Handle Receipt Upload
        $receiptPath = null;
        if ($request->hasFile('payment_receipt')) {
            $receiptPath = $request->file('payment_receipt')->store('receipts', 'public');
        }

        // Update User Profile Address and Phone if provided
        $user = Auth::user();
        $user->update([
            'phone' => $request->phone ?? $user->phone,
            'address' => $request->address,
        ]);

        // Simulasikan pembuatan transaksi
        $transaction = Transaction::create([
            'user_id' => Auth::id(),
            'transaction_code' => 'TRX-' . strtoupper(bin2hex(random_bytes(4))),
            'total_amount' => $totalAmount,
            'payment_method' => $request->payment_method,
            'status' => ($receiptPath) ? 'paid' : 'pending', // Jika ada bukti, anggap bayar (simulasi)
            'payment_receipt' => $receiptPath,
            'shipping_address' => $request->address,
        ]);

        // Simpan Item
        foreach($cartItems as $id => $details) {
            \App\Models\TransactionItem::create([
                'transaction_id' => $transaction->id,
                'product_id' => $id,
                'quantity' => $details['quantity'],
                'price' => $details['price'],
                'subtotal' => $details['price'] * $details['quantity']
            ]);
        }

        // Kosongkan Keranjang
        session()->forget('cart');
        
        return redirect()->route('transactions.detail', $transaction->id)->with('success', 'Pembayaran berhasil dan pesanan diproses!');
    }

    /**
     * Menampilkan riwayat transaksi pengguna (sesuai Transaction Shop History.jpg).
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $transactions = Auth::user()->transactions()->latest()->get();
        return view('transaction.history', compact('transactions')); //
    }
    
    /**
     * Menampilkan detail satu transaksi.
     * @param  Transaction $transaction
     * @return \Illuminate\View\View
     */
    public function show(Transaction $transaction)
    {
        // Pastikan pengguna hanya bisa melihat transaksi miliknya sendiri
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }
        return view('transaction.show', compact('transaction'));
    }

    public function uploadReceipt(Request $request, Transaction $transaction)
    {
        $request->validate([
            'payment_receipt' => 'required|image|max:2048'
        ]);

        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        $receiptPath = $request->file('payment_receipt')->store('receipts', 'public');
        
        $transaction->update([
            'payment_receipt' => $receiptPath,
            'status' => 'paid'
        ]);

        return redirect()->back()->with('success', 'Bukti transfer berhasil diunggah!');
    }
}