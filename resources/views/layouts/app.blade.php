<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Isi title yang kita kirimkan dari views lain -->
    <title>@yield('title')</title>
    <!-- memanggil Link bootstraps --> 
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    <!-- Isi konten yang kita kirimkan dari views lain -->
    @yield('content')

</body>
</html>