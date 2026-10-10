<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Edukasi | SIPANDU</title>

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
            display: inline-block;
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
    </style>
</head>

<body>
<header>
    <h1>SIPANDU | Dinas Kesehatan</h1>
</header>

<main>
    <h2>Edit Edukasi</h2>
    <p class="subtitle">
        Perbarui informasi kesehatan yang sudah terdaftar.
    </p>

    <div class="card">
        <form action="{{ route('dinas.edukasi.update', $edukasi->id) }}"
              method="POST">

            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="judul">Judul Edukasi</label>

                <input type="text"
                       name="judul"
                       id="judul"
                       value="{{ old('judul', $edukasi->judul) }}"
                       required>

                @error('judul')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="kategori">Kategori</label>

                <select name="kategori" id="kategori" required>
                    <option value="umum"
                        @selected(old('kategori', $edukasi->kategori) == 'umum')>
                        Umum
                    </option>

                    <option value="balita"
                        @selected(old('kategori', $edukasi->kategori) == 'balita')>
                        Balita
                    </option>

                    <option value="ibu_hamil"
                        @selected(old('kategori', $edukasi->kategori) == 'ibu_hamil')>
                        Ibu Hamil
                    </option>

                    <option value="lansia"
                        @selected(old('kategori', $edukasi->kategori) == 'lansia')>
                        Lansia
                    </option>
                </select>

                @error('kategori')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="isi">Isi Edukasi</label>

                <textarea name="isi"
                          id="isi"
                          required>{{ old('isi', $edukasi->isi) }}</textarea>

                @error('isi')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="tanggal_publikasi">
                    Tanggal Publikasi
                </label>

                <input type="date"
                       name="tanggal_publikasi"
                       id="tanggal_publikasi"
                       value="{{ old('tanggal_publikasi', $edukasi->tanggal_publikasi?->format('Y-m-d')) }}">

                @error('tanggal_publikasi')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="status_aktif">Status Edukasi</label>

                <select name="status_aktif" id="status_aktif" required>
                    <option value="1"
                        @selected((string) old('status_aktif', (int) $edukasi->status_aktif) === '1')>
                        Aktif
                    </option>

                    <option value="0"
                        @selected((string) old('status_aktif', (int) $edukasi->status_aktif) === '0')>
                        Tidak Aktif
                    </option>
                </select>

                @error('status_aktif')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="actions">
                <button type="submit" class="btn btn-primary">
                    Simpan Perubahan
                </button>

                <a href="{{ route('dinas.edukasi.index') }}"
                   class="btn">
                    Batal
                </a>
            </div>
        </form>
    </div>
</main>

</body>
</html>
