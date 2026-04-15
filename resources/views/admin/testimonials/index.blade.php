@extends('layouts.admin')

@section('title', 'Manajemen Testimoni')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
    <div>
        <h3 class="fw-bold text-dark">Manajemen Testimoni</h3>
        <p class="text-muted">Kelola testimoni dari pelanggan untuk ditampilkan di halaman utama.</p>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-visible">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3">Nama Pelanggan</th>
                        <th class="py-3">Komentar</th>
                        <th class="py-3">Rating</th>
                        <th class="py-3">Tampilkan di Home</th>
                        <th class="py-3 text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($testimonials as $testimonial)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-3">
                                        <div class="avatar-title rounded-circle bg-soft-primary text-primary">
                                            {{ substr($testimonial->name, 0, 1) }}
                                        </div>
                                    </div>
                                    <span class="fw-bold">{{ $testimonial->name }}</span>
                                </div>
                            </td>
                            <td>
                                <p class="mb-0 text-muted small" style="max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $testimonial->comment }}">
                                    "{{ $testimonial->comment }}"
                                </p>
                            </td>
                            <td>
                                <div class="text-warning small">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star{{ $i <= $testimonial->rating ? '-fill' : '' }}"></i>
                                    @endfor
                                </div>
                            </td>
                            <td>
                                <form action="{{ route('admin.testimonials.toggle', $testimonial->id) }}" method="POST">
                                    @csrf
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" 
                                               onchange="this.form.submit()" {{ $testimonial->is_featured ? 'checked' : '' }}>
                                        <span class="badge {{ $testimonial->is_featured ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }} rounded-pill">
                                            {{ $testimonial->is_featured ? 'Ditampilkan' : 'Disembunyikan' }}
                                        </span>
                                    </div>
                                </form>
                            </td>
                            <td class="text-end pe-4">
                                <form action="{{ route('admin.testimonials.destroy', $testimonial->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus testimoni ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                        <i class="bi bi-trash me-1"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <i class="bi bi-chat-left-quote fs-1 text-muted d-block mb-3"></i>
                                <span class="text-muted">Belum ada testimoni masuk.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($testimonials->count() > 0)
    <div class="card-footer bg-white border-top-0 p-4">
        {{ $testimonials->links() }}
    </div>
    @endif
</div>

<style>
    .bg-soft-primary { background-color: rgba(13, 110, 253, 0.1); }
    .avatar-sm { height: 35px; width: 35px; }
    .avatar-title { height: 100%; width: 100%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 12px; }
    .bg-success-subtle { background-color: #d1e7dd; }
    .bg-secondary-subtle { background-color: #e2e3e5; }
    .form-switch .form-check-input { cursor: pointer; }
</style>
@endsection
