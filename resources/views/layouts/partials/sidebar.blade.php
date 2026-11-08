@php
    $role = auth()->user()->role;

    if (in_array($role, ['kader', 'kader_posyandu'], true)) {
        $roleLabel = 'Kader Posyandu';
        $navigation = [
            ['label' => 'Dashboard', 'route' => 'kader.dashboard', 'match' => 'kader.dashboard'],
            ['label' => 'Pemeriksaan', 'route' => 'kader.pemeriksaan.index', 'match' => 'kader.pemeriksaan.*'],
            ['label' => 'Peserta', 'route' => 'kader.peserta.index', 'match' => 'kader.peserta.*'],
            ['label' => 'Monitoring', 'route' => 'kader.monitoring.index', 'match' => 'kader.monitoring.*'],
            ['label' => 'Jadwal', 'route' => 'kader.jadwal.index', 'match' => 'kader.jadwal.*'],
            ['label' => 'Imunisasi', 'route' => 'kader.imunisasi.index', 'match' => 'kader.imunisasi.*'],
        ];
    } elseif (in_array($role, ['keluarga', 'peserta'], true)) {
        $roleLabel = 'Keluarga / Peserta';
        $navigation = [
            ['label' => 'Dashboard', 'route' => 'peserta.dashboard', 'match' => 'peserta.dashboard'],
            ['label' => 'Rekam Medis (KMS)', 'route' => 'peserta.data.index', 'match' => 'peserta.data.*'],
            ['label' => 'Anggota Keluarga', 'route' => 'peserta.keluarga.index', 'match' => 'peserta.keluarga.*'],
            ['label' => 'Edukasi Kesehatan', 'route' => 'peserta.edukasi.index', 'match' => 'peserta.edukasi.*'],
        ];
    } elseif (in_array($role, ['dinas_kesehatan', 'dinas'], true)) {
        $roleLabel = 'Dinas Kesehatan';
        $navigation = [
            ['label' => 'Dashboard', 'route' => 'dinas.dashboard', 'match' => 'dinas.dashboard'],
            ['label' => 'Puskesmas', 'route' => 'dinas.puskesmas.index', 'match' => 'dinas.puskesmas.*'],
            ['label' => 'Edukasi', 'route' => 'dinas.edukasi.index', 'match' => 'dinas.edukasi.*'],
            ['label' => 'Laporan Wilayah', 'route' => 'dinas.laporan.index', 'match' => 'dinas.laporan.*'],
        ];
    } else {
        $roleLabel = 'Puskesmas';
        $navigation = [
            ['label' => 'Dashboard', 'route' => 'puskesmas.dashboard', 'match' => 'puskesmas.dashboard'],
            ['label' => 'Data Posyandu', 'route' => 'puskesmas.posyandu.index', 'match' => 'puskesmas.posyandu.*'],
            ['label' => 'Data Peserta & KIA', 'route' => 'puskesmas.peserta.index', 'match' => 'puskesmas.peserta.*'],
            ['label' => 'Kelola Akun Kader', 'route' => 'puskesmas.kader.index', 'match' => 'puskesmas.kader.*'],
            ['label' => 'Kelola Kegiatan', 'route' => 'puskesmas.kegiatan.index', 'match' => 'puskesmas.kegiatan.*'],
            ['label' => 'Kelola Imunisasi', 'route' => 'puskesmas.imunisasi.index', 'match' => 'puskesmas.imunisasi.*'],
            ['label' => 'Tindak Lanjut Peserta', 'route' => 'puskesmas.tindak-lanjut.index', 'match' => 'puskesmas.tindak-lanjut.*'],
            ['label' => 'Monitoring Perkembangan', 'route' => 'puskesmas.monitoring.index', 'match' => 'puskesmas.monitoring.*'],
            ['label' => 'Pengaduan & Tanggapan', 'route' => 'puskesmas.pengaduan.index', 'match' => 'puskesmas.pengaduan.*'],
        ];
    }
@endphp

<aside id="sidebar"
       class="fixed inset-y-0 left-0 z-40 flex w-72 -translate-x-full flex-col border-r border-gray-200 bg-white transition-transform lg:static lg:translate-x-0">
    <div class="flex h-16 shrink-0 items-center border-b border-gray-200 bg-teal-500 px-5">
        <x-sipandu-brand :subtitle="$roleLabel" :light="true" />
        <button type="button"
                data-sidebar-close
                class="ml-auto rounded-md p-1 text-teal-50 transition-colors hover:bg-white/20 lg:hidden"
                aria-label="Tutup menu navigasi">
            <x-puskesmas.icon name="x" class="h-5 w-5" />
        </button>
    </div>

    <nav aria-label="Navigasi utama SIPANDU" class="flex-1 space-y-1 overflow-y-auto px-3 py-4">
        @foreach ($navigation as $item)
            @php($isActive = request()->routeIs($item['match']))
            <a href="{{ route($item['route']) }}"
               @if ($isActive) aria-current="page" @endif
               class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors {{ $isActive ? 'bg-teal-50 text-teal-700 ring-1 ring-inset ring-teal-200' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
                <span class="flex-1 truncate">{{ $item['label'] }}</span>
                @if ($isActive)
                    <span class="h-1.5 w-1.5 shrink-0 rounded-full bg-teal-500"></span>
                @endif
            </a>
        @endforeach
    </nav>

    <div class="shrink-0 space-y-2 border-t border-gray-200 p-3">
        <a href="{{ route('profile') }}"
           class="block rounded-lg bg-gray-50 px-3 py-2.5 transition-colors hover:bg-gray-100">
            <span class="flex items-center gap-2">
                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-teal-100 text-sm font-bold text-teal-800">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </span>
                <span class="min-w-0">
                    <span class="block truncate text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</span>
                    <span class="block text-xs text-gray-500">Akun {{ $roleLabel }}</span>
                </span>
            </span>
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="flex w-full items-center gap-2 rounded-lg px-3 py-2 text-sm font-semibold text-rose-600 transition-colors hover:bg-rose-50">
                <x-puskesmas.icon name="logout" class="h-4 w-4" />
                <span>Keluar</span>
            </button>
        </form>
    </div>
</aside>
