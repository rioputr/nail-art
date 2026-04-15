@extends('layouts.app')

@section('title', 'Riwayat Booking Saya - Caroline Nail Art')

@section('content')
<div class="container my-5">
    <div class="mb-4">
        <a href="{{ route('profile') }}" class="btn btn-light rounded-pill px-4 shadow-sm text-secondary fw-medium">
            <i class="bi bi-arrow-left me-2"></i> Kembali ke Profil
        </a>
    </div>
    
    <div class="mb-5 d-flex justify-content-between align-items-end">
        <div>
            <h2 class="fw-bold text-dark">Riwayat Booking</h2>
            <p class="text-muted">Lihat dan pantau status jadwal perawatan kuku Anda.</p>
        </div>
        <a href="{{ route('booking.create') }}" class="btn btn-primary-custom rounded-pill px-4 shadow-sm">
            <i class="bi bi-plus-lg me-2"></i> Buat Booking Baru
        </a>
    </div>

    @forelse($bookings as $booking)
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 border-start border-4 {{ 
        $booking->status == 'confirmed' ? 'border-primary' : (
        $booking->status == 'completed' ? 'border-success' : (
        $booking->status == 'cancelled' ? 'border-danger' : 'border-warning')) 
    }}">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-3">
                    <h6 class="text-muted small fw-bold mb-1">LAYANAN</h6>
                    <p class="fw-bold text-dark mb-0 fs-5">{{ $booking->service_details }}</p>
                </div>
                <div class="col-md-3">
                    <h6 class="text-muted small fw-bold mb-1">WAKTU & TANGGAL</h6>
                    <p class="text-dark mb-0 fw-medium">
                        <i class="bi bi-calendar3 me-2 text-primary-custom"></i>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}
                    </p>
                    <p class="text-muted mb-0 small">
                        <i class="bi bi-clock me-2"></i>{{ $booking->booking_time }} WIB
                    </p>
                </div>
                <div class="col-md-2">
                    <h6 class="text-muted small fw-bold mb-1">ESTIMASI HARGA</h6>
                    <p class="fw-bold text-primary-custom mb-0">Rp {{ number_format($booking->estimated_price, 0, ',', '.') }}</p>
                </div>
                <div class="col-md-2">
                    <h6 class="text-muted small fw-bold mb-1">STATUS</h6>
                    @php
                        $statusClass = [
                            'pending' => 'bg-warning-subtle text-warning',
                            'confirmed' => 'bg-primary-subtle text-primary',
                            'completed' => 'bg-success-subtle text-success',
                            'cancelled' => 'bg-danger-subtle text-danger',
                        ][$booking->status] ?? 'bg-secondary-subtle text-secondary';
                    @endphp
                    <span class="badge {{ $statusClass }} rounded-pill px-3 py-1 small fw-bold">
                        {{ ucfirst($booking->status) }}
                    </span>
                </div>
                <div class="col-md-2 text-md-end">
                    @if($booking->status == 'pending')
                    <button class="btn btn-outline-danger btn-sm rounded-pill px-3" onclick="confirmCancel({{ $booking->id }})">
                        Batalkan
                    </button>
                    @endif
                </div>
            </div>
            
            @if($booking->notes)
            <hr class="my-4 opacity-10">
            <div class="bg-light p-3 rounded-3 mt-2">
                <h6 class="text-muted small fw-bold mb-1 uppercase">CATATAN ANDA:</h6>
                <p class="mb-0 small text-dark italic">"{{ $booking->notes }}"</p>
            </div>
            @endif
        </div>
    </div>
    @empty
    <div class="card border-0 shadow-sm rounded-4 p-5 text-center">
        <div class="py-5">
            <i class="bi bi-calendar-x fs-1 text-muted opacity-25 d-block mb-3"></i>
            <h5 class="text-muted fw-bold">Belum ada riwayat booking</h5>
            <p class="text-muted mb-4">Ingin perawatan kuku cantik? Yuk, reservasi sekarang!</p>
            <a href="{{ route('booking.create') }}" class="btn btn-primary-custom rounded-pill px-5 shadow-sm">
                Booking Sekarang
            </a>
        </div>
    </div>
    @endforelse
</div>

<style>
    .bg-warning-subtle { background-color: #fff3cd; }
    .bg-success-subtle { background-color: #d1e7dd; }
    .bg-primary-subtle { background-color: #cfe2ff; }
    .bg-danger-subtle { background-color: #f8d7da; }
    .shadow-xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
    .italic { font-style: italic; }
    .uppercase { text-transform: uppercase; }
</style>

<form id="cancelForm" action="" method="POST" style="display: none;">
    @csrf
</form>

<script>
function confirmCancel(id) {
    if(confirm('Apakah Anda yakin ingin membatalkan booking ini?')) {
        const form = document.getElementById('cancelForm');
        form.action = `/booking/cancel/${id}`; // I might need to add this route or use a generic one
        form.submit();
    }
}
</script>
@endsection
