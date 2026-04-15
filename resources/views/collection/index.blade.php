@extends('layouts.app')

@section('title', 'Koleksi Nail Art - Caroline Nail Art')

@section('content')
<div class="container py-5">
    <div class="text-center mb-4">
        <h1 class="display-5 fw-bold mb-3">Koleksi Nail Art</h1>
        <p class="text-muted">Jelajahi berbagai pilihan seni kuku terbaik untuk menunjang penampilan Anda</p>
    </div>
    <!-- Top Bar -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <p class="text-muted mb-0">Menampilkan <span id="collectionCount">{{ count($collections) }}</span> Koleksi</p>
    </div>

    <!-- Collections Grid -->
    <div class="row g-4" id="collectionsGrid">
        @forelse($collections as $collection)
        <div class="col-sm-6 col-md-4 col-lg-3 collection-wrapper">
            <div class="card h-100 shadow-sm collection-card border-0 rounded-3" data-name="{{ strtolower($collection->name) }}" data-description="{{ strtolower($collection->description ?? '') }}">
                <div class="position-relative overflow-hidden rounded-top-3">
                    @if($collection->category)
                        <span class="badge bg-danger position-absolute top-0 start-0 m-2 z-1">{{ ucfirst($collection->category) }}</span>
                    @endif
                    <img src="{{ $collection->image_url }}" class="card-img-top" style="height:280px;object-fit:cover;" 
                         onerror="this.src='https://placehold.co/400x400/f8f9fa/6c757d?text={{ urlencode($collection->name) }}'"
                         alt="{{ $collection->name }}">
                </div>
                <div class="card-body d-flex flex-column">
                    <h6 class="fw-semibold collection-name mb-2">{{ $collection->name }}</h6>
                    <p class="card-text text-muted small mb-3 flex-grow-1">{{ Str::limit($collection->description, 100) }}</p>
                    <a href="{{ route('collection.detail', $collection->slug) }}" class="btn btn-outline-danger mt-auto rounded-pill">
                        <i class="bi bi-eye me-1"></i> Lihat Detail
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <img src="https://illustrations.popsy.co/gray/question-mark.svg" height="150" class="mb-3">
            <h5 class="text-muted">Tidak ada koleksi tersedia</h5>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if(method_exists($collections, 'links'))
    <div class="d-flex justify-content-center mt-5">
        {{ $collections->links() }}
    </div>
    @endif
</div>

<style>
    .collection-card {
        transition: all 0.3s ease;
    }
    
    .collection-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(233, 30, 99, 0.15) !important;
    }

    .collection-card .card-img-top {
        transition: transform 0.3s ease;
    }

    .collection-card:hover .card-img-top {
        transform: scale(1.05);
    }

    .btn-outline-danger {
        border-color: #dc3545;
        color: #dc3545;
    }

    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: white;
    }
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('searchInput');
    const cards = document.querySelectorAll('.collection-card');
    const countTop = document.getElementById('collectionCount');
    const totalCollections = {{ count($collections) }};

    function filterCollections() {
        const term = searchInput ? searchInput.value.toLowerCase().trim() : '';
        let visible = 0;

        cards.forEach(card => {
            const collectionName = card.getAttribute('data-name') || '';
            const collectionDesc = card.getAttribute('data-description') || '';
            
            // Check if search term matches name or description
            const matchText = term === '' || collectionName.includes(term) || collectionDesc.includes(term);

            // Show or hide the collection
            const wrapper = card.closest('.collection-wrapper');
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

        // Show message if no collections found
        const noResultsMsg = document.getElementById('noResultsMessage');
        if (visible === 0 && term !== '') {
            if (!noResultsMsg) {
                const grid = document.getElementById('collectionsGrid');
                const msg = document.createElement('div');
                msg.id = 'noResultsMessage';
                msg.className = 'col-12 text-center py-5';
                msg.innerHTML = `
                    <img src="https://illustrations.popsy.co/gray/search.svg" height="150" class="mb-3">
                    <h5 class="text-muted">Koleksi "${term}" tidak ditemukan</h5>
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
        searchInput.addEventListener('input', filterCollections);
        
        // Event listener for Enter key
        searchInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                filterCollections();
                searchInput.blur();
            }
        });
    }

    // Run initial filter
    filterCollections();
});
</script>
@endpush
@endsection
