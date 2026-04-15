@extends('layouts.app')

@section('title', 'Checkout - Caroline Nail Art')

@section('content')
<div class="container my-5">
    <div class="row g-4">
        <!-- Billing & Shipping Details -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                <div class="card-header bg-white p-4 border-bottom">
                    <h4 class="fw-bold mb-0">Informasi Pengiriman</h4>
                </div>
                <div class="card-body p-4">
                    <form id="checkoutForm" action="{{ route('checkout.process') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label small fw-bold text-muted">NAMA LENGKAP</label>
                                <input type="text" name="name" class="form-control rounded-3" 
                                       value="{{ auth()->user()->name }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">EMAIL</label>
                                <input type="email" class="form-control rounded-3" 
                                       value="{{ auth()->user()->email }}" disabled>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">NOMOR TELEPON</label>
                                <input type="tel" name="phone" class="form-control rounded-3" 
                                       value="{{ auth()->user()->phone }}" placeholder="0812xxxx" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold text-muted">ALAMAT LENGKAP</label>
                                <textarea name="address" class="form-control rounded-3" rows="3" 
                                          placeholder="Nama jalan, Nomor rumah, Kecamatan, Kota" required>{{ auth()->user()->address }}</textarea>
                            </div>
                        </div>

                        <hr class="my-4 opacity-10">

                       <h5 class="fw-bold mb-3">Metode Pembayaran</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="payment-option border rounded-3 p-3 position-relative cursor-pointer active">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_method" id="bankTransfer" value="bank_transfer" checked>
                                        <label class="form-check-label fw-bold d-block" for=" bankTransfer">
                                            Transfer Bank
                                        </label>
                                    </div>
                                    <i class="bi bi-bank position-absolute top-50 end-0 translate-middle-y me-3 fs-4 text-muted"></i>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="payment-option border rounded-3 p-3 position-relative cursor-pointer">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_method" id="eWallet" value="ewallet">
                                        <label class="form-check-label fw-bold d-block" for="eWallet">
                                            E-Wallet (OVO/Gopay)
                                        </label>
                                    </div>
                                    <i class="bi bi-wallet2 position-absolute top-50 end-0 translate-middle-y me-3 fs-4 text-muted"></i>
                                </div>
                            </div>
                        </div>
 
                        <div id="bankInfoSection" class="p-4 bg-light rounded-4 border border-dashed mt-4">
                            <h6 class="fw-bold mb-3"><i class="bi bi-info-circle me-2 text-primary"></i> Informasi Transfer</h6>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted small">Bank:</span>
                                <span class="fw-bold small">Bank Central Asia (BCA)</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted small">No Rekening:</span>
                                <span class="fw-bold small text-primary-custom">123-456-7890</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                                <span class="text-muted small">Atas Nama:</span>
                                <span class="fw-bold small">Caroline Nail Art Shop</span>
                            </div>
                            
                            <div class="mb-0">
                                <label class="form-label small fw-bold">Unggah Bukti Transfer (Opsional)</label>
                                <input type="file" name="payment_receipt" class="form-control form-control-sm rounded-3 py-2" accept="image/*">
                                <small class="text-muted d-block mt-2">Format: JPG, PNG, Max 2MB. </small>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden sticky-top" style="top: 100px;">
                <div class="card-header bg-white p-4 border-bottom">
                    <h5 class="fw-bold mb-0">Ringkasan Pesanan</h5>
                </div>
                <div class="card-body p-4">
                    <div class="order-items mb-4">
                        @foreach($cartItems as $id => $item)
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-3 overflow-hidden border shadow-sm me-3" style="width: 50px; height: 50px;">
                                <img src="{{ $item['image'] }}" class="w-100 h-100 object-fit-cover" onerror="this.src='https://placehold.co/50x50?text=Product'">
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0 small fw-bold text-dark">{{ $item['name'] }}</h6>
                                <small class="text-muted">{{ $item['quantity'] }} x Rp {{ number_format($item['price'], 0, ',', '.') }}</small>
                            </div>
                            <span class="fw-bold small">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                    </div>

                    <hr class="opacity-10 mb-4">

                    <div class="d-flex justify-content-between mb-2 text-muted">
                        <span>Total Harga ({{ count($cartItems) }} produk)</span>
                        <span>Rp {{ number_format($totalAmount, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2 text-muted">
                        <span>Biaya Pengiriman</span>
                        <span class="text-success fw-bold small">GRATIS</span>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mt-4 mb-4 pt-4 border-top">
                        <h5 class="mb-0 fw-bold">Total Tagihan</h5>
                        <h4 class="mb-0 fw-bold text-primary-custom" id="totalPayment">Rp {{ number_format($totalAmount, 0, ',', '.') }}</h4>
                    </div>

                    <p class="text-muted small mb-4">
                        Dengan mengklik tombol di bawah, Anda setuju dengan <a href="#" class="text-primary-custom text-decoration-none">Syarat & Ketentuan</a> kami.
                    </p>

                    <button type="submit" form="checkoutForm" class="btn btn-primary-custom w-100 py-3 rounded-pill fw-bold shadow-sm">
                        Proses Pembayaran <i class="bi bi-arrow-right ms-2"></i>
                    </button>
                    
                    <div class="text-center mt-3">
                        <small class="text-muted"><i class="bi bi-lock-fill text-success me-1"></i></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .payment-option {
        transition: all 0.2s ease;
        border: 2px solid #eee !important;
    }
    .payment-option.active {
        border-color: var(--primary-pink) !important;
        background-color: #fff5f8;
    }
    .payment-option:hover {
        border-color: #dee2e6 !important;
    }
    .cursor-pointer { cursor: pointer; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const options = document.querySelectorAll('.payment-option');
    const bankSection = document.getElementById('bankInfoSection');
    
    options.forEach(opt => {
        opt.addEventListener('click', function() {
            options.forEach(o => o.classList.remove('active'));
            this.classList.add('active');
            const radio = this.querySelector('input');
            radio.checked = true;
            
            if (radio.value === 'bank_transfer') {
                bankSection.style.display = 'block';
            } else {
                bankSection.style.display = 'none';
            }
        });
    });
});
</script>
@endsection
