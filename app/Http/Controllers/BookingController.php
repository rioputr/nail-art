<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;

class BookingController
{
    /**
     * Menampilkan formulir penjadwalan booking (sesuai Booking.jpg).
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $users = [];
        if (Auth::check() && in_array(Auth::user()->role, ['admin', 'manager'])) {
            $users = \App\Models\User::all();
        }
        return view('booking', compact('users')); // Updated to use booking.blade.php
    }

    /**
     * Menyimpan data booking dari pengguna (membutuhkan login/auth middleware).
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'booking_date' => 'required|date|after_or_equal:today',
            'booking_time' => ['required', function ($attribute, $value, $fail) use ($request) {
                if ($request->booking_date == now()->format('Y-m-d')) {
                    // Compare simple string like "09:00" vs "14:30"
                    if ($value <= now()->format('H:i')) {
                        $fail('Waktu booking sudah terlewat, silakan pilih waktu lain.');
                    }
                }
            }],
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telepon' => 'required|string|max:20',
            'layanan' => 'required|string',
            'catatan' => 'nullable|string',
        ]);

        $prices = [
            'Basic Manicure' => 150000,
            'Gel Polish' => 200000,
            'Nail Art Design' => 350000,
            'Nail Extensions' => 500000,
        ];
        $price = $prices[$validatedData['layanan']] ?? 0;

        $userId = Auth::id();
        // If admin/manager, they can select who the booking is for (or leave it as guest)
        if (Auth::check() && in_array(Auth::user()->role, ['admin', 'manager'])) {
            $userId = $request->user_id ?: null;
        }

        Booking::create([
            'user_id' => $userId,
            'name' => $validatedData['nama'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['telepon'],
            'booking_date' => $validatedData['booking_date'],
            'booking_time' => $validatedData['booking_time'],
            'service_details' => $validatedData['layanan'],
            'notes' => $validatedData['catatan'],
            'estimated_price' => $price,
            'status' => 'pending'
        ]);

        return redirect()->route('booking.create')->with('success', 'Booking berhasil dibuat!');
    }

    
    /**
     * Menampilkan riwayat booking pengguna.
     */
    public function history()
    {
        $bookings = Auth::user()->bookings()->latest()->get();
        return view('booking.history', compact('bookings'));
    }
    
    public function index()
    {
        $bookings = Booking::latest()->get();
        $selectedBooking = request('id') ? Booking::find(request('id')) : $bookings->first();

        return view('admin.bookings.index', compact(
            'bookings',
            'selectedBooking'
        ));
    }

    public function confirm($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['status' => 'confirmed']);

        return redirect()->back()->with('success', 'Booking berhasil dikonfirmasi!');
    }

    public function cancel($id)
    {
        $booking = Booking::findOrFail($id);
        
        // Security check: Only owner or admin can cancel
        if (Auth::user()->role !== 'admin' && $booking->user_id !== Auth::id()) {
            abort(403);
        }

        $booking->update(['status' => 'cancelled']);

        return redirect()->back()->with('success', 'Booking berhasil dibatalkan!');
    }

    public function reschedule(Request $request, $id)
    {
        $request->validate([
            'booking_date' => 'required|date',
            'booking_time' => 'required',
        ]);

        $booking = Booking::findOrFail($id);
        $booking->update([
            'booking_date' => $request->booking_date,
            'booking_time' => $request->booking_time,
            'status' => 'pending' // Reset to pending if rescheduled? Or keep current. Usually pending/rescheduled.
        ]);

        return redirect()->back()->with('success', 'Jadwal booking berhasil diperbarui!');
    }
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect()->route('admin.bookings.index')->with('success', 'Booking berhasil dihapus!');
    }
}
