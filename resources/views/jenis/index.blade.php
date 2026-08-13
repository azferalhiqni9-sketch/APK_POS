@extends('layouts.app')

@section('title', 'Jenis Produk')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Daftar Jenis Produk</h2>
        <a href="{{ route('jenis.create') }}" class="btn btn-primary">+ Tambah Jenis</a>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="bg-light text-uppercase text-secondary small fw-bold">
            <tr>
                <th>No</th>
                <th>Nama Jenis</th>
                <th>Dibuat Oleh (User)</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($jenis as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->nama_jenis }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center fw-bold shrink-0" 
                                style="width: 32px; height: 32px; font-size: 0.8rem;">
                                {{ strtoupper(substr($item->user->name ?? 'K', 0, 1)) }}
                            </div>

                            <span class="fw-semibold text-dark small">
                                {{ $item->user->name ?? 'Kasir' }}
                            </span>
                        </div>
                    </td>
                    <td>
                        <a href="{{ route('jenis.edit', $item->id) }}" class="btn btn-sm btn-outline-warning d-inline-flex align-items-center gap-1 px-2.5 py-1">Edit</a>
                        <form action="{{ route('jenis.destroy', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                class="btn btn-sm btn-outline-danger d-inline-flex align-items-center gap-1 px-2.5 py-1" 
                                onclick="return confirm('Apakah Anda yakin ingin menghapus jenis ini?')"
                                title="Hapus Jenis">
                                <i class="bi bi-trash"></i>
                                <span>Hapus</span>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Data jenis belum ada.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection