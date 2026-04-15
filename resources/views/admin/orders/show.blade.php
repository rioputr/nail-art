@extends('layouts.admin')

@section('title', 'Detail Pesanan #' . $order->transaction_code)

@section('content')
<div class="d-flex align-items-center mb-4">
    <a href="{{ route('admin.orders.index') }}" class="btn btn-light rounded-3 me-3">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h3 class="fw-bold text-dark mb-0">Detail Pesanan #{{ $order->transaction_code }}</h3>
</div>

<div class="row g-4">
    <!-- Order Items & Summary -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white border-bottom p-4">
                <h5 class="fw-bold mb-0 text-dark">Daftar Produk</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Produk</th>
                                <th class="text-center">Harga</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-end pe-4">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td class="ps-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $item->product->image_url }}" class="rounded-3 shadow-sm me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                        <div>
                                            <h6 class="mb-0 fw-bold fs-14 text-dark">{{ $item->product->name }}</h6>
                                            <small class="text-muted">{{ $item->product->category->name ?? 'Category' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td class="text-center">{{ $item->quantity }}</td>
                                <td class="text-end pe-4 fw-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="border-top">
                            <tr>
                                <td colspan="3" class="text-end ps-4 py-3 fw-bold">Subtotal</td>
                                <td class="text-end pe-4 py-3 fw-bold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            </tr>
                            <tr class="table-light">
                                <td colspan="3" class="text-end ps-4 py-3 fw-bold fs-5">Total Pembayaran</td>
                                <td class="text-end pe-4 py-3 fw-bold fs-5 text-primary">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        @if($order->payment_receipt)
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white border-bottom p-4">
                <h5 class="fw-bold mb-0 text-dark">Bukti Pembayaran</h5>
            </div>
            <div class="card-body p-4 text-center">
                <a href="{{ asset('storage/' . $order->payment_receipt) }}" target="_blank">
                    <img src="{{ asset('storage/' . $order->payment_receipt) }}" class="img-fluid rounded shadow-sm" style="max-height: 400px;">
                </a>
                <p class="mt-3 text-muted small">Klik gambar untuk memperbesar</p>
            </div>
        </div>
        @endif
    </div>

    <!-- Customer & Status Info -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white border-bottom p-4">
                <h5 class="fw-bold mb-0 text-dark">Informasi Pelanggan</h5>
            </div>
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-4">
                    <div class="avatar-lg bg-soft-primary text-primary rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <span class="fs-3 fw-bold">{{ substr($order->user->name ?? 'G', 0, 1) }}</span>
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark mb-1">{{ $order->user->name ?? 'Guest User' }}</h6>
                        <p class="text-muted mb-0 small">{{ $order->user->email ?? '-' }}</p>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted small fw-bold">NOMOR TELEPON</label>
                    <p class="fw-medium text-dark mb-0"><i class="bi bi-telephone text-primary me-2"></i> {{ $order->user->phone ?? '-' }}</p>
                </div>
                <div>
                    <label class="form-label text-muted small fw-bold">ALAMAT PENGIRIMAN</label>
                    <p class="fw-medium text-dark mb-0"><i class="bi bi-geo-alt text-danger me-2"></i> {{ $order->shipping_address }}</p>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-bottom p-4">
                <h5 class="fw-bold mb-0 text-dark">Aksi Pesanan</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label text-muted small fw-bold">UPDATE STATUS SEKARANG</label>
                        <select name="status" class="form-select border-2 rounded-3">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending (Menunggu Bayar)</option>
                            <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Paid (Terbayar)</option>
                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped (Dikirim)</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed (Selesai)</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled (Dibatalkan)</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 rounded-3 py-2 fw-bold shadow-sm">
                        <i class="bi bi-save me-2"></i> Simpan Status Baru
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-soft-primary { background-color: rgba(13, 110, 253, 0.1); }
    .fs-14 { font-size: 14px; }
</style>
@endsection
