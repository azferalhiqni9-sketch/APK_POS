@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')

{{-- Navbar --}}

<div class="container py-3">
    {{-- Header & Tombol Kembali --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">
                <i class="bi bi-box-seam-fill text-primary me-2"></i>Tambah Produk
            </h3>
            <p class="text-muted small mb-0">Silakan masukkan detail produk baru di bawah ini.</p>
        </div>
        <a href="{{ route('produk.index') }}" class="btn btn-outline-secondary shadow-sm px-3 py-2">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    {{-- Card Wrapper untuk Form --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-4">
            
            <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="foto" class="form-label fw-semibold text-secondary">Gambar Produk</label>
                    <input type="file" class="form-control bg-light @error('foto') is-invalid @enderror" id="foto" name="foto">
                    @error('foto')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold text-secondary">Nama Produk</label>
                    <input type="text" class="form-control bg-light @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Contoh: Kopi Susu" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="purchase_price" class="form-label fw-semibold text-secondary">Harga Beli</label>
                    <input type="number" class="form-control bg-light @error('purchase_price') is-invalid @enderror" id="purchase_price" name="purchase_price" value="{{ old('purchase_price') }}" placeholder="0" required>
                    @error('purchase_price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="selling_price" class="form-label fw-semibold text-secondary">Harga Jual</label>
                    <input type="number" class="form-control bg-light @error('selling_price') is-invalid @enderror" id="selling_price" name="selling_price" value="{{ old('selling_price') }}" placeholder="0" required>
                    @error('selling_price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="stock" class="form-label fw-semibold text-secondary">Stok</label>
                    <input type="number" class="form-control bg-light @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock') }}" placeholder="0" required>
                    @error('stock')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('produk.index') }}" class="btn btn-light px-4 border">Batal</a>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm">
                        <i class="bi bi-save me-1"></i> Simpan
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

@endsection