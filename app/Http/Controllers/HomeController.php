<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Testimonial;

class HomeController
{
    public function index()
    {
        $featuredProducts = Product::where('is_popular', true)->take(3)->get();
        $testimonials = Testimonial::where('is_featured', true)->take(3)->get();
        
        return view('home', compact('featuredProducts', 'testimonials')); 
    }
}
