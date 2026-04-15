@extends('layouts.app')

@section('title', 'Edit Profil - Caroline Nail Art')

@section('content')
<div class="container my-5">
    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ route('profile') }}" class="btn btn-light rounded-pill px-4 shadow-sm text-secondary fw-medium">
            <i class="bi bi-arrow-left me-2"></i> Kembali ke Profil
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white border-bottom p-4">
                    <h4 class="fw-bold mb-0 text-dark">Edit Informasi Profil</h4>
                </div>
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Avatar Section -->
                        <div class="text-center mb-5">
                            <div class="position-relative d-inline-block">
                                <img id="avatarPreview" 
                                     src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : '/img/default-avatar.png' }}" 
                                     class="rounded-circle shadow-sm border border-4 border-white" 
                                     style="width: 120px; height: 120px; object-fit: cover;">
                                <label for="avatarInput" class="position-absolute bottom-0 end-0 bg-primary-custom text-white rounded-circle d-flex align-items-center justify-content-center cursor-pointer shadow" style="width: 35px; height: 35px; border: 3px solid #fff;">
                                    <i class="bi bi-camera-fill small"></i>
                                </label>
                                <input type="file" name="avatar" id="avatarInput" class="d-none" accept="image/*" onchange="previewAvatar(this)">
                            </div>
                            <p class="text-muted small mt-2 mb-0">Klik ikon kamera untuk mengubah foto profil</p>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted uppercase">NAMA LENGKAP</label>
                                <input type="text" name="name" class="form-control rounded-3 py-2"
                                       value="{{ auth()->user()->name }}" required>
                            </div> 
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted uppercase">ALAMAT EMAIL</label>
                                <input type="email" name="email" class="form-control rounded-3 py-2"
                                       value="{{ auth()->user()->email }}" required>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label small fw-bold text-muted uppercase">NOMOR TELEPON</label>
                                <input type="tel" name="phone" class="form-control rounded-3 py-2"
                                       value="{{ auth()->user()->phone }}" placeholder="0812xxxx">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label small fw-bold text-muted uppercase">ALAMAT TINGGAL</label>
                                <textarea name="address" class="form-control rounded-3" rows="3" placeholder="Alamat lengkap...">{{ auth()->user()->address }}</textarea>
                            </div>
                        </div>

                        <hr class="my-5 opacity-10">

                        <div class="mb-4">
                            <h5 class="fw-bold mb-1">Ganti Kata Sandi</h5>
                            <p class="text-muted small">Kosongkan jika tidak ingin mengubah kata sandi.</p>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label small fw-bold text-muted">KATA SANDI SAAT INI</label>
                                <input type="password" name="current_password" class="form-control rounded-3 py-2 @error('current_password') is-invalid @enderror" placeholder="********">
                                @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">KATA SANDI BARU</label>
                                <input type="password" name="new_password" class="form-control rounded-3 py-2 @error('new_password') is-invalid @enderror" placeholder="Minimal 8 karakter">
                                @error('new_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">KONFIRMASI KATA SANDI BARU</label>
                                <input type="password" name="new_password_confirmation" class="form-control rounded-3 py-2" placeholder="Ulangi kata sandi baru">
                            </div>
                        </div>

                        <div class="mt-5 text-end">
                            <button type="submit" class="btn btn-primary-custom rounded-pill px-5 py-2 fw-bold shadow-sm">
                                Simpan Perubahan <i class="bi bi-check2-circle ms-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('avatarPreview').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<style>
    .uppercase { text-transform: uppercase; }
    .cursor-pointer { cursor: pointer; }
</style>
@endsection
