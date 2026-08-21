<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Toko Berkah POS')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Memanggil library SweetAlert2 dari CDN untuk menampilkan pop-up/toast modern -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-light">

    {{-- Navbar: Menampilkan navigasi kecuali di halaman login --}}
    @if (!request()->is('login'))
        @include('layouts.navbar')
    @endif

    {{-- KONTEN UTAMA: Area tempat konten dari halaman lain (seperti jenis/produk) ditampilkan --}}
    <main style="max-width: 1200px; width: 100%; margin: 0 auto; padding-left: 20px; padding-right: 20px;" class="py-3">
        @yield('content')
    </main>

    {{-- Toast Notification: Muncul otomatis jika controller mengirim pesan 'success' --}}
    @if(session('success'))
    <script>
        // Membuat konfigurasi dasar Toast agar tampil di pojok kanan atas
        const Toast = Swal.mixin({
            toast: true,                // Mengaktifkan mode Toast (kecil & melayang)
            position: 'top-end',        // Menaruh posisi di pojok kanan atas
            showConfirmButton: false,   // Menyembunyikan tombol "OK"
            timer: 3000,                // Menutup otomatis dalam 3 detik
            timerProgressBar: true,     // Menampilkan garis waktu mundur di bawah notifikasi
            didOpen: (toast) => {
                // Berhenti menghitung waktu jika kursor diarahkan ke notifikasi
                toast.onmouseenter = Swal.stopTimer;
                // Melanjutkan hitung waktu jika kursor dijauhkan
                toast.onmouseleave = Swal.resumeTimer;
            }
        });

        // Menjalankan notifikasi dengan icon sukses dan pesan dari Laravel session
        Toast.fire({
            icon: 'success',
            title: '{{ session('success') }}'
        });
    </script>
    @endif

</body>
</html>