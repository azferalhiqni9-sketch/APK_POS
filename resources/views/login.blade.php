@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="position-fixed top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center bg-light animate-fade-in">
    
    <div class="card shadow-sm border-0 rounded-4 p-4 p-md-5" style="width: 100%; max-width: 420px; background: #ffffff;">
        
        <!-- Header / Judul dengan Ikon Toko yang Elegan -->
        <div class="text-center mb-4">
            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-2 shadow-sm" style="width: 55px; height: 55px;">
                <i class="bi bi-shop fs-4"></i>
            </div>
            <div class="fw-bold text-primary fs-3 mb-1" style="letter-spacing: -1px;">Toko <span class="text-dark">Berkah</span></div>
            <p class="text-muted small mb-0">Masukkan akun untuk mengakses sistem</p>
        </div>

        <div class="card-body p-0">
            <form action="{{ route('login') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold text-dark small">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted ps-3 rounded-start-3">
                            <i class="bi bi-envelope"></i>
                        </span>
                        <input type="email" name="email" class="form-control bg-light border-start-0 py-2 @error('email') is-invalid @enderror" id="email" value="{{ old('email') }}" placeholder="nama@email.com" required autofocus>
                    </div>
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label fw-semibold text-dark small">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted ps-3 rounded-start-3">
                            <i class="bi bi-lock"></i>
                        </span>
                        <input type="password" name="password" class="form-control bg-light border-start-0 py-2 @error('password') is-invalid @enderror" id="password" placeholder="••••••••" required>
                    </div>
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror 
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="py-2.5 btn btn-primary fw-bold rounded-3 shadow-sm hover-login-btn">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Masuk ke Sistem
                    </button>
                </div>
            </form>
        </div>
        
    </div>

</div>

{{-- Efek Hover Halus pada Tombol Masuk --}}
<style>
    .hover-login-btn {
        transition: all 0.25s ease-in-out;
    }
    .hover-login-btn:hover {
        background-color: #0b5ed7 !important;
        transform: translateY(-1px);
        box-shadow: 0 .5rem 1rem rgba(13, 110, 253, 0.2) !important;
    }
</style>
@endsection