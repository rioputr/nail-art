<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController
{
    /**
     * Menampilkan halaman profil pengguna (sesuai Profil Pengguna.png).
     * @return \Illuminate\View\View
     */
    public function profile()
    {
        $user = Auth::user();
        // Ambil riwayat booking dan pesanan terkini (simulasi)
        $latestBookings = $user->bookings()->latest()->take(3)->get();
        $latestTransactions = $user->transactions()->latest()->take(3)->get();
        
        return view('user.profile', compact('user', 'latestBookings', 'latestTransactions')); //
    }

    /**
     * Menampilkan formulir pengaturan akun (sesuai Pengaturan Pengguna.png).
     * @return \Illuminate\View\View
     */
    public function showSettings()
    {
        $user = Auth::user();
        return view('user.settings', compact('user')); //
    }

    /**
     * Memperbarui pengaturan akun pengguna.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateSettings(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
        ]);

        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Kata sandi saat ini salah.']);
            }
            $user->password = Hash::make($request->new_password);
        }
        
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        
        return back()->with('success', 'Pengaturan akun berhasil diperbarui!');
    }
}