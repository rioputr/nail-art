@extends('layouts.admin')

@section('title', 'Admin Reports')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold m-0">Admin Reports</h3>
    <a href="{{ route('admin.reports.export') }}" class="btn btn-danger text-white">
        <i class="bi bi-download me-2"></i> Export CSV
    </a>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <!-- Total Revenue -->
    <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100 p-3">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Total Pendapatan</h6>
                <h2 class="fw-bold mb-1 text-primary-custom">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</h2>
                <small class="text-muted">Total dari pesanan selesai & berhasil dibayar</small>
            </div>
        </div>
    </div>

    <!-- Average Order Value -->
    <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100 p-3">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Pendapatan Booking Per Bulan Ini</h6>
                <h2 class="fw-bold mb-1">Rp {{ number_format($stats['monthly_booking_revenue'], 0, ',', '.') }}</h2>
                <small class="text-muted">Total pendapatan booking bulan {{ \Carbon\Carbon::now()->translatedFormat('F') }}</small>
            </div>
        </div>
    </div>

    <!-- Monthly Bookings -->
    <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100 p-3">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Booking Bulan Ini</h6>
                <h2 class="fw-bold mb-1">{{ number_format($stats['monthly_bookings']) }}</h2>
                <small class="text-muted">Jumlah reservasi di bulan {{ \Carbon\Carbon::now()->translatedFormat('F') }}</small>
            </div>
        </div>
    </div>
</div>

<!-- Charts -->
<div class="row g-4">
    <!-- Sales Trends -->
    <div class="col-md-6">
        <div class="card shadow-sm border-0 h-100 p-3">
            <div class="card-body">
                <h5 class="fw-bold mb-4">Sales Trends</h5>
                <canvas id="salesChart" height="200"></canvas>
                <div class="text-center mt-3">
                    <span class="badge rounded-pill bg-light text-dark border">
                        <span class="d-inline-block rounded-circle bg-secondary me-1" style="width: 8px; height: 8px;"></span>
                        Penjualan
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Booking Trends -->
    <div class="col-md-6">
        <div class="card shadow-sm border-0 h-100 p-3">
            <div class="card-body">
                <h5 class="fw-bold mb-4">Booking Trends</h5>
                <canvas id="bookingsChart" height="200"></canvas>
                <div class="text-center mt-3">
                    <span class="badge rounded-pill bg-light text-dark border">
                        <span class="d-inline-block rounded-circle" style="width: 8px; height: 8px; background-color: #ff4081;"></span>
                        Pemesanan
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Sales Chart (Line)
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: @json($chartData['sales']['labels']),
            datasets: [{
                label: 'Penjualan',
                data: @json($chartData['sales']['data']),
                borderColor: '#8d6e63', // Brownish tone matching mockup line
                backgroundColor: 'rgba(141, 110, 99, 0.1)',
                borderWidth: 2,
                tension: 0.4, // Smooth curve
                pointRadius: 0
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: false,
                    grid: { display: true, drawBorder: false }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });

    // Booking Chart (Bar)
    const bookingCtx = document.getElementById('bookingsChart').getContext('2d');
    new Chart(bookingCtx, {
        type: 'bar',
        data: {
            labels: @json($chartData['bookings']['labels']),
            datasets: [{
                label: 'Pemesanan',
                data: @json($chartData['bookings']['data']),
                backgroundColor: '#ff4081', // Pink tone matching mockup
                borderRadius: 4,
                barThickness: 30
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { display: true, drawBorder: false }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
</script>
@endpush
