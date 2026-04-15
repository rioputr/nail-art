@extends('layouts.app')

@section('title', 'Shop - Caroline Nail Art')

@section('content')
<div class="container py-5">
    <div class="text-center mb-4">
        <h1 class="display-5 fw-bold mb-3">Caroline Shop</h1>
        <p class="text-muted">Temukan produk nail art terbaik untuk Anda</p>
    </div>

    <!-- Search Bar -->
    <div class="row justify-content-center mb-5">
        <div class="col-md-6">
            <div class="input-group input-group-lg shadow-sm">
                <span class="input-group-text bg-white border-end-0">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </span>
                <input type="text" id="searchInput" class="form-control border-start-0" placeholder="Cari produk...">
            </div>
        </div>
    </div>

    <!-- Top Bar -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <p class="text-muted mb-0">Menampilkan <span id="productCount">{{ $products->total() }}</span> Produk</p>
        <div class="d-flex gap-3">
            <form method="GET" action="{{ route('shop.index') }}" id="sortForm">
                <select class="form-select" name="sort_by" onchange="this.form.submit()">
                    <option value="terbaru" {{ ($sortBy ?? 'terbaru') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                    <option value="termurah" {{ ($sortBy ?? '') == 'termurah' ? 'selected' : '' }}>Termurah</option>
                    <option value="termahal" {{ ($sortBy ?? '') == 'termahal' ? 'selected' : '' }}>Termahal</option>
                    <option value="populer" {{ ($sortBy ?? '') == 'populer' ? 'selected' : '' }}>Populer</option>
                </select>
            </form>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="row g-4" id="productsGrid">
        @forelse($products as $product)
        <div class="col-sm-6 col-md-4 col-lg-3 product-wrapper">
            <div class="card h-100 shadow-sm product-card border-0 rounded-3" data-name="{{ strtolower($product->name) }}">
                <div class="position-relative overflow-hidden rounded-top-3">
                    @if($product->is_popular)
                        <span class="badge bg-warning text-dark position-absolute top-0 start-0 m-2 z-1">Populer</span>
                    @endif
                    <img src="{{ $product->image_url }}" class="card-img-top" style="height:280px;object-fit:cover;" 
                         onerror="this.src='https://placehold.co/400x400/f8f9fa/6c757d?text={{ urlencode($product->name) }}'"
                         alt="{{ $product->name }}">
                </div>
                <div class="card-body d-flex flex-column">
                    <h6 class="fw-semibold product-name mb-2">{{ $product->name }}</h6>
                    <div class="mb-3">
                        <span class="text-danger fw-bold fs-5">Rp{{ number_format($product->price,0,',','.') }}</span>
                        @if(isset($product->original_price) && $product->original_price)
                            <small class="text-muted text-decoration-line-through ms-2">Rp{{ number_format($product->original_price,0,',','.') }}</small>
                        @endif
                    </div>
                    <a href="{{ route('add.to.cart', $product->id) }}" class="btn btn-danger mt-auto rounded-pill">
                        <i class="bi bi-cart-plus me-1"></i> Tambah ke Keranjang
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <img src="https://illustrations.popsy.co/gray/question-mark.svg" height="150" class="mb-3">
            <h5 class="text-muted">Tidak ada produk tersedia</h5>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-5">
        {{ $products->links() }}
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('searchInput');
    const cards = document.querySelectorAll('.product-card');
    const countTop = document.getElementById('productCount');
    const totalProducts = {{ $products->total() }};

    function filterProducts() {
        const term = searchInput ? searchInput.value.toLowerCase().trim() : '';
        let visible = 0;

        cards.forEach(card => {
            const productName = card.getAttribute('data-name') || '';
            
            // Check if search term matches
            const matchText = term === '' || productName.includes(term);

            // Show or hide the product
            const wrapper = card.closest('.product-wrapper');
            if (wrapper) {
                if (matchText) {
                    wrapper.style.display = '';
                    visible++;
                } else {
                    wrapper.style.display = 'none';
                }
            }
        });

        // Update counter
        if(countTop) {
            countTop.textContent = visible;
        }

        // Show message if no products found
        const noResultsMsg = document.getElementById('noResultsMessage');
        if (visible === 0 && term !== '') {
            if (!noResultsMsg) {
                const grid = document.getElementById('productsGrid');
                const msg = document.createElement('div');
                msg.id = 'noResultsMessage';
                msg.className = 'col-12 text-center py-5';
                msg.innerHTML = `
                    <img src="https://illustrations.popsy.co/gray/search.svg" height="150" class="mb-3">
                    <h5 class="text-muted">Produk "${term}" tidak ditemukan</h5>
                    <p class="text-muted">Coba kata kunci lain</p>
                `;
                grid.appendChild(msg);
            }
        } else if (noResultsMsg) {
            noResultsMsg.remove();
        }
    }

    // Event listener for search input (real-time)
    if(searchInput) {
        searchInput.addEventListener('input', filterProducts);
        
        // Event listener for Enter key
        searchInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault(); // Prevent form submission
                filterProducts();
                searchInput.blur(); // Remove focus from input
            }
        });
    }

    // Run initial filter to show all products
    filterProducts();
});
</script>
@endpush
@endsection