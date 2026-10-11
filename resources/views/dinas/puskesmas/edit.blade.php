<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Puskesmas | SIPANDU</title>

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
            margin: 55px auto;
            padding: 0 20px;
        }

        h2 {
            font-size: 28px;
            margin-bottom: 10px;
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
            min-height: 90px;
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
    <h2>Edit Puskesmas</h2>
    <p class="subtitle">Perbarui informasi Puskesmas yang terdaftar.</p>

    <div class="card">
        <form action="{{ route('dinas.puskesmas.update', $puskesmas->id) }}"
              method="POST">

            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="dinas_kesehatan_id">Dinas Kesehatan</label>

                <select name="dinas_kesehatan_id"
                        id="dinas_kesehatan_id"
                        required>
                    <option value="">Pilih Dinas Kesehatan</option>

                    @foreach ($dinas as $item)
                        <option value="{{ $item->id }}"
                            @selected(old('dinas_kesehatan_id', $puskesmas->dinas_kesehatan_id) == $item->id)>
                            {{ $item->nama_dinas }}
                        </option>
                    @endforeach
                </select>

                @error('dinas_kesehatan_id')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="nama_puskesmas">Nama Puskesmas</label>

                <input type="text"
                       name="nama_puskesmas"
                       id="nama_puskesmas"
                       value="{{ old('nama_puskesmas', $puskesmas->nama_puskesmas) }}"
                       required>

                @error('nama_puskesmas')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="kecamatan">Kecamatan</label>

                <input type="text"
                       name="kecamatan"
                       id="kecamatan"
                       value="{{ old('kecamatan', $puskesmas->kecamatan) }}"
                       required>

                @error('kecamatan')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="alamat">Alamat</label>

                <textarea name="alamat"
                          id="alamat"
                          required>{{ old('alamat', $puskesmas->alamat) }}</textarea>

                @error('alamat')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="telepon">Nomor Telepon</label>

                <input type="text"
                       name="telepon"
                       id="telepon"
                       value="{{ old('telepon', $puskesmas->telepon) }}">

                @error('telepon')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>

                <input type="email"
                       name="email"
                       id="email"
                       value="{{ old('email', $puskesmas->email) }}">

                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="actions">
                <button type="submit" class="btn btn-primary">
                    Simpan Perubahan
                </button>

                <a href="{{ route('dinas.puskesmas.index') }}"
                   class="btn">
                    Batal
                </a>
            </div>
        </form>
    </div>
</main>

</body>
</html>
