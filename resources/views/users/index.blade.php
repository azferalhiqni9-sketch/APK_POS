{{-- 1. LAYOUT INHERITANCE: Memanggil kerangka tampilan utama --}}
@extends('layouts.app')

{{-- 2. DYNAMIC TITLE: Mengeset judul halaman --}}
@section('title', 'Users')

{{-- 3. CONTENT SECTION: Wadah utama konten --}}
@section('content')

<div class="container py-3">
    {{-- HEADER & TOMBOL TAMBAH DATA --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">
                <i class="bi bi-people-fill text-primary me-2"></i>Users
            </h3>
            <p class="text-muted small mb-0">Kelola daftar pengguna aplikasi POS dengan mudah.</p>
        </div>
        {{-- ROUTE HELPER: Memanggil URL tambah user berdasarkan nama route 'admin.users.create' --}}
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary shadow-sm px-3 py-2">
            <i class="bi bi-person-plus-fill me-1"></i> Tambah User
        </a>
    </div>

    {{-- CARD WRAPPER --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-4">

            {{-- FORM SEARCH (GET METHOD) --}}
            <form action="{{ route('admin.users') }}" method="GET" class="mb-4">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-search"></i></span>
                    {{-- REQUEST HELPER: Menjaga agar teks pencarian tidak hilang dari kolom input setelah tombol search diklik --}}
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="form-control border-start-0 bg-light"
                        placeholder="Search username or email"
                    >
                    <button class="btn btn-dark px-4" type="submit">Search</button>
                </div>
            </form>

            {{-- TABEL DATA --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-uppercase fs-7 text-secondary">
                        <tr>
                            <th class="py-3 ps-3" style="width: 5%;">#</th>
                            <th class="py-3">Name</th>
                            <th class="py-3">Email</th>
                            <th class="py-3">Role</th>
                            <th class="py-3 text-center" style="width: 18%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- FORELSE DIRECTIVE: Loop data array/collection $users sekaligus menangani kondisi jika data kosong --}}
                        @forelse ($users as $user)
                        <tr>
                            {{-- PAGINATION NUMBERING FORMULA: Menghitung nomor urut agar berlanjut secara benar pada tiap halaman pagination --}}
                            <td class="ps-3 fw-semibold text-muted">{{ $users->firstItem() + $loop->index }}</td>
                            <td>
                                {{-- INTERPOLASI / MUSTACHE SYNTAX: Mencetak data nama user dari model --}}
                                <div class="fw-bold text-dark">{{ $user->name }}</div>
                            </td>
                            <td class="text-muted">{{ $user->email }}</td>
                            <td>
                                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-semibold">
                                    {{-- TERNARY OPERATOR & HELPER: Pengecekan apakah role berupa Object Relasi atau String biasa --}}
                                    {{ is_object($user->role) ? $user->role->name : ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    {{-- TOMBOL EDIT (ROUTING WITH PARAMETER): Mengirimkan objek/ID user ke route edit --}}
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline-primary btn-sm px-2 py-1 shadow-sm d-inline-flex align-items-center" title="Edit">
                                        <i class="bi bi-pencil-square me-1"></i> Edit
                                    </a>

                                    {{-- FORM HAPUS DENGAN DYNAMIC ID --}}
                                    <form id="delete-form-user-{{ $user->id }}" action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                        {{-- @csrf: Token keamanan Laravel --}}
                                        @csrf
                                        {{-- @method('DELETE'): METHOD SPOOFING untuk mengubah request POST menjadi DELETE sesuai aturan RESTful API --}}
                                        @method('DELETE')
                                        <button type="button" 
                                            class="btn btn-outline-danger btn-sm px-2 py-1 shadow-sm d-inline-flex align-items-center" 
                                            onclick="confirmUserDelete({{ $user->id }})" 
                                            title="Hapus">
                                            <i class="bi bi-trash me-1"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        {{-- KONDISI JIKA DATA $users KOSONG --}}
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Tidak ada data user ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION WITH QUERY STRING --}}
            {{-- METHOD_EXISTS: Mengecek apakah variabel $users menggunakan Paginator dari controller --}}
            @if (method_exists($users, 'links'))
                <div class="mt-4 d-flex justify-content-end">
                    {{-- withQueryString(): Memastikan parameter kata kunci pencarian (search) tetap terbawa saat berpindah halaman pagination --}}
                    {{ $users->withQueryString()->links() }}
                </div>
            @endif

        </div>
    </div>
</div>

{{-- JAVASCRIPT SWEETALERT UNTUK KONFIRMASI HAPUS --}}
<script>
function confirmUserDelete(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data user yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Memicu pengiriman form hapus berdasarkan ID yang dipilih
            document.getElementById('delete-form-user-' + id).submit();
        }
    });
}
</script>

@endsection