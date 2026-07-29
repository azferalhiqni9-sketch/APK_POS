@extends('layouts.app')

@section('title', 'Halaman Penjualan')

@section('content')

@include('layouts.navbar')

<div class="container py-3">
    {{-- Header & Tombol Tambah --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">
                <i class="bi bi-cart-check text-primary me-2"></i>Halaman Penjualan
            </h3>
            <p class="text-muted small mb-0">Kelola riwayat transaksi, status pembayaran, dan kasir toko.</p>
        </div>
        <a href="{{ route('penjualan.create') }}" class="btn btn-primary shadow-sm px-3 py-2">
            <i class="bi bi-plus-circle-fill me-1"></i> Create
        </a>
    </div>

    {{-- Pesan Flash Session --}}
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 rounded-3 mb-4" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 rounded-3 mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    {{-- Card Wrapper untuk Konten --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-4">

            {{-- Form Search --}}
            <form action="{{ route('penjualan.index') }}" method="GET" class="mb-4">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-search"></i></span>
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="form-control border-start-0 bg-light"
                        placeholder="Cari transaksi atau nama kasir..."
                    >
                    <button class="btn btn-dark px-4" type="submit">Search</button>
                </div>
            </form>

            {{-- Tabel Data Penjualan --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-uppercase fs-7 text-secondary">
                        <tr>
                            <th class="py-3 ps-3" style="width: 5%;">#</th>
                            <th class="py-3">Tanggal Transaksi</th>
                            <th class="py-3">Kasir</th>
                            <th class="py-3">Total Pembayaran</th>
                            <th class="py-3">Metode</th>
                            <th class="py-3">Status</th>
                            <th class="py-3 text-center" style="width: 20%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sales as $sale)
                        <tr>
                            <td class="ps-3 fw-semibold text-muted">{{ $sales->firstItem() + $loop->index }}</td>
                            <td>
                                <span class="text-dark fw-medium">{{ $sale->created_at->translatedFormat('d-m-Y H:i:s') }}</span>
                            </td>
                            <td>
                                <span class="text-secondary fw-semibold">{{ $sale->user->name ?? '-' }}</span>
                            </td>
                            <td class="fw-bold text-success">
                                Rp {{ number_format($sale->total_pembayaran, 0, ',', '.') }}
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border px-2 py-1">{{ $sale->metode_pembayaran }}</span>
                            </td>
                            <td>
                                @if(strtoupper($sale->status) === 'COMPLETED')
                                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill fw-semibold">COMPLETED</span>
                                @else
                                    <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill fw-semibold">OPEN</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('penjualan.show', $sale) }}" class="btn btn-info btn-sm text-white px-2 py-1 shadow-sm" title="Detail">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                    
                                    @can('view', $sale)
                                        @if(strtoupper($sale->status) === 'OPEN')
                                            <a href="{{ route('penjualan.edit', $sale) }}" class="btn btn-warning btn-sm text-dark px-2 py-1 shadow-sm" title="Edit">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </a>
                                        @endif
                                    @endcan

                                    @can('delete', $sale)
                                        @if(strtoupper($sale->status) === 'OPEN')
                                            <form action="{{ route('penjualan.destroy', $sale) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm px-2 py-1 shadow-sm" onclick="return confirm('Apakah anda yakin akan menghapus penjualan ini?')" title="Hapus">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </button>
                                            </form>
                                        @endif
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Tidak ada data penjualan ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if (method_exists($sales, 'links'))
                <div class="mt-4 d-flex justify-content-end">
                    {{ $sales->withQueryString()->links() }}
                </div>
            @endif

        </div>
    </div>
</div>

@endsection