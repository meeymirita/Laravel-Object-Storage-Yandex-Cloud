<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @fonts

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="h-screen overflow-hidden bg-gradient-to-br from-slate-100 to-slate-300 p-4 sm:p-8">
    <main class="mx-auto flex h-full max-w-[1920px] flex-col gap-6 lg:flex-row">
        <div class="min-h-0 flex-1 lg:w-[60%] lg:flex-none">
            <x-file-list/>
        </div>
        <div class="min-h-0 flex-1 lg:w-[40%] lg:flex-none">
            <x-file-upload/>
        </div>
    </main>
</body>
</html>
