<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Klinik App') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-gray-100 to-gray-200 font-sans text-gray-900 antialiased">

<div class="min-h-screen">

    <!-- NAVBAR -->
    <div class="sticky top-0 z-40">
        @include('layouts.navigation')
    </div>

    <!-- HEADER -->
    @if (isset($header))
        <header class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-xl font-semibold text-gray-800">
                    {{ $header }}
                </h1>
            </div>
        </header>
    @endif

    <!-- CONTENT -->
    <main class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{ $slot }}
        </div>
    </main>

</div>

<!-- TOAST SUCCESS -->
@if(session('success'))
    <div id="toast-success"
         class="fixed top-5 right-5 bg-green-500 text-white px-4 py-3 rounded-lg shadow-lg z-50 animate-bounce">
        {{ session('success') }}
    </div>
@endif

<!-- TOAST ERROR -->
@if(session('error'))
    <div id="toast-error"
         class="fixed top-5 right-5 bg-red-500 text-white px-4 py-3 rounded-lg shadow-lg z-50 animate-bounce">
        {{ session('error') }}
    </div>
@endif

<!-- AUTO HIDE TOAST -->
<script>
    setTimeout(() => {
        document.getElementById('toast-success')?.remove();
        document.getElementById('toast-error')?.remove();
    }, 3000);
</script>

</body>
</html>