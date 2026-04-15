@extends('layouts.app')

@section('title', 'Seni Kuku yang Memukau')

@section('content')
<div class="container-fluid p-0">
    <div class="jumbotron text-center p-5 position-relative" style="background-image: url('/img/hero-bg.jpg'); background-size: cover; background-position: center; height: 500px; border-radius: 0 0 2rem 2rem; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, rgba(0, 0, 0, 0.7) 0%, rgba(200, 100, 150, 0.3) 100%); border-radius: 0 0 2rem 2rem;"></div>
        <div class="container h-100 d-flex flex-column justify-content-center align-items-center position-relative text-white">
            <h1 class="display-4 fw-bold mb-3" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">Seni Kuku yang Memukau, Di Ujung Jari Anda</h1>
            <p class="lead mb-4" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.5); max-width: 800px;">Temukan koleksi, reservasi booking, dan peralatan nail art terbaik untuk kuku cantik Anda.</p>
            <a href="/collection" class="btn btn-primary-custom rounded-pill btn-lg px-5 shadow-sm" style="transition: all 0.3s ease;">Lihat Sekarang</a>
        </div>
    </div>
</div>

<div class="container my-5">
    <h2 class="text-center mb-5 fw-bold">Koleksi Pilihan</h2>
    <div class="row">
        @for ($i = 0; $i < 3; $i++)
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm">
                    <img src="/img/collection-{{ $i+1 }}.jpg" class="card-img-top" alt="Koleksi" style="height: 250px; object-fit: cover;">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold">Koleksi Musim Semi</h5>
                        <p class="card-text text-secondary" style="font-size: 0.9rem;">Deskripsi singkat koleksi...</p>
                        <a href="/collection" class="btn btn-primary-custom btn-sm mt-2">Lihat Detail</a>
                    </div>
                </div>
            </div>
        @endfor
    </div>

    <div class="text-center my-5 py-5 border-top">
        <h2 class="fw-bold">Tentang Kami</h2>
        <p class="text-secondary w-75 mx-auto">Nail Art Ambory didirikan dengan visi untuk menghadirkan seni kuku berkualitas tinggi yang dapat diakses oleh semua orang. Kami berdedikasi untuk memberikan layanan terbaik, dan kepuasan Anda adalah prioritas utama kami. Produk terbaik untuk hasil yang memukau.</p>
    </div>
</div>

<div class="container-fluid promo-section text-center">
    <div class="container">
        <h3 class="fw-bold text-dark">Siap Untuk Transformasi Kuku Anda?</h3>
        <p class="text-secondary">Jadwalkan janji temu Anda hari ini dan rasakan kemudahan seni kuku yang tak tertandingi.</p>
        <a href="/booking" class="btn btn-primary-custom rounded-pill mt-3">Booking Sekarang</a>
    </div>
</div>

<div class="container my-5 pb-5">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h2 class="fw-bold mb-0">Testimoni</h2>
        <a href="/testimonials" class="btn btn-outline-primary-custom rounded-pill">Lihat Semua</a>
    </div>
    <div class="row">
        @foreach ($testimonials as $testimonial)
            <div class="col-md-4 mb-4">
                <div class="card p-4 border-0 shadow-sm h-100 rounded-4" style="background-color: #fcfcfc;">
                    <p class="card-text fst-italic mb-4">"{{ $testimonial->comment }}"</p>
                    <div class="d-flex justify-content-between align-items-center mt-auto border-top pt-3">
                        <div class="stars text-warning small">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="bi bi-star{{ $i <= $testimonial->rating ? '-fill' : '' }}"></i>
                            @endfor
                        </div>
                        <p class="mb-0 fw-bold small">{{ $testimonial->name }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<div class="container my-5 text-center">
    <h2 class="fw-bold mb-4">Lokasi Kami</h2>
    <p class="text-secondary mb-4">Kunjungi studio kami untuk konsultasi dan perawatan kuku secara langsung di Jl. Babakan Jeruk 1 No.32, Bandung.</p>
    <div class="ratio ratio-21x9 shadow-sm rounded-4 overflow-hidden" style="max-height: 450px;">
        <iframe src="https://maps.google.com/maps?q=Jl.%20Babakan%20Jeruk%201%20No.32,%20Sukagalih,%20Kec.%20Sukajadi,%20Kota%20Bandung,%20Jawa%20Barat%2040163&t=&z=15&ie=UTF8&iwloc=&output=embed" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</div>
@endsection