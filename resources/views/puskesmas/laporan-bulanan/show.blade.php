<x-app-layout>
    @php($summary = $report->data['ringkasan'] ?? [])
    <div class="mx-auto max-w-7xl space-y-6">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <a href="{{ route('puskesmas.laporan-bulanan.index') }}" class="text-sm font-semibold text-teal-700 hover:underline">← Kembali ke laporan</a>
                <h1 class="mt-3 text-2xl font-bold text-slate-800">
                    Laporan {{ \Illuminate\Support\Carbon::createFromDate($report->tahun, $report->bulan, 1)->translatedFormat('F Y') }}
                </h1>
                <p class="mt-1 text-sm text-slate-500">Rekap otomatis kegiatan Posyandu berstatus selesai.</p>
            </div>
            <span class="rounded-full px-3 py-1.5 text-xs font-bold {{ $report->status === 'dikirim' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                {{ $report->status === 'dikirim' ? 'Terkirim ke Dinas' : 'Draf - menunggu tinjauan' }}
            </span>
        </div>

        @if (session('success') || session('info'))
            <div class="rounded-xl border border-teal-200 bg-teal-50 p-4 text-sm font-semibold text-teal-900">{{ session('success') ?? session('info') }}</div>
        @endif
        @if ($errors->any())
            <div class="rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800">{{ $errors->first() }}</div>
        @endif

        <section class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ([
                'Pertemuan selesai' => $summary['jumlah_pertemuan'] ?? 0,
                'Kunjungan peserta hadir' => $summary['peserta_hadir'] ?? 0,
                'Pemeriksaan' => $summary['pemeriksaan'] ?? 0,
                'Petugas hadir' => $summary['petugas_hadir'] ?? 0,
            ] as $label => $value)
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm text-slate-500">{{ $label }}</p>
                    <p class="mt-2 text-3xl font-bold text-slate-800">{{ number_format($value, 0, ',', '.') }}</p>
                </div>
            @endforeach
        </section>

        @if ($report->status === 'draft')
            <div class="flex flex-wrap gap-3">
                <form method="POST" action="{{ route('puskesmas.laporan-bulanan.refresh', $report) }}">
                    @csrf
                    @method('PUT')
                    <button class="rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">Perbarui dari kegiatan selesai</button>
                </form>
                <form method="POST" action="{{ route('puskesmas.laporan-bulanan.submit', $report) }}" onsubmit="return confirm('Kirim laporan bulanan ini ke Dinas Kesehatan? Laporan tidak dapat diubah setelah dikirim.')">
                    @csrf
                    <button class="rounded-xl bg-teal-700 px-4 py-2.5 text-sm font-bold text-white hover:bg-teal-800">Kirim ke Dinas</button>
                </form>
            </div>
        @elseif ($report->dikirim_pada)
            <p class="text-sm text-slate-500">Dikirim pada {{ $report->dikirim_pada->translatedFormat('d F Y H:i') }}.</p>
        @endif

        <section class="space-y-4">
            <h2 class="text-lg font-bold text-slate-800">Rekap per Posyandu</h2>
            @forelse (($report->data['posyandu'] ?? []) as $posyandu)
                <article class="space-y-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <h3 class="text-lg font-bold text-slate-800">{{ $posyandu['nama_posyandu'] }}</h3>
                        <p class="text-sm text-slate-500">
                            {{ $posyandu['jumlah_pertemuan'] }} pertemuan ·
                            {{ $posyandu['peserta_hadir'] }} kunjungan peserta ·
                            {{ $posyandu['pemeriksaan'] }} pemeriksaan ·
                            {{ $posyandu['petugas_hadir'] }} petugas hadir
                        </p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200 text-sm">
                            <thead class="bg-slate-50 text-left text-xs uppercase tracking-wide text-slate-500">
                                <tr><th class="px-4 py-3">Tanggal / Kegiatan</th><th class="px-4 py-3">Peserta hadir</th><th class="px-4 py-3">Pemeriksaan</th><th class="px-4 py-3">Petugas</th><th class="px-4 py-3">Catatan Kader</th></tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach ($posyandu['kegiatan'] as $meeting)
                                    <tr>
                                        <td class="px-4 py-3"><p class="font-semibold text-slate-800">{{ $meeting['nama'] }}</p><p class="text-xs text-slate-500">{{ \Illuminate\Support\Carbon::parse($meeting['tanggal'])->translatedFormat('d F Y') }} · {{ $meeting['jenis'] }}</p></td>
                                        <td class="px-4 py-3 text-slate-600">{{ $meeting['peserta_hadir'] }}</td>
                                        <td class="px-4 py-3 text-slate-600">{{ $meeting['pemeriksaan'] }}</td>
                                        <td class="px-4 py-3 text-slate-600">{{ $meeting['petugas_hadir'] }}</td>
                                        <td class="max-w-sm whitespace-pre-line px-4 py-3 text-slate-600">{{ $meeting['catatan_kader'] ?: '—' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </article>
            @empty
                <div class="rounded-2xl border border-slate-200 bg-white p-6 text-sm text-slate-500">
                    Belum ada pertemuan yang selesai pada periode ini. Perbarui data setelah Kader menyelesaikan kegiatan.
                </div>
            @endforelse
        </section>

        <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <h2 class="font-bold text-slate-800">Catatan Puskesmas</h2>
            @if ($report->status === 'draft')
                <form method="POST" action="{{ route('puskesmas.laporan-bulanan.update', $report) }}" class="mt-3 space-y-3">
                    @csrf
                    @method('PUT')
                    <textarea name="catatan" rows="4" maxlength="10000" class="w-full rounded-xl border-slate-300 text-sm" placeholder="Tambahkan ringkasan atau catatan untuk Dinas">{{ old('catatan', $report->catatan) }}</textarea>
                    @error('catatan')<p class="text-sm text-rose-700">{{ $message }}</p>@enderror
                    <button class="rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Simpan Catatan</button>
                </form>
            @else
                <p class="mt-3 whitespace-pre-line text-sm text-slate-600">{{ $report->catatan ?: 'Tidak ada catatan tambahan.' }}</p>
            @endif
        </section>
    </div>
</x-app-layout>
