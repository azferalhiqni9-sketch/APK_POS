<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Toko Berkah POS')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">

    {{-- Navbar teteh yang sudah bagus --}}
    @if (!request()->is('login'))
        @include('layouts.navbar')
    @endif

    {{-- KONTEN UTAMA: Padding kiri-kanan disamakan jadi 20px supaya sejajar pas --}}
    <main style="max-width: 1200px; width: 100%; margin: 0 auto; padding-left: 20px; padding-right: 20px;" class="py-3">
        @yield('content')
    </main>

</body>
</html>