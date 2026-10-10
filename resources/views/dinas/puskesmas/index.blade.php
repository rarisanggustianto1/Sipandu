<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Puskesmas - SIPANDU</title>

    
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
        color: #222222;
        padding: 20px 40px;
        border-bottom: 1px solid #dddddd;
    }

    .navbar h2 {
        margin: 0;
    }

    .container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-bottom: 25px;
        flex-wrap: wrap;
    }

    .subtitle {
        color: #666666;
    }

    .btn {
        display: inline-block;
        padding: 10px 15px;
        border: 1px solid #cccccc;
        border-radius: 6px;
        background: #f5f5f5;
        color: #222222;
        text-decoration: none;
        font-size: 14px;
        cursor: pointer;
    }

    .table-wrapper {
        background: white;
        border: 1px solid #dddddd;
        border-radius: 8px;
        padding: 20px;
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 14px;
        text-align: left;
        border-bottom: 1px solid #dddddd;
    }

    th {
        background: #f5f5f5;
    }

    .actions {
        display: flex;
        gap: 8px;
    }

    .alert {
        background: #f5f5f5;
        border: 1px solid #dddddd;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .pagination {
        margin-top: 20px;
    }
</style>

</head>
<body>

    <div class="navbar">
        <h2>SIPANDU | Dinas Kesehatan</h2>
    </div>

    <div class="container">

        <div class="header">
            <div>
                <h1>Data Puskesmas</h1>
                <p class="subtitle">
                    Kelola data Puskesmas yang terdaftar.
                </p>
            </div>

            <a href="{{ route('dinas.puskesmas.create') }}"
               class="btn btn-primary">
                + Tambah Puskesmas
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
                        <th>No</th>
                        <th>Nama Puskesmas</th>
                        <th>Kecamatan</th>
                        <th>Alamat</th>
                        <th>Telepon</th>
                        <th>Dinas Kesehatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($puskesmas as $item)
                        <tr>
                            <td>
                                {{ $puskesmas->firstItem() + $loop->index }}
                            </td>
                            <td>{{ $item->nama_puskesmas }}</td>
                            <td>{{ $item->kecamatan }}</td>
                            <td>{{ $item->alamat }}</td>
                            <td>{{ $item->telepon ?? '-' }}</td>
                            <td>
                                {{ $item->dinasKesehatan?->nama_dinas ?? '-' }}
                            </td>
                            <td>
                                <div class="actions">
                                    <a class="btn btn-edit"
                                       href="{{ route('dinas.puskesmas.edit', $item) }}">
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('dinas.puskesmas.destroy', $item) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus Puskesmas ini? Data terkait juga dapat terhapus.');">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-delete">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align:center; padding:30px;">
                                Belum ada data Puskesmas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="pagination">
                {{ $puskesmas->links() }}
            </div>
        </div>

        <p style="margin-top:25px;">
            <a href="{{ route('dinas.dashboard') }}">
                ← Kembali ke Dashboard
            </a>
        </p>

    </div>
</body>
</html>
