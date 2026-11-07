<!-- Sidebar Container (Relative / Normal Flex Item on Desktop, Off-canvas Drawer on Mobile) -->
<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'"
       class="fixed md:static inset-y-0 left-0 z-50 w-64 md:w-72 bg-white border-r border-gray-200 flex flex-col justify-between transition-transform duration-200 ease-in-out shrink-0 h-full">
    
    <!-- Top Section: Header & Menu Navigation -->
    <div class="flex flex-col flex-1 overflow-y-auto">
        
        <!-- Sidebar Header: Logo & Title -->
        <div class="p-5 border-b border-gray-100 flex items-center justify-between">
            <a href="{{ route('peserta.dashboard') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/sipandu-logo.png') }}" 
                     alt="Logo SiPANDU" 
                     class="h-10 w-auto object-contain">
                <div class="flex flex-col">
                    <span class="text-xl font-bold tracking-tight text-teal-800 leading-tight">
                        SiPANDU
                    </span>
                    <span class="text-xs text-gray-500 font-medium">
                        Keluarga & Peserta
                    </span>
                </div>
            </a>

            <!-- Close button: Visible ONLY on mobile screen (md:hidden) -->
            <button @click="sidebarOpen = false" 
                    type="button"
                    class="md:hidden text-gray-400 hover:text-gray-600 p-1.5 rounded-lg hover:bg-gray-100 focus:outline-none">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

<<<<<<< HEAD
        <!-- Section Title -->
        <div class="px-5 pt-5 pb-2">
            <p class="text-[11px] font-bold tracking-wider text-gray-400 uppercase mb-3 px-3">
                NAVIGASI UTAMA
            </p>
        </div>
=======
            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()?->name ?? 'Pengguna' }}</div>
>>>>>>> origin/main

        <!-- Navigation Menu Links (4 Menu Utama: Beranda, Anggota Keluarga, Rekam Medis, Edukasi) -->
        <nav class="flex-1 px-4 space-y-1.5">
            <!-- 1. Beranda -->
            <a href="{{ route('peserta.dashboard') }}"
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('peserta.dashboard') ? 'bg-teal-50 text-teal-700 font-semibold' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                <span class="{{ request()->routeIs('peserta.dashboard') ? 'text-teal-600' : 'text-gray-400' }}">
                    <!-- Home / Beranda Icon -->
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                </span>
                <span>Beranda</span>
            </a>

            <!-- 2. Anggota Keluarga -->
            <a href="{{ route('peserta.keluarga.index') }}"
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('peserta.keluarga.*') ? 'bg-teal-50 text-teal-700 font-semibold' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                <span class="{{ request()->routeIs('peserta.keluarga.*') ? 'text-teal-600' : 'text-gray-400' }}">
                    <!-- Users / Anggota Keluarga Icon -->
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                </span>
                <span>Anggota Keluarga</span>
            </a>

            <!-- 3. Rekam Medis (Grafik KMS, Tumbuh Kembang, Imunisasi) -->
            <a href="{{ route('peserta.data.index') }}"
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('peserta.data.*') ? 'bg-teal-50 text-teal-700 font-semibold' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                <span class="{{ request()->routeIs('peserta.data.*') ? 'text-teal-600' : 'text-gray-400' }}">
                    <!-- Document Chart / Medical Record Icon -->
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                    </svg>
                </span>
                <span>Rekam Medis</span>
            </a>

            <!-- 4. Edukasi (Artikel Stunting & Tips Kesehatan) -->
            @php
                $edukasiUrl = Route::has('peserta.edukasi.index') 
                    ? route('peserta.edukasi.index') 
                    : (Route::has('dinas.edukasi.index') ? route('dinas.edukasi.index') : url('/peserta/edukasi'));
                $isEdukasiActive = request()->routeIs('peserta.edukasi.*') || request()->is('*edukasi*');
            @endphp
            <a href="{{ $edukasiUrl }}"
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition-all {{ $isEdukasiActive ? 'bg-teal-50 text-teal-700 font-semibold' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                <span class="{{ $isEdukasiActive ? 'text-teal-600' : 'text-gray-400' }}">
                    <!-- Book Open / Academic / Education Icon -->
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                    </svg>
                </span>
                <span>Edukasi</span>
            </a>
        </nav>
    </div>

    <!-- Bottom Section: User Profile & Actions -->
    <div class="p-4 border-t border-gray-200 mt-auto bg-white">
        <!-- User Information -->
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-full bg-teal-50 text-teal-700 flex items-center justify-center font-bold text-sm shrink-0 border border-teal-200">
                {{ strtoupper(substr(Auth::user()->name ?? 'T', 0, 1)) }}
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-sm font-semibold text-gray-800 truncate leading-tight">
                    {{ Auth::user()->name ?? 'Tamu' }}
                </p>
                <p class="text-xs text-gray-500 truncate">
                    Peserta Posyandu
                </p>
            </div>
        </div>

        <!-- Action Buttons: Symmetric Grid -->
        <div class="grid grid-cols-2 gap-2 mt-3">
            @if (Route::has('profile.edit'))
                <a href="{{ route('profile.edit') }}" 
                   class="text-center px-3 py-2 text-xs font-medium text-gray-700 bg-gray-50 border border-gray-200 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition">
                    Profil
                </a>
            @else
                <button type="button" class="text-center px-3 py-2 text-xs font-medium text-gray-400 bg-gray-50 border border-gray-200 rounded-lg cursor-default">
                    Profil
                </button>
            @endif

            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <button type="submit" 
                        class="w-full flex items-center justify-center gap-1.5 px-3 py-2 text-xs font-medium text-rose-600 bg-rose-50 border border-rose-100 rounded-lg hover:bg-rose-100 hover:text-rose-700 transition">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                    </svg>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </div>
<<<<<<< HEAD
</aside>
=======

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">
                    {{ Auth::user()?->name ?? 'Pengguna' }}
                </div>
                
                <div class="font-medium text-sm text-gray-500">
                    {{ Auth::user()?->email ?? '' }}
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
>>>>>>> origin/main
