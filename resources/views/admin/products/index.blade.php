@extends('layouts.admin')

@section('title', 'Manajemen Produk')

@section('content')
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h3 class="fw-bold">Manajemen Produk</h3>
        <p class="text-muted">
            Kelola daftar produk nail art Anda, termasuk detail, stok, dan status ketersediaan.
        </p>
    </div>

    <button class="btn btn-danger"
            data-bs-toggle="modal"
            data-bs-target="#createProductModal">
        <i class="bi bi-plus"></i> Tambah Produk
    </button>
</div>

<!-- Toolbar -->
<div class="d-flex gap-2 mb-3">
    <input type="text" class="form-control w-25" placeholder="Cari produk...">
    <button class="btn btn-outline-secondary">
        <i class="bi bi-funnel"></i> Filter
    </button>
</div>

<!-- Table -->
<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th><input type="checkbox"></th>
                    <th>Thumbnail</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>

                @forelse($products as $product)
                    <tr>
                        <td><input type="checkbox"></td>
                        <td>
                            <img src="{{ $product->image_url ?? 'https://via.placeholder.com/50' }}"
                                 class="rounded" width="50">
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td>{{ $product->stock ?? '-' }}</td>
                        <td>
                            @if($product->status == 'active')
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-danger">Tidak Aktif</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-outline-secondary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editProductModal{{ $product->id }}">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>

                    {{-- Modal edit (HARUS di dalam foreach) --}}
                    @include('admin.products.edit-modal', ['product' => $product])
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">
                            Belum ada produk
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>
</div>

<!-- Pagination (opsional, kalau pakai paginate) -->
{{-- {{ $products->links() }} --}}

{{-- Modal create (TIDAK butuh $product) --}}
@include('admin.products.create-modal')

@endsection
