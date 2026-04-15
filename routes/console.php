<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| File ini adalah tempat Anda dapat mendefinisikan semua penanganan perintah
| konsol berbasis Closure. Setiap Closure terikat pada instance Command 
| yang memungkinkan interaksi I/O yang sederhana.
|
*/

// Contoh Command bawaan Laravel:
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Menampilkan kutipan inspirasional.');


// --- Contoh Command Kustom untuk Caroline Nail Art ---
// Anda bisa menggunakan ini untuk membersihkan data lama, mengirim email massal, dll.

Artisan::command('nailart:clean-old-bookings', function () {
    // Logic untuk menghapus data booking yang sudah lama (misalnya lebih dari 6 bulan)
    $count = 0; // Ganti dengan logic penghitungan data yang dihapus
    
    $this->info("Berhasil membersihkan {$count} data booking lama.");
})->purpose('Membersihkan data booking yang sudah lewat dari database.');