<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController
{
   public function edit()
{
    
    return view('user.edit'); 
}

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'avatar' => 'nullable|image|max:2048',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
        ]);

        $data = $request->only('name', 'email', 'phone', 'address');

        // Handle Avatar
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $avatarPath;
        }

        // Handle Password Change
        if ($request->filled('new_password')) {
            if (!\Illuminate\Support\Facades\Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Kata sandi saat ini salah.']);
            }
            $data['password'] = \Illuminate\Support\Facades\Hash::make($request->new_password);
        }

        $user->update($data);

        return redirect()->back()->with('success', 'Profil dan pengaturan akun berhasil diperbarui');
    }
    public function logout(Request $request)
    {
        Auth::logout(); // Menghapus sesi login pengguna

        $request->session()->invalidate(); // Menghancurkan session
        $request->session()->regenerateToken(); // Membuat token CSRF baru demi keamanan

        return redirect('/'); // INI YANG ANDA MINTA: Kembali ke halaman utama
    }
}

