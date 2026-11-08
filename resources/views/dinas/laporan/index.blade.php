<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan | SIPANDU</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #fff;
            color: #222;
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

        .summary {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
            margin-bottom: 24px;
        }

        .summary-card {
            background: white;
            padding: 24px;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
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
    <h2 class="page-title">Laporan Kesehatan Wilayah</h2>
    <p class="subtitle">
        Lihat dan rekap laporan kegiatan Posyandu berdasarkan
        wilayah binaan Puskesmas.
    </p>

    <!-- FILTER LAPORAN -->
    <div class="card">
        <h3>Filter Laporan</h3>

        <form method="GET"
              action="{{ route('dinas.laporan.index') }}">

            <div class="filters">

                <div>
                    <label for="puskesmas">Puskesmas</label>
                    <select name="puskesmas" id="puskesmas">
                        <option value="">Semua Puskesmas</option>
                    </select>
                </div>

                <div>
                    <label for="posyandu">Posyandu</label>
                    <select name="posyandu" id="posyandu">
                        <option value="">Semua Posyandu</option>
                    </select>
                </div>

                <div>
                    <label for="jenis">Jenis Laporan</label>
                    <select name="jenis" id="jenis">
                        <option value="">Semua Jenis</option>
                        <option value="pemeriksaan">Pemeriksaan</option>
                        <option value="imunisasi">Imunisasi</option>
                        <option value="kegiatan">Kegiatan Posyandu</option>
                    </select>
                </div>

                <div>
                    <label for="tanggal_mulai">Tanggal Mulai</label>
                    <input type="date"
                           name="tanggal_mulai"
                           id="tanggal_mulai"
                           value="{{ request('tanggal_mulai') }}">
                </div>

                <div>
                    <label for="tanggal_selesai">Tanggal Selesai</label>
                    <input type="date"
                           name="tanggal_selesai"
                           id="tanggal_selesai"
                           value="{{ request('tanggal_selesai') }}">
                </div>

            </div>

            <div class="filter-actions">
                <button type="submit" class="btn btn-primary">
                    Terapkan Filter
                </button>

                <a href="{{ route('dinas.laporan.index') }}"
                   class="btn">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- RINGKASAN -->
    <div class="summary">
        <div class="summary-card">
            <p>Total Laporan</p>
            <h2>0</h2>
        </div>

        <div class="summary-card">
            <p>Puskesmas Terlibat</p>
            <h2>0</h2>
        </div>

        <div class="summary-card">
            <p>Posyandu Terlibat</p>
            <h2>0</h2>
        </div>
    </div>

    <!-- TABEL LAPORAN -->
    <div class="card">

        <div class="table-header">
            <h3>Daftar Laporan</h3>

            <div class="table-actions">
                <button type="button" class="btn" disabled>
                    Unduh PDF
                </button>

                <button type="button" class="btn" disabled>
                    Unduh CSV
                </button>
            </div>
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tanggal</th>
                        <th>Puskesmas</th>
                        <th>Posyandu</th>
                        <th>Jenis Laporan</th>
                        <th>Jumlah Data</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td colspan="7">
                            <div class="empty">
                                Belum ada data laporan yang ditampilkan.
                                <p>
                                    Data akan muncul setelah halaman
                                    terhubung dengan modul Kader dan Puskesmas.
                                </p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <a href="{{ route('dinas.dashboard') }}" class="back">
        ← Kembali ke Dashboard
    </a>
</main>

</body>
</html>
