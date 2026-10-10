<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Edukasi | SIPANDU</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #ffffff;
            color: #222;
        }

        header {
            background: #f5f5f5;
            padding: 24px 4%;
            border-bottom: 1px solid #ddd;
        }

        header h1 {
            margin: 0;
            font-size: 26px;
        }

        main {
            max-width: 1100px;
            margin: 45px auto;
            padding: 0 20px;
        }

        .heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        h2 {
            margin: 0 0 8px;
            font-size: 28px;
        }

        .subtitle {
            margin: 0;
            color: #666;
        }

        .btn {
            display: inline-block;
            padding: 10px 16px;
            border: 1px solid #ccc;
            border-radius: 6px;
            background: #f5f5f5;
            color: #222;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
        }

        .btn-primary {
            background: #333;
            color: white;
            border-color: #333;
        }

        .btn-danger {
            background: #fff;
            color: #a11;
            border-color: #ddd;
        }

        .alert {
            padding: 14px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            background: #f5f5f5;
        }

        .table-wrapper {
            overflow-x: auto;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 15px;
            border-bottom: 1px solid #eee;
            text-align: left;
            vertical-align: middle;
        }

        th {
            background: #f5f5f5;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .actions {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .actions form {
            margin: 0;
        }

        .empty {
            padding: 35px;
            text-align: center;
            color: #777;
        }

        .pagination {
            margin-top: 20px;
        }
    </style>
</head>

<body>
<header>
    <h1>SIPANDU | Dinas Kesehatan</h1>
</header>

<main>
    <div class="heading">
        <div>
            <h2>Kelola Edukasi</h2>
            <p class="subtitle">
                Kelola informasi kesehatan untuk seluruh pengguna SIPANDU.
            </p>
        </div>

        <a href="{{ route('dinas.edukasi.create') }}"
           class="btn btn-primary">
            + Tambah Edukasi
        </a>
    </div>

    @if (session('success'))
        <div class="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Judul Edukasi</th>
                    <th>Kategori</th>
                    <th>Tanggal Publikasi</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($edukasi as $item)
                    <tr>
                        <td>
                            {{ $edukasi->firstItem() + $loop->index }}
                        </td>

                        <td>{{ $item->judul }}</td>

                        <td>
                            {{ ucwords(str_replace('_', ' ', $item->kategori)) }}
                        </td>

                        <td>
                            {{ $item->tanggal_publikasi
                                ? $item->tanggal_publikasi->format('d-m-Y')
                                : '-' }}
                        </td>

                        <td>
                            {{ $item->status_aktif ? 'Aktif' : 'Tidak Aktif' }}
                        </td>

                        <td>
                            <div class="actions">
                                <a href="{{ route('dinas.edukasi.edit', $item->id) }}"
                                   class="btn">
                                    Edit
                                </a>

                                <form action="{{ route('dinas.edukasi.destroy', $item->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus edukasi ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-danger">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty">
                            Belum ada data edukasi.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination">
        {{ $edukasi->links() }}
    </div>
    
    <div style="margin-top: 30px;">
        <a href="{{ route('dinas.dashboard') }}"
            style="color: #333; text-decoration: underline;">
            ← Kembali ke Dashboard
        </a>
    </div>


</main>
</body>
</html>
