<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Edukasi | SIPANDU</title>

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
            background: #f5f5f5;
            border-bottom: 1px solid #ddd;
            padding: 24px 4%;
        }

        header h1 {
            margin: 0;
            font-size: 26px;
        }

        main {
            max-width: 900px;
            margin: 50px auto;
            padding: 0 20px;
        }

        h2 {
            margin-bottom: 10px;
            font-size: 28px;
        }

        .subtitle {
            color: #666;
            margin-bottom: 30px;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 30px;
        }

        .form-group {
            margin-bottom: 22px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
        }

        input, select, textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font: inherit;
        }

        textarea {
            min-height: 180px;
            resize: vertical;
        }

        .error {
            color: #b42318;
            font-size: 14px;
            margin-top: 6px;
        }

        .actions {
            display: flex;
            gap: 12px;
            margin-top: 28px;
        }

        .btn {
            padding: 12px 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            background: #f5f5f5;
            color: #222;
            font: inherit;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-primary {
            background: #333;
            color: white;
            border-color: #333;
        }

        .hint {
            color: #777;
            font-size: 13px;
            margin-top: 6px;
        }
    </style>
</head>

<body>

<header>
    <h1>SIPANDU | Dinas Kesehatan</h1>
</header>

<main>
    <h2>Tambah Edukasi</h2>
    <p class="subtitle">
        Tambahkan informasi kesehatan untuk seluruh pengguna SIPANDU.
    </p>

    <div class="card">
        <form action="{{ route('dinas.edukasi.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="judul">Judul Edukasi</label>
                <input type="text"
                       name="judul"
                       id="judul"
                       value="{{ old('judul') }}"
                       placeholder="Masukkan judul edukasi"
                       required>

                @error('judul')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="kategori">Kategori</label>
                <select name="kategori" id="kategori" required>
                    <option value="">Pilih Kategori</option>
                    <option value="umum" @selected(old('kategori') == 'umum')>Umum</option>
                    <option value="balita" @selected(old('kategori') == 'balita')>Balita</option>
                    <option value="ibu_hamil" @selected(old('kategori') == 'ibu_hamil')>Ibu Hamil</option>
                    <option value="lansia" @selected(old('kategori') == 'lansia')>Lansia</option>
                </select>

                @error('kategori')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="isi">Isi Edukasi</label>
                <textarea name="isi"
                          id="isi"
                          placeholder="Tuliskan isi artikel edukasi..."
                          required>{{ old('isi') }}</textarea>

                @error('isi')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="tanggal_publikasi">Tanggal Publikasi</label>
                <input type="date"
                       name="tanggal_publikasi"
                       id="tanggal_publikasi"
                       value="{{ old('tanggal_publikasi') }}">

                <p class="hint">Tanggal publikasi boleh dikosongkan.</p>

                @error('tanggal_publikasi')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="status_aktif">Status Edukasi</label>
                <select name="status_aktif" id="status_aktif" required>
                    <option value="1" @selected(old('status_aktif', '1') == '1')>
                        Aktif
                    </option>
                    <option value="0" @selected(old('status_aktif') == '0')>
                        Tidak Aktif
                    </option>
                </select>

                @error('status_aktif')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="actions">
                <button type="submit" class="btn btn-primary">
                    Simpan Edukasi
                </button>

                <a href="{{ route('dinas.edukasi.index') }}" class="btn">
                    Batal
                </a>
            </div>
        </form>
    </div>
</main>

</body>
</html>
