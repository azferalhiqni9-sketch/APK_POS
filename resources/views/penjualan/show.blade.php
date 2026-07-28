@extends('layouts.app')

@section('title', 'Detail Penjualan')

@section('content')

    @include('layouts.navbar')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Detail Transaksi</h1>
        <a href="{{ route('penjualan.index') }}" class="btn btn-secondary">Kembali</a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold">Tanggal Transaksi</div>
                <div class="col-md-9">: {{ $sale->created_at->translatedFormat('d-m-Y H:i:s') }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold">Kasir</div>
                <div class="col-md-9">: {{ $sale->user->name }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold">Metode Pembayaran</div>
                <div class="col-md-9">: {{ $sale->metode_pembayaran }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3 font-weight-bold">Status</div>
                <div class="col-md-9">: 
                    <span class="badge {{ $sale->status === 'COMPLETED' ? 'bg-success' : 'bg-warning' }}">
                        {{ $sale->status }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <h3>Daftar Produk yang Dibeli</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Produk</th>
                <th>Harga Satuan</th>
                <th>Kuantitas</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sale->itemPenjualan as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->produk->nama ?? 'Produk Dihapus' }}</td>
                <td>Rp.{{ number_format($item->harga_satuan ?? 0) }}</td>
                <td>{{ $item->kuantitas }}</td>
                <td>Rp.{{ number_format($item->subtotal) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Tidak ada item dalam transaksi ini.</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" class="text-end">Total Pembayaran:</th>
                <th>Rp.{{ number_format($sale->total_pembayaran) }}</th>
            </tr>
        </tfoot>
    </table>

@endsection