<!DOCTYPE html>
<<<<<<< HEAD
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SiPANDU') }} @hasSection('title') - @yield('title') @endif</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts & Styles -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <script src="https://cdn.tailwindcss.com"></script>
            <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        @endif
    </head>
    <body class="h-full font-sans antialiased text-gray-800 bg-gray-50 overflow-hidden" x-data="{ sidebarOpen: false }">
        <!-- Main Application Wrapper: flex h-screen overflow-hidden -->
        <div class="flex h-screen overflow-hidden">

            <!-- Mobile Backdrop (Visible only when mobile sidebar drawer opens) -->
            <div x-show="sidebarOpen" 
                 x-transition:enter="transition-opacity ease-linear duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="sidebarOpen = false" 
                 class="fixed inset-0 bg-gray-900/40 z-40 md:hidden"
                 style="display: none;"></div>

            <!-- Sidebar Navigation (w-64 / w-72, relative/sticky flex item on desktop) -->
            @include('layouts.navigation')

            <!-- Main Content Area: flex-1 flex flex-col h-screen overflow-hidden min-w-0 -->
            <div class="flex-1 flex flex-col h-screen overflow-hidden min-w-0 bg-gray-50/50">

                <!-- Mobile Top Bar (Only visible on small devices) -->
                <div class="md:hidden flex items-center justify-between bg-white border-b border-gray-200 px-4 py-3 shrink-0">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/sipandu-logo.png') }}" alt="Logo SiPANDU" class="h-8 w-auto object-contain">
                        <div>
                            <span class="text-base font-bold text-teal-800 leading-tight block">SiPANDU</span>
                            <span class="text-[10px] text-gray-500 font-medium">Pemantauan Posyandu</span>
                        </div>
                    </div>
                    <button @click="sidebarOpen = !sidebarOpen" 
                            type="button" 
                            class="p-2 rounded-lg text-gray-600 hover:text-teal-700 hover:bg-gray-100 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>
                </div>

                <!-- Page Header (Optional) -->
                @isset($header)
                    <header class="bg-white border-b border-gray-200 py-4 px-6 sm:px-8 shrink-0">
                        <div class="max-w-7xl mx-auto">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Scrollable Main Container: flex-1 overflow-y-auto p-6 -->
                <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
                    <!-- Flash Messages Notification -->
                    @if (session('status'))
                        <div class="mb-5 max-w-7xl mx-auto rounded-xl bg-teal-50 border border-teal-200 px-4 py-3 text-sm text-teal-800 flex items-center gap-2 shadow-sm">
                            <svg class="w-5 h-5 text-teal-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                            <span>{{ session('status') }}</span>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="mb-5 max-w-7xl mx-auto rounded-xl bg-emerald-50 border border-emerald-200 px-4 py-3 text-sm text-emerald-800 flex items-center gap-2 shadow-sm">
                            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    @if (session('error') || $errors->any())
                        <div class="mb-5 max-w-7xl mx-auto rounded-xl bg-rose-50 border border-rose-200 px-4 py-3 text-sm text-rose-800 shadow-sm">
                            @if (session('error'))
                                <p class="font-medium">{{ session('error') }}</p>
                            @endif
                            @if ($errors->any())
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    @endif

                    <!-- Content Injected via Slot or Yield -->
                    <div class="max-w-7xl mx-auto">
                        @if (isset($slot) && trim($slot) !== '')
                            {{ $slot }}
                        @else
                            @yield('content')
                        @endif
                    </div>
                </main>

            </div>
        </div>
    </body>
=======
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'SIPANDU') — SIPANDU</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        :root {
            --sipandu-primary: oklch(55% 0.18 250);
            --sipandu-primary-light: oklch(92% 0.04 250);
            --sipandu-primary-dark: oklch(40% 0.18 250);
            --sipandu-success: oklch(62% 0.19 150);
            --sipandu-success-light: oklch(95% 0.04 150);
            --sipandu-warning: oklch(78% 0.18 80);
            --sipandu-warning-light: oklch(96% 0.04 80);
            --sipandu-danger: oklch(58% 0.24 27);
            --sipandu-danger-light: oklch(95% 0.04 27);
            --sipandu-info: oklch(65% 0.15 220);
            --sipandu-info-light: oklch(95% 0.04 220);
        }
    </style>
</head>

<body class="bg-[#FDFDFC] text-[#1b1b18] min-h-screen antialiased">

    @auth
        <header class="bg-white shadow-sm border-b">
            <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-3">
                <a href="{{ url('/') }}" class="text-lg font-bold tracking-tight">
                    SIPANDU
                </a>

                <nav class="flex items-center gap-4 text-sm">
                    <span class="rounded bg-blue-100 px-2 py-1 text-xs font-medium text-blue-800">
                        {{ auth()->user()->role }}
                    </span>

                    <span>{{ auth()->user()->name }}</span>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-red-600 hover:underline">
                            Keluar
                        </button>
                    </form>
                </nav>
            </div>
        </header>
    @endauth

    {{-- Flash Messages --}}
    @if (session('success'))
        <div class="max-w-6xl mx-auto px-4 mt-4">
            <div class="rounded-md p-4 text-sm bg-green-100 text-green-800">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="max-w-6xl mx-auto px-4 mt-4">
            <div class="rounded-md p-4 text-sm bg-red-100 text-red-800">
                {{ session('error') }}
            </div>
        </div>
    @endif

    {{-- Page Content --}}
    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

</body>
</html>
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
                    <a href="{{ route('profile.edit') }}" class="hover:underline">{{ auth()->user()->name }}</a>
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
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'SIPANDU') — SIPANDU</title>

    @fonts

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        /* ── SIPANDU Custom Styles ──────────────────────────── */
        :root {
            --sipandu-primary: oklch(55% 0.18 250);
            --sipandu-primary-light: oklch(92% 0.04 250);
            --sipandu-primary-dark: oklch(40% 0.18 250);
            --sipandu-success: oklch(62% 0.19 150);
            --sipandu-success-light: oklch(95% 0.04 150);
            --sipandu-warning: oklch(78% 0.18 80);
            --sipandu-warning-light: oklch(96% 0.04 80);
            --sipandu-danger: oklch(58% 0.24 27);
            --sipandu-danger-light: oklch(95% 0.04 27);
            --sipandu-info: oklch(65% 0.15 220);
            --sipandu-info-light: oklch(95% 0.04 220);
        }
    </style>
</head>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC] min-h-screen antialiased">

    {{-- ── Top Navigation Bar ──────────────────────────────── --}}
    <nav class="bg-white dark:bg-[#161615] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] border-b border-[#e3e3e0] dark:border-[#3E3E3A]">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                {{-- Logo / Brand --}}
                <div class="flex items-center gap-3">
                    <a href="{{ route('peserta.dashboard') }}" class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-md flex items-center justify-center text-white font-semibold text-sm" style="background: var(--sipandu-primary);">
                            SP
                        </div>
                        <span class="font-semibold text-lg">SIPANDU</span>
                    </a>
                </div>

                {{-- Navigation Links --}}
                <div class="hidden sm:flex items-center gap-1">
                    <a href="{{ route('peserta.dashboard') }}"
                       class="px-4 py-2 rounded-md text-sm font-medium transition
                              {{ request()->routeIs('peserta.dashboard') ? 'bg-gray-100 dark:bg-[#3E3E3A] text-[#1b1b18] dark:text-[#EDEDEC]' : 'text-[#706f6c] dark:text-[#A1A09A] hover:bg-gray-100 dark:hover:bg-gray-900' }}">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25a2.25 2.25 0 0 1-2.25-2.25v-2.25Z" /></svg>
                            Dashboard
                        </span>
                    </a>
                    <a href="{{ route('peserta.keluarga.index') }}"
                       class="px-4 py-2 rounded-md text-sm font-medium transition
                              {{ request()->routeIs('peserta.keluarga.*') ? 'bg-gray-100 dark:bg-[#3E3E3A] text-[#1b1b18] dark:text-[#EDEDEC]' : 'text-[#706f6c] dark:text-[#A1A09A] hover:bg-gray-100 dark:hover:bg-gray-900' }}">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" /></svg>
                            Keluarga
                        </span>
                    </a>
                    <a href="{{ route('peserta.data.index') }}"
                       class="px-4 py-2 rounded-md text-sm font-medium transition
                              {{ request()->routeIs('peserta.data.*') ? 'bg-gray-100 dark:bg-[#3E3E3A] text-[#1b1b18] dark:text-[#EDEDEC]' : 'text-[#706f6c] dark:text-[#A1A09A] hover:bg-gray-100 dark:hover:bg-gray-900' }}">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" /></svg>
                            Peserta
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    {{-- ── Flash Messages ──────────────────────────────────── --}}
    @if (session('success'))
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="rounded-md p-4 text-sm font-medium" style="background: var(--sipandu-success-light); color: var(--sipandu-success);">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                    {{ session('success') }}
                </div>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="rounded-md p-4 text-sm font-medium" style="background: var(--sipandu-danger-light); color: var(--sipandu-danger);">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" /></svg>
                    {{ session('error') }}
                </div>
            </div>
        </div>
    @endif

    {{-- ── Page Content ────────────────────────────────────── --}}
    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

</body>
>>>>>>> origin/main
</html>
