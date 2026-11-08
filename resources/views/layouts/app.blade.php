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
        $hasSidebar = auth()->check();
    @endphp

    @if ($hasSidebar)
        <div class="flex min-h-screen">
            <div id="sidebar-backdrop"
                 class="fixed inset-0 z-30 hidden bg-gray-900/50 lg:hidden"
                 data-sidebar-close></div>

            @include('layouts.partials.sidebar')

            <div class="flex min-w-0 flex-1 flex-col">
                <main class="relative mx-auto w-full min-w-0 max-w-7xl flex-1 px-4 pb-6 pt-16 lg:px-8 lg:py-6">
                    <button type="button"
                            data-sidebar-open
                            class="fixed left-4 top-4 z-20 rounded-lg border border-gray-200 bg-white p-2 text-gray-700 shadow-sm transition-colors hover:bg-gray-50 lg:hidden"
                            aria-label="Buka menu navigasi"
                            aria-controls="sidebar"
                            aria-expanded="false">
                        <x-puskesmas.icon name="menu" class="h-5 w-5" />
                    </button>
                    @include('layouts.partials.flash')
                    @isset($header)
                        <div class="mb-6 border-b border-gray-200 pb-4">
                            {{ $header }}
                        </div>
                    @endisset
                    @yield('content')
                    {{ $slot ?? '' }}
                </main>
            </div>
        </div>
    @else
        <main class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            @include('layouts.partials.flash')
            @isset($header)
                <div class="mb-6 border-b border-gray-200 pb-4">
                    {{ $header }}
                </div>
            @endisset
            @yield('content')
            {{ $slot ?? '' }}
        </main>
    @endif
</body>
</html>
