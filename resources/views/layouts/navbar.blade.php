<div class="sticky-top pt-0 pb-2">
    <nav class="navbar navbar-expand-lg bg-white border shadow-sm rounded-3 py-3 px-4" style="max-width: 1200px; width: 100%; margin: 0 auto;">
        <div class="container-fluid p-0">
            
            {{-- Brand / Logo POS --}}
            <a class="navbar-brand fw-bold text-primary fs-4 m-0 text-decoration-none" href="{{ route('dashboard') }}">
                <i class="bi bi-shop me-2"></i>Toko Berkah POS
            </a>

            {{-- Toggle Button for Mobile --}}
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            {{-- Menu Navigation --}}
            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                <ul class="navbar-nav mb-2 mb-lg-0 align-items-lg-center gap-2 me-3">
                    
                    <li class="nav-item">
                        <a class="btn {{ Request::is('dashboard*') ? 'btn-primary fw-bold shadow-sm' : 'btn-light text-dark' }}" href="{{ route('dashboard') }}">
                            <i class="bi bi-speedometer2 me-1"></i> Dashboard
                        </a>
                    </li>

                    {{-- Menu Users HANYA untuk ADMIN (role_id = 1) --}}
                    @if(auth()->check() && auth()->user()->role_id == 1)
                    <li class="nav-item">
                        <a class="btn {{ Request::is('admin/users*') ? 'btn-primary fw-bold shadow-sm' : 'btn-light text-dark' }}" href="{{ route('admin.users') }}">
                            <i class="bi bi-people me-1"></i> Users
                        </a>
                    </li>
                    @endif

                    <li class="nav-item">
                        <a class="btn {{ Request::is('jenis*') ? 'btn-primary fw-bold shadow-sm' : 'btn-light text-dark' }}" href="{{ route('jenis.index') }}">
                            <i class="bi bi-tags me-1"></i> Jenis
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn {{ Request::is('produk*') ? 'btn-primary fw-bold shadow-sm' : 'btn-light text-dark' }}" href="{{ route('produk.index') }}">
                            <i class="bi bi-box-seam me-1"></i> Produk
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="btn {{ Request::is('penjualan*') ? 'btn-primary fw-bold shadow-sm' : 'btn-light text-dark' }}" href="{{ route('penjualan.index') }}">
                            <i class="bi bi-cart-check me-1"></i> Penjualan
                        </a>
                    </li>

                </ul>

                {{-- Logout Button --}}
                <form action="{{ route('logout') }}" method="POST" class="d-flex m-0">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger px-3 py-2">
                        <i class="bi bi-box-arrow-right me-1"></i> Logout
                    </button>
                </form>
            </div>

        </div>
    </nav>
</div>