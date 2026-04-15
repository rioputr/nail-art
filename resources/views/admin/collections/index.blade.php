@extends('layouts.admin')

@section('title', 'Collection Manager')

@section('content')
<div class="d-flex flex-column h-100">
    
    <!-- Page Title from Mockup -->
    <div class="mb-4">
        <h4 class="fw-bold text-secondary opacity-75">Collection Manager</h4>
    </div>

    <div class="row g-4 flex-grow-1" style="min-height: 0;">
        
        <!-- LEFT COLUMN: Collection List Card -->
        <div class="col-md-3 d-flex flex-column">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                <div class="card-header bg-white border-bottom-0 p-4 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold m-0 text-dark">Daftar Koleksi</h5>
                    <a href="{{ route('admin.collections.index') }}" class="btn btn-sm btn-outline-dark rounded-3 shadow-sm d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;" title="Tambah Koleksi Baru">
                        <i class="bi bi-plus-lg"></i>
                    </a>
                </div>
                
                <div class="card-body p-0 custom-scrollbar overflow-y-auto">
                    <div class="list-group list-group-flush p-3">
                        @forelse($collections as $col)
                            <a href="{{ route('admin.collections.index', ['edit' => $col->id]) }}" 
                               class="list-group-item list-group-item-action mb-3 rounded-3 border {{ (isset($selectedCollection) && $selectedCollection->id == $col->id) ? 'active-collection-card' : 'bg-white' }} p-3 position-relative overflow-hidden transition-all">
                                
                                <div class="d-flex gap-3">
                                    <img src="{{ $col->image_url }}" 
                                         class="rounded-3 object-fit-cover shadow-sm" width="60" height="60">
                                    <div class="flex-grow-1 d-flex flex-column justify-content-between">
                                        <h6 class="mb-0 fw-bold text-dark text-truncate" style="font-size: 0.95rem;">
                                            {{ $col->name }}
                                        </h6>
                                        <div class="d-flex justify-content-between align-items-center mt-2">
                                        <!-- <span class="text-muted small" style="font-size: 0.75rem;">{{ $col->products_count }} Produk</span> -->
                                            
                                            @if($col->is_published)
                                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2 py-0" style="font-size: 0.65rem;">Publikasi</span>
                                            @else
                                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill px-2 py-0" style="font-size: 0.65rem;">Draf</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="text-center py-5 text-muted">
                                <small>Belum ada koleksi</small>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: Detail/Edit Card -->
        <div class="col-md-9 d-flex flex-column">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                <div class="card-body p-0 d-flex flex-column">
                    
                    <!-- Form Content Scrollable Area -->
                    <div class="flex-grow-1 overflow-y-auto custom-scrollbar p-5">
                       
                        <form id="collectionForm" action="{{ isset($selectedCollection) ? route('admin.collections.update', $selectedCollection->id) : route('admin.collections.store') }}" 
                              method="POST" 
                              enctype="multipart/form-data">
                            @csrf
                            @if(isset($selectedCollection))
                                @method('PUT')
                            @endif

                            <!-- Header inside Detail Card -->
                            <div class="d-flex justify-content-between align-items-start mb-5">
                                <div>
                                    <h3 class="fw-bold text-dark m-0">
                                        {{ isset($selectedCollection) ? $selectedCollection->name : 'Koleksi Baru' }}
                                    </h3>
                                </div>

                                <div class="d-flex align-items-center gap-3">
                                    <!-- Pink Toggle Switch -->
                                    <div class="form-check form-switch custom-pink-switch d-flex align-items-center gap-2 m-0 bg-light px-3 py-2 rounded-pill border">
                                        <input class="form-check-input m-0 cursor-pointer" type="checkbox" role="switch" id="is_published" name="is_published" 
                                               style="width: 2.5em; height: 1.25em;"
                                               value="1" {{ (old('is_published', $selectedCollection->is_published ?? false)) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold small text-muted cursor-pointer" for="is_published">Publikasi</label>
                                    </div>

                                    @if(isset($selectedCollection))
                                       <!-- <button type="button" class="btn btn-outline-dark rounded-pill fw-bold btn-sm px-3 py-2">
                                            <i class="bi bi-pencil-square me-1"></i> Edit
                                        </button> -->
                                    @endif
                                </div>
                            </div>

                            <h6 class="fw-bold mb-3 text-dark">Detail Koleksi</h6>
                            
                            <div class="mb-4">
                                <label class="form-label text-muted small fw-bold">Nama Koleksi</label>
                                <input type="text" name="name" class="form-control rounded-3 p-2 border-secondary-subtle" 
                                       placeholder="Contoh: Koleksi Musim Semi Ceria"
                                       value="{{ old('name', $selectedCollection->name ?? '') }}" required>
                            </div>

                            <div class="mb-5">
                                <label class="form-label text-muted small fw-bold">Deskripsi</label>
                                <textarea name="description" class="form-control rounded-3 p-3 border-secondary-subtle" rows="3" 
                                          placeholder="Deskripsi koleksi...">{{ old('description', $selectedCollection->description ?? '') }}</textarea>
                            </div>

                            <h6 class="fw-bold mb-3 text-dark">Gambar Koleksi</h6>
                            <div class="mb-5">
                                <div class="image-upload-dashed border rounded-3 text-center cursor-pointer position-relative d-flex align-items-center justify-content-center bg-white" 
                                     onclick="document.getElementById('imageInput').click()"
                                     style="border-style: dashed !important; border-width: 2px; height: 200px; border-color: #dee2e6;">
                                     
                                    <input type="file" class="d-none" name="image" id="imageInput" accept="image/*">
                                    
                                    <div id="uploadPlaceholder" class="{{ (isset($selectedCollection) && $selectedCollection->image) ? 'd-none' : '' }}">
                                        <i class="bi bi-image fs-3 text-secondary d-block mb-2"></i>
                                        <span class="text-muted fw-medium small">Seret dan lepas gambar di sini, atau klik untuk mengunggah.</span>
                                    </div>

                                    <img id="imagePreview" 
                                         src="{{ isset($selectedCollection) ? $selectedCollection->image_url : '' }}" 
                                         class="{{ (isset($selectedCollection) && $selectedCollection->image) ? 'd-block' : 'd-none' }} w-100 h-100 object-fit-contain p-2">
                                </div>
                            </div>

                           <!-- <h6 class="fw-bold mb-3 text-dark">Produk dalam Koleksi ({{ count($products) }})</h6>
                            
                            <div class="input-group mb-3">
                                <span class="input-group-text bg-white border-end-0 rounded-start-3 ps-3"><i class="bi bi-search text-muted"></i></span>
                                <input type="text" id="productSearch" class="form-control border-start-0 rounded-end-3 py-2 bg-white" placeholder="Cari & tambahkan produk...">
                            </div>

                            <div class="border rounded-3 p-1 bg-white" style="max-height: 300px; overflow-y: auto;">
                                @forelse($products as $product)
                                    <div class="product-item d-flex align-items-center p-2 border-bottom border-light hover-bg-light rounded">
                                        <div class="d-flex align-items-center flex-grow-1 gap-3">
                                            <i class="bi bi-grip-vertical text-muted opacity-25"></i>
                                            <span class="fw-medium text-dark small">{{ $product->name }}</span>
                                        </div>
                                        <div class="form-check m-0">
                                            <input class="form-check-input cursor-pointer" type="checkbox" 
                                                   name="products[]" 
                                                   value="{{ $product->id }}"
                                                   {{ (isset($selectedCollection) && $selectedCollection->products->contains($product->id)) ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-3 text-muted small">Tidak ada produk.</div>
                                @endforelse
                            </div>

                            </div> -->

                        </form>
                    </div>

                    <!-- Footer Actions (Sticky Bottom inside Card) -->
                    <div class="p-4 border-top bg-white d-flex justify-content-end gap-3 sticky-bottom">
                         @if(isset($selectedCollection))
                            <button type="button" class="btn btn-outline-danger fw-bold rounded-3 px-4 py-2 me-auto" 
                                    onclick="if(confirm('Apakah Anda yakin ingin menghapus koleksi ini?')) document.getElementById('delete-form-{{ $selectedCollection->id }}').submit();">
                                <i class="bi bi-trash me-1"></i> Hapus
                            </button>
                         @endif
                         <a href="{{ route('admin.collections.index') }}" class="btn btn-outline-secondary fw-bold rounded-3 px-4 py-2">Batal</a>
                         <button type="button" onclick="document.getElementById('collectionForm').submit();" class="btn btn-dark fw-bold rounded-3 px-4 py-2">Simpan Perubahan</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@if(isset($selectedCollection))
<form id="delete-form-{{ $selectedCollection->id }}" action="{{ route('admin.collections.destroy', $selectedCollection->id) }}" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>
@endif

<style>
    /* Custom Scrollbar */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #e9ecef;
        border-radius: 4px;
    }

    /* Active State for List */
    .active-collection-card {
        background-color: #fff5f8 !important; /* Light Pink */
        border-color: #ff4d8d !important;
        box-shadow: 0 4px 12px rgba(255, 77, 141, 0.1) !important;
    }

    /* Pink Toggle */
    .custom-pink-switch .form-check-input:checked {
        background-color: #ff4d8d;
        border-color: #ff4d8d;
    }
    
    .hover-bg-light:hover {
        background-color: #f8f9fa;
    }
    
    .form-control:focus {
        border-color: #ff4d8d;
        box-shadow: 0 0 0 0.25rem rgba(255, 77, 141, 0.15);
    }
    
    .transition-all {
        transition: all 0.2s ease-in-out;
    }
    
    .cursor-pointer {
        cursor: pointer;
    }
    
    .image-upload-dashed:hover {
        background-color: #fafafa !important;
        border-color: #adb5bd !important;
    }
</style>

<script>
    // Image Preview
    document.getElementById('imageInput').addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('imagePreview');
                const placeholder = document.getElementById('uploadPlaceholder');
                preview.src = e.target.result;
                preview.classList.remove('d-none');
                preview.classList.add('d-block');
                placeholder.classList.add('d-none');
            }
            reader.readAsDataURL(e.target.files[0]);
        }
    });

    // Product Search
    document.getElementById('productSearch').addEventListener('keyup', function() {
        const val = this.value.toLowerCase();
        document.querySelectorAll('.product-item').forEach(el => {
            const txt = el.innerText.toLowerCase();
            el.style.display = txt.includes(val) ? 'flex' : 'none';
        });
    });
</script>
@endsection
