@php
    $role = auth()->user()->role;

    if (in_array($role, ['kader', 'kader_posyandu'], true)) {
        $roleLabel = 'Kader Posyandu';
        $navigation = [
            ['label' => 'Dashboard', 'icon' => 'grid', 'route' => 'kader.dashboard', 'match' => 'kader.dashboard'],
            ['label' => 'Jadwal', 'icon' => 'calendar', 'route' => 'kader.jadwal.index', 'match' => 'kader.jadwal.*'],
            ['label' => 'Peserta', 'icon' => 'users', 'route' => 'kader.peserta.index', 'match' => 'kader.peserta.*'],
            ['label' => 'Pemeriksaan', 'icon' => 'clipboard', 'route' => 'kader.pemeriksaan.index', 'match' => 'kader.pemeriksaan.*'],
            ['label' => 'Imunisasi', 'icon' => 'clipboard', 'route' => 'kader.imunisasi.index', 'match' => 'kader.imunisasi.*'],
            ['label' => 'Monitoring', 'icon' => 'chart', 'route' => 'kader.monitoring.index', 'match' => 'kader.monitoring.*'],
        ];
    } elseif (in_array($role, ['keluarga', 'peserta'], true)) {
        $roleLabel = 'Keluarga / Peserta';
        $navigation = [
            ['label' => 'Dashboard', 'icon' => 'grid', 'route' => 'peserta.dashboard', 'match' => 'peserta.dashboard'],
            ['label' => 'Jadwal Posyandu', 'icon' => 'calendar', 'route' => 'peserta.jadwal.index', 'match' => 'peserta.jadwal.*'],
            ['label' => 'Rekam Medis (KMS)', 'icon' => 'clipboard', 'route' => 'peserta.data.index', 'match' => 'peserta.data.*'],
            ['label' => 'Anggota Keluarga', 'icon' => 'users', 'route' => 'peserta.keluarga.index', 'match' => 'peserta.keluarga.*'],
            ['label' => 'Edukasi Kesehatan', 'icon' => 'book', 'route' => 'peserta.edukasi.index', 'match' => 'peserta.edukasi.*'],
        ];
    } elseif (in_array($role, ['dinas_kesehatan', 'dinas'], true)) {
        $roleLabel = 'Dinas Kesehatan';
        $navigation = [
            ['label' => 'Dashboard', 'icon' => 'grid', 'route' => 'dinas.dashboard', 'match' => 'dinas.dashboard'],
            ['label' => 'Puskesmas', 'icon' => 'building', 'route' => 'dinas.puskesmas.index', 'match' => 'dinas.puskesmas.*'],
            ['label' => 'Edukasi', 'icon' => 'book', 'route' => 'dinas.edukasi.index', 'match' => 'dinas.edukasi.*'],
            ['label' => 'Laporan Wilayah', 'icon' => 'chart', 'route' => 'dinas.laporan.index', 'match' => 'dinas.laporan.*'],
        ];
    } else {
        $roleLabel = 'Puskesmas';
        $navigation = [
            ['label' => 'Dashboard', 'icon' => 'grid', 'route' => 'puskesmas.dashboard', 'match' => 'puskesmas.dashboard'],
            ['label' => 'Data Posyandu', 'icon' => 'building', 'route' => 'puskesmas.posyandu.index', 'match' => 'puskesmas.posyandu.*'],
            ['label' => 'Data Peserta & KIA', 'icon' => 'users', 'route' => 'puskesmas.peserta.index', 'match' => 'puskesmas.peserta.*'],
            ['label' => 'Kelola Akun Kader', 'icon' => 'key', 'route' => 'puskesmas.kader.index', 'match' => 'puskesmas.kader.*'],
            ['label' => 'Kelola Kegiatan', 'icon' => 'calendar', 'route' => 'puskesmas.kegiatan.index', 'match' => 'puskesmas.kegiatan.*'],
            ['label' => 'Kelola Imunisasi', 'icon' => 'clipboard', 'route' => 'puskesmas.imunisasi.index', 'match' => 'puskesmas.imunisasi.*'],
            ['label' => 'Laporan Bulanan ke Dinas', 'icon' => 'chart', 'route' => 'puskesmas.laporan-bulanan.index', 'match' => 'puskesmas.laporan-bulanan.*'],
            ['label' => 'Monitoring Perkembangan', 'icon' => 'chart', 'route' => 'puskesmas.monitoring.index', 'match' => 'puskesmas.monitoring.*'],
        ];
    }

@endphp

<aside id="sidebar"
       class="fixed inset-y-0 left-0 z-40 flex h-dvh w-72 -translate-x-full flex-col border-r border-gray-200 bg-white transition-transform lg:static lg:h-dvh lg:shrink-0 lg:translate-x-0">
    <div class="flex h-16 shrink-0 items-center border-b border-gray-200 bg-teal-500 px-5">
        <x-sipandu-brand :subtitle="$roleLabel" :light="true" />
        <button type="button"
                data-sidebar-close
                class="ml-auto rounded-md p-1 text-teal-50 transition-colors hover:bg-white/20 lg:hidden"
                aria-label="Tutup menu navigasi">
            <x-puskesmas.icon name="x" class="h-5 w-5" />
        </button>
    </div>

    <nav aria-label="Navigasi utama SIPANDU" class="min-h-0 flex-1 space-y-1 overflow-y-auto overscroll-contain px-3 py-4">
        @foreach ($navigation as $item)
            @php($isActive = request()->routeIs($item['match']))
            <a href="{{ route($item['route']) }}"
               @if ($isActive) aria-current="page" @endif
               class="group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors {{ $isActive ? 'bg-teal-50 text-teal-700 ring-1 ring-inset ring-teal-200' : 'text-slate-600 hover:bg-teal-50 hover:text-teal-800' }}">
                <x-puskesmas.icon :name="$item['icon']" class="h-5 w-5 shrink-0 {{ $isActive ? 'text-teal-700' : 'text-slate-400 transition-colors group-hover:text-teal-700' }}" />
                <span class="flex-1 truncate">{{ $item['label'] }}</span>
                @if ($isActive)
                    <span class="h-1.5 w-1.5 shrink-0 rounded-full bg-teal-500"></span>
                @endif
            </a>
        @endforeach
    </nav>

    <div class="shrink-0 space-y-2 border-t border-gray-200 p-3">
        <a href="{{ route('profile') }}"
           class="group block rounded-xl border border-transparent bg-slate-50 px-3 py-2.5 transition-colors hover:border-teal-100 hover:bg-teal-50"
           aria-label="Buka profil akun {{ auth()->user()->name }}">
            <span class="flex items-center gap-2">
                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-teal-100 text-sm font-bold text-teal-800">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </span>
                <span class="min-w-0">
                    <span class="block truncate text-sm font-semibold text-slate-800 group-hover:text-teal-800">{{ auth()->user()->name }}</span>
                    <span class="block text-xs text-slate-500">Profil akun · {{ $roleLabel }}</span>
                </span>
                <x-puskesmas.icon name="chevron" class="ml-auto h-4 w-4 shrink-0 text-slate-400 transition-colors group-hover:text-teal-700" />
            </span>
        </a>
        <form method="POST" action="{{ route('logout') }}" onsubmit="return confirm('Yakin ingin keluar dari akun?')">
            @csrf
            <button type="submit"
                    class="flex w-full items-center gap-2 rounded-lg px-3 py-2 text-sm font-semibold text-rose-600 transition-colors hover:bg-rose-50">
                <x-puskesmas.icon name="logout" class="h-4 w-4" />
                <span>Keluar</span>
            </button>
        </form>
    </div>
</aside>
