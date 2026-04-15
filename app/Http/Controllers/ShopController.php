<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ShopController
{
    
    /**
     * Menampilkan halaman daftar produk toko (sesuai Shop.jpg).
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Start query
        $query = Product::where('stock', '>', 0);
        
        // Apply sorting
        $sortBy = $request->get('sort_by', 'terbaru');
        
        switch($sortBy) {
            case 'termurah':
                $query->orderBy('price', 'asc');
                break;
            case 'termahal':
                $query->orderBy('price', 'desc');
                break;
            case 'populer':
                $query->orderBy('is_popular', 'desc')->latest();
                break;
            case 'terbaru':
            default:
                $query->latest();
                break;
        }
        
        $products = $query->paginate(12)->appends(['sort_by' => $sortBy]);
        
        return view('shop.index', compact('products', 'sortBy')); 
    }
    
    /**
     * Menampilkan keranjang belanja pengguna.
     */
    public function cart()
    {
       
    
        // Pastikan ini 'shop.cart' (folder shop, file cart)
        return view('shop.cart'); 

    }

    public function addToCart($id)
{
    // Cari produk berdasarkan ID (Asumsi Anda punya model Product)
    $product = \App\Models\Product::findOrFail($id);
    
    // Ambil data keranjang dari session, jika kosong buat array baru
    $cart = session()->get('cart', []);

    // Jika produk sudah ada di keranjang, tambah jumlahnya (quantity)
    if(isset($cart[$id])) {
        $cart[$id]['quantity']++;
    } else {
        // Jika belum ada, masukkan data produk ke array cart
        $cart[$id] = [
            "name" => $product->name,
            "quantity" => 1,
            "price" => $product->price,
            "image" => $product->image_url
        ];
    }

    // Simpan kembali array cart ke dalam session
    session()->put('cart', $cart);

    return redirect()->back()->with('success', 'Produk berhasil ditambah ke keranjang!');
}
    public function update(Request $request)
    {
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            session()->flash('success', 'Keranjang berhasil diperbarui!');
        }
    }

    public function remove(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Produk berhasil dihapus!');
        }
    }
}