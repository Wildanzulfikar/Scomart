<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Dashboard')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white font-sans antialiased">
    <div class="min-h-screen">
        {{-- Navbar khusus admin --}}
        @include('layouts.admin-navigation')

        {{-- Header --}}
        @hasSection('header')
            <header class="container">
                <div class="max-w-7xl py-6">
                    @yield('header')
                </div>
            </header>
        @endif

        {{-- Main content --}}
        <main class="container bg-white">
            @yield('content')
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
