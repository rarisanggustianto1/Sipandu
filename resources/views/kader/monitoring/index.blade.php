<x-app-layout>
    @php
        $persentaseBaik = $ringkasan['jumlah_peserta'] > 0
            ? round($ringkasan['jumlah_baik'] / $ringkasan['jumlah_peserta'] * 100)
            : 0;
        $persentasePemantauan = $ringkasan['jumlah_peserta'] > 0
            ? round($ringkasan['jumlah_pemantauan'] / $ringkasan['jumlah_peserta'] * 100)
            : 0;
        $persentasePrioritas = max(0, 100 - $persentaseBaik - $persentasePemantauan);
        $urutanKategori = ['ibu_hamil' => 1, 'balita' => 2, 'lansia' => 3];
    @endphp

    <div class="mx-auto max-w-7xl space-y-6 px-4 py-8 sm:px-6 lg:px-8">
        <header class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <h1 class="text-2xl font-black tracking-tight text-slate-900">Monitoring &amp; Pemantauan</h1>
                <p class="mt-1 text-sm text-slate-500">Pantau kondisi peserta dan tentukan prioritas tindak lanjut Posyandu Anda.</p>
            </div>

            <nav aria-label="Pilih periode monitoring" class="inline-flex w-fit rounded-full bg-slate-200/70 p-1">
                @foreach (['minggu_ini' => 'Minggu Ini', 'bulan_ini' => 'Bulan Ini', '3_bulan' => '3 Bulan'] as $key => $label)
                    <a
                        href="{{ route('kader.monitoring.index', ['periode' => $key]) }}"
                        @if ($periode === $key) aria-current="page" @endif
                        class="rounded-full px-4 py-2 text-xs font-semibold transition {{ $periode === $key ? 'bg-teal-700 text-white shadow-sm' : 'text-slate-600 hover:bg-white hover:text-slate-900' }}"
                    >{{ $label }}</a>
                @endforeach
            </nav>
        </header>

        <section aria-labelledby="monitoring-summary-title" class="rounded-3xl border border-slate-100 bg-white p-5 shadow-sm sm:p-7">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div>
                    <h2 id="monitoring-summary-title" class="text-xs font-bold uppercase tracking-[0.12em] text-slate-400">Total Peserta Dipantau</h2>
                    <div class="mt-1 flex items-baseline gap-2">
                        <p class="text-3xl font-black tracking-tight text-slate-900">{{ $ringkasan['jumlah_peserta'] }}</p>
                        <span class="text-sm text-slate-400">Jiwa</span>
                    </div>
                    <p class="mt-1 text-xs text-slate-500">{{ $ringkasan['jumlah_diperiksa'] }} diperiksa pada periode {{ strtolower($namaPeriode) }}</p>
                </div>

                <span class="rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-bold text-emerald-700">
                    {{ $ringkasan['persentase_diperiksa'] }}% telah diperiksa
                </span>
            </div>

            <div
                class="mt-5 flex h-3 overflow-hidden rounded-full bg-slate-100"
                role="img"
                aria-label="Sebaran status: {{ $persentaseBaik }} persen kondisi baik, {{ $persentasePemantauan }} persen perlu pemantauan, {{ $persentasePrioritas }} persen prioritas"
            >
                <span class="bg-teal-600 transition-all" style="width: {{ $persentaseBaik }}%"></span>
                <span class="bg-amber-400 transition-all" style="width: {{ $persentasePemantauan }}%"></span>
                <span class="bg-rose-500 transition-all" style="width: {{ $persentasePrioritas }}%"></span>
            </div>

            <div class="mt-4 grid gap-2 sm:grid-cols-3">
                <div class="flex items-center justify-between gap-3 rounded-2xl bg-slate-50 px-4 py-3">
                    <span class="text-sm font-medium text-slate-600">Kondisi Baik</span>
                    <span class="text-sm font-extrabold text-slate-900">{{ $persentaseBaik }}%</span>
                </div>
                <div class="flex items-center justify-between gap-3 rounded-2xl bg-amber-50/70 px-4 py-3">
                    <span class="text-sm font-medium text-amber-800">Perlu Pemantauan</span>
                    <span class="text-sm font-extrabold text-amber-900">{{ $persentasePemantauan }}%</span>
                </div>
                <div class="flex items-center justify-between gap-3 rounded-2xl bg-rose-50/70 px-4 py-3">
                    <span class="text-sm font-medium text-rose-800">Prioritas / Intervensi</span>
                    <span class="text-sm font-extrabold text-rose-900">{{ $persentasePrioritas }}%</span>
                </div>
            </div>
        </section>

        <section class="space-y-3">
            <div>
                <h2 class="text-base font-bold text-slate-800">Kategori Monitoring <span class="font-normal text-slate-500">(Pilih untuk melihat detail)</span></h2>
            </div>

            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($kategori->sortBy(fn (array $item): int => $urutanKategori[$item['key']]) as $item)
                    @php
                        $satuan = $item['key'] === 'balita' ? 'Anak' : 'Orang';
                        $urlDetail = route('kader.monitoring.show', ['kategori' => $item['key'], 'periode' => $periode]);
                    @endphp
                    <a href="{{ $urlDetail }}" class="group rounded-3xl border border-slate-100 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-teal-200 hover:shadow-md">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <h3 class="font-bold text-slate-800">{{ $item['label'] }}</h3>
                                <p class="mt-1 text-xs text-slate-400">Total {{ $item['jumlah_peserta'] }} {{ $satuan }}</p>
                            </div>
                            <span class="text-xs font-semibold text-teal-700 group-hover:underline">Lihat detail</span>
                        </div>

                        <div class="my-4 border-t border-slate-100"></div>

                        <div class="grid grid-cols-3 gap-2">
                            <div class="rounded-2xl border border-teal-100 bg-teal-50/60 px-2 py-3 text-center">
                                <p class="text-[11px] font-medium text-teal-800">Baik</p>
                                <p class="mt-1 text-lg font-extrabold leading-none text-teal-900">{{ $item['jumlah_baik'] }}</p>
                            </div>
                            <div class="rounded-2xl border border-amber-100 bg-amber-50/60 px-2 py-3 text-center">
                                <p class="text-[11px] font-medium text-amber-800">Dipantau</p>
                                <p class="mt-1 text-lg font-extrabold leading-none text-amber-900">{{ $item['jumlah_pemantauan'] }}</p>
                            </div>
                            <div class="rounded-2xl border border-rose-100 bg-rose-50/60 px-2 py-3 text-center">
                                <p class="text-[11px] font-medium text-rose-800">Prioritas</p>
                                <p class="mt-1 text-lg font-extrabold leading-none text-rose-900">{{ $item['jumlah_prioritas'] }}</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>

        <p class="text-xs leading-relaxed text-slate-500">
            Status pemantauan dibuat dari pemeriksaan yang tercatat dan indikator yang perlu ditinjau. Status ini bukan diagnosis medis.
        </p>
    </div>
</x-app-layout>
