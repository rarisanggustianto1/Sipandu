@props([
    'peserta',
    'riwayat',
    'backUrl',
    'backLabel',
    'recordUrl' => null,
])

@php
    $riwayat = collect($riwayat);
    $pemeriksaanTerbaru = $riwayat->first();
    $detailTerbaru = match ($peserta->kategori) {
        'balita' => $pemeriksaanTerbaru?->balita,
        'ibu_hamil' => $pemeriksaanTerbaru?->bumil,
        'lansia' => $pemeriksaanTerbaru?->lansia,
        default => null,
    };

    $titikGrafik = $riwayat
        ->reverse()
        ->values()
        ->map(function ($pemeriksaan) use ($peserta): ?array {
            $detail = match ($peserta->kategori) {
                'balita' => $pemeriksaan->balita,
                'ibu_hamil' => $pemeriksaan->bumil,
                'lansia' => $pemeriksaan->lansia,
                default => null,
            };
            $beratBadan = $detail?->berat_badan;

            if ($beratBadan === null) {
                return null;
            }

            return [
                'tanggal' => $pemeriksaan->tanggal_pemeriksaan,
                'berat_badan' => (float) $beratBadan,
            ];
        })
        ->filter()
        ->values();

    $beratMinimum = $titikGrafik->min('berat_badan');
    $beratMaksimum = $titikGrafik->max('berat_badan');
    $rentangBerat = max(1, ($beratMaksimum ?? 0) - ($beratMinimum ?? 0));
    $koordinatGrafik = $titikGrafik->map(function (array $titik, int $indeks) use ($titikGrafik, $beratMinimum, $rentangBerat): array {
        $x = $titikGrafik->count() === 1
            ? 360
            : 48 + ($indeks * 624 / ($titikGrafik->count() - 1));
        $y = 190 - (($titik['berat_badan'] - $beratMinimum) / $rentangBerat * 140);

        return [
            ...$titik,
            'x' => round($x, 2),
            'y' => round($y, 2),
        ];
    });
    $titikGarisGrafik = $koordinatGrafik
        ->map(fn (array $titik): string => $titik['x'].','.$titik['y'])
        ->implode(' ');
    $kategoriWarna = match ($peserta->kategori) {
        'balita' => 'from-teal-700 to-emerald-600',
        'ibu_hamil' => 'from-rose-700 to-orange-500',
        'lansia' => 'from-indigo-700 to-violet-600',
        default => 'from-teal-700 to-emerald-600',
    };
    $kategoriLatar = match ($peserta->kategori) {
        'balita' => 'bg-teal-50 text-teal-800 ring-teal-200',
        'ibu_hamil' => 'bg-rose-50 text-rose-800 ring-rose-200',
        'lansia' => 'bg-indigo-50 text-indigo-800 ring-indigo-200',
        default => 'bg-teal-50 text-teal-800 ring-teal-200',
    };
@endphp

<div class="mx-auto max-w-6xl space-y-6 px-4 py-6 sm:px-6 sm:py-8 lg:px-8">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <a href="{{ $backUrl }}" class="inline-flex items-center gap-2 text-sm font-semibold text-teal-800 transition hover:text-teal-950">
            <span aria-hidden="true">←</span> {{ $backLabel }}
        </a>
        @if ($recordUrl)
            <a href="{{ $recordUrl }}" class="inline-flex items-center justify-center rounded-xl bg-teal-700 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-teal-800 focus:outline-none focus:ring-2 focus:ring-teal-600 focus:ring-offset-2">
                + Catat pemeriksaan
            </a>
        @endif
    </div>

    <article class="relative isolate overflow-hidden rounded-3xl bg-gradient-to-br {{ $kategoriWarna }} p-5 text-white shadow-lg sm:p-8">
        <div class="pointer-events-none absolute -right-14 -top-20 h-64 w-64 rounded-full border-[32px] border-white/10"></div>
        <div class="pointer-events-none absolute -bottom-28 right-1/4 h-64 w-64 rounded-full bg-white/5"></div>

        <div class="relative flex flex-col gap-6 sm:flex-row sm:items-start sm:justify-between">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/sipandu-logo.png') }}" alt="Logo SIPANDU" class="h-14 w-14 rounded-2xl bg-white object-contain p-1 shadow-sm">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-white/75">Buku pemantauan kesehatan</p>
                    <h1 class="mt-1 text-2xl font-black tracking-wide sm:text-3xl">Kartu Kesehatan</h1>
                    <p class="mt-1 text-sm font-medium text-white/85">SIPANDU · Sahabat sehat keluarga</p>
                </div>
            </div>
            <div class="rounded-2xl border border-white/20 bg-white/10 px-4 py-3 backdrop-blur-sm sm:min-w-48">
                <p class="text-xs font-semibold uppercase tracking-wide text-white/70">Pemantauan oleh</p>
                <p class="mt-1 font-bold">{{ $peserta->keluarga->posyandu->nama_posyandu }}</p>
                <p class="mt-1 text-xs text-white/75">Diperbarui
                    {{ $pemeriksaanTerbaru?->tanggal_pemeriksaan?->format('d M Y') ?? 'belum ada pemeriksaan' }}
                </p>
            </div>
        </div>

        <div class="relative mt-7 grid gap-5 border-t border-white/20 pt-6 sm:grid-cols-[1fr_auto] sm:items-end">
            <div>
                <div class="flex flex-wrap items-center gap-2">
                    <h2 class="text-2xl font-extrabold sm:text-3xl">{{ $peserta->nama }}</h2>
                    <span class="rounded-full bg-white/15 px-3 py-1 text-xs font-bold ring-1 ring-inset ring-white/25">{{ $peserta->label_kategori }}</span>
                </div>
                <dl class="mt-4 grid grid-cols-2 gap-x-6 gap-y-3 text-sm sm:max-w-2xl sm:grid-cols-4">
                    <div><dt class="text-xs text-white/70">NIK</dt><dd class="mt-0.5 font-semibold">{{ $peserta->nik }}</dd></div>
                    <div><dt class="text-xs text-white/70">Tanggal lahir</dt><dd class="mt-0.5 font-semibold">{{ $peserta->tanggal_lahir?->format('d M Y') ?? '-' }}</dd></div>
                    <div><dt class="text-xs text-white/70">Usia</dt><dd class="mt-0.5 font-semibold">{{ $peserta->usia }} tahun</dd></div>
                    <div><dt class="text-xs text-white/70">Jenis kelamin</dt><dd class="mt-0.5 font-semibold">{{ $peserta->label_jenis_kelamin }}</dd></div>
                </dl>
            </div>
            <div class="rounded-xl bg-white/10 px-4 py-3 text-sm ring-1 ring-inset ring-white/20">
                <p class="text-xs text-white/70">Nomor Kartu Keluarga</p>
                <p class="mt-1 font-bold tracking-wider">{{ $peserta->keluarga->no_kk }}</p>
                <p class="mt-1 text-xs text-white/80">{{ $peserta->keluarga->nama_kepala_keluarga }}</p>
            </div>
        </div>
    </article>

    <section class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4" aria-label="Ringkasan pemeriksaan terbaru">
        @if ($peserta->kategori === 'balita')
            <x-health-card.metric label="Berat badan terakhir" :value="$detailTerbaru?->berat_badan" unit="kg" :date="$pemeriksaanTerbaru?->tanggal_pemeriksaan?->format('d M Y')" />
            <x-health-card.metric label="Panjang / tinggi" :value="$detailTerbaru?->tinggi_badan" unit="cm" :date="$detailTerbaru ? 'Pengukuran terakhir' : null" />
            <x-health-card.metric label="Lingkar kepala" :value="$detailTerbaru?->lingkar_kepala" unit="cm" :date="$detailTerbaru ? 'Pengukuran terakhir' : null" />
            <x-health-card.metric label="Status gizi" :value="$detailTerbaru?->catatan_gizi" :date="$detailTerbaru ? 'Pemeriksaan terakhir' : null" />
        @elseif ($peserta->kategori === 'ibu_hamil')
            <x-health-card.metric label="Usia kehamilan" :value="$detailTerbaru?->usia_kehamilan" unit="minggu" :date="$pemeriksaanTerbaru?->tanggal_pemeriksaan?->format('d M Y')" />
            <x-health-card.metric label="Berat badan terakhir" :value="$detailTerbaru?->berat_badan" unit="kg" :date="$detailTerbaru ? 'Pengukuran terakhir' : null" />
            <x-health-card.metric label="Tekanan darah" :value="$detailTerbaru?->tekanan_darah" :date="$detailTerbaru ? 'Pemeriksaan terakhir' : null" />
            <x-health-card.metric label="Denyut jantung janin" :value="$detailTerbaru?->denyut_jantung_janin" unit="bpm" :date="$detailTerbaru ? 'Pemeriksaan terakhir' : null" />
        @else
            <x-health-card.metric label="Berat badan terakhir" :value="$detailTerbaru?->berat_badan" unit="kg" :date="$pemeriksaanTerbaru?->tanggal_pemeriksaan?->format('d M Y')" />
            <x-health-card.metric label="Tekanan darah" :value="$detailTerbaru?->tekanan_darah" :date="$detailTerbaru ? 'Pemeriksaan terakhir' : null" />
            <x-health-card.metric label="Gula darah" :value="$detailTerbaru?->gula_darah" unit="mg/dL" :date="$detailTerbaru ? 'Pemeriksaan terakhir' : null" />
            <x-health-card.metric label="Kolesterol" :value="$detailTerbaru?->kolesterol" unit="mg/dL" :date="$detailTerbaru ? 'Pemeriksaan terakhir' : null" />
        @endif
    </section>

    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="flex flex-wrap items-start justify-between gap-3 border-b border-slate-100 px-5 py-5 sm:px-6">
            <div>
                <h2 class="text-lg font-extrabold text-slate-900">Grafik pertumbuhan & kesehatan</h2>
                <p class="mt-1 text-sm text-slate-500">Tren berat badan berdasarkan catatan pemeriksaan yang tersimpan.</p>
            </div>
            <span class="rounded-full px-3 py-1 text-xs font-bold ring-1 ring-inset {{ $kategoriLatar }}">{{ $peserta->label_kategori }}</span>
        </div>

        @if ($koordinatGrafik->isEmpty())
            <div class="px-5 py-12 text-center sm:px-6">
                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-teal-50 text-2xl" aria-hidden="true">＋</div>
                <h3 class="mt-3 font-bold text-slate-800">Belum ada data pertumbuhan</h3>
                <p class="mt-1 text-sm text-slate-500">Grafik akan terisi setelah berat badan dicatat pada pemeriksaan.</p>
            </div>
        @else
            <div class="px-4 py-5 sm:px-6">
                <div class="mb-3 flex items-center gap-2 text-xs font-semibold text-slate-600">
                    <span class="h-2.5 w-2.5 rounded-full bg-teal-600"></span>
                    Berat badan (kg)
                </div>
                <div class="overflow-x-auto">
                    <svg viewBox="0 0 720 240" role="img" aria-labelledby="health-chart-title health-chart-description" class="h-auto min-w-[560px] w-full">
                        <title id="health-chart-title">Grafik berat badan {{ $peserta->nama }}</title>
                        <desc id="health-chart-description">{{ $koordinatGrafik->count() }} titik data pemeriksaan, dari {{ $koordinatGrafik->first()['berat_badan'] }} hingga {{ $koordinatGrafik->last()['berat_badan'] }} kilogram.</desc>
                        @foreach ([50, 120, 190] as $garisY)
                            <line x1="48" y1="{{ $garisY }}" x2="672" y2="{{ $garisY }}" stroke="#e2e8f0" stroke-dasharray="4 5" />
                        @endforeach
                        <polyline points="{{ $titikGarisGrafik }}" fill="none" stroke="#0f766e" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" />
                        @foreach ($koordinatGrafik as $titik)
                            <circle cx="{{ $titik['x'] }}" cy="{{ $titik['y'] }}" r="6" fill="#ffffff" stroke="#0f766e" stroke-width="4">
                                <title>{{ $titik['tanggal']?->format('d M Y') }}: {{ $titik['berat_badan'] }} kg</title>
                            </circle>
                        @endforeach
                        @foreach ($koordinatGrafik as $indeks => $titik)
                            @if ($koordinatGrafik->count() <= 6 || in_array($indeks, [0, (int) floor(($koordinatGrafik->count() - 1) / 2), $koordinatGrafik->count() - 1], true))
                                <text x="{{ $titik['x'] }}" y="222" text-anchor="middle" fill="#64748b" font-size="12">{{ $titik['tanggal']?->format('d/m/y') }}</text>
                            @endif
                        @endforeach
                    </svg>
                </div>
            </div>
        @endif
    </section>

    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 px-5 py-5 sm:px-6">
            <div>
                <h2 class="text-lg font-extrabold text-slate-900">Riwayat pemeriksaan</h2>
                <p class="mt-1 text-sm text-slate-500">{{ $riwayat->count() }} catatan · dari yang terbaru</p>
            </div>
            <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-700">{{ $peserta->label_kategori }}</span>
        </div>

        @forelse ($riwayat as $item)
            @php
                $detail = match ($peserta->kategori) {
                    'balita' => $item->balita,
                    'ibu_hamil' => $item->bumil,
                    'lansia' => $item->lansia,
                    default => null,
                };
            @endphp
            <article class="relative border-b border-slate-100 px-5 py-5 last:border-b-0 sm:px-6">
                <div class="flex flex-wrap items-start justify-between gap-3">
                    <div class="flex items-start gap-3">
                        <span class="mt-1 flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-teal-50 text-teal-700" aria-hidden="true">✓</span>
                        <div>
                            <h3 class="font-bold text-slate-900">{{ $item->tanggal_pemeriksaan?->format('d F Y') ?? 'Tanggal tidak tersedia' }}</h3>
                            <p class="mt-0.5 text-xs text-slate-500">{{ $peserta->label_kategori }} · Pemeriksaan Posyandu</p>
                        </div>
                    </div>
                    @if (request()->routeIs('kader.peserta.show'))
                        <a href="{{ route('kader.pemeriksaan.show', $item) }}" class="text-sm font-bold text-teal-800 hover:text-teal-950">Lihat detail →</a>
                    @endif
                </div>

                @if ($detail)
                    @if ($peserta->kategori === 'balita')
                        <dl class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-4">
                            <x-health-card.value label="Berat badan" :value="$detail->berat_badan" unit="kg" />
                            <x-health-card.value label="Panjang / tinggi" :value="$detail->tinggi_badan" unit="cm" />
                            <x-health-card.value label="Lingkar kepala" :value="$detail->lingkar_kepala" unit="cm" />
                            <x-health-card.value label="Status gizi" :value="$detail->catatan_gizi" />
                            @if ($detail->perkembangan)
                                <div class="col-span-2 rounded-xl bg-slate-50 p-3 sm:col-span-4">
                                    <dt class="text-xs font-medium text-slate-500">Tumbuh kembang</dt>
                                    <dd class="mt-1 whitespace-pre-line text-sm text-slate-800">{{ $detail->perkembangan }}</dd>
                                </div>
                            @endif
                        </dl>
                    @elseif ($peserta->kategori === 'ibu_hamil')
                        <dl class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-3">
                            <x-health-card.value label="Usia kehamilan" :value="$detail->usia_kehamilan" unit="minggu" />
                            <x-health-card.value label="Berat badan" :value="$detail->berat_badan" unit="kg" />
                            <x-health-card.value label="Tekanan darah" :value="$detail->tekanan_darah" />
                            <x-health-card.value label="Tinggi fundus" :value="$detail->tinggi_fundus" unit="cm" />
                            <x-health-card.value label="Denyut jantung janin" :value="$detail->denyut_jantung_janin" unit="bpm" />
                            <x-health-card.value label="Catatan kehamilan" :value="$detail->catatan_kehamilan" />
                        </dl>
                    @else
                        <dl class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-3">
                            <x-health-card.value label="Berat badan" :value="$detail->berat_badan" unit="kg" />
                            <x-health-card.value label="Tekanan darah" :value="$detail->tekanan_darah" />
                            <x-health-card.value label="Gula darah" :value="$detail->gula_darah" unit="mg/dL" />
                            <x-health-card.value label="Kolesterol" :value="$detail->kolesterol" unit="mg/dL" />
                            <x-health-card.value label="Asam urat" :value="$detail->asam_urat" unit="mg/dL" />
                            <x-health-card.value label="Catatan kesehatan" :value="$detail->catatan_kesehatan" />
                        </dl>
                    @endif
                @else
                    <p class="mt-4 rounded-xl bg-amber-50 p-3 text-sm text-amber-900">Detail pemeriksaan kategori ini belum tersedia.</p>
                @endif

                @if ($item->keluhan || $item->catatan)
                    <div class="mt-3 grid gap-3 sm:grid-cols-2">
                        @if ($item->keluhan)
                            <div class="rounded-xl border border-amber-100 bg-amber-50/70 p-3">
                                <p class="text-xs font-bold text-amber-900">Keluhan</p>
                                <p class="mt-1 whitespace-pre-line text-sm text-slate-700">{{ $item->keluhan }}</p>
                            </div>
                        @endif
                        @if ($item->catatan)
                            <div class="rounded-xl border border-teal-100 bg-teal-50/70 p-3">
                                <p class="text-xs font-bold text-teal-900">Catatan / rekomendasi</p>
                                <p class="mt-1 whitespace-pre-line text-sm text-slate-700">{{ $item->catatan }}</p>
                            </div>
                        @endif
                    </div>
                @endif
            </article>
        @empty
            <div class="px-5 py-10 text-center sm:px-6">
                <h3 class="font-bold text-slate-800">Belum ada riwayat pemeriksaan</h3>
                <p class="mt-1 text-sm text-slate-500">Catatan dari kunjungan Posyandu akan tampil di sini.</p>
            </div>
        @endforelse
    </section>

    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 px-5 py-5 sm:px-6">
            <h2 class="text-lg font-extrabold text-slate-900">Imunisasi & layanan tambahan</h2>
            <p class="mt-1 text-sm text-slate-500">Catatan imunisasi, vitamin, dan obat cacing peserta.</p>
        </div>
        @forelse ($peserta->imunisasi as $item)
            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 px-5 py-4 last:border-b-0 sm:px-6">
                <div class="flex items-center gap-3">
                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-sky-50 text-sky-700" aria-hidden="true">＋</span>
                    <div>
                        <p class="font-bold text-slate-900">{{ $item->jenis_imunisasi }}</p>
                        @if ($item->catatan)
                            <p class="mt-0.5 text-sm text-slate-500">{{ $item->catatan }}</p>
                        @endif
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm font-semibold text-slate-700">{{ $item->tanggal_pemberian?->format('d M Y') ?? 'Tanggal belum tercatat' }}</p>
                    <p class="mt-0.5 text-xs text-slate-500">{{ ucfirst($item->status) }}</p>
                </div>
            </div>
        @empty
            <p class="px-5 py-5 text-sm text-slate-500 sm:px-6">Belum ada catatan imunisasi atau layanan tambahan.</p>
        @endforelse
    </section>

    <footer class="flex flex-wrap items-center justify-between gap-2 border-t border-slate-200 pt-4 text-xs text-slate-500">
        <span>Kartu kesehatan digital SIPANDU · Data diperbarui berdasarkan catatan pemeriksaan Posyandu.</span>
        <span>Dicetak / dilihat {{ now()->format('d M Y') }}</span>
    </footer>
</div>
