<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Edukasi | SIPANDU</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #fff;
            color: #222;
        }

        header {
            padding: 24px 4%;
            background: #f5f5f5;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        header h1 { margin: 0; font-size: 26px; }

        main {
            max-width: 900px;
            margin: 45px auto;
            padding: 0 20px;
        }

        h2 { margin-bottom: 8px; }

        .subtitle {
            color: #666;
            margin-bottom: 28px;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 12px;
            padding: 28px;
        }

        .tabs {
            display: flex;
            gap: 5px;
            margin-bottom: 28px;
        }

        .tab {
            flex: 1;
            padding: 15px;
            border: none;
            border-radius: 30px;
            background: #f3f3f3;
            cursor: pointer;
            font-size: 16px;
        }

        .tab.active {
            background: #333;
            color: white;
        }

        .panel { display: none; }
        .panel.active { display: block; }

        .form-group { margin-bottom: 22px; }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }

        input, select, textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font: inherit;
        }

        textarea {
            min-height: 230px;
            resize: vertical;
        }

        .upload-box {
            display: block;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 35px 20px;
            text-align: center;
            cursor: pointer;
            background: #fafafa;
        }

        .upload-box:hover { background: #f3f3f3; }

        .upload-icon {
            font-size: 32px;
            margin-bottom: 12px;
        }

        .upload-title {
            font-size: 18px;
            font-weight: 500;
        }

        .hint {
            color: #777;
            font-size: 13px;
            margin-top: 8px;
        }

        .info {
            margin: 25px 0;
            padding: 15px;
            border-radius: 8px;
            background: #f7f7f7;
            line-height: 1.6;
        }

        .info strong {
            display: block;
            margin-bottom: 5px;
        }

        .status-options {
            display: flex;
            gap: 25px;
            margin: 15px 0 25px;
        }

        .status-options label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: normal;
            cursor: pointer;
        }

        .status-options input {
            width: auto;
            accent-color: #333;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 30px;
            background: #333;
            color: white;
            font: inherit;
            cursor: pointer;
            text-align: center;
        }

        .btn:hover { background: #555; }

        .btn-secondary {
            background: #eee;
            color: #222;
        }

        .btn-secondary:hover { background: #ddd; }

        .back {
            display: inline-block;
            margin-top: 18px;
            color: #555;
            text-decoration: none;
        }

        .error {
            color: #b42318;
            font-size: 13px;
            margin-top: 7px;
        }

        .success {
            padding: 13px;
            margin-bottom: 18px;
            border-radius: 8px;
            background: #ecfdf5;
        }

        .hidden { display: none; }
    </style>
</head>

<body>

@include('dinas.partials.header')

<main>
    <h2>Tambah Edukasi</h2>
    <p class="subtitle">
        Buat artikel kesehatan secara manual atau import dari PDF.
    </p>

    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="error" style="margin-bottom:18px">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="card">

        <div class="tabs">
            <button type="button" class="tab active"
                    id="tab-manual" onclick="showTab('manual')">
                Input Manual
            </button>

            <button type="button" class="tab"
                    id="tab-pdf" onclick="showTab('pdf')">
                Import PDF
            </button>
        </div>

        <!-- TAB IMPORT PDF -->
        <div id="panel-pdf" class="panel">

            <form action="{{ route('dinas.edukasi.import-pdf') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <div class="form-group">
                    <label>Import Dokumen PDF</label>

                    <label class="upload-box" for="pdf">
                        <div class="upload-icon">⇧</div>
                        <div class="upload-title">Pilih file PDF</div>
                        <div class="hint">
                            Teks PDF akan diubah menjadi draf artikel
                        </div>
                        <div id="pdf-name" class="hint"></div>
                    </label>

                    <input type="file"
                           name="pdf"
                           id="pdf"
                           accept=".pdf,application/pdf"
                           required
                           class="hidden"
                           onchange="showPdfName(this)">
                </div>

                <div class="info">
                    <strong>ⓘ Setelah PDF diimpor</strong>
                    Judul dan isi artikel dapat diperiksa serta diedit.
                    Gambar sampul juga bisa ditambahkan sebelum publikasi.
                </div>

                <button type="submit" class="btn">
                    Import dan Edit Artikel
                </button>
            </form>
        </div>

        <!-- TAB INPUT MANUAL / EDIT HASIL PDF -->
        <div id="panel-manual" class="panel active">

            @if(old('isi'))
                <div class="info">
                    <strong>Hasil Import PDF</strong>
                    Periksa dan edit isi artikel sebelum menyimpan.
                </div>
            @endif

            <form action="{{ route('dinas.edukasi.store') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <div class="form-group">
                    <label for="judul">Judul Artikel</label>
                    <input type="text"
                           name="judul"
                           id="judul"
                           value="{{ old('judul') }}"
                           placeholder="Masukkan judul artikel"
                           required>
                </div>

                <div class="form-group">
                    <label for="kategori">Kategori</label>

                    <select name="kategori" id="kategori" required>
                        <option value="">Pilih kategori</option>
                        <option value="umum" @selected(old('kategori') === 'umum')>Umum</option>
                        <option value="balita" @selected(old('kategori') === 'balita')>Balita</option>
                        <option value="ibu_hamil" @selected(old('kategori') === 'ibu_hamil')>Ibu Hamil</option>
                        <option value="lansia" @selected(old('kategori') === 'lansia')>Lansia</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="gambar">Gambar Sampul</label>
                    <input type="file"
                           name="gambar"
                           id="gambar"
                           accept="image/jpeg,image/png,image/webp">
                    <p class="hint">JPG, PNG, atau WebP. Maksimal 5 MB.</p>
                </div>

                <div class="form-group">
                    <label for="isi">Isi Artikel</label>
                    <textarea name="isi"
                              id="isi"
                              placeholder="Tuliskan isi artikel..."
                              required>{{ old('isi') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="tanggal_publikasi">
                        Tanggal Publikasi
                    </label>

                    <input type="date"
                           name="tanggal_publikasi"
                           id="tanggal_publikasi"
                           value="{{ old('tanggal_publikasi') }}">
                </div>

                <div class="form-group">
                    <label>Status Artikel</label>

                    <div class="status-options">
                        <label>
                            <input type="radio"
                                   name="status_aktif"
                                   value="0"
                                   @checked(old('status_aktif', '0') == '0')>
                            Draft
                        </label>

                        <label>
                            <input type="radio"
                                   name="status_aktif"
                                   value="1"
                                   @checked(old('status_aktif') == '1')>
                            Publikasikan
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn">
                    Simpan Artikel
                </button>
            </form>
        </div>

        <a href="{{ route('dinas.edukasi.index') }}" class="back">
            ← Kembali ke Daftar Edukasi
        </a>
    </div>
</main>


<input type="hidden"
       id="has-pdf-error"
       value="{{ $errors->has('pdf') ? '1' : '0' }}">

<script>
    function showTab(tab) {
        document.getElementById('panel-manual')
            .classList.toggle('active', tab === 'manual');

        document.getElementById('panel-pdf')
            .classList.toggle('active', tab === 'pdf');

        document.getElementById('tab-manual')
            .classList.toggle('active', tab === 'manual');

        document.getElementById('tab-pdf')
            .classList.toggle('active', tab === 'pdf');
    }

    function showPdfName(input) {
        const pdfName = document.getElementById('pdf-name');

        pdfName.textContent = input.files.length
            ? input.files[0].name
            : '';
    }

    const hasPdfError = document.getElementById('has-pdf-error').value;

    if (hasPdfError === '1') {
        showTab('pdf');
    }
</script>

</body>
</html>
