@extends('layouts.app')
@section('title', 'Shop - Koleksi Nail Art')

@section('content')
<div class="container my-5">
    <h1 class="fw-bold mb-4">Koleksi Nail Art</h1>

    <div class="row">
        <div class="col-md-3">
            <div class="card p-3 mb-4 shadow-sm">
                <h5 class="fw-bold mb-3">Cari Produk</h5>
                <input type="text" class="form-control mb-4" placeholder="Cari cat kuku, alat...">
                
                <h5 class="fw-bold mb-2">Kategori</h5>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="kategori1">
                    <label class="form-check-label text-secondary" for="kategori1">Perawatan Kuku</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="kategori2">
                    <label class="form-check-label text-secondary" for="kategori2">Cat Kuku Gel</label>
                </div>
                </div>
        </div>

        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <p class="mb-0 text-secondary">Menampilkan 8 dari 12 Produk</p>
                <div class="d-flex align-items-center">
                    <select class="form-select me-3" style="width: auto;">
                        <option>Terbaru</option>
                        <option>Harga Tertinggi</option>
                    </select>
                    <span class="text-secondary">Halaman 1 dari 2</span>
                </div>
            </div>

            <div class="row">
                @foreach ($products as $product)
                {{ $product->name }}

                    <div class="col-md-4 mb-4">
                        <div class="card product-card text-center border-0 shadow-sm">
                            <div class="position-relative">
                                <img src="/img/{{ $product->image_url }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                                @if ($product->is_new)
                                    <span class="badge bg-danger position-absolute top-0 start-0 m-2">Terbaru</span>
                                @endif
                                @if ($product->is_popular)
                                    <span class="badge bg-warning position-absolute top-0 start-0 m-2">Populer</span>
                                @endif
                            </div>
                            <div class="card-body">
                                <h6 class="fw-bold">{{ $product->name }}</h6>
                                @if ($product->old_price)
                                    <p class="card-text text-decoration-line-through text-secondary mb-0">Rp{{ number_format($product->old_price) }}</p>
                                @endif
                                <h5 class="fw-bold text-primary-custom">Rp{{ number_format($product->price) }}</h5>
                                <button class="btn btn-sm btn-primary-custom w-100">Tambahkan ke Keranjang</button>
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            
            <div class="d-flex justify-content-center mt-4">
                </div>
        </div>
    </div>
</div>
@endsection