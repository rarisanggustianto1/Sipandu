<!DOCTYPE html>
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
    @php
        $hasSidebar = auth()->check() && auth()->user()->role === 'tenaga_kesehatan';
    @endphp

    @if ($hasSidebar)
        {{-- Layout dengan sidebar (role Puskesmas) --}}
        <div class="flex min-h-screen">

            <div id="sidebar-backdrop"
                 class="fixed inset-0 z-30 hidden bg-gray-900/50 lg:hidden"
                 data-sidebar-close></div>

            @include('puskesmas.partials.sidebar')

            <div class="flex min-w-0 flex-1 flex-col">

                {{-- Topbar --}}
                <header class="sticky top-0 z-20 flex h-16 shrink-0 items-center gap-3 border-b border-gray-200 bg-white px-4 lg:px-6">
                    <button type="button" data-sidebar-open
                            class="rounded-md p-2 text-gray-600 transition-colors hover:bg-gray-100 lg:hidden"
                            aria-label="Buka menu" aria-controls="sidebar" aria-expanded="false">
                        <x-puskesmas.icon name="menu" class="h-6 w-6" />
                    </button>

                    <h1 class="min-w-0 flex-1 truncate text-base font-semibold text-gray-800 lg:text-lg">
                        @yield('heading', trim($__env->getSection('title', 'Dashboard')) ?: 'Dashboard')
                    </h1>

                    <nav class="flex items-center gap-2">
                        <a href="{{ route('profile') }}"
                           class="hidden items-center gap-2 rounded-md px-3 py-2 text-sm text-gray-700 transition-colors hover:bg-gray-100 sm:flex">
                            <span class="flex h-7 w-7 items-center justify-center rounded-full bg-teal-100 text-xs font-bold text-teal-700">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </span>
                            <span class="max-w-[10rem] truncate">{{ auth()->user()->name }}</span>
                        </a>

                        <span class="hidden rounded-md bg-teal-50 px-2.5 py-1 text-xs font-medium text-teal-700 ring-1 ring-inset ring-teal-200 md:inline-block">
                            {{ auth()->user()->role === 'tenaga_kesehatan' ? 'Puskesmas' : auth()->user()->role }}
                        </span>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="flex items-center gap-2 rounded-md px-3 py-2 text-sm font-medium text-rose-600 transition-colors hover:bg-rose-50">
                                <x-puskesmas.icon name="logout" class="h-5 w-5" />
                                <span class="hidden sm:inline">Keluar</span>
                            </button>
                        </form>
                    </nav>
                </header>

                {{-- Konten --}}
                <main class="min-w-0 flex-1 px-4 py-6 lg:px-8">
                    @include('layouts.partials.flash')
                    @yield('content')
                </main>
            </div>
        </div>
    @else
        {{-- Layout sederhana (login, tamu) --}}
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
            @include('layouts.partials.flash')
            @yield('content')
        </main>
    @endif
</body>
</html>