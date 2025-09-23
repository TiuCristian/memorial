<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

        <link href="{{ asset('css/custom.css') }}?v={{ time() }}" rel="stylesheet">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://unpkg.com/swiper@10/swiper-bundle.min.css">


        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://unpkg.com/swiper@10/swiper-bundle.min.js"></script>

        
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <body>
               @yield('content')
            </body>
            <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
                <div class="container">
                    <a class="navbar-brand" href="{{ route('homepage') }}">Memorial</a>
                    <div>
                        <a class="btn btn-outline-primary" href="{{ route('memories.form') }}">Formular amintiri</a>
                    </div>
                </div>
            </nav>
        </div>
    </body>
</html>
