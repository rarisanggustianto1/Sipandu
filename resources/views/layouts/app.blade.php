<!DOCTYPE html>
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
</html>
