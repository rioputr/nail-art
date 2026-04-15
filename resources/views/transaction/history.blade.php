@extends('layouts.app')

@section('title', 'Riwayat Belanja - Caroline Nail Art')

@section('content')
<div class="container my-5">
    <div class="mb-4">
        <a href="{{ route('profile') }}" class="btn btn-light rounded-pill px-4 shadow-sm text-secondary fw-medium">
            <i class="bi bi-arrow-left me-2"></i> Kembali ke Profil
        </a>
    </div>

    <div class="mb-5">
        <h2 class="fw-bold text-dark">Riwayat Belanja</h2>
        <p class="text-muted">Pantau status pesanan dan lihat kembali detail transaksi Anda.</p>
    </div>

    @forelse($transactions as $transaction)
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-3">
                    <h6 class="text-muted small fw-bold mb-1">KODE TRANSAKSI</h6>
                    <p class="fw-bold text-dark mb-0">#{{ $transaction->transaction_code }}</p>
                </div>
                <div class="col-md-3">
                    <h6 class="text-muted small fw-bold mb-1">TANGGAL</h6>
                    <p class="text-dark mb-0">{{ $transaction->created_at->format('d M Y') }}</p>
                </div>
                <div class="col-md-2">
                    <h6 class="text-muted small fw-bold mb-1">TOTAL</h6>
                    <p class="fw-bold text-primary-custom mb-0">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</p>
                </div>
                <div class="col-md-2">
                    <h6 class="text-muted small fw-bold mb-1">STATUS</h6>
                    @php
                        $statusClass = [
                            'pending' => 'bg-warning-subtle text-warning',
                            'paid' => 'bg-success-subtle text-success',
                            'shipped' => 'bg-primary-subtle text-primary',
                            'completed' => 'bg-info-subtle text-info',
                            'cancelled' => 'bg-danger-subtle text-danger',
                        ][$transaction->status] ?? 'bg-secondary-subtle text-secondary';
                    @endphp
                    <span class="badge {{ $statusClass }} rounded-pill px-3 py-1 small">
                        {{ ucfirst($transaction->status) }}
                    </span>
                </div>
                <div class="col-md-2 text-md-end">
                    <a href="{{ route('transactions.detail', $transaction->id) }}" class="btn btn-light rounded-pill px-4 btn-sm fw-bold">
                        Detail <i class="bi bi-chevron-right ms-1"></i>
                    </a>
                </div>
            </div>
            
            <hr class="my-4 opacity-10">
            
            <div class="d-flex align-items-center">
                <div class="flex-grow-1">
                    <div class="d-flex gap-2 overflow-auto">
                        @foreach($transaction->items as $item)
                        <img src="{{ $item->product->image_url }}" class="rounded shadow-xs" style="width: 40px; height: 40px; object-fit: cover;" title="{{ $item->product->name }}">
                        @endforeach
                    </div>
                </div>
                <div class="text-muted small">
                    {{ $transaction->items->count() }} Produk
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="card border-0 shadow-sm rounded-4 p-5 text-center">
        <div class="py-5">
            <i class="bi bi-bag-x fs-1 text-muted opacity-25 d-block mb-3"></i>
            <h5 class="text-muted fw-bold">Anda belum memiliki riwayat belanja</h5>
            <p class="text-muted mb-4">Ayo mulai belanja dan temukan koleksi nail art impian Anda!</p>
            <a href="{{ route('shop.index') }}" class="btn btn-primary-custom rounded-pill px-5">
                Mulai Belanja Sekarang
            </a>
        </div>
    </div>
    @endforelse
</div>

<style>
    .bg-warning-subtle { background-color: #fff3cd; }
    .bg-success-subtle { background-color: #d1e7dd; }
    .bg-primary-subtle { background-color: #cfe2ff; }
    .bg-info-subtle { background-color: #cff4fc; }
    .bg-danger-subtle { background-color: #f8d7da; }
    .shadow-xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
</style>
@endsection
