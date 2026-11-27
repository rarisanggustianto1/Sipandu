<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Laporan Bulanan | SIPANDU</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
@include('dinas.partials.header')

<main class="mx-auto max-w-7xl">
    @php($summary = $report->data['ringkasan'] ?? [])
    <div class="dinas-page-header">
        <div class="flex flex-wrap items-start justify-between gap-3">
            <div>
                <a href="{{ route('dinas.laporan.index') }}" class="text-sm font-semibold">← Kembali ke laporan wilayah</a>
                <h1 class="page-title mt-2">Laporan {{ \Illuminate\Support\Carbon::createFromDate($report->tahun, $report->bulan, 1)->translatedFormat('F Y') }}</h1>
                <p class="subtitle">{{ $report->puskesmas->nama_puskesmas }} · {{ $report->puskesmas->kecamatan }}</p>
            </div>
            <p class="mt-1 text-sm text-slate-500">Dikirim {{ $report->dikirim_pada?->translatedFormat('d F Y H:i') ?? '—' }}</p>
        </div>
    </div>

    <section class="summary">
        <div class="summary-card"><p>Pertemuan selesai</p><h2>{{ number_format($summary['jumlah_pertemuan'] ?? 0, 0, ',', '.') }}</h2></div>
        <div class="summary-card"><p>Kunjungan peserta hadir</p><h2>{{ number_format($summary['peserta_hadir'] ?? 0, 0, ',', '.') }}</h2></div>
        <div class="summary-card"><p>Pemeriksaan</p><h2>{{ number_format($summary['pemeriksaan'] ?? 0, 0, ',', '.') }}</h2></div>
        <div class="summary-card"><p>Petugas hadir</p><h2>{{ number_format($summary['petugas_hadir'] ?? 0, 0, ',', '.') }}</h2></div>
    </section>

    @if ($report->catatan)
        <section class="card">
            <h3>Catatan Puskesmas</h3>
            <p class="whitespace-pre-line">{{ $report->catatan }}</p>
        </section>
    @endif

    <h2 class="section-title">Rincian per Posyandu</h2>
    <div class="space-y-5">
        @forelse (($report->data['posyandu'] ?? []) as $posyandu)
            <section class="card">
                <h3>{{ $posyandu['nama_posyandu'] }}</h3>
                <p class="mb-4 text-sm text-slate-600">
                    {{ $posyandu['jumlah_pertemuan'] }} pertemuan ·
                    {{ $posyandu['peserta_hadir'] }} kunjungan peserta ·
                    {{ $posyandu['pemeriksaan'] }} pemeriksaan ·
                    {{ $posyandu['petugas_hadir'] }} petugas hadir
                </p>
                <div class="table-wrapper">
                    <table class="report-table report-detail-table">
                        <colgroup>
                            <col style="width: 31%">
                            <col style="width: 11%">
                            <col style="width: 11%">
                            <col style="width: 11%">
                            <col style="width: 36%">
                        </colgroup>
                        <thead><tr><th>Tanggal / Kegiatan</th><th>Peserta Hadir</th><th>Pemeriksaan</th><th>Petugas</th><th>Catatan Kader</th></tr></thead>
                        <tbody>
                            @foreach ($posyandu['kegiatan'] as $meeting)
                                <tr>
                                    <td>
                                        <div class="space-y-1">
                                            <p class="font-semibold text-slate-800">{{ \Illuminate\Support\Carbon::parse($meeting['tanggal'])->translatedFormat('d F Y') }}</p>
                                            <p class="text-sm">{{ $meeting['nama'] }}</p>
                                            <span class="inline-flex rounded-full bg-teal-50 px-2 py-0.5 text-xs font-semibold text-teal-700">{{ $meeting['jenis'] }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $meeting['peserta_hadir'] }}</td>
                                    <td>{{ $meeting['pemeriksaan'] }}</td>
                                    <td>{{ $meeting['petugas_hadir'] }}</td>
                                    <td class="whitespace-pre-line">{{ $meeting['catatan_kader'] ?: '—' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        @empty
            <section class="card"><p class="empty">Tidak ada pertemuan selesai pada periode ini.</p></section>
        @endforelse
    </div>
</main>
</body>
</html>
