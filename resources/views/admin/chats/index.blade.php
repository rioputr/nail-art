@extends('layouts.admin')

@section('title', 'Daftar Konsultasi')

@section('content')
<div class="container-fluid py-4">
    <!-- Page header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="text-dark fw-bold mb-0">Konsultasi / Live Chat ✨</h2>
        </div>
    </div>

    <!-- Cards -->
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-white py-3 border-bottom">
            <h5 class="mb-0 fw-semibold text-dark">Semua Sesi <span class="badge bg-light text-secondary border ms-2">{{ $sessions->count() }}</span></h5>
        </div>
        
        <div class="card-body p-0">
            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-muted small text-uppercase">
                        <tr>
                            <th class="ps-4 py-3">Pelanggan</th>
                            <th class="py-3">Email</th>
                            <th class="py-3">Tipe</th>
                            <th class="py-3">Status</th>
                            <th class="py-3">Update Terakhir</th>
                            <th class="pe-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($sessions as $session)
                        <tr>
                            <td class="ps-4 py-3">
                                <div class="fw-bold text-dark">{{ $session->user_id ? optional($session->user)->name : $session->guest_name }}</div>
                            </td>
                            <td class="py-3 text-secondary">
                                {{ $session->user_id ? optional($session->user)->email : $session->guest_email }}
                            </td>
                            <td class="py-3">
                                @if($session->user_id)
                                    <span class="badge bg-success text-white px-3 border border-success-subtle rounded-pill">User</span>
                                @else
                                    <span class="badge bg-warning text-dark px-3 border border-warning-subtle rounded-pill">Guest</span>
                                @endif
                            </td>
                            <td class="py-3">
                                @if($session->status === 'open')
                                    <span class="badge bg-primary text-white px-3 rounded-pill" title="Sesi Terbuka">Open</span>
                                @else
                                    <span class="badge bg-secondary text-white px-3 rounded-pill" title="Sesi Ditutup">Closed</span>
                                @endif
                            </td>
                            <td class="py-3 text-secondary small">
                                {{ $session->updated_at->diffForHumans() }}
                            </td>
                            <td class="pe-4 py-3 text-center">
                                <a href="{{ route('admin.chats.show', $session->id) }}" class="btn btn-sm btn-outline-primary px-3 rounded-pill mb-1">
                                    <i class="bi bi-chat-text me-1"></i> Balas
                                </a>
                                <form action="{{ route('admin.chats.destroy', $session->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus obrolan ini secara permanen?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger px-3 rounded-pill mb-1">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-5 text-center text-muted">
                                Tidak ada obrolan saat ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
