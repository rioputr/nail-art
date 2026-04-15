@extends('layouts.app')

@section('title', 'Keranjang Belanja - Caroline Nail Art')

@section('content')
<div class="container my-5">
    <div class="row g-4">
        <!-- Cart Items -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white p-4 border-bottom">
                    <h4 class="fw-bold mb-0">Keranjang Belanja <span class="text-muted fs-6 fw-normal">({{ session('cart') ? count(session('cart')) : 0 }} item)</span></h4>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3 text-muted small fw-bold text-uppercase">Produk</th>
                                    <th class="py-3 text-muted small fw-bold text-uppercase text-center">Harga</th>
                                    <th class="py-3 text-muted small fw-bold text-uppercase text-center">Jumlah</th>
                                    <th class="py-3 text-muted small fw-bold text-uppercase text-center">Subtotal</th>
                                    <th class="py-3 text-muted small fw-bold text-uppercase text-end pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0 @endphp
                                @if(session('cart') && count(session('cart')) > 0)
                                    @foreach(session('cart') as $id => $details)
                                        @php $total += $details['price'] * $details['quantity'] @endphp
                                        <tr data-id="{{ $id }}">
                                            <td class="ps-4 py-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-3 overflow-hidden shadow-sm me-3" style="width: 80px; height: 80px;">
                                                        <img src="{{ $details['image'] }}" 
                                                             class="w-100 h-100 object-fit-cover" 
                                                             onerror="this.src='https://placehold.co/80x80?text=Product'">
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-1 fw-bold">{{ $details['name'] }}</h6>
                                                        <span class="badge bg-light text-primary-custom border border-primary-custom-subtle rounded-pill small">Original</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center fw-medium">Rp {{ number_format($details['price'], 0, ',', '.') }}</td>
                                            <td class="text-center" style="width: 140px;">
                                                <div class="input-group input-group-sm quantity-control mx-auto">
                                                    <button class="btn btn-outline-secondary rounded-start-pill update-cart-qty px-2" data-action="minus">
                                                        <i class="bi bi-dash"></i>
                                                    </button>
                                                    <input type="number" value="{{ $details['quantity'] }}" 
                                                           class="form-control text-center cart-qty-input border-secondary-subtle" 
                                                           readonly style="max-width: 50px;">
                                                    <button class="btn btn-outline-secondary rounded-end-pill update-cart-qty px-2" data-action="plus">
                                                        <i class="bi bi-plus"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <td class="text-center fw-bold text-dark">Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}</td>
                                            <td class="text-end pe-4">
                                                <button class="btn btn-sm btn-light text-danger rounded-circle shadow-sm remove-from-cart" style="width: 36px; height: 36px;">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <div class="py-4">
                                                <i class="bi bi-cart-x fs-1 text-muted d-block mb-3 opacity-25"></i>
                                                <h5 class="text-muted fw-bold">Keranjang Anda masih kosong</h5>
                                                <p class="text-muted mb-4 small">Mungkin ini saat yang tepat untuk memanjakan kuku Anda!</p>
                                                <a href="{{ route('shop.index') }}" class="btn btn-primary-custom rounded-pill px-4">
                                                    Mulai Belanja <i class="bi bi-arrow-right ms-2"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="mt-4">
                <a href="{{ route('shop.index') }}" class="btn btn-link link-secondary text-decoration-none p-0 fw-medium small">
                    <i class="bi bi-arrow-left me-2"></i> Kembali Belanja
                </a>
            </div>
        </div>

        <!-- Summary Sidebar -->
        <div class="col-lg-4">
            <div class="sticky-top" style="top: 100px;">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                    <div class="card-header bg-white p-4 border-bottom">
                        <h5 class="fw-bold mb-0">Ringkasan Pesanan</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between mb-3 text-muted">
                            <span>Subtotal</span>
                            <span class="fw-medium">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-4 text-muted">
                            <span>Pengiriman</span>
                            <span class="text-success fw-medium small">Gratis (Promo)</span>
                        </div>
                        <hr class="opacity-10 mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0 fw-bold">Total</h5>
                            <h4 class="mb-0 fw-bold text-primary-custom">Rp {{ number_format($total, 0, ',', '.') }}</h4>
                        </div>
                        
                        <a href="{{ route('checkout') }}" 
                           class="btn btn-primary-custom w-100 py-3 rounded-pill fw-bold shadow-sm mb-3 {{ (!session('cart') || count(session('cart')) == 0) ? 'disabled' : '' }}">
                            Lanjut ke Pembayaran <i class="bi bi-credit-card ms-2"></i>
                        </a>
                        
                        <div class="text-center">
                            <p class="text-muted small mb-0"><i class="bi bi-shield-check me-1 text-success"></i> Transaksi Aman & Terenkripsi</p>
                        </div>
                    </div>
                </div>
                
                <!-- Promo Card 
                <div class="card border-0 bg-light rounded-4 shadow-sm">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3"><i class="bi bi-tag text-primary-custom me-2"></i>Punya Kode Promo?</h6>
                        <div class="input-group shadow-sm rounded-pill overflow-hidden border">
                            <input type="text" class="form-control border-0 px-4 small" placeholder="Masukkan kode...">
                            <button class="btn btn-dark px-4 fw-bold">Pakai</button>
                        </div>
                    </div>
                </div>-->
            </div>
        </div>
    </div>
</div>

<style>
    .quantity-control .btn {
        background-color: #f8f9fa;
        border-color: #dee2e6;
    }
    .quantity-control .btn:hover {
        background-color: #e9ecef;
        border-color: var(--primary-pink);
        color: var(--primary-pink);
    }
    .object-fit-cover {
        object-fit: cover;
    }
    .cart-qty-input::-webkit-outer-spin-button,
    .cart-qty-input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
    $(".update-cart-qty").click(function (e) {
        e.preventDefault();
        var ele = $(this);
        var id = ele.parents("tr").attr("data-id");
        var input = ele.siblings("input");
        var currentVal = parseInt(input.val());
        var action = ele.attr("data-action");
        
        var newVal = currentVal;
        if(action == 'plus') {
            newVal = currentVal + 1;
        } else if(action == 'minus' && currentVal > 1) {
            newVal = currentVal - 1;
        }
        
        if(newVal != currentVal) {
            $.ajax({
                url: '{{ route('update.cart') }}',
                method: "patch",
                data: {
                    _token: '{{ csrf_token() }}', 
                    id: id, 
                    quantity: newVal
                },
                success: function (response) {
                    window.location.reload();
                }
            });
        }
    });

    $(".remove-from-cart").click(function (e) {
        e.preventDefault();
        var ele = $(this);
        if(confirm("Apakah Anda yakin ingin menghapus produk ini?")) {
            $.ajax({
                url: '{{ route('remove.from.cart') }}',
                method: "DELETE",
                data: {
                    _token: '{{ csrf_token() }}', 
                    id: ele.parents("tr").attr("data-id")
                },
                success: function (response) {
                    window.location.reload();
                }
            });
        }
    });
</script>
@endsection