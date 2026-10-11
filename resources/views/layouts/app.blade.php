<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'SIPANDU') }} @yield('title')</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            body { font-family: ui-sans-serif, system-ui, sans-serif; }
        </style>
    @endif
</head>
<body class="min-h-screen bg-gray-100 text-gray-900">
    @auth
        <header class="bg-white shadow-sm">
            <div class="mx-auto flex max-w-5xl items-center justify-between px-4 py-3">
                <a href="{{ url('/') }}" class="text-lg font-bold tracking-tight">SIPANDU</a>
                <nav class="flex items-center gap-4 text-sm">
                    <span class="rounded bg-blue-100 px-2 py-1 text-xs font-medium text-blue-800">
                        {{ auth()->user()->role }}
                    </span>
                    <a href="{{ route('profile') }}" class="hover:underline">{{ auth()->user()->name }}</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-red-600 hover:underline">Keluar</button>
                    </form>
                </nav>
            </div>
        </header>
    @endauth

    <main class="mx-auto max-w-5xl px-4 py-6">
        @if (session('status'))
            <div class="mb-4 rounded bg-green-100 px-4 py-2 text-sm text-green-800">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 rounded bg-red-100 px-4 py-2 text-sm text-red-800">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
