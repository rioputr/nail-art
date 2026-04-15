<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Illuminate\Http\Request;

// TAMBAHKAN 'extends Controller' di sini
class CollectionController 
{
    /**
     * Menampilkan daftar koleksi (sesuai Collection.jpg)
     */
    public function index()
    {
        // Pastikan kolom 'is_published' ada di migrasi tabel collections Anda
        $collections = Collection::where('is_published', true)->get();
        
        return view('collection.index', compact('collections'));
    }

    /**
     * Menampilkan detail koleksi berdasarkan slug
     */
    public function show($slug)
    {
        $collection = Collection::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return view('collection.show', compact('collection'));
    }
}