@extends('layouts.app')

@section('title', 'Testimoni Pelanggan - Caroline Nail Art')

@section('content')
<div class="testimonial-header py-5 bg-light text-center">
    <div class="container">
        <h1 class="fw-bold text-dark mb-3">Testimoni</h1>
        <p class="text-muted lead mx-auto" style="max-width: 600px;">Apa kata mereka tentang pengalaman perawatan kuku di Caroline Nail Art? Kepuasan Anda adalah prioritas kami.</p>
    </div>
</div>

<div class="container my-5">
    <div class="row g-4">
        @forelse($testimonials as $testimonial)
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-4 transition-hover">
                <div class="card-body p-0 d-flex flex-column">
                    <div class="mb-4">
                        <p class="text-dark fst-italic mb-0">"{{ $testimonial->comment }}"</p>
                    </div>
                    
                    <div class="mt-auto pt-4 border-top">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="stars text-warning">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $i <= $testimonial->rating ? '-fill' : '' }}"></i>
                                @endfor
                            </div>
                            <h6 class="fw-bold text-dark mb-0">{{ $testimonial->name }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <p class="text-muted">Belum ada testimoni.</p>
        </div>
        @endforelse
    </div>

    <!-- Submit Testimony Section -->
    <div class="mt-5 p-5 bg-primary-custom rounded-4 text-white">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h2 class="fw-bold mb-3 text-white">Bagikan Pengalaman Anda</h2>
                <p class="mb-0 opacity-75">Sangat senang mendengar pendapat Anda! Bagikan cerita Anda bersama Caroline Nail Art untuk membantu kami terus berkembang.</p>
            </div>
            <div class="col-lg-6 text-lg-end">
                @auth
                    <button class="btn btn-white btn-lg rounded-pill px-5 fw-bold" data-bs-toggle="modal" data-bs-target="#submitTestimonyModal">
                        Tulis Testimoni <i class="bi bi-pencil-square ms-2"></i>
                    </button>
                @else
                    <a href="{{ route('login') }}" class="btn btn-white btn-lg rounded-pill px-5 fw-bold">
                        Tulis Testimoni <i class="bi bi-pencil-square ms-2"></i>
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>

<!-- Modal Submit Testimoni -->
<div class="modal fade" id="submitTestimonyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-header border-0 p-4">
                <h5 class="modal-title fw-bold">Berikan Penilaian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('testimonials.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4 pt-0">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted uppercase">NAMA ANDA</label>
                        <input type="text" name="name" class="form-control rounded-3" value="{{ auth()->user()->name ?? '' }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted uppercase">RATING</label>
                        <select name="rating" class="form-select rounded-3" required>
                            <option value="5">⭐⭐⭐⭐⭐ (Sangat Puas)</option>
                            <option value="4">⭐⭐⭐⭐ (Puas)</option>
                            <option value="3">⭐⭐⭐ (Biasa Saja)</option>
                            <option value="2">⭐⭐ (Kurang Puas)</option>
                            <option value="1">⭐ (Sangat Kurang)</option>
                        </select>
                    </div>
                    <div class="mb-0">
                        <label class="form-label small fw-bold text-muted uppercase">KOMENTAR / PENGALAMAN</label>
                        <textarea name="comment" class="form-control rounded-3" rows="4" placeholder="Tuliskan pengalaman Anda di sini..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary-custom rounded-pill px-4 fw-bold">Kirim Testimoni</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .transition-hover {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .transition-hover:hover {
        transform: translateY(-10px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,.1) !important;
    }
    .btn-white {
        background-color: #fff;
        color: var(--primary-color, #E91E63);
    }
    .btn-white:hover {
        background-color: #f8f9fa;
        color: var(--primary-color, #E91E63);
    }
    .uppercase { text-transform: uppercase; }
</style>
@endsection
