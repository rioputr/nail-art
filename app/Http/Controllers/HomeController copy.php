<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Mengambil data produk
use App\Models\Booking; // Mengambil data booking/promosi

class HomeController extends Controller
{
    /**
     * Menampilkan halaman Home (sesuai Home.jpg).
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $featuredProducts = Product::where('is_popular', true)->take(3)->get();
        
        return view('home', compact('featuredProducts')); // Akan me-load resources/views/home.blade.php
    }
}