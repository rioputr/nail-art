@extends('layouts.admin')

@section('title', 'Edit Pengguna: ' . $user->name)

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="mb-4">
        <a href="{{ route('admin.users.index') }}" class="btn btn-link text-decoration-none p-0 mb-2">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar
        </a>
        <h2 class="fw-bold">Edit Pengguna</h2>
        <p class="text-muted">Perbarui informasi untuk pengguna <strong>{{ $user->name }}</strong>.</p>
    </div>

    <!-- Form -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

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
                                       value="{{ old('name', $user->name) }}" 
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
                                       value="{{ old('email', $user->email) }}" 
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
                                       value="{{ old('phone', $user->phone) }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="avatar" class="form-label">Foto Profil (Biarkan kosong jika tidak ingin mengubah)</label>
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
                                          rows="3">{{ old('address', $user->address) }}</textarea>
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
                                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
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
                                    <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                                    <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                                    <option value="pending" {{ old('status', $user->status) == 'pending' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password" class="form-label">Kata Sandi Baru (Biarkan kosong jika tidak ingin mengubah)</label>
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi Baru</label>
                                <input type="password" 
                                       class="form-control" 
                                       id="password_confirmation" 
                                       name="password_confirmation">
                            </div>

                            <div class="col-12 mt-4 text-end">
                                <hr class="mb-4">
                                <button type="button" class="btn btn-light px-4 me-2" onclick="history.back()">Batal</button>
                                <button type="submit" class="btn btn-pink px-4">
                                    <i class="bi bi-check-circle me-2"></i>Perbarui Pengguna
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="col-lg-4">
            <!-- Current Avatar -->
            <div class="card shadow-sm border-0 mb-4 text-center p-4">
                <div class="mb-3">
                    <img src="{{ $user->avatar_url }}" 
                         class="rounded-circle shadow-sm" 
                         width="120" 
                         height="120" 
                         alt="{{ $user->name }}"
                         style="object-fit: cover;">
                </div>
                <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                <p class="text-muted small mb-0">{{ ucfirst($user->role) }} • {{ ucfirst($user->status) }}</p>
            </div>

            <div class="card shadow-sm border-0 border-top border-pink border-4 mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Informasi Akun</h5>
                    <div class="d-flex justify-content-between mb-2 small">
                        <span class="text-muted">Terdaftar pada:</span>
                        <span class="fw-medium">{{ $user->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2 small">
                        <span class="text-muted">Terakhir diperbarui:</span>
                        <span class="fw-medium">{{ $user->updated_at->diffForHumans() }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-0 small">
                        <span class="text-muted">Login terakhir:</span>
                        <span class="fw-medium">{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Belum pernah' }}</span>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 bg-light">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-danger mb-3">Zona Berbahaya</h5>
                    <p class="text-muted small mb-3">Tindakan ini tidak dapat dibatalkan. Menghapus pengguna akan menghilangkan semua data terkait.</p>
                    <button type="button" 
                            class="btn btn-outline-danger btn-sm w-100" 
                            onclick="confirmDelete()">
                        <i class="bi bi-trash me-2"></i>Hapus Pengguna
                    </button>
                    <form id="delete-user-form" action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>
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

@push('scripts')
<script>
    function confirmDelete() {
        if (confirm('Apakah Anda yakin ingin menghapus pengguna ini? Tindakan ini tidak dapat dibatalkan.')) {
            document.getElementById('delete-user-form').submit();
        }
    }
</script>
@endpush
@endsection
