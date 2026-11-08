<x-app-layout>
    <div class="mx-auto max-w-7xl space-y-6 px-4 py-8 sm:px-6 lg:px-8">
        <a href="{{ route('kader.monitoring.index', ['periode' => $periode]) }}" class="inline-flex items-center gap-2 text-sm font-bold text-teal-800 hover:text-teal-950">
            Kembali ke ringkasan monitoring
        </a>

        <header class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-bold uppercase tracking-wide text-teal-700">Monitoring kategori</p>
            <h1 class="mt-1 text-2xl font-black text-slate-900">Perkembangan {{ $labelKategori }}</h1>
            <p class="mt-2 text-sm text-slate-500">Grafik menunjukkan rata-rata hasil pemeriksaan per pertemuan atau tanggal pemeriksaan dalam periode {{ strtolower($namaPeriode) }}.</p>
            <div class="mt-5 grid gap-3 sm:grid-cols-3">
                <div class="rounded-xl bg-slate-50 p-4">
                    <p class="text-xs font-semibold text-slate-500">Peserta terdaftar</p>
                    <p class="mt-1 text-2xl font-black text-slate-900">{{ $jumlahPeserta }}</p>
                </div>
                <div class="rounded-xl bg-slate-50 p-4">
                    <p class="text-xs font-semibold text-slate-500">Pernah diperiksa</p>
                    <p class="mt-1 text-2xl font-black text-slate-900">{{ $jumlahDiperiksa }}</p>
                </div>
                <div class="rounded-xl bg-slate-50 p-4">
                    <p class="text-xs font-semibold text-slate-500">Pertemuan / periode tercatat</p>
                    <p class="mt-1 text-2xl font-black text-slate-900">{{ $jumlahPertemuan }}</p>
                </div>
            </div>
        </header>

        <nav aria-label="Pilih periode monitoring" class="inline-flex rounded-full bg-slate-200/70 p-1">
            @foreach (['minggu_ini' => 'Minggu Ini', 'bulan_ini' => 'Bulan Ini', '3_bulan' => '3 Bulan'] as $key => $label)
                <a
                    href="{{ route('kader.monitoring.show', ['kategori' => $kategori, 'periode' => $key]) }}"
                    @if ($periode === $key) aria-current="page" @endif
                    class="rounded-full px-4 py-2 text-xs font-semibold transition {{ $periode === $key ? 'bg-teal-700 text-white shadow-sm' : 'text-slate-600 hover:bg-white hover:text-slate-900' }}"
                >{{ $label }}</a>
            @endforeach
        </nav>

        <section class="space-y-4">
            <div>
                <h2 class="text-lg font-extrabold text-slate-900">Grafik perkembangan antarpertemuan</h2>
                <p class="mt-1 text-sm text-slate-500">Setiap titik adalah rata-rata peserta yang memiliki nilai pada pertemuan tersebut.</p>
            </div>

            @if ($points->isEmpty())
                <p class="rounded-2xl border border-dashed border-slate-300 bg-white p-8 text-center text-sm text-slate-500">Belum ada data pemeriksaan untuk kategori ini.</p>
            @else
                <div class="grid gap-4 lg:grid-cols-2">
                    @foreach ($grafik as $metric => $definisi)
                        <x-monitoring-chart
                            :title="$definisi['label']"
                            :unit="$definisi['unit']"
                            :metric="$metric"
                            :points="$points"
                        />
                    @endforeach
                </div>

                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
                    <div class="border-b border-slate-100 px-5 py-4">
                        <h3 class="font-bold text-slate-900">Ringkasan setiap pertemuan</h3>
                    </div>
                    <div class="divide-y divide-slate-100">
                        @foreach ($points as $point)
                            <div class="flex flex-wrap items-center justify-between gap-2 px-5 py-3 text-sm">
                                <div>
                                    <p class="font-semibold text-slate-800">{{ $point['label'] }}</p>
                                    <p class="text-xs text-slate-500">{{ $point['tanggal'] }}</p>
                                </div>
                                <span class="rounded-full bg-teal-50 px-3 py-1 text-xs font-bold text-teal-800">{{ $point['jumlah_peserta'] }} peserta diperiksa</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </section>

        <section class="overflow-hidden rounded-2xl border border-amber-200 bg-white shadow-sm">
            <div class="border-b border-amber-100 bg-amber-50 px-5 py-4">
                <h2 class="text-lg font-extrabold text-amber-950">Peserta yang perlu ditinjau</h2>
                <p class="mt-1 text-sm text-amber-900">Gunakan daftar ini sebagai pengingat untuk meninjau catatan dan menentukan tindak lanjut bersama tenaga kesehatan.</p>
            </div>

            @forelse ($prioritas as $item)
                <article class="flex flex-col gap-3 border-b border-slate-100 px-5 py-4 last:border-b-0 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="font-bold text-slate-900">{{ $item['peserta']->nama }}</h3>
                        <p class="mt-1 text-xs text-slate-500">Pemeriksaan terakhir · {{ $item['tanggal'] }}</p>
                        <ul class="mt-2 space-y-1 text-sm text-amber-800">
                            @foreach ($item['alasan'] as $alasan)
                                <li>• {{ $alasan }}</li>
                            @endforeach
                        </ul>
                        @if ($item['keluhan'] || $item['catatan'])
                            <p class="mt-2 text-sm text-slate-600">
                                @if ($item['keluhan'])
                                    Keluhan: {{ $item['keluhan'] }}
                                @endif
                                @if ($item['catatan'])
                                    {{ $item['keluhan'] ? ' · ' : '' }}Catatan: {{ $item['catatan'] }}
                                @endif
                            </p>
                        @endif
                    </div>
                    <a href="{{ route('kader.peserta.show', $item['peserta']) }}" class="shrink-0 rounded-xl bg-slate-100 px-4 py-2 text-center text-xs font-bold text-slate-700 hover:bg-slate-200">Buka KIA peserta</a>
                </article>
            @empty
                <p class="px-5 py-8 text-center text-sm text-slate-500">Belum ada indikator prioritas dari catatan pemeriksaan yang tersedia.</p>
            @endforelse
        </section>

        <aside class="rounded-2xl border border-sky-100 bg-sky-50 p-4 text-sm text-sky-900">
            Pemantauan berat badan menurun dibanding pemeriksaan sebelumnya. Untuk ibu hamil dan lansia, tekanan darah 140/90 mmHg atau lebih ditandai agar ditinjau tenaga kesehatan. Penanda ini hanya skrining sederhana dan bukan diagnosis.
        </aside>
    </div>
</x-app-layout>
