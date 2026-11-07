@php
    /*
    | Sidebar Puskesmas dengan struktur folder.
    |
    | Setiap kelompok = satu folder yang bisa dibuka / ditutup.
    | Folder yang memuat halaman aktif otomatis terbuka.
    |
    | Status menu:
    |   ready -> route tersedia, bisa diklik
    |   soon  -> tabel ada di migration, modul controller belum dibuat
    */
    $singleItems = [
        [
            'label' => 'Dashboard',
            'icon' => 'grid',
            'status' => 'ready',
            'match' => 'puskesmas.dashboard',
            'url' => route('puskesmas.dashboard'),
            'accent' => 'text-teal-600',
        ],
    ];

    $menuGroups = [
        [
            'key' => 'master-data',
            'heading' => 'Master Data',
            'items' => [
                [
                    'label' => 'Data Posyandu',
                    'icon' => 'building',
                    'status' => 'ready',
                    'match' => 'puskesmas.posyandu.*',
                    'url' => route('puskesmas.posyandu.index'),
                    'accent' => 'text-emerald-600',
                ],
                [
                    'label' => 'Data Keluarga & Peserta',
                    'icon' => 'users',
                    'status' => 'soon',
                    'accent' => 'text-gray-400',
                ],
                [
                    'label' => 'Kelola Akun Kader',
                    'icon' => 'key',
                    'status' => 'ready',
                    'match' => 'puskesmas.kader.*',
                    'url' => route('puskesmas.kader.create'),
                    'accent' => 'text-blue-600',
                ],
            ],
        ],
        [
            'key' => 'pelayanan-agenda',
            'heading' => 'Pelayanan & Agenda',
            'items' => [
                [
                    'label' => 'Kegiatan & Sasaran',
                    'icon' => 'calendar',
                    'status' => 'soon',
                    'accent' => 'text-gray-400',
                ],
                [
                    'label' => 'Monitor Kegiatan',
                    'icon' => 'clipboard',
                    'status' => 'soon',
                    'accent' => 'text-gray-400',
                ],
                [
                    'label' => 'Pengaduan & Tanggapan',
                    'icon' => 'chat',
                    'status' => 'ready',
                    'match' => 'puskesmas.pengaduan.*',
                    'url' => route('puskesmas.pengaduan.index'),
                    'accent' => 'text-rose-600',
                ],
            ],
        ],
        [
            'key' => 'intervensi-rujukan',
            'heading' => 'Intervensi & Rujukan',
            'items' => [
                [
                    'label' => 'Tindak Lanjut (Rujukan Kader)',
                    'icon' => 'alert',
                    'status' => 'soon',
                    'accent' => 'text-gray-400',
                ],
            ],
        ],
        [
            'key' => 'rekap-analitik',
            'heading' => 'Rekap & Analitik',
            'items' => [
                [
                    'label' => 'Riwayat Pemeriksaan',
                    'icon' => 'clipboard',
                    'status' => 'soon',
                    'accent' => 'text-gray-400',
                ],
                [
                    'label' => 'Monitoring Perkembangan',
                    'icon' => 'chart',
                    'status' => 'soon',
                    'accent' => 'text-gray-400',
                ],
            ],
        ],
    ];

    // Helper: apakah kelompok ini memuat halaman yang sedang aktif?
    $groupIsOpen = function (array $group): bool {
        foreach ($group['items'] as $item) {
            if (($item['status'] ?? null) === 'ready' && request()->routeIs($item['match'])) {
                return true;
            }
        }

        return false;
    };
@endphp

<aside id="sidebar"
       class="fixed inset-y-0 left-0 z-40 flex w-72 -translate-x-full flex-col border-r border-gray-200 bg-white transition-transform lg:static lg:translate-x-0">

    <div class="flex h-16 shrink-0 items-center gap-3 border-b border-gray-200 bg-teal-500 px-5">
        <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-white/20 text-white">
            <x-puskesmas.icon name="grid" class="h-5 w-5" />
        </span>
        <div class="min-w-0">
            <p class="truncate text-sm font-bold text-white">SIPANDU</p>
            <p class="truncate text-xs text-teal-50">Puskesmas Admin</p>
        </div>
        <button type="button" data-sidebar-close
                class="ml-auto rounded-md p-1 text-teal-50 transition-colors hover:bg-white/20 lg:hidden"
                aria-label="Tutup menu">
            <x-puskesmas.icon name="x" class="h-5 w-5" />
        </button>
    </div>

    <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-4">

        {{-- Menu tunggal (tidak di dalam folder) --}}
        <ul class="space-y-1">
            @foreach ($singleItems as $item)
                @php $isActive = request()->routeIs($item['match']); @endphp
                <li>
                    <a href="{{ $item['url'] }}"
                       @if ($isActive) aria-current="page" @endif
                       class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors {{ $isActive ? 'bg-teal-50 text-teal-700 ring-1 ring-inset ring-teal-200' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
                        <span class="{{ $isActive ? 'text-teal-600' : $item['accent'] }}">
                            <x-puskesmas.icon :name="$item['icon']" />
                        </span>
                        <span class="flex-1 truncate">{{ $item['label'] }}</span>
                        @if ($isActive)
                            <span class="h-1.5 w-1.5 shrink-0 rounded-full bg-teal-500"></span>
                        @endif
                    </a>
                </li>
            @endforeach
        </ul>

        <div class="my-3 border-t border-gray-100"></div>

        {{-- Folder / kelompok menu --}}
        @foreach ($menuGroups as $group)
            @php $openByDefault = $groupIsOpen($group); @endphp

            <details class="group/folder mt-1" data-nav-group="{{ $group['key'] }}"
                     @if ($openByDefault) open @endif>

                <summary class="flex cursor-pointer select-none items-center gap-2.5 rounded-lg px-3 py-2.5 text-xs font-semibold uppercase tracking-wider text-gray-500 transition-colors hover:bg-gray-50 hover:text-gray-700">
                    <span class="text-gray-400 transition-transform duration-200 group-open/folder:rotate-90">
                        <x-puskesmas.icon name="chevron" class="h-4 w-4" />
                    </span>
                    <span class="flex-1 truncate">{{ $group['heading'] }}</span>

                    @php $readyCount = collect($group['items'])->where('status', 'ready')->count(); @endphp
                    @if ($readyCount > 0)
                        <span class="rounded-full bg-teal-100 px-1.5 py-0.5 text-[10px] font-bold text-teal-700">
                            {{ $readyCount }}
                        </span>
                    @endif
                </summary>

                <ul class="mt-1 space-y-1 border-l-2 border-gray-100 pl-3">
                    @foreach ($group['items'] as $item)
                        @php
                            $isReady = $item['status'] === 'ready';
                            $isActive = $isReady && request()->routeIs($item['match']);
                        @endphp

                        <li>
                            @if ($isReady)
                                <a href="{{ $item['url'] }}"
                                   @if ($isActive) aria-current="page" @endif
                                   class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition-colors {{ $isActive ? 'bg-teal-50 text-teal-700 ring-1 ring-inset ring-teal-200' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                                    <span class="{{ $isActive ? 'text-teal-600' : $item['accent'] }}">
                                        <x-puskesmas.icon :name="$item['icon']" class="h-4 w-4" />
                                    </span>
                                    <span class="flex-1 truncate">{{ $item['label'] }}</span>
                                    @if ($isActive)
                                        <span class="h-1.5 w-1.5 shrink-0 rounded-full bg-teal-500"></span>
                                    @endif
                                </a>
                            @else
                                <span class="flex cursor-not-allowed items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-gray-400"
                                      title="Modul belum tersedia">
                                    <span class="{{ $item['accent'] }}">
                                        <x-puskesmas.icon :name="$item['icon']" class="h-4 w-4" />
                                    </span>
                                    <span class="flex-1 truncate">{{ $item['label'] }}</span>
                                    <span class="shrink-0 rounded bg-gray-100 px-1.5 py-0.5 text-[10px] font-semibold uppercase tracking-wide text-gray-400">Segera</span>
                                </span>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </details>
        @endforeach
    </nav>

    <div class="shrink-0 border-t border-gray-200 p-3">
        <div class="rounded-lg bg-gray-50 px-3 py-2.5">
            <p class="truncate text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</p>
            <p class="truncate text-xs text-gray-500">{{ auth()->user()->email }}</p>
        </div>
    </div>
</aside>