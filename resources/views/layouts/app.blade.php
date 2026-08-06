<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Toko Berkah POS')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">

    {{-- Navbar hanya akan muncul jika bukan halaman login --}}
    @if (!request()->is('login'))
        @include('layouts.navbar')
    @endif

    <main class="container py-3">
        @yield('content')
    </main>

</body>
</html>