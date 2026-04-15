@extends('layouts.admin')

@section('title', 'Manajemen Pesanan Toko')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold text-dark">Manajemen Pesanan</h3>
    <p class="text-muted">Kelola dan pantau status pengiriman pesanan produk dari toko.</p>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-visible">
    <div class="card-body p-0">
        <div>
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3">Kode Transaksi</th>
                        <th class="py-3">Pelanggan</th>
                        <th class="py-3">Total</th>
                        <th class="py-3">Tanggal</th>
                        <th class="py-3">Status</th>
                        <th class="py-3 text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td class="ps-4">
                                <span class="fw-bold">#{{ $order->transaction_code }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-3">
                                        <div class="avatar-title rounded-circle bg-soft-primary text-primary">
                                            {{ substr($order->user->name ?? 'G', 0, 1) }}
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fs-14">{{ $order->user->name ?? 'Guest' }}</h6>
                                        <p class="text-muted mb-0 small">{{ $order->user->email ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="fw-semibold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td class="text-muted small">{{ $order->created_at->format('d M Y, H:i') }}</td>
                            <td>
                                @php
                                    $statusClass = [
                                        'pending' => 'bg-warning-subtle text-warning border-warning-subtle',
                                        'paid' => 'bg-info-subtle text-info border-info-subtle',
                                        'shipped' => 'bg-primary-subtle text-primary border-primary-subtle',
                                        'completed' => 'bg-success-subtle text-success border-success-subtle',
                                        'cancelled' => 'bg-danger-subtle text-danger border-danger-subtle',
                                    ][$order->status] ?? 'bg-secondary-subtle text-secondary';
                                @endphp
                                <span class="badge {{ $statusClass }} border rounded-pill px-3 py-1">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light rounded-3 shadow-sm border" type="button" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-3">
                                        <li><a class="dropdown-item py-2" href="{{ route('admin.orders.show', $order->id) }}"><i class="bi bi-eye me-2"></i> Detail</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><h6 class="dropdown-header">Update Status</h6></li>
                                        <li>
                                            <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="status" value="shipped">
                                                <button type="submit" class="dropdown-item py-2 {{ $order->status == 'shipped' ? 'disabled' : '' }}"><i class="bi bi-truck me-2 text-primary"></i> Tandai Dikirim</button>
                                            </form>
                                        </li>
                                        <li>
                                            <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="status" value="completed">
                                                <button type="submit" class="dropdown-item py-2 {{ $order->status == 'completed' ? 'disabled' : '' }}"><i class="bi bi-check-circle me-2 text-success"></i> Selesai</button>
                                            </form>
                                        </li>
                                        <li>
                                            <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="status" value="cancelled">
                                                <button type="submit" class="dropdown-item py-2 text-danger {{ $order->status == 'cancelled' ? 'disabled' : '' }}"><i class="bi bi-x-circle me-2"></i> Batalkan</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="bi bi-cart-x fs-1 text-muted d-block mb-3"></i>
                                <span class="text-muted">Belum ada pesanan yang masuk.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($orders->count() > 0)
    <div class="card-footer bg-white border-top-0 p-4">
        {{ $orders->links() }}
    </div>
    @endif
</div>

<style>
    .bg-soft-primary { background-color: rgba(13, 110, 253, 0.1); }
    .avatar-sm { height: 40px; width: 40px; }
    .avatar-title { height: 100%; width: 100%; display: flex; align-items: center; justify-content: center; font-weight: bold; }
    .bg-warning-subtle { background-color: #fff3cd; }
    .bg-info-subtle { background-color: #cff4fc; }
    .bg-primary-subtle { background-color: #cfe2ff; }
    .bg-success-subtle { background-color: #d1e7dd; }
    .bg-danger-subtle { background-color: #f8d7da; }
</style>
@endsection
