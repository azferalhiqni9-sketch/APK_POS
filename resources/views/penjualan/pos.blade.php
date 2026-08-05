@extends('layouts.app')

@section('title', 'POS')

@section('content')

{{-- Navbar Utama --}}
@include('layouts.navbar')

<div class="container py-3">
    @if (session('errors'))
        <div class="alert alert-danger shadow-sm rounded-3">
            {{ session('errors') }}
        </div>
    @endif

    {{-- Header Halaman --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">
                <i class="bi bi-cart-plus-fill text-primary me-2"></i>{{ $mode == 'edit' ? 'Edit Penjualan' : 'Tambah Penjualan' }}
            </h3>
            <p class="text-muted small mb-0">Pilih produk di sebelah kiri untuk dimasukkan ke keranjang kasir.</p>
        </div>
        <a href="{{ route('penjualan.index') }}" class="btn btn-outline-secondary shadow-sm px-3 py-2">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    {{-- Card Wrapper Utama POS --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-4">
            
            <div class="row g-4">

                {{-- ================== KOLOM KIRI: PRODUK ================== --}}
                <div class="col-lg-7">
                    <div class="mb-3">
                        <form method="GET" action="{{ route('penjualan.create') }}">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-search"></i></span>
                                <input type="text" name="search" value="{{ request('search') }}" class="form-control border-start-0 bg-light"
                                    placeholder="Cari produk..." onkeyup="this.form.submit()">
                            </div>
                        </form>
                    </div>

                    <div class="pe-2" style="max-height: 60vh; overflow-y: auto;">
                        <div class="d-flex flex-column gap-2">
                            @foreach ($products as $product)
                                <form method="POST" action="{{ route('itempenjualan.store') }}" class="row g-2 align-items-center bg-white border rounded-3 p-2 shadow-sm m-0">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                                    <div class="col-7">
                                        <button type="submit"
                                            class="btn btn-outline-primary w-100 text-start p-2 border-0 bg-light {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}">
                                            <div class="d-flex align-items-center gap-2">
                                                <img src="{{ asset('storage/' . $product->foto) }}" alt="Gambar"
                                                    class="rounded-circle shadow-sm" style="width:45px; height:45px; object-fit:cover">
                                                <div>
                                                    <div class="fw-semibold text-dark">{{ $product->nama }}</div>
                                                    <small class="text-muted">Rp {{ number_format($product->harga_jual) }}</small>
                                                </div>
                                            </div>
                                        </button>
                                    </div>

                                    <div class="col-3">
                                        <input type="number" name="quantity" value="1" min="1"
                                            class="form-control form-control-sm bg-light text-center">
                                    </div>

                                    <div class="col-2">
                                        <button type="submit"
                                            class="btn btn-primary w-100 btn-sm shadow-sm {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}">
                                            <i class="bi bi-plus-lg"></i>
                                        </button>
                                    </div>
                                </form>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- ================== KOLOM KANAN: KERANJANG ================== --}}
                <div class="col-lg-5">
                    <div class="card border bg-light rounded-3 p-3">
                        <div class="table-responsive mb-3" style="max-height: 35vh; overflow-y: auto;">
                            <table class="table table-sm align-middle mb-0 bg-white rounded-3 overflow-hidden">
                                <thead class="table-light text-secondary fs-7">
                                    <tr>
                                        <th class="ps-3">Produk</th>
                                        <th>Harga</th>
                                        <th style="width: 20%;">Qty</th>
                                        <th>Subtotal</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($sale->itemPenjualan as $item)
                                        <tr>
                                            <td class="ps-3 fw-semibold text-dark small">{{ $item->produk->nama }}</td>
                                            <td class="small text-muted">Rp {{ number_format($item->produk->harga_jual) }}</td>
                                            <td>
                                                <form method="POST" action="{{ route('itempenjualan.update', $item->id) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="number" name="quantity" value="{{ $item->kuantitas }}"
                                                        class="form-control form-control-sm text-center bg-light" min="1" onchange="this.form.submit()">
                                                </form>
                                            </td>
                                            <td class="small fw-semibold">Rp {{ number_format($item->subtotal) }}</td>
                                            <td class="text-center">
                                                @can('delete', $item)
                                                <form method="POST" action="{{ route('itempenjualan.destroy', $item->id) }}" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-outline-danger btn-sm px-2 py-1 shadow-sm d-inline-flex align-items-center" title="Hapus">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                                @endcan
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-muted small">Keranjang masih kosong</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="border-top pt-3 mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="text-muted fw-semibold">Total Pembayaran:</span>
                                <h4 class="fw-bold text-dark mb-0">Rp {{ number_format($sale->total_pembayaran) }}</h4>
                            </div>

                            <form method="POST" action="{{ route('penjualan.update', $sale->id) }}"
                                onsubmit="return confirm('Yakin ingin checkout ?')">
                                @csrf
                                @method('PUT')

                                <select name="payment_method" class="form-select mb-3 bg-white shadow-sm">
                                    <option value="">Pilih Pembayaran</option>
                                    <option value="CASH">Cash</option>
                                    <option value="QRIS">QRIS</option>
                                </select>

                                <button class="btn btn-success w-100 py-2 fw-semibold shadow-sm {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}">
                                    <i class="bi bi-check-circle me-1"></i> Checkout
                                </button>
                            </form>

                            @can('delete', $sale)
                            <form action="{{ route('penjualan.destroy', $sale->id) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin membatalkan transaksi?')" class="mt-2">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-outline-danger w-100 py-2 fw-semibold {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}">
                                    <i class="bi bi-x-circle me-1"></i> Batalkan Transaksi
                                </button>
                            </form>
                            @endcan
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

@endsection