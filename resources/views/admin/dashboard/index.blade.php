@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <!-- Total Penjualan -->
        <div class="col-xl-3 col-md-6">
            <div class="card stats-card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <p class="text-muted mb-1 small">Total Penjualan</p>
                            <h3 class="fw-bold mb-0">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</h3>
                            <small class="text-muted">
                                Berdasarkan pesanan lunas
                            </small>
                        </div>
                        <div class="stats-icon bg-primary-soft">
                            <i class="bi bi-wallet2 text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pemesanan Hari Ini -->
        <div class="col-xl-3 col-md-6">
            <div class="card stats-card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <p class="text-muted mb-1 small">Booking Hari Ini</p>
                            <h3 class="fw-bold mb-0">{{ $stats['bookings_today'] }}</h3>
                            <small class="text-muted">
                                Reservasi terjadwal hari ini
                            </small>
                        </div>
                        <div class="stats-icon bg-success-soft">
                            <i class="bi bi-calendar-check text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pengguna Terdaftar -->
        <div class="col-xl-3 col-md-6">
            <div class="card stats-card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <p class="text-muted mb-1 small">Total Pelanggan</p>
                            <h3 class="fw-bold mb-0">{{ $stats['total_users'] }}</h3>
                            <small class="text-muted">
                                Pengguna terdaftar aktif
                            </small>
                        </div>
                        <div class="stats-icon bg-info-soft">
                            <i class="bi bi-people text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pesanan Tertunda -->
        <div class="col-xl-3 col-md-6">
            <div class="card stats-card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <p class="text-muted mb-1 small">Pesanan Tertunda</p>
                            <h3 class="fw-bold mb-0">{{ $stats['pending_orders'] }}</h3>
                            <small class="text-muted">
                                Menunggu konfirmasi bayar
                            </small>
                        </div>
                        <div class="stats-icon bg-warning-soft">
                            <i class="bi bi-clock-history text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- Sales Chart -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title fw-bold mb-0">Tren Bisnis (14 Hari)</h5>
                        <div class="small text-muted">Pendapatan vs Volume</div>
                    </div>
                    <div style="height: 250px;">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions 
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold mb-3">Tindakan Cepat</h5>
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.products.create') }}" class="btn btn-primary-custom rounded-pill py-2">
                            <i class="bi bi-plus-circle me-2"></i>Tambah Produk
                        </a>
                        <a href="{{ route('admin.collections.create') }}" class="btn btn-outline-secondary rounded-pill py-2">
                            <i class="bi bi-grid me-2"></i>Koleksi Baru
                        </a>
                        <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary rounded-pill py-2">
                            <i class="bi bi-calendar-event me-2"></i>Kelola Booking
                        </a>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary rounded-pill py-2">
                            <i class="bi bi-cart me-2"></i>Cek Pesanan
                        </a>
                        <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-secondary rounded-pill py-2">
                            <i class="bi bi-graph-up-arrow me-2"></i>Laporan Detail
                        </a>
                    </div>
                </div>
            </div>
        </div>-->
    </div>

    <!-- Recent Activity Section -->
    <div class="row">
        <!-- Recent Transactions -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title fw-bold mb-0">Transaksi Toko Terbaru</h5>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-link text-decoration-none p-0 text-primary-custom fw-bold small">Lihat Semua</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle border-0">
                            <thead>
                                <tr class="text-muted small">
                                    <th class="border-0">KODE</th>
                                    <th class="border-0">PELANGGAN</th>
                                    <th class="border-0">TOTAL</th>
                                    <th class="border-0">STATUS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentTransactions ?? [] as $t)
                                <tr>
                                    <td class="border-0 fw-bold">#{{ $t->transaction_code }}</td>
                                    <td class="border-0">
                                        <div class="d-flex flex-column">
                                            <span class="fw-medium small">{{ $t->user->name ?? 'Guest' }}</span>
                                            <span class="text-muted" style="font-size: 10px;">{{ $t->created_at->diffForHumans() }}</span>
                                        </div>
                                    </td>
                                    <td class="border-0 text-primary-custom fw-bold small">Rp {{ number_format($t->total_amount, 0, ',', '.') }}</td>
                                    <td class="border-0">
                                        @php
                                            $badgeClass = [
                                                'pending' => 'bg-warning-subtle text-warning',
                                                'paid' => 'bg-info-subtle text-info',
                                                'shipped' => 'bg-primary-subtle text-primary',
                                                'completed' => 'bg-success-subtle text-success',
                                                'cancelled' => 'bg-danger-subtle text-danger',
                                            ][$t->status] ?? 'bg-secondary-subtle text-secondary';
                                        @endphp
                                        <span class="badge {{ $badgeClass }} border-0 rounded-pill px-2 py-1" style="font-size: 10px;">{{ ucfirst($t->status) }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted small">Belum ada transaksi.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Bookings -->
        <div class="col-lg-5 mt-4 mt-lg-0">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title fw-bold mb-0">Booking Terbaru</h5>
                        <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-link text-decoration-none p-0 text-primary-custom fw-bold small">Lihat Semua</a>
                    </div>
                    <div class="activity-feed">
                        @forelse($recentBookings ?? [] as $booking)
                        <div class="d-flex align-items-start mb-4">
                            <div class="bg-primary-soft rounded-3 p-2 me-3">
                                <i class="bi bi-calendar-event text-primary-custom"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h6 class="fw-bold mb-0 small">{{ $booking->name }}</h6>
                                    <span class="text-muted" style="font-size: 10px;">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M') }}</span>
                                </div>
                                <p class="text-muted small mb-1">{{ Str::limit($booking->service_details, 30) }}</p>
                                <span class="badge border-0 rounded-pill px-2 py-1 
                                    @if($booking->status == 'confirmed') bg-success-subtle text-success 
                                    @elseif($booking->status == 'pending') bg-warning-subtle text-warning 
                                    @else bg-danger-subtle text-danger @endif" 
                                    style="font-size: 10px;">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-5 text-muted small">Belum ada booking.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sales Chart
    const ctx = document.getElementById('salesChart');
    
    if (ctx) {
        const gradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(139, 115, 85, 0.4)');
        gradient.addColorStop(1, 'rgba(139, 115, 85, 0.05)');
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($chartLabels),
                datasets: [
                {
                    label: 'Pendapatan (Rp)',
                    data: @json($salesTrend),
                    borderColor: '#E91E63',
                    backgroundColor: 'rgba(233, 30, 99, 0.05)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 3,
                    pointBackgroundColor: '#E91E63',
                    yAxisID: 'y',
                },
                {
                    label: 'Jumlah Booking',
                    data: @json($bookingsTrend),
                    borderColor: '#4A5568',
                    backgroundColor: 'transparent',
                    borderWidth: 2,
                    borderDash: [5, 5],
                    fill: false,
                    tension: 0.4,
                    pointRadius: 3,
                    pointBackgroundColor: '#4A5568',
                    yAxisID: 'y1',
                }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        align: 'end',
                        labels: {
                            boxWidth: 20,
                            padding: 20,
                            font: { size: 11 }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#fff',
                        titleColor: '#1a202c',
                        bodyColor: '#1a202c',
                        borderColor: '#e2e8f0',
                        borderWidth: 1,
                        padding: 12,
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.datasetIndex === 0) {
                                    label += 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                                } else {
                                    label += context.parsed.y + ' Order';
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        beginAtZero: true,
                        grid: { color: '#f7fafc', drawBorder: false },
                        ticks: {
                            callback: function(value) {
                                if (value >= 1000000) return 'Rp' + (value/1000000).toFixed(1) + 'jt';
                                if (value >= 1000) return 'Rp' + (value/1000).toFixed(0) + 'rb';
                                return 'Rp' + value;
                            },
                            font: { size: 10 }
                        }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        beginAtZero: true,
                        grid: { drawOnChartArea: false },
                        ticks: {
                            stepSize: 1,
                            font: { size: 10 }
                        },
                        title: {
                            display: true,
                            text: 'Volume Booking',
                            font: { size: 10 }
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 10 } }
                    }
                }
            }
        });
    }
});
</script>
@endpush
@endsection