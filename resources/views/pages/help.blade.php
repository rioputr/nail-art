@extends('layouts.app')

@section('title', 'Help Center - Caroline Nail Art')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <h1 class="fw-bold mb-4 text-primary-custom">Help Center</h1>
            <div class="row g-4 text-start">
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm p-4 rounded-4 h-100">
                        <h5 class="fw-bold mb-3"><i class="bi bi-person-circle me-2"></i>Akun & Profil</h5>
                        <p class="small text-muted">Pelajari cara mengelola profil, mengubah password, dan mengunggah avatar.</p>
                        <a href="/faq" class="btn btn-sm btn-outline-primary-custom">Baca Selengkapnya</a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm p-4 rounded-4 h-100">
                        <h5 class="fw-bold mb-3"><i class="bi bi-credit-card me-2"></i>Pembayaran & Booking</h5>
                        <p class="small text-muted">Panduan cara pembayaran via transfer bank dan proses konfirmasi booking.</p>
                        <a href="/contact" class="btn btn-sm btn-outline-primary-custom">Hubungi Kami</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
