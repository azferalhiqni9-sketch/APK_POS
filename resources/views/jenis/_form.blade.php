<div class="mb-3">
    <label class="form-label fw-bold">Nama Jenis</label>
    <input type="text" name="nama_jenis" class="form-control @error('nama_jenis') is-invalid @enderror"
        value="{{ old('nama_jenis', $jenis->nama_jenis ?? '') }}" required>
    @error('nama_jenis')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<button class="btn btn-success mt-2" type="submit">Simpan</button>
<a href="{{ route('jenis.index') }}" class="btn btn-secondary mt-2">Kembali</a>