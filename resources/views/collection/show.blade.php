@extends('layouts.app')

@section('title', $collection->name . ' - Caroline Nail Art')

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('collection.index') }}" class="text-decoration-none">Koleksi</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $collection->name }}</li>
        </ol>
    </nav>

    <div class="row g-5">
        <!-- Image Section -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <img src="{{ $collection->image_url }}" class="img-fluid w-100" style="max-height: 500px; object-fit: cover;"
                     onerror="this.src='https://placehold.co/600x500/f8f9fa/6c757d?text={{ urlencode($collection->name) }}'"
                     alt="{{ $collection->name }}">
            </div>
        </div>

        <!-- Detail Section -->
        <div class="col-lg-6">
            <div class="ps-lg-4">
                @if($collection->category)
                    <span class="badge bg-danger rounded-pill mb-3 px-3 py-2">{{ ucfirst($collection->category) }}</span>
                @endif

                <h1 class="display-5 fw-bold mb-4">{{ $collection->name }}</h1>

                <div class="mb-4">
                    <h5 class="text-muted mb-3">Deskripsi</h5>
                    <p class="lead text-secondary">{{ $collection->description ?? 'Tidak ada deskripsi tersedia.' }}</p>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex gap-3 mt-5">
                    <a href="{{ route('booking.create') }}" class="btn btn-danger btn-lg rounded-pill px-4">
                        <i class="bi bi-calendar-check me-2"></i> Booking Sekarang
                    </a>
                    <a href="{{ route('collection.index') }}" class="btn btn-outline-secondary btn-lg rounded-pill px-4">
                        <i class="bi bi-arrow-left me-2"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .breadcrumb-item a {
        color: #dc3545;
    }

    .breadcrumb-item a:hover {
        color: #b02a37;
    }

    .btn-danger {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        border: none;
        transition: all 0.3s ease;
    }

    .btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(220, 53, 69, 0.4);
    }
</style>
@endsection
