@extends('layouts.auth')

@section('title', 'Register - Caroline Nail Art')

@section('content')
<div class="min-vh-100 d-flex">
    <!-- Left Side: Image/Illustration (Visible on Desktop) -->
    <div class="d-none d-lg-flex col-lg-6 align-items-center justify-content-center p-5 position-relative overflow-hidden" style="background-color: #fcf4f7;">
        <!-- Decorative Elements -->
        <div class="position-absolute translate-middle" style="top: 15%; left: 0%; width: 350px; height: 350px; background: radial-gradient(circle, rgba(233, 30, 99, 0.08) 0%, transparent 70%); border-radius: 50%;"></div>
        <div class="position-absolute translate-middle" style="bottom: 5%; right: -5%; width: 450px; height: 450px; background: radial-gradient(circle, rgba(233, 30, 99, 0.04) 0%, transparent 70%); border-radius: 50%;"></div>
        
        <div class="text-center position-relative z-1 animate-fade-up">
            <img src="https://images.unsplash.com/photo-1519014816548-bf5fe059798b?q=80&w=1000&auto=format&fit=crop" 
                 alt="Nail Art Setup" 
                 class="img-fluid rounded-4 shadow-lg mb-5" 
                 style="max-width: 80%; transform: rotate(2deg); border: 15px solid white;">
            
            <h1 class="display-4 fw-bold text-primary-custom mb-3">Mulai Perjalanan Kecantikan Anda</h1>
            <p class="lead text-muted mx-auto" style="max-width: 450px;">
                Dapatkan akses eksklusif ke layanan perawatan kuku terbaik dan raih poin untuk setiap kunjungan Anda.
            </p>
        </div>
    </div>

    <!-- Right Side: Register Form -->
    <div class="col-12 col-lg-6 d-flex align-items-center justify-content-center bg-white p-4 p-md-5">
        <div class="w-100" style="max-width: 420px;">
            <!-- Back to Home -->
            <a href="/" class="text-decoration-none text-muted mb-4 d-inline-block transition-hover">
                <i class="bi bi-arrow-left me-2"></i> Kembali ke Beranda
            </a>

            <!-- Logo -->
            <div class="mb-4">
                <img src="/img/logo.png" alt="Caroline Nail Art" height="50" class="mb-3">
            </div>

            <!-- Header -->
            <div class="mb-4">
                <h2 class="fw-bold text-dark">Buat Akun Baru</h2>
                <p class="text-muted">Lengkapi data di bawah ini untuk bergabung dengan kami.</p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('register') }}" class="needs-validation">
                @csrf

                <!-- Nama Lengkap -->
                <div class="mb-4">
                    <label for="name" class="form-label fw-semibold small text-muted text-uppercase tracking-wider">
                        Nama Lengkap
                    </label>
                    <div class="input-group input-group-lg group-focus-pink">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-person text-muted"></i>
                        </span>
                        <input
                            id="name"
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            class="form-control bg-light border-start-0 @error('name') is-invalid @enderror"
                            placeholder="Contoh: Siti Aminah"
                            required
                        >
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="form-label fw-semibold small text-muted text-uppercase tracking-wider">
                        Email
                    </label>
                    <div class="input-group input-group-lg group-focus-pink">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-envelope text-muted"></i>
                        </span>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="form-control bg-light border-start-0 @error('email') is-invalid @enderror"
                            placeholder="nama@email.com"
                            required
                        >
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="form-label fw-semibold small text-muted text-uppercase tracking-wider">
                        Kata Sandi
                    </label>
                    <div class="input-group input-group-lg group-focus-pink">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-lock text-muted"></i>
                        </span>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            class="form-control bg-light border-start-0 @error('password') is-invalid @enderror"
                            placeholder="••••••••"
                            required
                        >
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <small class="text-muted d-block mt-2" style="font-size: 0.75rem;">
                        <i class="bi bi-info-circle me-1"></i> Gunakan minimal 8 karakter dengan kombinasi huruf dan angka.
                    </small>
                </div>

                <!-- Konfirmasi Password -->
                <div class="mb-4">
                    <label for="password_confirmation" class="form-label fw-semibold small text-muted text-uppercase tracking-wider">
                        Konfirmasi Kata Sandi
                    </label>
                    <div class="input-group input-group-lg group-focus-pink">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-check2-circle text-muted"></i>
                        </span>
                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            class="form-control bg-light border-start-0"
                            placeholder="••••••••"
                            required
                        >
                    </div>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn btn-primary-custom w-100 py-3 fw-bold shadow-sm rounded-3 mb-4 transition-transform text-uppercase tracking-widest" style="font-size: 0.9rem;">
                    Daftar Sekarang <i class="bi bi-plus-circle ms-2"></i>
                </button>

                <!-- Divider -->
                <div class="position-relative mb-4 text-center">
                    <hr class="text-muted opacity-25">
                    <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-muted small fw-medium">
                        Atau Daftar Dengan
                    </span>
                </div>

                <!-- Social Register -->
                <div class="row g-2 mb-4">
                    <div class="col-12">
                        <a href="#" class="btn btn-outline-light border text-dark w-100 py-2 rounded-3 d-flex align-items-center justify-content-center gap-2 transition-hover bg-white shadow-sm-hover">
                            <img src="https://www.gstatic.com/images/branding/product/1x/googleg_48dp.png" height="18"> <span class="small fw-semibold">Lanjutkan dengan Google</span>
                        </a>
                    </div>
                </div>

                <!-- Login Link -->
                <div class="text-center">
                    <p class="text-muted small mb-0">
                        Sudah memiliki akun? 
                        <a href="{{ route('login') }}" class="text-primary-custom fw-bold text-decoration-none ms-1">
                            Masuk di Sini
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    :root {
        --primary-pink: #E91E63;
        --secondary-pink: #F8BBD0;
    }

    .text-primary-custom {
        color: var(--primary-pink) !important;
    }

    .btn-primary-custom {
        background-color: var(--primary-pink);
        border: none;
        color: white;
    }

    .btn-primary-custom:hover {
        background-color: #d81b60;
        color: white;
        transform: translateY(-2px);
    }

    .group-focus-pink:focus-within .input-group-text,
    .group-focus-pink:focus-within .form-control {
        border-color: var(--primary-pink) !important;
        box-shadow: none !important;
        background-color: #fff !important;
    }

    .transition-hover {
        transition: all 0.3s ease;
    }

    .transition-hover:hover {
        color: var(--primary-pink) !important;
        transform: translateX(5px);
    }

    .transition-transform {
        transition: transform 0.2s ease;
    }

    .shadow-sm-hover:hover {
        box-shadow: 0 .125rem .25rem rgba(0,0,0,.075)!important;
    }

    .animate-fade-up {
        animation: fadeUp 0.8s ease-out;
    }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .tracking-widest { letter-spacing: 0.1em; }
    .tracking-wider { letter-spacing: 0.05em; }
</style>
@endsection

