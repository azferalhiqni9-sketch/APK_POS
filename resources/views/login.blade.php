@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="position-fixed top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center bg-light">
    
    <div class="card shadow-sm border rounded-4 p-4 p-md-5" style="width: 100%; max-width: 420px; background: #ffffff;">
        
        <!-- Header / Judul -->
        <div class="text-center mb-4">
            <div class="fw-bold text-primary fs-3 mb-1" style="letter-spacing: -1px;">POS<span class="text-dark">App</span></div>
            <p class="text-muted small">Masukkan akun untuk mengakses sistem</p>
        </div>

        <div class="card-body p-0">
            <form action="{{ route('login') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold text-dark small">Email Address</label>
                    <input type="email" name="email" class="form-control bg-light py-2 @error('email') is-invalid @enderror" id="email" value="{{ old('email') }}" placeholder="nama@email.com" required autofocus>
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label fw-semibold text-dark small">Password</label>
                    <input type="password" name="password" class="form-control bg-light py-2 @error('password') is-invalid @enderror" id="password" placeholder="••••••••" required>
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror 
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="py-2.5 btn btn-dark fw-bold rounded-3 shadow-sm">Masuk ke Sistem</button>
                </div>
            </form>
        </div>
        
    </div>

</div>
@endsection