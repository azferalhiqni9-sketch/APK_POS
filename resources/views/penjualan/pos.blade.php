@extends('layouts.app')

@section('title', 'POS')

@section('content')

<div class="container py-3">

    {{-- Header Halaman --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">
                <i class="bi bi-cart-plus-fill text-primary me-2"></i>{{ $mode == 'edit' ? 'Edit Penjualan' : 'Tambah Penjualan' }}
            </h3>
            <p class="text-muted small mb-0">Pilih produk di sebelah kiri untuk dimasukkan ke keranjang kasir.</p>
        </div>
        <a href="{{ route('penjualan.index') }}" class="btn btn-outline-secondary shadow-sm px-3 py-2">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    {{-- Card Wrapper Utama POS --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-4">
            
            <div class="row g-4">

                {{-- ================== KOLOM KIRI: PRODUK ================== --}}
                <div class="col-lg-7">
                    <div class="mb-3">
                        <form method="GET" action="{{ route('penjualan.create') }}">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-search"></i></span>
                                <input type="text" name="search" value="{{ request('search') }}" class="form-control border-start-0 bg-light"
                                    placeholder="Cari produk..." onkeyup="this.form.submit()">
                            </div>
                        </form>
                    </div>

                    <div class="pe-2" style="max-height: 60vh; overflow-y: auto;">
                        <div class="d-flex flex-column gap-2">
                            @foreach ($products as $product)
                                <form method="POST" action="{{ route('itempenjualan.store') }}" class="row g-2 align-items-center bg-white border rounded-3 p-2 shadow-sm m-0">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="penjualan_id" value="{{ $sale->id }}">

                                    <div class="col-7">
                                        <button type="submit"
                                            class="btn btn-outline-primary w-100 text-start p-2 border-0 bg-light {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}">
                                            <div class="d-flex align-items-center gap-2">
                                                <img src="{{ asset('storage/' . $product->foto) }}" alt="Gambar"
                                                    class="rounded-circle shadow-sm" style="width:45px; height:45px; object-fit:cover">
                                                <div>
                                                    <div class="fw-semibold text-dark">{{ $product->nama }}</div>
                                                    <small class="text-muted">Rp {{ number_format($product->harga_jual) }}</small>
                                                </div>
                                            </div>
                                        </button>
                                    </div>

                                    <div class="col-3">
                                        <input type="number" name="quantity" value="1" min="1"
                                            class="form-control form-control-sm bg-light text-center">
                                    </div>

                                    <div class="col-2">
                                        <button type="submit"
                                            class="btn btn-primary w-100 btn-sm shadow-sm {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}">
                                            <i class="bi bi-plus-lg"></i>
                                        </button>
                                    </div>
                                </form>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- ================== KOLOM KANAN: KERANJANG ================== --}}
                <div class="col-lg-5">
                    <div class="card border bg-light rounded-3 p-3">
                        <div class="table-responsive mb-3" style="max-height: 35vh; overflow-y: auto;">
                            <table class="table table-sm align-middle mb-0 bg-white rounded-3 overflow-hidden">
                                <thead class="table-light text-secondary fs-7">
                                    <tr>
                                        <th class="ps-3">Produk</th>
                                        <th>Harga</th>
                                        <th style="width: 20%;">Qty</th>
                                        <th>Subtotal</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($sale->itemPenjualan as $item)
                                        <tr>
                                            <td class="ps-3 fw-semibold text-dark small">{{ $item->produk->nama }}</td>
                                            <td class="small text-muted">Rp {{ number_format($item->produk->harga_jual) }}</td>
                                            <td>
                                                <form method="POST" action="{{ route('itempenjualan.update', $item->id) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="number" name="quantity" value="{{ $item->kuantitas }}"
                                                        class="form-control form-control-sm text-center bg-light" min="1" onchange="this.form.submit()">
                                                </form>
                                            </td>
                                            <td class="small fw-semibold">Rp {{ number_format($item->subtotal) }}</td>
                                            <td class="text-center">
                                                @can('delete', $item)
                                                <form method="POST" action="{{ route('itempenjualan.destroy', $item->id) }}" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-outline-danger btn-sm px-2 py-1 shadow-sm d-inline-flex align-items-center" title="Hapus">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                                @endcan
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-muted small">Keranjang masih kosong</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="border-top pt-3 mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="text-muted fw-semibold">Total Pembayaran:</span>
                                <h4 class="fw-bold text-dark mb-0">Rp {{ number_format($sale->total_pembayaran) }}</h4>
                            </div>

                            {{-- Form Checkout --}}
                            <form method="POST" action="{{ route('penjualan.update', $sale->id) }}" id="form-checkout">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label class="form-label small fw-semibold text-muted">Metode Pembayaran</label>
                                    
                                    <input type="hidden" name="payment_method" id="payment_method" value="" required>

                                    <div class="row g-2">
                                        <div class="col-6">
                                            <button type="button" class="btn btn-outline-primary w-100 py-2 payment-btn" data-value="CASH">
                                                <i class="bi bi-cash-coin me-1"></i> Cash
                                            </button>
                                        </div>

                                        <div class="col-6">
                                            <button type="button" class="btn btn-outline-primary w-100 py-2 payment-btn" data-value="QRIS">
                                                <i class="bi bi-qr-code me-1"></i> QRIS
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                {{-- Section Cash (Hanya tampil jika memilih CASH) --}}
                                <div class="mb-3" id="cash-section" style="display: none;">
                                    <label class="form-label small fw-semibold text-muted">Uang Diterima (Cash)</label>
                                    <input type="number" name="uang_bayar" id="uang_bayar" class="form-control bg-white shadow-sm" placeholder="Masukkan jumlah uang...">
                                    
                                    <div class="mt-2 p-2 bg-white rounded border d-flex justify-content-between align-items-center">
                                        <span class="small text-muted fw-semibold">Kembalian:</span>
                                        <span id="text-kembalian" class="fw-bold text-danger fs-6">Rp 0</span>
                                    </div>
                                </div>

                                {{-- Section QRIS (Hanya tampil jika memilih QRIS) --}}
                                <div class="mb-3 text-center p-3 bg-white rounded border shadow-sm" id="qris-section" style="display: none;">
                                    <label class="form-label small fw-semibold text-muted d-block mb-2">Scan QRIS untuk Pembayaran</label>
                                    <img src="{{ asset('imges/Barcode.jpeg') }}" alt="QRIS Barcode" class="img-fluid rounded border p-2 bg-white" style="max-width: 200px;">
                                </div>

                                <button type="button" class="btn btn-success w-100 py-2 fw-semibold shadow-sm btn-checkout {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}">
                                    <i class="bi bi-check-circle me-1"></i> Checkout
                                </button>
                            </form>

                            {{-- Form Batalkan Transaksi --}}
                            @can('delete', $sale)
                            <form action="{{ route('penjualan.destroy', $sale->id) }}" method="POST" class="mt-2" id="form-batal">
                                @csrf
                                @method('DELETE')

                                <button type="button" class="btn btn-outline-danger w-100 py-2 fw-semibold btn-batal {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}">
                                    <i class="bi bi-x-circle me-1"></i> Batalkan Transaksi
                                </button>
                            </form>
                            @endcan
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

{{-- Script SweetAlert2, Tombol Pembayaran & Kalkulator Kembalian Otomatis --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Pop-up jika Stok Tidak Cukup
        @if (session('swal_error'))
            Swal.fire({
                icon: 'error',
                title: 'Stok Tidak Cukup!',
                text: '{{ session('swal_error') }}',
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'Mengerti'
            });
        @endif

        const paymentBtns = document.querySelectorAll('.payment-btn');
        const paymentMethodInput = document.getElementById('payment_method');
        const cashSection = document.getElementById('cash-section');
        const qrisSection = document.getElementById('qris-section');
        const inputUangBayar = document.getElementById('uang_bayar');
        const textKembalian = document.getElementById('text-kembalian');
        const totalTagihan = {{ $sale->total_pembayaran ?? 0 }};

        // Logika Tombol Metode Pembayaran
        paymentBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                paymentBtns.forEach(b => b.classList.remove('active', 'btn-primary', 'text-white'));
                paymentBtns.forEach(b => b.classList.add('btn-outline-primary'));

                this.classList.remove('btn-outline-primary');
                this.classList.add('active', 'btn-primary', 'text-white');

                const selectedValue = this.getAttribute('data-value');
                paymentMethodInput.value = selectedValue;

                if (selectedValue === 'CASH') {
                    cashSection.style.display = 'block';
                    qrisSection.style.display = 'none';
                    inputUangBayar.setAttribute('required', 'required');
                } else if (selectedValue === 'QRIS') {
                    cashSection.style.display = 'none';
                    qrisSection.style.display = 'block';
                    inputUangBayar.removeAttribute('required');
                    inputUangBayar.value = '';
                    textKembalian.innerText = 'Rp 0';
                } else {
                    cashSection.style.display = 'none';
                    qrisSection.style.display = 'none';
                    inputUangBayar.removeAttribute('required');
                }
            });
        });

        // Hitung Kembalian Otomatis
        if (inputUangBayar) {
            inputUangBayar.addEventListener('input', function() {
                let uangBayar = parseFloat(this.value) || 0;
                let kembalian = uangBayar - totalTagihan;

                if (kembalian >= 0) {
                    textKembalian.innerText = 'Rp ' + kembalian.toLocaleString('id-ID');
                    textKembalian.classList.remove('text-danger');
                    textKembalian.classList.add('text-success');
                } else {
                    textKembalian.innerText = 'Uang Kurang (Rp ' + Math.abs(kembalian).toLocaleString('id-ID') + ')';
                    textKembalian.classList.remove('text-success');
                    textKembalian.classList.add('text-danger');
                }
            });
        }

        // Konfirmasi Checkout
        const btnCheckout = document.querySelector('.btn-checkout');
        if (btnCheckout) {
            btnCheckout.addEventListener('click', function (e) {
                e.preventDefault();
                const form = document.getElementById('form-checkout');

                Swal.fire({
                    title: 'Konfirmasi Checkout',
                    text: "Yakin ingin melakukan checkout transaksi ini?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#198754',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Checkout!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        }

        // Konfirmasi Batalkan Transaksi
        const btnBatal = document.querySelector('.btn-batal');
        if (btnBatal) {
            btnBatal.addEventListener('click', function (e) {
                e.preventDefault();
                const form = document.getElementById('form-batal');

                Swal.fire({
                    title: 'Batalkan Transaksi?',
                    text: "Semua produk di keranjang akan dihapus!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Batalkan!',
                    cancelButtonText: 'Tidak'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        }
    });
</script>

@endsection