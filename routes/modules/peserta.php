<?php

use App\Http\Controllers\Peserta\EdukasiController;
use App\Http\Controllers\Peserta\KeluargaController;
use App\Http\Controllers\Peserta\PesertaController;
use App\Http\Controllers\Peserta\PesertaDashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Modul 4: Peserta / Keluarga
|--------------------------------------------------------------------------
| Hak akses: role 'keluarga' (atau alias 'peserta')
| Meliputi: Beranda keluarga, kartu kesehatan digital, KMS balita, riwayat pemeriksaan, dan artikel edukasi kesehatan.
*/

Route::prefix('peserta')
    ->middleware(['auth', 'role:keluarga'])
    ->name('peserta.')
    ->group(function () {
        // Beranda Keluarga
        Route::get('/', PesertaDashboardController::class)->name('dashboard');

        // Profil Kepala Keluarga & Anggota
        Route::get('keluarga', [KeluargaController::class, 'index'])->name('keluarga.index');
        Route::get('keluarga/{keluarga}/edit', [KeluargaController::class, 'edit'])->name('keluarga.edit');
        Route::put('keluarga/{keluarga}', [KeluargaController::class, 'update'])->name('keluarga.update');

        // Rekam Medis (KMS Digital) & Data Kesehatan
        Route::resource('data', PesertaController::class)->only(['index', 'create', 'store', 'show']);

        // Materi & Edukasi Kesehatan
        Route::get('edukasi', [EdukasiController::class, 'index'])->name('edukasi.index');
        Route::get('edukasi/{id}', [EdukasiController::class, 'show'])->name('edukasi.show');
    });
