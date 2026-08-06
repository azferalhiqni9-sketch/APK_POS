@extends('layouts.app')

@section('title', 'Detail Penjualan')

@section('content')

<div class="container-fluid px-4 py-4">

    {{-- Header Halaman & Tombol Kembali --}}
    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
        <div class="d-flex align-items-center">
            <div class="bg-primary text-white rounded-3 p-3 me-3 shadow-sm d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                <i class="bi bi-receipt fs-4"></i>
            </div>
            <div>
                <h3 class="fw-bold text-dark mb-0">Detail Transaksi</h3>
                <p class="text-muted small mb-0">Rincian informasi lengkap transaksi dan daftar produk.</p>
            </div>
        </div>
        <a href="{{ route('penjualan.index') }}" class="btn btn-outline-secondary px-4 py-2 shadow-sm fw-semibold rounded-pill hover-back-btn">
            <i class="bi bi-arrow-left me-2"></i> Kembali
        </a>
    </div>

    <div class="row g-4">
        {{-- Sisi Kiri / Atas: Informasi Utama Transaksi (Dibagi dalam Grid Kartu Kecil) --}}
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4">
                <div class="d-flex align-items-center mb-3 pb-2 border-bottom">
                    <i class="bi bi-info-circle-fill text-primary me-2 fs-5"></i>
                    <h5 class="fw-bold text-dark mb-0">Informasi Umum</h5>
                </div>

                <div class="row g-3">
                    {{-- Tanggal Transaksi --}}
                    <div class="col-md-3 col-sm-6">
                        <div class="p-3 rounded-3 bg-light border-0 h-100">
                            <span class="d-block text-muted small fw-bold text-uppercase mb-1">Tanggal Transaksi</span>
                            <span class="fw-bold text-dark fs-6">{{ $sale->created_at->translatedFormat('d-m-Y H:i:s') }}</span>
                        </div>
                    </div>
                    {{-- Kasir --}}
                    <div class="col-md-3 col-sm-6">
                        <div class="p-3 rounded-3 bg-light border-0 h-100">
                            <span class="d-block text-muted small fw-bold text-uppercase mb-1">Kasir Toko</span>
                            <span class="fw-bold text-dark fs-6"><i class="bi bi-person-fill text-secondary me-1"></i> {{ $sale->user->name }}</span>
                        </div>
                    </div>
                    {{-- Metode Pembayaran --}}
                    <div class="col-md-3 col-sm-6">
                        <div class="p-3 rounded-3 bg-light border-0 h-100">
                            <span class="d-block text-muted small fw-bold text-uppercase mb-1">Metode Pembayaran</span>
                            <div>
                                <span class="badge bg-white text-dark border px-3 py-1.5 fw-bold shadow-sm mt-1">{{ $sale->metode_pembayaran }}</span>
                            </div>
                        </div>
                    </div>
                    {{-- Status --}}
                    <div class="col-md-3 col-sm-6">
                        <div class="p-3 rounded-3 bg-light border-0 h-100">
                            <span class="d-block text-muted small fw-bold text-uppercase mb-1">Status Pembayaran</span>
                            <div>
                                <span class="badge {{ $sale->status === 'COMPLETED' ? 'bg-success bg-opacity-10 text-success border border-success border-opacity-25' : 'bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25' }} px-3 py-1.5 rounded-pill fw-bold mt-1">
                                    <i class="bi bi-check-circle-fill me-1"></i> {{ $sale->status }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sisi Bawah: Daftar Produk yang Dibeli --}}
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
                <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-bag-check-fill text-primary me-2 fs-5"></i>
                        <h5 class="fw-bold text-dark mb-0">Daftar Produk yang Dibeli</h5>
                    </div>
                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-bold">
                        {{ count($sale->itemPenjualan) }} Item Produk
                    </span>
                </div>
                
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle table-hover mb-0">
                            <thead class="table-light text-uppercase fs-7 text-muted">
                                <tr>
                                    <th class="py-3 ps-4" style="width: 5%;">#</th>
                                    <th class="py-3">Nama Produk</th>
                                    <th class="py-3">Harga Satuan</th>
                                    <th class="py-3 text-center">Kuantitas</th>
                                    <th class="py-3 text-end pe-4">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sale->itemPenjualan as $item)
                                <tr>
                                    <td class="ps-4 text-muted fw-bold">{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-light text-primary rounded-3 p-2 me-3 border d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                                                <i class="bi bi-box-seam"></i>
                                            </div>
                                            <span class="fw-bold text-dark">{{ $item->produk->nama ?? 'Produk Dihapus' }}</span>
                                        </div>
                                    </td>
                                    <td class="text-muted fw-medium">Rp {{ number_format($item->harga_satuan ?? 0, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark border px-3 py-1.5 fw-bold rounded-pill">
                                            {{ $item->kuantitas }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-4 fw-bold text-dark">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-5">
                                        <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                        Tidak ada item dalam transaksi ini.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                            <tfoot class="bg-light border-top">
                                <tr>
                                    <td colspan="4" class="text-end fw-bold py-3 text-dark text-uppercase">Total Pembayaran:</td>
                                    <td class="text-end pe-4 text-primary fw-extrabold fs-4 py-3">
                                        Rp {{ number_format($sale->total_pembayaran, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- CSS Tambahan untuk Mempercantik Animasi & Efek Hover --}}
<style>
    .hover-back-btn {
        transition: all 0.25s ease-in-out;
    }
    .hover-back-btn:hover {
        background-color: #495057 !important;
        color: #ffffff !important;
        border-color: #495057 !important;
        transform: translateY(-2px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }
    .fw-extrabold {
        font-weight: 800 !important;
    }
</style>

@endsection