@extends('layouts.app')

@section('title', 'Tambah Jenis')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            
            <!-- Card Box yang bikin tampilannya nggak polos -->
            <div class="card shadow border-0 rounded-4">
                <div class="card-body p-4 p-md-5">
                    
                    <div class="mb-4 text-center">
                        <h3 class="fw-bold text-dark">Tambah Jenis Baru</h3>
                        <p class="text-muted small">Silakan masukkan kategori atau jenis produk pada form di bawah.</p>
                    </div>

                    <form action="{{ route('jenis.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary">Nama Jenis</label>
                            <input type="text" name="nama_jenis" class="form-control py-2 px-3 rounded-3 @error('nama_jenis') is-invalid @enderror"
                                value="{{ old('nama_jenis') }}" placeholder="Contoh: Makanan, Minuman" required>
                            @error('nama_jenis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="{{ route('jenis.index') }}" class="btn btn-outline-secondary px-4 py-2 rounded-3">Kembali</a>
                            <button class="btn btn-success px-4 py-2 rounded-3 shadow-sm" type="submit">Simpan Data</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection