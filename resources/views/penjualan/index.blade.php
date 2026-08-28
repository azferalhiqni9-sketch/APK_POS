@extends('layouts.app')

@section('title', 'Halaman Penjualan')

@section('content')

<div class="container py-4">
    {{-- Header & Tombol Tambah --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1 d-flex align-items-center">
                <i class="bi bi-cart3 text-primary me-2"></i> Penjualan
            </h3>
            <p class="text-muted small mb-0">Kelola riwayat transaksi, status pembayaran, dan kasir toko.</p>
        </div>
        <a href="{{ route('penjualan.create') }}" class="btn btn-primary rounded-3 shadow-sm px-4 py-2 fw-medium">
            <i class="bi bi-plus-circle me-1"></i> Tambah Penjualan
        </a>
    </div>

    {{-- Card Konten (Shadow dipertebal dari shadow-sm menjadi shadow agar lebih timbul) --}}
    <div class="card border-0 shadow rounded-4 overflow-hidden">
        <div class="card-body p-4">

            {{-- Form Pencarian --}}
            <form action="{{ route('penjualan.index') }}" method="GET" class="mb-4">
                <div class="input-group rounded-3 shadow-sm border">
                    <span class="input-group-text bg-light border-0 text-muted ps-3">
                        <i class="bi bi-search"></i>
                    </span>
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="form-control border-0 bg-light py-2"
                        placeholder="Cari transaksi atau nama kasir..."
                    >
                    <button class="btn btn-dark px-4 fw-medium" type="submit">Search</button>
                </div>
            </form>

            {{-- Tabel Data Penjualan --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    {{-- Menggunakan table-light agar header tabel berwarna abu-abu muda sebagai pembatas --}}
                    <thead class="table-light">
                        <tr class="text-uppercase" style="font-size: 0.85rem; letter-spacing: 0.5px;">
                            <th class="py-3 ps-3 text-secondary fw-bold" style="width: 5%;">#</th>
                            <th class="py-3 text-secondary fw-bold">Tanggal Transaksi</th>
                            <th class="py-3 text-secondary fw-bold">Kasir</th>
                            <th class="py-3 text-secondary fw-bold">Total Pembayaran</th>
                            <th class="py-3 text-secondary fw-bold">Metode</th>
                            <th class="py-3 text-secondary fw-bold">Status</th>
                            <th class="py-3 text-center text-secondary fw-bold" style="width: 20%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sales as $sale)
                        <tr class="border-bottom">
                            <td class="ps-3 text-muted">{{ $sales->firstItem() + $loop->index }}</td>
                            <td>
                                <span class="text-dark fw-medium">{{ $sale->created_at->translatedFormat('d-m-Y H:i:s') }}</span>
                            </td>
                            <td>
                                <span class="text-secondary">{{ $sale->user->name ?? '-' }}</span>
                            </td>
                            <td class="fw-bold text-success">
                                Rp {{ number_format($sale->total_pembayaran, 0, ',', '.') }}
                            </td>
                            <td>
                                <span class="badge border border-secondary text-secondary bg-transparent px-3 py-1 rounded-pill">
                                    {{ $sale->metode_pembayaran }}
                                </span>
                            </td>
                            <td>
                                @if(strtoupper($sale->status) === 'COMPLETED')
                                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill fw-semibold">
                                        COMPLETED
                                    </span>
                                @else
                                    <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill fw-semibold">
                                        OPEN
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('penjualan.show', $sale) }}" class="btn btn-outline-info btn-sm rounded-3 px-3 py-1 d-inline-flex align-items-center" title="Detail">
                                        <i class="bi bi-eye me-1"></i> Detail
                                    </a>
                                    
                                    @can('view', $sale)
                                        @if(strtoupper($sale->status) === 'OPEN')
                                            <a href="{{ route('penjualan.edit', $sale) }}" class="btn btn-outline-primary btn-sm rounded-3 px-3 py-1 d-inline-flex align-items-center" title="Edit">
                                                <i class="bi bi-pencil-square me-1"></i> Edit
                                            </a>
                                        @endif
                                    @endcan

                                    @can('delete', $sale)
                                        @if(strtoupper($sale->status) === 'OPEN')
                                            <form action="{{ route('penjualan.destroy', $sale) }}" method="POST" class="d-inline form-delete">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-outline-danger btn-sm rounded-3 px-3 py-1 d-inline-flex align-items-center btn-delete" title="Hapus">
                                                    <i class="bi bi-trash me-1"></i> Hapus
                                                </button>
                                            </form>
                                        @endif
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted bg-light rounded-bottom-4">
                                <i class="bi bi-inbox fs-2 d-block mb-2 text-secondary"></i>
                                Tidak ada data penjualan ditemukan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginasi --}}
            @if (method_exists($sales, 'links'))
                <div class="mt-4 d-flex justify-content-end">
                    {{ $sales->withQueryString()->links() }}
                </div>
            @endif

        </div>
    </div>
</div>

{{-- Script SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.btn-delete');
        
        deleteButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const form = this.closest('form');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data penjualan yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545', 
                    cancelButtonColor: '#6c757d',  
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>

@endsection