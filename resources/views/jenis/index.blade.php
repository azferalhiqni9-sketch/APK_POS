@extends('layouts.app')

@section('title', 'Jenis Produk')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1 d-flex align-items-center gap-2">
            <i class="bi bi-tags-fill text-primary" style="font-size: 1.5rem;"></i> Jenis
        </h2>
        <p class="text-muted small mb-0">Kelola daftar jenis produk aplikasi POS dengan mudah.</p>
    </div>
    <a href="{{ route('jenis.create') }}" class="btn btn-primary d-inline-flex align-items-center gap-1 shadow-sm">
        <i class="bi bi-plus-lg"></i> Tambah Jenis
    </a>
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
                        
                        {{-- Form Hapus dengan SweetAlert --}}
                        <form id="delete-form-{{ $item->id }}" action="{{ route('jenis.destroy', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" 
                                class="btn btn-sm btn-outline-danger d-inline-flex align-items-center gap-1 px-2.5 py-1" 
                                onclick="confirmJenisDelete({{ $item->id }})"
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

{{-- Script SweetAlert khusus untuk Hapus --}}
<script>
function confirmJenisDelete(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data jenis yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}
</script>
@endsection