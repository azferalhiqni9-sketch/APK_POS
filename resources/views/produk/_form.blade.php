@csrf

<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
    <div class="card-body p-4 p-md-5">
        
        <!-- Header Informasi Singkat -->
        <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
            <div class="bg-success bg-opacity-10 text-success p-3 rounded-circle me-3">
                <i class="bi bi-box-seam fs-4"></i>
            </div>
            <div>
                <h5 class="fw-bold text-dark mb-1">Informasi Detail Produk</h5>
                <p class="text-muted small mb-0">Silakan lengkapi data produk dengan benar pada form di bawah ini.</p>
            </div>
        </div>

        <div class="row g-4">
            <!-- Kolom Kiri: Input Data -->
            <div class="col-lg-8">
                
                <!-- 1. Nama Produk -->
                <div class="mb-3">
                    <label class="form-label fw-semibold text-secondary">
                        <i class="bi bi-tag me-1"></i> Nama Produk
                    </label>
                    <input type="text" name="name"
                           class="form-control form-control-lg bg-light @error('name') is-invalid @enderror"
                           value="{{ old('name', $produk->nama ?? '') }}"
                           placeholder="Contoh: Kopi Susu Aren">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- 2. Nama Jenis -->
                <div class="mb-3">
                    <label class="form-label fw-semibold text-secondary">
                        <i class="bi bi-grid me-1"></i> Nama Jenis Kategori
                    </label>
                    <select name="jenis_id" class="form-select form-select-lg bg-light @error('jenis_id') is-invalid @enderror" required>
                        <option value="" selected disabled>-- Pilih Jenis --</option>
                        @foreach ($jenis as $item)
                            <option value="{{ $item->id }}" @selected(old('jenis_id', $produk->jenis_id ?? '') == $item->id)>
                                {{ ucfirst($item->nama_jenis) }}
                            </option>
                        @endforeach
                    </select>
                    @error('jenis_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- 3 & 4. Harga Beli & Harga Jual -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold text-secondary">
                            <i class="bi bi-wallet2 me-1"></i> Harga Beli (Modal)
                        </label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-light text-muted">Rp</span>
                            <input type="number" name="purchase_price"
                                   class="form-control bg-light @error('purchase_price') is-invalid @enderror"
                                   value="{{ old('purchase_price', $produk->harga_beli ?? '') }}"
                                   placeholder="0">
                        </div>
                        @error('purchase_price')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold text-secondary">
                            <i class="bi bi-cash-stack me-1"></i> Harga Jual
                        </label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-light text-muted">Rp</span>
                            <input type="number" name="selling_price"
                                   class="form-control bg-light @error('selling_price') is-invalid @enderror"
                                   value="{{ old('selling_price', $produk->harga_jual ?? '') }}"
                                   placeholder="0">
                        </div>
                        @error('selling_price')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- 5. Stok -->
                <div class="mb-3">
                    <label class="form-label fw-semibold text-secondary">
                        <i class="bi bi-layers me-1"></i> Stok Barang
                    </label>
                    <input type="number" name="stock"
                           class="form-control form-control-lg bg-light @error('stock') is-invalid @enderror"
                           value="{{ old('stock', $produk->stok ?? '') }}"
                           placeholder="0">
                    @error('stock')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <!-- Kolom Kanan: Foto Produk & Preview -->
            <div class="col-lg-4">
                <div class="card border border-2 border-dashed rounded-4 p-3 bg-light h-100 d-flex flex-column justify-content-center text-center">
                    <label class="form-label fw-semibold text-secondary mb-3">
                        <i class="bi bi-image me-1"></i> Foto Produk
                    </label>
                    
                    <!-- Kotak Preview -->
                    <div class="mb-3 mx-auto position-relative rounded-3 overflow-hidden shadow-sm bg-white border" style="width: 160px; height: 160px; display: flex; align-items: center; justify-content: center;">
                        <img id="preview" 
                             src="{{ isset($produk->foto) && $produk->foto ? asset('storage/'.$produk->foto) : '#' }}" 
                             alt="Preview" 
                             class="w-100 h-100 object-fit-cover" 
                             style="{{ isset($produk->foto) && $produk->foto ? 'display: block;' : 'display: none;' }}">
                        
                        <div id="placeholder-box" class="text-muted p-2" style="{{ isset($produk->foto) && $produk->foto ? 'display: none;' : 'display: block;' }}">
                            <i class="bi bi-cloud-arrow-up display-6 text-success opacity-75"></i>
                            <p class="small mb-0 mt-1 text-muted">Belum ada foto</p>
                        </div>
                    </div>

                    <!-- Input File -->
                    <input type="file"
                           name="foto"
                           class="form-control form-control-sm @error('foto') is-invalid @enderror"
                           onchange="previewImage(this)">
                           
                    @error('foto')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    <div class="form-text text-muted x-small mt-2">Format: JPG, PNG, WEBP (Maks. 2MB)</div>
                </div>
            </div>
        </div>

        <!-- Tombol Aksi di Bawah -->
        <div class="d-flex justify-content-end gap-2 mt-4 pt-4 border-top">
            <a href="{{ route('produk.index') }}" class="btn btn-light px-4 py-2 border fw-semibold">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
            <button class="btn btn-success px-4 py-2 fw-semibold shadow-sm" type="submit">
                <i class="bi bi-check-lg me-1"></i> Simpan Produk
            </button>
        </div>

    </div>
</div>

<script>
    function previewImage(input) {
        const preview = document.getElementById('preview');
        const placeholderBox = document.getElementById('placeholder-box');
        const file = input.files[0];

        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
            if (placeholderBox) placeholderBox.style.display = 'none';
        }
    }
</script>