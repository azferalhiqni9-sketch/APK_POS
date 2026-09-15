@extends('layouts.app')

@section('content')
    <div class="container-fluid px-4 py-3">

        <!-- Judul Halaman -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h3 class="fw-bold mb-1 text-dark">Tentang Berkah Fashion</h3>
                <p class="text-muted mb-0">Informasi seputar profil usaha Berkah Fashion dan pengembang sistem</p>
            </div>
        </div>

        <div class="row g-4">

            <!-- Kolom Kiri: Informasi Perusahaan -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4">
                        <span class="badge bg-primary-subtle text-primary fw-bold px-3 py-2 rounded-pill mb-3">
                            <i class="fa-solid fa-store me-1"></i> Profil Toko
                        </span>
                        <h4 class="fw-bold text-dark mb-3">Apa itu Berkah Fashion?</h4>
                        <p class="text-secondary lead fs-6">
                            <strong>Berkah Fashion</strong> adalah usaha yang bergerak di bidang retail fashion berkualitas, menyediakan berbagai pilihan produk busana terbaik mulai dari <strong>pakaian, celana, hingga sepatu</strong> modern untuk kebutuhan harian maupun acara formal.
                        </p>
                        <p class="text-muted mb-4">
                            Sistem informasi berbasis web ini dikembangkan khusus untuk mengelola operasional penjualan, pencatatan stok produk fashion, serta transaksi kasir Berkah Fashion secara cepat dan akurat.
                        </p>

                        <!-- Produk & Layanan Utama -->
                        <h5 class="fw-bold mb-3 text-dark">Kategori Produk Utama</h5>
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <div class="p-3 rounded-3 bg-primary-subtle border border-primary border-opacity-25 text-center h-100">
                                    <div class="fs-2 text-primary mb-2"><i class="fa-solid fa-shirt"></i></div>
                                    <h6 class="fw-bold text-dark mb-1">Pakaian</h6>
                                    <small class="text-muted">Kaos, kemeja, jaket, dan busana harian maupun resmi.</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 rounded-3 bg-success-subtle border border-success border-opacity-25 text-center h-100">
                                    <div class="fs-2 text-success mb-2"><i class="fa-solid fa-user-large"></i></div>
                                    <h6 class="fw-bold text-dark mb-1">Celana</h6>
                                    <small class="text-muted">Celana jeans, chino, kulot, dan celana formal bergaya modern.</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 rounded-3 bg-warning-subtle border border-warning border-opacity-25 text-center h-100">
                                    <div class="fs-2 text-warning mb-2"><i class="fa-solid fa-shoe-prints"></i></div>
                                    <h6 class="fw-bold text-dark mb-1">Sepatu</h6>
                                    <small class="text-muted">Sneakers, sepatu formal, dan alas kaki kasual yang nyaman.</small>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Alamat Toko -->
                        <div class="p-3 rounded-3 bg-light border border-2 border-primary border-opacity-50">
                            <h6 class="fw-bold text-primary mb-2">
                                <i class="fa-solid fa-location-dot me-2"></i>Alamat & Lokasi Toko
                            </h6>
                            <p class="text-dark mb-0 small">
                                <strong>Berkah Fashion</strong><br>
                                Jl. Leuwianyar, Gang Dadali, Kel. Sukamanah, Kec. Cipedes,<br>
                                Kota Tasikmalaya, Jawa Barat 46115<br>
                                <span class="text-muted"><i class="fa-regular fa-clock me-1"></i>Jam Operasional: Setiap Hari (08.00 - 21.00 WIB)</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Pengembang, Kontak, & Keunggulan -->
            <div class="col-lg-4 d-flex flex-column gap-3">

                <!-- 1. Card Profil Pengembang -->
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="bg-primary py-4 text-center text-white">
                        <img src="{{ asset('imges/logo.jpg') }}" 
                             class="rounded-circle img-thumbnail shadow" 
                             style="width: 110px; height: 110px; object-fit: cover;" 
                             alt="Logo Berkah Fashion">
                    </div>
                    <div class="card-body p-4 text-center">
                        <h5 class="fw-bold mb-1 text-dark">Rajil Apriana</h5>
                        <span class="badge bg-primary-subtle text-primary fw-semibold mb-3">Web Developer</span>
                        <p class="text-muted small mb-0">
                            Pengembang sistem aplikasi kasir dan manajemen persediaan untuk <strong>Berkah Fashion</strong>. Berfokus pada efisiensi transaksi dan pengelolaan stok barang.
                        </p>
                    </div>
                </div>

                <!-- 2. Card Kontak & Layanan Pelanggan -->
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-headset text-primary me-2"></i>Kontak & Layanan</h6>
                        <div class="d-flex flex-column gap-2 small">
                            <div class="d-flex align-items-center">
                                <i class="fa-brands fa-whatsapp text-success fs-5 me-3 width-20"></i>
                                <span>+62 897-965-6360</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="fa-brands fa-instagram text-danger fs-5 me-3 width-20"></i>
                                <span>@berkahfashion.official</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="fa-solid fa-envelope text-warning fs-5 me-3 width-20"></i>
                                <span>info@berkahfashion.com</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. Card Keunggulan Toko -->
                <div class="card border-0 shadow-sm rounded-4 bg-primary text-white">
                    <div class="card-body p-3 text-center">
                        <p class="fw-bold mb-1"><i class="fa-solid fa-circle-check me-1"></i> Jaminan Kualitas</p>
                        <small class="opacity-75">Bahan Premium • Harga Terjangkau • Pelayanan Cepat</small>
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection