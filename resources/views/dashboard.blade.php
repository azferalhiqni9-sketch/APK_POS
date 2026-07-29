@extends('layouts.app')

@section('title', 'Dashboard Ringkasan')

@section('content')

    @include('layouts.navbar')

    <div class="container-fluid px-4 py-5" style="background-color: #fafbfc; min-height: 100vh;">
        
        {{-- Header Title & Date --}}
        <div class="row align-items-center mb-5">
            <div class="col-lg-8">
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-semibold mb-2">
                    <i class="bi bi-speedometer2 me-1"></i> Dashboard Overview
                </span>
                <h1 class="h3 fw-bold text-dark tracking-tight mb-1">Ringkasan Hari Ini</h1>
                <p class="text-muted mb-0">Monitor performa penjualan dan status inventaris toko secara real-time.</p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <div class="d-inline-flex align-items-center bg-white shadow-sm border border-light px-3 py-2 rounded-4">
                    <i class="bi bi-calendar3 text-primary me-2 fs-5"></i>
                    <span class="fw-medium text-dark small">{{ $tanggalHariIni->translatedFormat('l, d F Y') }}</span>
                </div>
            </div>
        </div>

        @can('viewAny', App\Models\User::class)
            {{-- Today's Sales Section --}}
            <div class="mb-5">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-primary rounded-2 me-2" style="width: 4px; height: 20px;"></div>
                    <h5 class="fw-bold text-dark mb-0">Today's Sales</h5>
                </div>
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm rounded-4 bg-white position-relative overflow-hidden">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-muted small fw-semibold text-uppercase tracking-wider">Total Penjualan Hari Ini</span>
                                    <div class="icon-box bg-primary bg-opacity-10 text-primary rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <i class="bi bi-wallet2 fs-5"></i>
                                    </div>
                                </div>
                                <h2 class="fw-bold text-dark mb-0">Rp {{ number_format($ringkasan['total_penjualan'], 0, ',', '.') }}</h2>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm rounded-4 bg-white position-relative overflow-hidden">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-muted small fw-semibold text-uppercase tracking-wider">Jumlah Transaksi</span>
                                    <div class="icon-box bg-success bg-opacity-10 text-success rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <i class="bi bi-receipt fs-5"></i>
                                    </div>
                                </div>
                                <h2 class="fw-bold text-dark mb-0">{{ number_format($ringkasan['total_transaksi'], 0, ',', '.') }} <span class="fs-6 fw-normal text-muted">Transaksi</span></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Cash & Payment Status Section --}}
            <div class="mb-5">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-success rounded-2 me-2" style="width: 4px; height: 20px;"></div>
                    <h5 class="fw-bold text-dark mb-0">Cash & Payment Status</h5>
                </div>
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm rounded-4 bg-white">
                            <div class="card-body p-4 d-flex align-items-center justify-content-between">
                                <div>
                                    <span class="text-muted small fw-semibold text-uppercase tracking-wider d-block mb-1">Pembayaran Tunai</span>
                                    <h4 class="fw-bold text-success mb-0">Rp {{ number_format($ringkasan['total_cash'], 0, ',', '.') }}</h4>
                                </div>
                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill fw-semibold">Cash</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm rounded-4 bg-white">
                            <div class="card-body p-4 d-flex align-items-center justify-content-between">
                                <div>
                                    <span class="text-muted small fw-semibold text-uppercase tracking-wider d-block mb-1">Pembayaran Non-Tunai</span>
                                    <h4 class="fw-bold text-info mb-0">Rp {{ number_format($ringkasan['total_non_tunai'], 0, ',', '.') }}</h4>
                                </div>
                                <span class="badge bg-info bg-opacity-10 text-info px-3 py-2 rounded-pill fw-semibold">Non-Tunai</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endcan

        {{-- Critical Inventory Status --}}
        <div class="mb-5">
            <div class="d-flex align-items-center mb-3">
                <div class="bg-warning rounded-2 me-2" style="width: 4px; height: 20px;"></div>
                <h5 class="fw-bold text-dark mb-0">Critical Inventory Status</h5>
            </div>
            <div class="row g-4">
                {{-- Produk Rendah --}}
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                        <div class="card-body p-4">
                            <h6 class="fw-bold text-dark mb-3">Daftar Produk Rendah Stok</h6>
                            <div class="table-responsive">
                                <table class="table table-borderless align-middle mb-0">
                                    <thead class="bg-light text-muted small text-uppercase">
                                        <tr>
                                            <th class="py-3 rounded-start">#</th>
                                            <th class="py-3">Nama Produk</th>
                                            <th class="py-3 rounded-end">Stok</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($produkStokRendah as $index => $produk)
                                            <tr class="border-bottom border-light">
                                                <td class="py-3 text-muted">{{ $produkStokRendah->firstItem() + $index }}</td>
                                                <td class="py-3 fw-medium text-dark">{{ $produk->nama }}</td>
                                                <td class="py-3"><span class="badge bg-warning bg-opacity-10 text-warning px-2.5 py-1.5 fw-bold">{{ $produk->stok }} Pcs</span></td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-muted text-center py-4 small">
                                                    <i class="bi bi-check-circle text-success me-1"></i> Seluruh produk berada dalam kondisi stok aman.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3">
                                {{ $produkStokRendah->links() }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Produk Habis Stok --}}
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                        <div class="card-body p-4">
                            <h6 class="fw-bold text-dark mb-3">Produk Habis Stok</h6>
                            <div class="table-responsive">
                                <table class="table table-borderless align-middle mb-0">
                                    <thead class="bg-light text-muted small text-uppercase">
                                        <tr>
                                            <th class="py-3 rounded-start">#</th>
                                            <th class="py-3">Nama Produk</th>
                                            <th class="py-3 rounded-end">Stok</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($produkStokHabis as $produk)
                                            <tr class="border-bottom border-light">
                                                <td class="py-3 text-muted">{{ $loop->iteration }}</td>
                                                <td class="py-3 fw-medium text-dark">{{ $produk->nama }}</td>
                                                <td class="py-3"><span class="badge bg-danger bg-opacity-10 text-danger px-2.5 py-1.5 fw-bold">Habis</span></td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-muted text-center py-4 small">
                                                    <i class="bi bi-check-circle text-success me-1"></i> Seluruh produk berada dalam kondisi stok aman.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3">
                                {{ $produkStokHabis->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Best Seller Products --}}
        <div class="mb-4">
            <div class="d-flex align-items-center mb-3">
                <div class="bg-info rounded-2 me-2" style="width: 4px; height: 20px;"></div>
                <h5 class="fw-bold text-dark mb-0">Best Seller Products</h5>
            </div>
            <div class="card border-0 shadow-sm rounded-4 bg-white">
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle mb-0">
                            <thead class="bg-light text-muted small text-uppercase">
                                <tr>
                                    <th class="py-3 rounded-start">Nama Produk</th>
                                    <th class="py-3">Stok Tersisa</th>
                                    <th class="py-3 rounded-end">Unit Terjual</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($produkTerlaris as $produk)
                                    <tr class="border-bottom border-light">
                                        <td class="py-3 fw-medium text-dark">{{ $produk->nama }}</td>
                                        <td class="py-3 text-muted">{{ $produk->stok }} Pcs</td>
                                        <td class="py-3"><span class="badge bg-success bg-opacity-10 text-success fw-bold px-3 py-2">{{ $produk->total_terjual }} Terjual</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-muted text-center py-4 small">
                                            Belum ada data penjualan produk.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection