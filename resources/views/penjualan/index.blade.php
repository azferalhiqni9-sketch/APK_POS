@extends('layouts.app')

@section('title', 'Penjualan')

@section('content')

    @include('layouts.navbar')

    {{-- Pesan Error (Flash Session) --}}
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    {{-- Pesan Sukses (Flash Session) --}}
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <h1>Halaman Penjualan</h1>
    <a href="{{ route('penjualan.create') }}" class="btn btn-primary mb-3">Create</a>

    <form action="{{ route('penjualan.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" value="{{ request()->search }}" class="form-control"
                placeholder="search penjualan">
            <button class="btn btn-outline-secondary" type="submit">
                search
            </button>
        </div>
    </form>
    
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Tanggal Transaksi</th>
                <th scope="col">Kasir</th>
                <th scope="col">Total Pembayaran</th>
                <th scope="col">Metode Pembayaran</th>
                <th scope="col">Status</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sales as $sale)
            <tr>
                <th scope="row">{{ $sales->firstItem() + $loop->index }}</th>
                <td>{{ $sale->created_at->translatedFormat('d-m-Y H:i:s') }}</td>
                <td>{{ $sale->user->name }}</td>
                <td>Rp.{{ number_format($sale->total_pembayaran) }}</td>
                <td>{{ $sale->metode_pembayaran }}</td>
                <td>{{ $sale->status }}</td>
                <td class="d-flex align-items-center gap-1">
                    <a href="{{ route('penjualan.show', $sale) }}" class="btn btn-primary btn-sm">Detail</a>
                    
                    @can('view', $sale)
                        @if(strtoupper($sale->status) === 'OPEN')
                            <a href="{{ route('penjualan.edit', $sale) }}" class="btn btn-warning btn-sm">Edit</a>
                        @endif
                    @endcan

                    @can('delete', $sale)
                        @if(strtoupper($sale->status) === 'OPEN')
                            <form action="{{ route('penjualan.destroy', $sale) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin akan menghapus penjualan ini?')">
                                    Hapus
                                </button>
                            </form>
                        @endif
                    @endcan
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Data Tidak Ditemukan</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $sales->links() }}

@endsection