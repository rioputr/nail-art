@extends('layouts.app')

@section('title', 'Invoice #' . $transaction->transaction_code)

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-5">
                    <!-- Invoice Header -->
                    <div class="d-flex justify-content-between align-items-center mb-5">
                        <div>
                            <img src="/img/logo.png" alt="Logo" style="height: 40px;" class="mb-3">
                            <h4 class="fw-bold mb-0 text-primary-custom">Caroline Nail Art</h4>
                            <small class="text-muted">Invoice Pemesanan Produk</small>
                        </div>
                        <div class="text-end">
                            <h2 class="fw-bold text-dark mb-1">INVOICE</h2>
                            <p class="text-muted mb-0">#{{ $transaction->transaction_code }}</p>
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="col-md-6">
                            <h6 class="text-muted small fw-bold mb-3 uppercase">DITAGIHKAN KEPADA:</h6>
                            <p class="fw-bold text-dark mb-1">{{ $transaction->user->name }}</p>
                            <p class="text-muted mb-1 small">{{ $transaction->user->email }}</p>
                            <p class="text-muted mb-0 small">{{ $transaction->user->phone }}</p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <h6 class="text-muted small fw-bold mb-3 uppercase">DIKIRIM KE:</h6>
                            <p class="text-dark mb-1 small">{{ $transaction->shipping_address }}</p>
                            
                            @php
                                $statusClass = [
                                    'pending' => 'bg-warning-subtle text-warning border-warning-subtle',
                                    'paid' => 'bg-success-subtle text-success border-success-subtle',
                                    'shipped' => 'bg-primary-subtle text-primary border-primary-subtle',
                                    'completed' => 'bg-info-subtle text-info border-info-subtle',
                                    'cancelled' => 'bg-danger-subtle text-danger border-danger-subtle',
                                ][$transaction->status] ?? 'bg-secondary-subtle text-secondary border-secondary-subtle';
                            @endphp
                            <span class="badge {{ $statusClass }} border rounded-pill px-3 py-1">
                                <i class="bi bi-info-circle me-1"></i> {{ ucfirst($transaction->status) }}
                            </span>
                        </div>
                    </div>

                    @if(!$transaction->payment_receipt && $transaction->payment_method === 'bank_transfer')
                    <div class="card border-0 bg-light rounded-4 mb-5 shadow-none border-dashed">
                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-3">Selesaikan Pembayaran</h6>
                            <p class="small text-muted mb-4">Silakan transfer ke rekening BCA 123-456-7890 a/n Caroline Nail Art Shop dan unggah bukti transfer di bawah ini.</p>
                            
                            <form action="{{ route('transactions.uploadReceipt', $transaction->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="d-md-flex gap-3 align-items-center">
                                    <div class="flex-grow-1">
                                        <input type="file" name="payment_receipt" class="form-control rounded-pill" accept="image/*" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary-custom rounded-pill mt-3 mt-md-0 px-4 fw-bold">
                                        Unggah Bukti <i class="bi bi-upload ms-2"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    @elseif($transaction->payment_receipt)
                    <div class="mb-5 p-3 border rounded-4 text-center bg-light">
                        <small class="text-muted d-block mb-2">Bukti Pembayaran Terlampir:</small>
                        <a href="{{ asset('storage/' . $transaction->payment_receipt) }}" target="_blank">
                             <img src="{{ asset('storage/' . $transaction->payment_receipt) }}" class="rounded shadow-sm" style="height: 60px;">
                        </a>
                    </div>
                    @endif

                    <!-- Items Table -->
                    <div class="table-responsive mb-5">
                        <table class="table align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-3 py-3 border-0 small fw-bold">PRODUK</th>
                                    <th class="text-center py-3 border-0 small fw-bold">JUMLAH</th>
                                    <th class="text-end pe-3 py-3 border-0 small fw-bold">SUBTOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transaction->items as $item)
                                <tr>
                                    <td class="ps-3 py-4">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $item->product->image_url }}" class="rounded shadow-sm me-3" style="width: 40px; height: 40px; object-fit: cover;">
                                            <span class="fw-bold text-dark">{{ $item->product->name }}</span>
                                        </div>
                                    </td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-end pe-3 fw-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="border-top">
                                <tr>
                                    <td colspan="2" class="text-end py-3 fw-bold text-muted">Subtotal</td>
                                    <td class="text-end pe-3 py-3 fw-bold">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-end py-3 fw-bold text-dark fs-5">Total Pembayaran</td>
                                    <td class="text-end pe-3 py-3 fw-bold text-primary-custom fs-5">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="bg-light p-4 rounded-4 mb-5">
                        <h6 class="fw-bold mb-2">Informasi Tambahan:</h6>
                        <ul class="text-muted small mb-0">
                            <li>Pesanan Anda akan segera diproses setelah verifikasi pembayaran manual (jika menggunakan Bank Transfer).</li>
                            <li>Estimasi pengiriman adalah 2-3 hari kerja.</li>
                            <li>Anda dapat memantau status pesanan di menu Riwayat Transaksi.</li>
                        </ul>
                    </div>

                    <div class="text-center">
                        <a href="{{ route('shop.index') }}" class="btn btn-outline-secondary rounded-pill px-4 me-2">Back to Shop</a>
                        <button onclick="window.print()" class="btn btn-primary-custom rounded-pill px-4">
                            <i class="bi bi-printer me-2"></i> Cetak Invoice
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        .btn, .navbar, .footer { display: none !important; }
        .card { box-shadow: none !important; border: 1px solid #eee !important; }
    }
    .bg-success-subtle { background-color: #d1e7dd; }
    .bg-warning-subtle { background-color: #fff3cd; }
    .bg-primary-subtle { background-color: #cfe2ff; }
    .bg-info-subtle { background-color: #cff4fc; }
    .bg-danger-subtle { background-color: #f8d7da; }
    .border-dashed { border-style: dashed !important; border-width: 2px !important; border-color: #dee2e6 !important; }
    .uppercase { text-transform: uppercase; }
</style>
@endsection
