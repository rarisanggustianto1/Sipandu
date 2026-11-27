<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan | SIPANDU</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            box-sizing: border-box;
        }

        header {
            background: white;
            border-bottom: 1px solid #e5e7eb;
            padding: 22px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        header h1 {
            margin: 0;
            font-size: 23px;
        }

        main {
            max-width: 1200px;
            margin: 35px auto;
            padding: 0 20px;
        }

        .page-title {
            font-size: 27px;
            margin-bottom: 8px;
        }

        .subtitle {
            color: #666;
            margin-bottom: 28px;
        }

        .card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 24px;
        }

        .card h3 {
            margin-top: 0;
            margin-bottom: 20px;
        }

        .filters {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 600;
        }

        select, input {
            width: 100%;
            padding: 11px;
            border: 1px solid #d1d5db;
            border-radius: 7px;
            font: inherit;
            background: white;
        }

        .filter-actions {
            display: flex;
            gap: 10px;
            margin-top: 22px;
        }

        .btn {
            display: inline-block;
            padding: 11px 18px;
            border-radius: 7px;
            border: 1px solid #d1d5db;
            background: white;
            color: #374151;
            font: inherit;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-primary {
            background: #333;
            border-color: #333;
            color: white;
        }

        .btn:disabled {
            opacity: 0.55;
            cursor: not-allowed;
        }

        .summary-card p {
            margin: 0 0 12px;
            color: #666;
            font-size: 14px;
        }

        .summary-card h2 {
            margin: 0;
            font-size: 30px;
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .table-header h3 {
            margin: 0;
        }

        .table-actions {
            display: flex;
            gap: 10px;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        th {
            background: #f5f5f5;
            color: #333;
            font-weight: 600;
        }

        .empty {
            padding: 40px 15px;
            text-align: center;
            color: #64748b;
        }

        .back {
            display: inline-block;
            margin-top: 5px;
            color: #333;
            text-decoration: none;
        }

        @media (max-width: 768px) {
            .filters,
            .summary {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

@include('dinas.partials.header')

<main>
    <div class="dinas-page-header">
        <h1 class="page-title">Laporan Kesehatan Wilayah</h1>
        <p class="subtitle">
            Rekap bulanan kegiatan Posyandu yang telah dikirim oleh Puskesmas di wilayah Anda.
        </p>
    </div>

    <div class="card">
        <h3>Filter Laporan</h3>

        <form method="GET"
              action="{{ route('dinas.laporan.index') }}">

            <div class="filters">

                <div>
                    <label for="puskesmas">Puskesmas</label>
                    <select name="puskesmas" id="puskesmas">
                        <option value="">Semua Puskesmas</option>
                        @foreach ($puskesmasList as $puskesmas)
                            <option value="{{ $puskesmas->id }}" @selected((string) request('puskesmas') === (string) $puskesmas->id)>
                                {{ $puskesmas->nama_puskesmas }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="bulan">Bulan</label>
                    <select name="bulan" id="bulan">
                        <option value="">Semua Bulan</option>
                        @foreach (range(1, 12) as $month)
                            <option value="{{ $month }}" @selected((string) request('bulan') === (string) $month)>
                                {{ \Illuminate\Support\Carbon::createFromDate(now()->year, $month, 1)->translatedFormat('F') }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="tahun">Tahun</label>
                    <input type="number" name="tahun" id="tahun" min="2000" max="{{ now()->year }}" value="{{ request('tahun') }}">
                </div>
            </div>

            <div class="filter-actions">
                <button type="submit" class="btn btn-primary">
                    Terapkan Filter
                </button>

                <a href="{{ route('dinas.laporan.index') }}"
                   class="btn btn-secondary">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <div class="summary">
        <div class="summary-card">
            <p>Total Laporan</p>
            <h2>{{ number_format($totalReports, 0, ',', '.') }}</h2>
        </div>
        <div class="summary-card">
            <p>Puskesmas Terlibat</p>
            <h2>{{ number_format($puskesmasTerlibat, 0, ',', '.') }}</h2>
        </div>
    </div>

    <div class="card">
        <div class="table-header">
            <h3>Daftar Laporan Bulanan</h3>
        </div>

        <div class="table-wrapper">
            <table class="report-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Periode</th>
                        <th>Puskesmas</th>
                        <th>Pertemuan</th>
                        <th>Peserta Hadir</th>
                        <th>Pemeriksaan</th>
                        <th>Dikirim</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reports as $report)
                        @php($summary = $report->data['ringkasan'] ?? [])
                        <tr>
                            <td>{{ $reports->firstItem() + $loop->index }}</td>
                            <td>{{ \Illuminate\Support\Carbon::createFromDate($report->tahun, $report->bulan, 1)->translatedFormat('F Y') }}</td>
                            <td>{{ $report->puskesmas->nama_puskesmas }}</td>
                            <td>{{ number_format($summary['jumlah_pertemuan'] ?? 0, 0, ',', '.') }}</td>
                            <td>{{ number_format($summary['peserta_hadir'] ?? 0, 0, ',', '.') }}</td>
                            <td>{{ number_format($summary['pemeriksaan'] ?? 0, 0, ',', '.') }}</td>
                            <td>{{ $report->dikirim_pada?->translatedFormat('d M Y') ?? '—' }}</td>
                            <td><a href="{{ route('dinas.laporan.show', $report) }}" class="btn btn-edit">Lihat</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="empty">Belum ada laporan terkirim pada filter tersebut.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="pagination">{{ $reports->links() }}</div>
    </div>

    <a href="{{ route('dinas.dashboard') }}" class="back">
        ← Kembali ke Dashboard
    </a>
</main>

</body>
</html>
