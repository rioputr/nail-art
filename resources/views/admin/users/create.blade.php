@extends('layouts.admin')

@section('title', 'Tambah Pengguna Baru')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="mb-4">
        <a href="{{ route('admin.users.index') }}" class="btn btn-link text-decoration-none p-0 mb-2">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar
        </a>
        <h2 class="fw-bold">Tambah Pengguna Baru</h2>
        <p class="text-muted">Lengkapi formulir di bawah ini untuk menambahkan pengguna baru.</p>
    </div>

    <!-- Form -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-3">
                            <!-- Profil Dasar -->
                            <div class="col-12">
                                <h5 class="fw-bold mb-3">Informasi Dasar</h5>
                            </div>

                            <div class="col-md-6">
                                <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name') }}" 
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">Alamat Email <span class="text-danger">*</span></label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="phone" class="form-label">Nomor Telepon</label>
                                <input type="text" 
                                       class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" 
                                       name="phone" 
                                       value="{{ old('phone') }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="avatar" class="form-label">Foto Profil</label>
                                <input type="file" 
                                       class="form-control @error('avatar') is-invalid @enderror" 
                                       id="avatar" 
                                       name="avatar" 
                                       accept="image/*">
                                @error('avatar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="address" class="form-label">Alamat</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" 
                                          id="address" 
                                          name="address" 
                                          rows="3">{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Akses & Akun -->
                            <div class="col-12 mt-4">
                                <h5 class="fw-bold mb-3">Akses & Keamanan</h5>
                            </div>

                            <div class="col-md-6">
                                <label for="role" class="form-label">Peran Pengguna <span class="text-danger">*</span></label>
                                <select class="form-select @error('role') is-invalid @enderror" 
                                        id="role" 
                                        name="role" 
                                        required>
                                    <option value="">Pilih Peran</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="status" class="form-label">Status Akun <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" 
                                        id="status" 
                                        name="status" 
                                        required>
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password" class="form-label">Kata Sandi <span class="text-danger">*</span></label>
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi <span class="text-danger">*</span></label>
                                <input type="password" 
                                       class="form-control" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       required>
                            </div>

                            <div class="col-12 mt-4 text-end">
                                <hr class="mb-4">
                                <button type="reset" class="btn btn-light px-4 me-2">Reset</button>
                                <button type="submit" class="btn btn-pink px-4">
                                    <i class="bi bi-check-circle me-2"></i>Simpan Pengguna
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 border-top border-pink border-4 mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Panduan Singkat</h5>
                    <ul class="text-muted small ps-3">
                        <li class="mb-2">Pastikan alamat email yang digunakan unik dan valid.</li>
                        <li class="mb-2">Kata sandi minimal harus terdiri dari 8 karakter.</li>
                        <li class="mb-2">Pilih peran yang sesuai untuk membatasi hak akses sistem.</li>
                        <li class="mb-2">Foto profil disarankan berukuran maksimal 2MB dengan rasio 1:1.</li>
                    </ul>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body text-center p-4">
                    <i class="bi bi-shield-lock display-4 text-pink mb-3"></i>
                    <h5 class="fw-bold">Keamanan Data</h5>
                    <p class="text-muted small">Semua data yang Anda masukkan akan disimpan dengan enkripsi standar industri untuk menjaga keamanan pengguna.</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .btn-pink {
        background: linear-gradient(135deg, #FF4D8D 0%, #D63B73 100%);
        color: white;
        border: none;
        font-weight: 500;
        transition: all 0.3s;
    }
    
    .btn-pink:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 77, 141, 0.3);
        color: white;
    }

    .border-pink {
        border-top-color: #FF4D8D !important;
    }

    .text-pink {
        color: #FF4D8D !important;
    }
</style>
@endpush
@endsection
