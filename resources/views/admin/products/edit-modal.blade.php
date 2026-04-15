<div class="modal fade" id="editProductModal{{ $product->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <form action="{{ route('admin.products.update', $product->id) }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Header -->
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Edit Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Body -->
                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Nama Produk</label>
                        <input type="text"
                               name="name"
                               class="form-control"
                               value="{{ $product->name }}"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Harga</label>
                        <input type="number"
                               name="price"
                               class="form-control"
                               value="{{ $product->price }}"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Stok</label>
                        <input type="number"
                               name="stock"
                               class="form-control"
                               value="{{ $product->stock }}"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="active"
                                {{ $product->status == 'active' ? 'selected' : '' }}>
                                Aktif
                            </option>
                            <option value="inactive"
                                {{ $product->status == 'inactive' ? 'selected' : '' }}>
                                Tidak Aktif
                            </option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description"
                                  class="form-control"
                                  rows="3">{{ $product->description }}</textarea>
                    </div>

                    <!-- Gambar -->
                    <div class="mb-3">
                        <label class="form-label">Gambar Produk</label>

                        @if($product->image)
                            <div class="mb-2">
                                <img src="{{ $product->image_url }}"
                                     class="rounded"
                                     width="120">
                            </div>
                        @endif

                        <input type="file" name="image" class="form-control">
                        <small class="text-muted">
                            Kosongkan jika tidak ingin mengganti gambar
                        </small>
                    </div>

                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-outline-secondary"
                            data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Simpan Perubahan
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
