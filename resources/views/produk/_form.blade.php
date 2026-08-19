@csrf

<!-- 1. Gambar -->
<div class="mb-3">
    <label class="form-label fw-semibold text-secondary">Gambar</label>
    <input type="file"
           name="foto"
           class="form-control @error('foto') is-invalid @enderror"
           onchange="preview(this)">
    @error('foto')
        <div class="invalid-feedback d-block">
            {{ $message }}
        </div>
    @enderror
</div>

<!-- 2. Nama Jenis -->
<div class="mb-3">
    <label class="form-label fw-semibold text-secondary">Nama Jenis</label>
    <select name="jenis_id" class="form-select bg-light @error('jenis_id') is-invalid @enderror" required>
        <option value="" selected disabled>-- Pilih Jenis --</option>
        @foreach ($jenis as $item)
            <option value="{{ $item->id }}" @selected(old('jenis_id', $produk->jenis_id ?? '') == $item->id)>
                {{ ucfirst($item->nama_jenis) }}
            </option>
        @endforeach
    </select>
    @error('jenis_id')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

<!-- 3. Nama Produk -->
<div class="mb-3">
    <label class="form-label fw-semibold text-secondary">Nama Produk</label>
    <input type="text" name="name"
           class="form-control @error('name') is-invalid @enderror"
           value="{{ old('name', $produk->nama ?? '') }}">
    @error('name')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

<!-- 4. Harga Beli -->
<div class="mb-3">
    <label class="form-label fw-semibold text-secondary">Harga Beli</label>
    <input type="number" name="purchase_price"
           class="form-control @error('purchase_price') is-invalid @enderror"
           value="{{ old('purchase_price', $produk->harga_beli ?? '') }}">
    @error('purchase_price')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

<!-- 5. Harga Jual -->
<div class="mb-3">
    <label class="form-label fw-semibold text-secondary">Harga Jual</label>
    <input type="number" name="selling_price"
           class="form-control @error('selling_price') is-invalid @enderror"
           value="{{ old('selling_price', $produk->harga_jual ?? '') }}">
    @error('selling_price')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

<!-- 6. Stok -->
<div class="mb-3">
    <label class="form-label fw-semibold text-secondary">Stok</label>
    <input type="number" name="stock"
           class="form-control @error('stock') is-invalid @enderror"
           value="{{ old('stock', $produk->stok ?? '') }}">
    @error('stock')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

<button class="btn btn-success mt-3" type="submit">Simpan</button>
<a href="{{ route('produk.index') }}" class="btn btn-secondary mt-3">Kembali</a>

<script>
    function preview(input) {
        const preview = document.getElementById('preview');
        const file = input.files[0];

        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        }
    }
</script>