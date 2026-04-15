@extends('layouts.app')
@section('title', 'Profil Pengguna')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-md-3">
            <ul class="list-group list-group-flush shadow-sm rounded">
                <a href="{{ route('profile') }}" class="list-group-item list-group-item-action fw-bold {{ Request::is('profile') ? 'active-profile-custom' : '' }}">
                    <i class="fas fa-user-circle me-2"></i> Profil
                </a>
                <a href="{{ route('profile.edit') }}" class="list-group-item list-group-item-action {{ Request::is('profile/edit') ? 'active-profile-custom' : '' }}">
                    <i class="fas fa-cog me-2"></i> Pengaturan Akun
                </a>
                <a href="{{ route('transactions.history') }}" class="list-group-item list-group-item-action">
                    <i class="fas fa-history me-2"></i> Riwayat Transaksi
                </a>
               
                </a>
                </ul>
        </div>
        
        <div class="col-md-9">
        <div class="card p-4 text-center mb-5 shadow-sm">

    <img 
        src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : '/img/default-avatar.png' }}" 
        class="rounded-circle mx-auto mb-3 shadow-sm border" 
        style="width: 100px; height: 100px; object-fit: cover;"
    >

    <h3 class="fw-bold mb-1">
        {{ auth()->user()->name }}
    </h3>

    <p class="text-secondary mb-1">
        <i class="bi bi-envelope me-2"></i>
        {{ auth()->user()->email }}
    </p>

    <p class="text-secondary mb-1">
        <i class="bi bi-telephone me-2"></i>
        {{ auth()->user()->phone ?? '-' }}
    </p>

    <p class="text-secondary">
        <i class="bi bi-geo-alt me-2"></i>
        {{ auth()->user()->address ?? '-' }}
    </p>

    <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary btn-sm mt-2">
        <i class="bi bi-pencil-square me-1"></i> Edit Profil
    </a>

</div>


            <div class="row mb-5">
                <div class="col-md-6">
                    <h4 class="fw-bold mb-3">Riwayat Booking Terkini</h4>
                    @forelse($latestBookings as $booking)
                    <div class="border p-3 rounded mb-2 shadow-xs">
                        <div class="d-flex justify-content-between">
                            <p class="fw-bold mb-0">{{ $booking->service_name ?? 'Layanan' }}</p>
                            @php
                                $statusClass = [
                                    'pending' => 'bg-warning',
                                    'confirmed' => 'bg-primary',
                                    'completed' => 'bg-success',
                                    'cancelled' => 'bg-danger',
                                ][$booking->status] ?? 'bg-secondary';
                            @endphp
                            <span class="badge {{ $statusClass }}">{{ ucfirst($booking->status) }}</span>
                        </div>
                        <small class="text-secondary">{{ $booking->booking_date->format('Y-m-d') }}</small>
                    </div>
                    @empty
                    <div class="border p-3 rounded mb-2 text-center text-muted small">Belum ada riwayat booking.</div>
                    @endforelse
                    <a href="{{ route('booking.history') }}" class="text-primary-custom text-decoration-none fw-bold mt-2 d-block">Lihat Semua Booking <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
                <div class="col-md-6">
                    <h4 class="fw-bold mb-3">Ringkasan Pesanan Terkini</h4>
                    @forelse($latestTransactions as $transaction)
                    <div class="border p-3 rounded mb-2 shadow-xs">
                        <div class="d-flex justify-content-between">
                            <p class="fw-bold mb-0">
                                @if($transaction->items->count() > 0)
                                    {{ $transaction->items->first()->product->name }}
                                    @if($transaction->items->count() > 1)
                                        (+{{ $transaction->items->count() - 1 }} lainnya)
                                    @endif
                                @else
                                    Pesanan #{{ $transaction->transaction_code }}
                                @endif
                            </p>
                            @php
                                $statusClass = [
                                    'pending' => 'bg-warning',
                                    'paid' => 'bg-success',
                                    'shipped' => 'bg-info',
                                    'completed' => 'bg-primary',
                                    'cancelled' => 'bg-danger',
                                ][$transaction->status] ?? 'bg-secondary';
                            @endphp
                            <span class="badge {{ $statusClass }} text-dark">{{ ucfirst($transaction->status) }}</span>
                        </div>
                        <small class="text-secondary">{{ $transaction->created_at->format('Y-m-d') }}</small>
                    </div>
                    @empty
                    <div class="border p-3 rounded mb-2 text-center text-muted small">Belum ada riwayat pesanan.</div>
                    @endforelse
                    <a href="{{ route('transactions.history') }}" class="text-primary-custom text-decoration-none fw-bold mt-2 d-block">Lihat Semua Pesanan <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
            </div>

            <h4 class="fw-bold mb-3">Tautan Cepat</h4>
            <div class="d-flex gap-3">
                <a href="{{ route('transactions.history') }}" class="btn btn-outline-secondary"><i class="fas fa-receipt me-2"></i> Riwayat Transaksi</a>
                <a href="{{ route('booking.history') }}" class="btn btn-outline-secondary"><i class="fas fa-calendar-alt me-2"></i> Booking Saya</a>
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
    .list-group-item-action:hover {
        color: #E91E63 !important;
    }
    .shadow-xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
</style>
@endsection