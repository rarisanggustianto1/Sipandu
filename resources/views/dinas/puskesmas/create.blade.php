<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Puskesmas - SIPANDU</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: white;
            color: #222;
        }

        .navbar {
            background: #f5f5f5;
            padding: 20px 40px;
            border-bottom: 1px solid #ddd;
        }

        .navbar h2 {
            margin: 0;
        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .form-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input, select, textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-family: inherit;
            font-size: 14px;
        }

        textarea {
            min-height: 100px;
            resize: vertical;
        }

        .error {
            color: #444;
            font-size: 13px;
            margin-top: 5px;
        }

        .actions {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }

        .btn {
            padding: 12px 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background: #f5f5f5;
            color: #222;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <div class="navbar">
        <h2>SIPANDU | Dinas Kesehatan</h2>
    </div>

    <div class="container">
        <h1>Tambah Puskesmas</h1>
        <p>Masukkan informasi Puskesmas yang akan didaftarkan.</p>

        <div class="form-card">

            @if ($errors->any())
                <p>Periksa kembali data yang kamu masukkan.</p>
            @endif

            <form action="{{ route('dinas.puskesmas.store') }}"
                  method="POST">

                @csrf

                <div class="form-group">
                    <label for="dinas_kesehatan_id">
                        Dinas Kesehatan
                    </label>

                    <select name="dinas_kesehatan_id"
                            id="dinas_kesehatan_id" required>
                        <option value="">Pilih Dinas Kesehatan</option>

                        @foreach ($dinas as $item)
                            <option value="{{ $item->id }}"
                                @selected(old('dinas_kesehatan_id') == $item->id)>
                                {{ $item->nama_dinas }}
                            </option>
                        @endforeach
                    </select>

                    @error('dinas_kesehatan_id')
                        <div class="error">{{ $message }}</div>
                    @enderror

                    @if ($dinas->isEmpty())
                        <p>Belum ada data Dinas Kesehatan.
                           Tambahkan data Dinas Kesehatan terlebih dahulu.</p>
                    @endif
                </div>

                <div class="form-group">
                    <label for="nama_puskesmas">Nama Puskesmas</label>
                    <input type="text"
                           id="nama_puskesmas"
                           name="nama_puskesmas"
                           value="{{ old('nama_puskesmas') }}"
                           required>

                    @error('nama_puskesmas')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="kecamatan">Kecamatan</label>
                    <input type="text"
                           id="kecamatan"
                           name="kecamatan"
                           value="{{ old('kecamatan') }}"
                           required>

                    @error('kecamatan')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea id="alamat"
                              name="alamat"
                              required>{{ old('alamat') }}</textarea>

                    @error('alamat')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="telepon">Nomor Telepon</label>
                    <input type="text"
                           id="telepon"
                           name="telepon"
                           value="{{ old('telepon') }}">
                    @error('telepon')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email"
                           id="email"
                           name="email"
                           value="{{ old('email') }}">
                    @error('email')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="actions">
                    <button type="submit"
                            class="btn"
                            @disabled($dinas->isEmpty())>
                        Simpan Puskesmas
                    </button>

                    <a href="{{ route('dinas.puskesmas.index') }}"
                       class="btn">
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </div>

</body>
</html>
