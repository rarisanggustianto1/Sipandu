# SIPANDU - PANDUAN PENGEMBANGAN UI, ALUR TERMINAL, & PULL REQUEST (PR)

## SIPANDU: INTEGRASI BRANCH BERHASIL (MAIN BRANCH IS LIVE)

Seluruh kodingan **Controller, Routes, dan Database Migration** dari modul Dinas Kesehatan, Puskesmas, Kader Posyandu, dan Peserta/Keluarga telah resmi digabungkan ke branch `main`.

---

## 1. KONSEP PENGEMBANGAN BERBASIS MODUL (MODULAR DEVELOPMENT)

Proyek SIPANDU menggunakan metode pengerjaan terisolasi berbasis modul. Setiap anggota tim memegang penuh tanggung jawab satu domain/role. Dengan pendekatan ini, pengembangan UI Blade tidak perlu menunggu modul lain selesai 100% dan dapat diuji secara mandiri.

---

## 2. STRUKTUR MODUL & PEMBAGIAN TUGAS TIM

| Anggota | Modul / Peran | Folder Lokasi Blade View | Branch Fitur Git |
|---------|---------------|--------------------------|------------------|
| Dila | Dinas Kesehatan | `resources/views/dinas/` | `feature/dinas-kesehatan` |
| Deva | Puskesmas | `resources/views/puskesmas/` | `feature/puskesmas` |
| Raris (Ketua) | Kader Posyandu | `resources/views/kader/` | `feature/kader-posyandu` |
| Ketrin | Peserta/Keluarga | `resources/views/peserta/` | `feature/keluarga-peserta` |

---

## 3. PERINTAH TERMINAL SINKRONISASI AWAL (WAJIB DIJALANKAN)

Sebelum mulai mengedit atau membuat file UI Blade, jalankan perintah ini di VS Code agar kodingan di laptopmu sinkron dengan branch `main`:

```bash
# 1. Pindah ke branch main dan tarik pembaruan dari GitHub
git checkout main
git pull origin main

# 2. Pindah kembali ke branch fitur kamu & gabungkan pembaruan
# Dila
git checkout feature/dinas-kesehatan
git merge main
# Deva
git checkout feature/puskesmas
git merge main
# Raris
git checkout feature/kader-posyandu
git merge main
# Ketrin
git checkout feature/keluarga-peserta
git merge main
```

---

## 4. DETAIL PEMBUATAN VIEW BLADE: MODUL DINAS & PUSKESMAS

### Dila — Modul Dinas Kesehatan

**Folder:** `resources/views/dinas/`

| File | Keterangan |
|------|------------|
| `dashboard.blade.php` | Tampilan ringkasan statistik & grafik cakupan posyandu/puskesmas tingkat kabupaten/kota |
| `puskesmas/index.blade.php` | Tabel daftar Puskesmas binaan lengkap dengan alamat & kontak penanggung jawab |
| `puskesmas/create.blade.php` | Form registrasi unit Puskesmas baru ke dalam sistem |
| `puskesmas/edit.blade.php` | Form pembaruan data dan informasi profil Puskesmas |
| `edukasi/index.blade.php` | Daftar materi, banner, dan artikel edukasi kesehatan masyarakat |
| `edukasi/create.blade.php` | Form publikasi artikel dan materi edukasi kesehatan baru |

### Deva — Modul Puskesmas

**Folder:** `resources/views/puskesmas/`

| File | Keterangan |
|------|------------|
| `dashboard.blade.php` | Dashboard pemantauan wilayah kerja Puskesmas & ringkasan data posyandu |
| `posyandu/index.blade.php` | Tabel daftar Posyandu binaan yang berada di bawah pengawasan Puskesmas |
| `posyandu/create.blade.php` | Form pendaftaran Posyandu baru beserta lokasi wilayah kerjanya |
| `pengaduan/index.blade.php` | Daftar laporan & pengaduan layanan dari masyarakat/peserta |
| `pengaduan/show.blade.php` | Halaman rincian pengaduan & form pemberian tanggapan/tindak lanjut |
| `kader/create.blade.php` | Form pendaftaran & pembuatan akun login resmi untuk Kader Posyandu |

### Raris — Modul Kader Posyandu

**Folder:** `resources/views/kader/`

| File | Keterangan |
|------|------------|
| `pemeriksaan/index.blade.php` | Tabel riwayat pencatatan pengukuran BB, TB, LK, & status gizi balita |
| `pemeriksaan/create.blade.php` | Form entri data hasil penimbangan & pemeriksaan balita di Posyandu |
| `jadwal/index.blade.php` | Kalender/tabel penanggalan kegiatan operasional Posyandu bulanan |
| `jadwal/create.blade.php` | Form pembuatan jadwal kegiatan Posyandu & penentuan lokasi |
| `imunisasi/index.blade.php` | Rekapitulasi pemberian imunisasi, vaksin, & vitamin pada anak |
| `imunisasi/create.blade.php` | Form pencatatan jenis imunisasi yang diberikan kepada balita |

### Ketrin — Modul Peserta / Keluarga

**Folder:** `resources/views/peserta/`

| File | Keterangan |
|------|------------|
| `dashboard.blade.php` | Ringkasan status gizi anak, grafik Kartu Menuju Sehat (KMS), & pengumuman |
| `keluarga/index.blade.php` | Profil Kartu Keluarga (KK), data orang tua, & daftar anak terdaftar |
| `keluarga/edit.blade.php` | Form pembaruan informasi profil anggota keluarga & kontak |
| `data/index.blade.php` | Daftar riwayat pemeriksaan tumbuh kembang balita secara periodik |
| `data/show.blade.php` | Tampilan rincian rekam medis balita, status imunisasi, & catatan kader |

---

## 5. ATURAN PENGGUNAAN LAYOUT UTAMA

> ⚠️ **PENTING: Cek layout yang dipakai!**

Saat ini proyek menggunakan **layout kustom** (`resources/views/layouts/app.blade.php`), **bukan** komponen Breeze. Pastikan setiap file Blade modul menggunakan sintaks berikut:

```blade
@extends('layouts.app')

@section('title', 'Judul Halaman')

@section('content')
    <!-- Isi halaman Anda di sini -->
@endsection
```

**Jangan** membuat struktur `<html>` atau `<body>` secara terpisah di awal file Blade Anda. Jangan menggunakan `<x-app-layout>` (itu untuk layout bawaan Breeze yang tidak dipakai proyek ini).

---

## 6. DESIGN SYSTEM & PALETTE WARNA UTAMA

| Warna | Kode Hex |
|-------|----------|
| Teal Primary | `#0d9488` |
| Emerald Green | `#10b981` |
| Soft Coral | `#f43f5e` |
| Soft Blue | `#3b82f6` |

Gunakan warna-warna ini untuk tombol, badge, header, dan elemen UI lainnya agar tampilan konsisten.

---

## 7. STANDAR KODE PEMASANGAN LOGO SIPANDU PADA NAVIGATION HEADER

Gunakan potongan kode Blade standar di bawah ini pada setiap halaman modul agar Logo SIPANDU tampil seragam di sudut kiri atas halaman:

```blade
<!-- Kode Standar Logo Navbar SIPANDU -->
<div class="flex items-center gap-3">
    <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
        <img src="https://lh3.googleusercontent.com/gg/AJWXcNe-anVwUDrx9Ywxmk4FSfw1EBSe0Ycz5x3J0TVa6u7zWQLpZ9xKLzGQot.fH0QT4VwC3oK18X1mV090cFEdSmc1ZUTawXVwkFFKDntuhNmASarwH-ThzAB13EEKKxe515e70DC17JFVpMzo5FZkFkPH9nBnaSMcrFOmdLVnGbFKn3x9qtjpyfN7R2G6SsoM0xNx2DLYi9MV0nYLN4kVn7178rFinaq12ed02LgaC03JYYfniGvI6p9IuqDPB05sqPuccxnCLSGsGpgt_qYXWPAey_LZxl9g2E=s0" alt="Logo SIPANDU" class="h-10 w-auto object-contain">
        <span class="font-bold text-lg text-teal-800 tracking-tight">SiPANDU</span>
    </a>
</div>
```

---

## 8. CATATAN PENGUJIAN LOKAL SERVER

Setelah membuat file `.blade.php`, pastikan server lokal berjalan dengan `php artisan serve`. Jika halaman tidak muncul, bersihkan cache route:

```bash
php artisan route:clear
php artisan view:clear
php artisan serve
```

**Akses via browser:**

- Dinas: `http://127.0.0.1:8000/dinas`
- Puskesmas: `http://127.0.0.1:8000/puskesmas/dashboard`

---

## 9. FORMAT PERINTAH GIT PUSH DI TERMINAL

Setelah selesai mengerjakan file UI Blade di laptop masing-masing, jalankan perintah ini di terminal VS Code untuk mengunggah perubahan ke GitHub:

```bash
# 1. Cek file mana saja yang baru dibuat/diubah
git status

# 2. Daftarkan seluruh perubahan file
git add .

# 3. Commit dengan pesan standar (sesuai modul):
git commit -m "feat(puskesmas): selesai tampilan UI posyandu & registrasi kader"

# 4. Push ke branch fitur kamu sendiri di GitHub
git push origin [nama-branch-fitur-kamu]
```

---

## 10. PANDUAN LANGKAH-DEMI-LANGKAH PULL REQUEST (PR) DI GITHUB

1. **Akses Repository GitHub:** Buka link repository Sipandu di browser setelah menjalankan perintah `git push` di terminal.
2. **Klik Tombol Pull Request:** Klik banner kuning bertuliskan **„Compare & pull request“** di halaman depan, ATAU buka tab **Pull requests** lalu klik tombol hijau **New pull request**.
3. **Pengaturan Branch Target (CRITICAL):** Pastikan konfigurasi posisi branch sasaran adalah:
   - **base:** `main`
   - **compare:** `feature/[nama-branch-fitur-kamu]`
4. **Cek Status Conflict:** Pastikan muncul indikator hijau bertuliskan **„Able to merge“**. Jika berwarna merah/conflict, lakukan `git pull origin main` di laptopmu terlebih dahulu (lalu `git merge main` di branch fitur).
5. **Isi Judul & Deskripsi PR:** Tuliskan judul baku, contoh: `feat(puskesmas): Tampilan UI Posyandu & Registrasi Kader`. Jelaskan secara singkat daftar file `.blade.php` yang kamu buat.
6. **Submit & Kabari Ketua Tim:** Klik tombol hijau **Create pull request**. Informasikan kepada **Raris (Ketua Tim)** bahwa PR kamu sudah dikirim untuk direview dan di-merge ke branch `main`.

---

## 11. PROSEDUR SETELAH PULL REQUEST DI-MERGE (POST-MERGE SYNC)

> **WAJIB: SINKRONISASI SETELAH PR BERHASIL DI-MERGE**

Setiap kali PR salah satu anggota tim disetujui dan digabungkan ke `main` oleh Raris, anggota tim lainnya **WAJIB** langsung melakukan:

```bash
git checkout main
git pull origin main
```

Agar UI milik teman otomatis masuk ke lingkungan lokal mereka.

---

> **Catatan Tim:** Jika ada pertanyaan atau kendala, kabari ketua tim atau buat diskusi di Pull Request masing-masing.
