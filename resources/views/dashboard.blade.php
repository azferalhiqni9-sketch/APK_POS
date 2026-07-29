@extends('layouts.app')

@section('title', 'Dashboard Ringkasan')

@section('content')

    @include('layouts.navbar')

    <div class="container-fluid px-4 py-4" style="background-color: #f4f6f9; min-height: 100vh;">
        
        {{-- Header Title & Date --}}
        <div class="row align-items-center mb-4">
            <div class="col-md-6">
                <h2 class="fw-bold text-dark mb-1">Dashboard Overview</h2>
                <p class="text-muted mb-0">
                    Selamat datang kembali! Berikut ringkasan aktivitas toko hari ini.
                </p>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <span class="badge bg-white text-dark shadow-sm px-3 py-2 rounded-pill border">
                    <i class="bi bi-calendar-check text-primary me-2"></i>{{ $tanggalHariIni->translatedFormat('l, d F Y') }}
                </span>
            </div>
        </div>

        @can('viewAny', App\Models\User::class)
            {{-- Today's Sales Section --}}
            <div class="row g-3 mb-4">
                <div class="col-md-12">
                    <h6 class="text-uppercase text-muted fw-bold small tracking-wider mb-3">Today's Sales</h6>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-3 bg-white">
                        <div class="card-body p-4 d-flex align-items-center">
                            <div class="flex-shrink-0 bg-primary bg-opacity-15 text-primary rounded-3 p-3 me-3">
                                <i class="bi bi-wallet2 fs-4"></i>
                            </div>
                            <div>
                                <span class="text-muted d-block small fw-semibold">Total Nilai Penjualan Hari Ini</span>
                                <h3 class="fw-bold text-dark mb-0">Rp {{ number_format($ringkasan['total_penjualan'], 0, ',', '.') }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-3 bg-white">
                        <div class="card-body p-4 d-flex align-items-center">
                            <div class="flex-shrink-0 bg-success bg-opacity-15 text-success rounded-3 p-3 me-3">
                                <i class="bi bi-receipt fs-4"></i>
                            </div>
                            <div>
                                <span class="text-muted d-block small fw-semibold">Jumlah Transaksi Hari Ini</span>
                                <h3 class="fw-bold text-dark mb-0">{{ number_format($ringkasan['total_transaksi'], 0, ',', '.') }} <span class="fs-6 fw-normal text-muted">Transaksi</span></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Cash & Payment Status Section --}}
            <div class="row g-3 mb-4">
                <div class="col-md-12">
                    <h6 class="text-uppercase text-muted fw-bold small tracking-wider mb-3">Cash & Payment Status</h6>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-3 bg-white">
                        <div class="card-body p-3 d-flex justify-content-between align-items-center">
                            <div>
                                <span class="text-muted small d-block">Pembayaran Tunai (Cash)</span>
                                <h5 class="fw-bold text-success mb-0">Rp {{ number_format($ringkasan['total_cash'], 0, ',', '.') }}</h5>
                            </div>
                            <div class="badge bg-success bg-opacity-10 text-success p-2 rounded-circle">
                                <i class="bi bi-cash-stack fs-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-3 bg-white">
                        <div class="card-body p-3 d-flex justify-content-between align-items-center">
                            <div>
                                <span class="text-muted small d-block">Pembayaran Non-Tunai</span>
                                <h5 class="fw-bold text-info mb-0">Rp {{ number_format($ringkasan['total_non_tunai'], 0, ',', '.') }}</h5>
                            </div>
                            <div class="badge bg-info bg-opacity-10 text-info p-2 rounded-circle">
                                <i class="bi bi-credit-card fs-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endcan

        {{-- Critical Inventory Status --}}
        <div class="row g-3 mb-4">
            <div class="col-md-12">
                <h6 class="text-uppercase text-muted fw-bold small tracking-wider mb-3">Critical Inventory Status</h6>
            </div>
            
            {{-- Produk Rendah --}}
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-3 bg-white h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold text-dark mb-0">Daftar Produk Rendah Stok</h6>
                            <span class="badge bg-warning text-dark">Warning</span>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-borderless table-striped align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Produk</th>
                                        <th>Stok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($produkStokRendah as $index => $produk)
                                        <tr>
                                            <td>{{ $produkStokRendah->firstItem() + $index }}</td>
                                            <td class="fw-medium text-dark">{{ $produk->nama }}</td>
                                            <td><span class="badge bg-warning text-dark">{{ $produk->stok }}</span></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-muted text-center py-3">
                                                Seluruh produk berada dalam kondisi stok aman.
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
                <div class="card border-0 shadow-sm rounded-3 bg-white h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold text-dark mb-0">Produk Habis Stok</h6>
                            <span class="badge bg-danger">Critical</span>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-borderless table-striped align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Produk</th>
                                        <th>Stok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($produkStokHabis as $produk)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="fw-medium text-dark">{{ $produk->nama }}</td>
                                            <td><span class="badge bg-danger">Habis</span></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-muted text-center py-3">
                                                Seluruh produk berada dalam kondisi stok aman.
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

        {{-- Best Seller Products --}}
        <div class="row g-3">
            <div class="col-md-12">
                <h6 class="text-uppercase text-muted fw-bold small tracking-wider mb-3">Best Seller Products</h6>
                <div class="card border-0 shadow-sm rounded-3 bg-white">
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nama Produk</th>
                                        <th>Stok Tersisa</th>
                                        <th>Unit Terjual</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($produkTerlaris as $produk)
                                        <tr>
                                            <td class="fw-medium text-dark">{{ $produk->nama }}</td>
                                            <td>{{ $produk->stok }}</td>
                                            <td><span class="badge bg-success bg-opacity-10 text-success fw-bold px-2 py-1">{{ $produk->total_terjual }} Terjual</span></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-muted text-center py-3">
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

    </div>
@endsection