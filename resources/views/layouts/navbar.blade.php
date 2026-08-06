<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm py-3 mb-4 sticky-top">
    {{-- Ubah div container ini agar mengikuti lebar konten utama (max-width: 1200px) --}}
    <div style="max-width: 1200px; width: 100%; margin: 0 auto; padding: 0 20px; display: flex; justify-content: space-between; align-items: center;">
        
        {{-- Brand / Logo POS --}}
        <a class="navbar-brand fw-bold text-primary fs-4 m-0" href="{{ route('dashboard') }}">
            <i class="bi bi-shop me-2"></i>Toko Berkah POS
        </a>

        {{-- Toggle Button for Mobile --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Menu Navigation --}}
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav mb-2 mb-lg-0 align-items-lg-center gap-lg-2 me-lg-3">
                <li class="nav-item">
                    <a class="nav-link px-3 rounded {{ request()->routeIs('dashboard*') ? 'active bg-primary text-white fw-bold shadow-sm' : 'text-dark' }}" href="{{ route('dashboard') }}">
                        <i class="bi bi-speedometer2 me-1"></i> Dashboard
                    </a>
                </li>

                {{-- Menu Users HANYA untuk ADMIN (role_id = 1) --}}
                @if(auth()->check() && auth()->user()->role_id == 1)
                <li class="nav-item">
                    <a class="nav-link px-3 rounded {{ request()->routeIs('admin.users*') ? 'active bg-primary text-white fw-bold shadow-sm' : 'text-dark' }}" href="{{ route('admin.users') }}">
                        <i class="bi bi-people me-1"></i> Users
                    </a>
                </li>
                @endif

                <li class="nav-item">
                    <a class="nav-link px-3 rounded {{ request()->routeIs('produk*') ? 'active bg-primary text-white fw-bold shadow-sm' : 'text-dark' }}" href="{{ route('produk.index') }}">
                        <i class="bi bi-box-seam me-1"></i> Produk
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 rounded {{ request()->routeIs('penjualan*') ? 'active bg-primary text-white fw-bold shadow-sm' : 'text-dark' }}" href="{{ route('penjualan.index') }}">
                        <i class="bi bi-cart-check me-1"></i> Penjualan
                    </a>
                </li>
            </ul>

            {{-- Logout Button --}}
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm px-3 py-2 fw-medium">
                    <i class="bi bi-box-arrow-right me-1"></i> Logout
                </button>
            </form>
        </div>
    </div>
</nav>