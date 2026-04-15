@extends('layouts.app')
@section('title', 'Pengaturan Akun')

@section('content')
<div class="container my-5">
    <h2 class="fw-bold mb-4">Pengaturan Akun</h2>
    <div class="row">
        
        <div class="col-md-3">
            {{-- Navigasi Sidebar --}}
            <ul class="list-group list-group-flush shadow-sm rounded">
                <a href="{{ route('profile') }}" class="list-group-item list-group-item-action text-secondary">
                    <i class="fas fa-chevron-left me-2"></i> Kembali ke Profil
                </a>
                <a href="#" class="list-group-item list-group-item-action fw-bold active-profile-custom">
                    <i class="fas fa-user-circle me-2"></i> Akun
                </a>
                <a href="#" class="list-group-item list-group-item-action text-secondary">
                    <i class="fas fa-bell me-2"></i> Notifikasi
                </a>
                <a href="#" class="list-group-item list-group-item-action text-secondary">
                    <i class="fas fa-lock me-2"></i> Privasi
                </a>
                <a href="#" class="list-group-item list-group-item-action text-secondary">
                    <i class="fas fa-credit-card me-2"></i> Pembayaran
                </a>
                <a href="#" class="list-group-item list-group-item-action text-danger">
                    <i class="fas fa-trash-alt me-2"></i> Hapus Akun
                </a>
            </ul>
        </div>
        
        <div class="col-md-9">
            <div class="card p-4 shadow-sm">
                <h4 class="fw-bold mb-4">Pengaturan Akun</h4>
                <p class="text-secondary">Perbarui detail profil akun dan kata sandi Anda.</p>

                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    
                    {{-- Nama --}}
                    <div class="mb-3">
                        <label class="form-label text-secondary">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', Auth::user()->name) }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Email --}}
                    <div class="mb-3">
                        <label class="form-label text-secondary">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', Auth::user()->email) }}" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                    <h5 class="fw-bold mt-4 mb-3">Ganti Kata Sandi</h5>

                    {{-- Kata Sandi Saat Ini --}}
                    <div class="mb-3">
                        <label class="form-label text-secondary">Kata Sandi Saat Ini</label>
                        <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" placeholder="********">
                         @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Kata Sandi Baru --}}
                    <div class="mb-3">
                        <label class="form-label text-secondary">Kata Sandi Baru</label>
                        <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror" placeholder="Kata Sandi Baru">
                         @error('new_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Konfirmasi Kata Sandi Baru --}}
                    <div class="mb-4">
                        <label class="form-label text-secondary">Konfirmasi Kata Sandi Baru</label>
                        <input type="password" name="new_password_confirmation" class="form-control" placeholder="Konfirmasi Kata Sandi Baru">
                    </div>

                    <button type="submit" class="btn btn-primary-custom rounded-3">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .active-profile-custom {
        background-color: #f8b9d0; /* Warna Sekunder Pink Muda */
        color: #E91E63 !important;
        border-left: 5px solid #E91E63;
    }
    .list-group-item-action:not(.active-profile-custom):hover {
        background-color: #fcfcfc;
        color: #E91E63 !important;
    }
</style>
@endsection