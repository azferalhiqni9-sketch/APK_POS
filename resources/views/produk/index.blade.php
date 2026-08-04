@extends('layouts.app')

@section('title', 'Halaman Produk')

@section('content')

@include('layouts.navbar')

<div class="container py-3">
    {{-- Header & Tombol Tambah --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">
                <i class="bi bi-box-seam text-primary me-2"></i>Halaman Produk
            </h3>
            <p class="text-muted small mb-0">Kelola daftar produk, stok, dan harga barang di aplikasi POS.</p>
        </div>
        
        {{-- Tombol Create HANYA untuk ADMIN --}}
        @if(auth()->check() && auth()->user()->role === 'admin')
            <a href="{{ route('produk.create') }}" class="btn btn-primary shadow-sm px-3 py-2">
                <i class="bi bi-plus-circle-fill me-1"></i> Create
            </a>
        @endif
    </div>

    {{-- Card Wrapper untuk Konten --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-4">

            {{-- Form Search --}}
            <form action="{{ route('produk.index') }}" method="GET" class="mb-4">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-search"></i></span>
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="form-control border-start-0 bg-light"
                        placeholder="Search nama produk"
                    >
                    <button class="btn btn-dark px-4" type="submit">Search</button>
                </div>
            </form>

            {{-- Tabel Data Produk --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-uppercase fs-7 text-secondary">
                        <tr>
                            <th class="py-3 ps-3" style="width: 5%;">#</th>
                            <th class="py-3">User</th>
                            <th class="py-3 text-center" style="width: 8%;">Foto</th>
                            <th class="py-3">Nama</th>
                            <th class="py-3">Harga Beli</th>
                            <th class="py-3">Harga Jual</th>
                            <th class="py-3">Stok</th>
                            <th class="py-3 text-center" style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $item)
                        <tr>
                            <td class="ps-3 fw-semibold text-muted">{{ $products->firstItem() + $loop->index }}</td>
                            <td>
                                <span class="text-secondary fw-medium">{{ $item->user->name ?? '-' }}</span>
                            </td>
                            <td class="text-center">
                                @if($item->foto)
                                    <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto" class="rounded shadow-sm" style="width: 40px; height: 40px; object-fit: cover;">
                                @else
                                    <div class="bg-light text-muted rounded d-flex align-items-center justify-content-center mx-auto" style="width: 40px; height: 40px;">
                                        <i class="bi bi-image fs-6"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $item->nama }}</div>
                            </td>
                            <td class="text-muted">Rp {{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                            <td class="fw-semibold text-success">Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                            <td>
                                @if($item->stok <= 5)
                                    <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill fw-semibold">{{ $item->stok }} (Menipis)</span>
                                @else
                                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill fw-semibold">{{ $item->stok }}</span>
                                @endif
                            </td>
                            <td class="text-center">
                                {{-- Pengecekan Akses Aksi --}}
                                @if(auth()->check() && auth()->user()->role === 'admin')
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('produk.edit', $item) }}" class="btn btn-warning btn-sm text-dark px-2 py-1 shadow-sm" title="Edit">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        <form action="{{ route('produk.destroy', $item) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm px-2 py-1 shadow-sm" onclick="return confirm('Yakin hapus produk ini?')" title="Hapus">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    {{-- Tampilan untuk Kasir / Non-Admin --}}
                                    <span class="text-muted small fw-semibold">-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">Tidak ada data produk ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if (method_exists($products, 'links'))
                <div class="mt-4 d-flex justify-content-end">
                    {{ $products->withQueryString()->links() }}
                </div>
            @endif

        </div>
    </div>
</div>

@endsection