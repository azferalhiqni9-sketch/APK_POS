@extends('layouts.app')

@section('title', 'Dashboard Ringkasan')

@section('content')

    @include('layouts.navbar')

    <div class="container-fluid px-4 py-4" style="background-color: #f8f9fa; min-height: 100vh;">
        
        {{-- Header Title & Date --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 pb-3 border-bottom">
            <div>
                <h1 class="h3 fw-bold text-dark mb-1">Ringkasan Hari Ini</h1>
                <p class="text-muted mb-0">
                    <i class="bi bi-calendar-event me-1"></i> {{ $tanggalHariIni->translatedFormat('l, d F Y') }}
                </p>
            </div>
        </div>

        @can('viewAny', App\Models\User::class)
            {{-- Today's Sales Section --}}
            <div class="mb-4">
                <h5 class="fw-semibold text-secondary mb-3">Today's Sales</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm rounded-4 bg-white border-start border-primary border-4">
                            <div class="card-body p-4">
                                <div class="text-muted small text-uppercase fw-bold mb-1">Total Nilai Penjualan Hari Ini</div>
                                <h3 class="fw-bold text-dark mb-0">Rp {{ number_format($ringkasan['total_penjualan'], 0, ',', '.') }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm rounded-4 bg-white border-start border-success border-4">
                            <div class="card-body p-4">
                                <div class="text-muted small text-uppercase fw-bold mb-1">Jumlah Transaksi Hari Ini</div>
                                <h3 class="fw-bold text-dark mb-0">{{ number_format($ringkasan['total_transaksi'], 0, ',', '.') }} <span class="fs-6 fw-normal text-muted">Transaksi</span></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Cash & Payment Status Section --}}
            <div class="mb-4">
                <h5 class="fw-semibold text-secondary mb-3">Cash & Payment Status</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm rounded-4 bg-white">
                            <div class="card-body p-4">
                                <div class="text-muted small text-uppercase fw-bold mb-1">Total Pembayaran Tunai</div>
                                <h4 class="fw-bold text-success mb-0">Rp {{ number_format($ringkasan['total_cash'], 0, ',', '.') }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm rounded-4 bg-white">
                            <div class="card-body p-4">
                                <div class="text-muted small text-uppercase fw-bold mb-1">Total Pembayaran Non-Tunai</div>
                                <h4 class="fw-bold text-info mb-0">Rp {{ number_format($ringkasan['total_non_tunai'], 0, ',', '.') }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endcan

        {{-- Critical Inventory Status --}}
        <div class="mb-4">
            <h5 class="fw-semibold text-secondary mb-3">Critical Inventory Status</h5>
            <div class="row g-3">
                {{-- Produk Rendah --}}
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm rounded-4 p-2 bg-white">
                        <div class="card-body">
                            <h6 class="fw-bold text-dark mb-3">Daftar Produk Rendah</h6>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="rounded-start">#</th>
                                            <th>Nama</th>
                                            <th class="rounded-end">Stok</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($produkStokRendah as $index => $produk)
                                            <tr>
                                                <td>{{ $produkStokRendah->firstItem() + $index }}</td>
                                                <td class="fw-medium">{{ $produk->nama }}</td>
                                                <td><span class="badge bg-warning text-dark px-2 py-1">{{ $produk->stok }}</span></td>
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
                    <div class="card border-0 shadow-sm rounded-4 p-2 bg-white">
                        <div class="card-body">
                            <h6 class="fw-bold text-dark mb-3">Produk Habis Stok</h6>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="rounded-start">#</th>
                                            <th>Nama</th>
                                            <th class="rounded-end">Stok</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($produkStokHabis as $produk)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="fw-medium">{{ $produk->nama }}</td>
                                                <td><span class="badge bg-danger px-2 py-1">Habis</span></td>
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
        </div>

        {{-- Best Seller Products --}}
        <div class="mb-4">
            <h5 class="fw-semibold text-secondary mb-3">Best Seller Products</h5>
            <div class="card border-0 shadow-sm rounded-4 p-2 bg-white">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="rounded-start">Nama</th>
                                    <th>Stok</th>
                                    <th class="rounded-end">Unit Terjual</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($produkTerlaris as $produk)
                                    <tr>
                                        <td class="fw-medium">{{ $produk->nama }}</td>
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
@endsection