<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @fonts

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-100 to-slate-300 p-4 sm:p-8">
    <main class="mx-auto h-[calc(100vh-2rem)] max-w-3xl sm:h-[calc(100vh-4rem)]">
        <x-file-upload/>
    </main>
</body>
</html>
