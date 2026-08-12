@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')

{{-- Navbar --}}


<div class="container py-4">
    {{-- Header & Tombol Kembali di Kanan --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="fw-bold text-dark mb-1">
                <i class="bi bi-person-plus-fill text-primary me-2"></i>Tambah User
            </h3>
            <p class="text-muted small mb-0">Silakan isi data pengguna baru di bawah ini.</p>
        </div>
        <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary shadow-sm px-3 py-2">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    {{-- Card Wrapper untuk Form --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-4">
            
            <form action="{{ route('admin.users.store') }}" method="POST">
                @include('users._form')
            </form>

        </div>
    </div>
</div>

@endsection