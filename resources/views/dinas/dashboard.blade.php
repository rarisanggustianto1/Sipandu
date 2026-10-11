
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Dinas Kesehatan - SIPANDU</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #ffffff;
            color: #222222;
        }

        .navbar {
            background: #f5f5f5;
            padding: 20px 40px;
            border-bottom: 1px solid #dddddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .navbar h2 {
            margin: 0;
            font-size: 24px;
        }

        .nav-links {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .nav-links a {
            color: #333333;
            text-decoration: none;
            padding: 10px 14px;
            border-radius: 6px;
        }

        .nav-links a:hover {
            background: #e5e5e5;
        }

        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        h1 {
            margin-bottom: 10px;
        }

        .subtitle {
            color: #666666;
            margin-bottom: 30px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }

        .card {
            background: #ffffff;
            border: 1px solid #dddddd;
            border-radius: 8px;
            padding: 25px;
        }

        .card h3 {
            font-size: 16px;
            font-weight: 500;
            margin: 0 0 15px;
        }

        .card .number {
            font-size: 36px;
            font-weight: bold;
            color: #222222;
        }

        .section-title {
            margin-top: 45px;
            margin-bottom: 20px;
            font-size: 22px;
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 20px;
        }

        .menu-card {
            border: 1px solid #dddddd;
            border-radius: 8px;
            padding: 25px;
            background: #ffffff;
        }

        .menu-card h3 {
            margin: 0 0 12px;
            font-size: 20px;
        }

        .menu-card p {
            color: #666666;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            background: #333333;
            color: #ffffff;
            padding: 11px 18px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
        }

        .btn:hover {
            background: #555555;
        }

        @media (max-width: 600px) {
            .navbar {
                padding: 20px;
            }

            .navbar h2 {
                font-size: 20px;
            }

            .container {
                margin-top: 25px;
            }
        }
    </style>
</head>

<body>

    <header class="navbar">
        <h2>SIPANDU | Dinas Kesehatan</h2>

        <nav class="nav-links">
            <a href="{{ route('dinas.dashboard') }}">
                Dashboard
            </a>

            <a href="{{ route('dinas.puskesmas.index') }}">
                Puskesmas
            </a>

            <a href="{{ route('dinas.edukasi.index') }}">
                Edukasi
            </a>
        </nav>
    </header>

    <main class="container">

        <h1>Dashboard Dinas Kesehatan</h1>

        <p class="subtitle">
            Ringkasan data pemantauan Posyandu
        </p>

        <!-- Statistik Dashboard -->
        <section class="stats">

            <div class="card">
                <h3>Total Puskesmas</h3>
                <div class="number">
                    {{ $totalPuskesmas }}
                </div>
            </div>

            <div class="card">
                <h3>Total Posyandu</h3>
                <div class="number">
                    {{ $totalPosyandu }}
                </div>
            </div>

            <div class="card">
                <h3>Total Keluarga</h3>
                <div class="number">
                    {{ $totalKeluarga }}
                </div>
            </div>

            <div class="card">
                <h3>Total Peserta</h3>
                <div class="number">
                    {{ $totalPeserta }}
                </div>
            </div>

        </section>

        <!-- Menu Pengelolaan -->
        <h2 class="section-title">Menu Pengelolaan</h2>

        <section class="menu-grid">

            <div class="menu-card">
                <h3>Kelola Puskesmas</h3>

                <p>
                    Mengelola data Puskesmas yang terdaftar,
                    mulai dari menambahkan, melihat, mengedit,
                    hingga menghapus data Puskesmas.
                </p>

                <a href="{{ route('dinas.puskesmas.index') }}"
                   class="btn">
                    Kelola Puskesmas
                </a>
            </div>

            <div class="menu-card">
                <h3>Kelola Edukasi</h3>

                <p>
                    Mengelola artikel dan informasi kesehatan
                    yang dapat diakses oleh pengguna SIPANDU
                    dari berbagai daerah.
                </p>

                <a href="{{ route('dinas.edukasi.index') }}"
                   class="btn">
                    Kelola Edukasi
                </a>
            </div>

        </section>

    </main>

</body>
</html>
