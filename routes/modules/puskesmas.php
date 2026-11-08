<?php

use App\Http\Controllers\Puskesmas\DashboardController;
use App\Http\Controllers\Puskesmas\ImunisasiController;
use App\Http\Controllers\Puskesmas\KegiatanController;
use App\Http\Controllers\Puskesmas\KaderController;
use App\Http\Controllers\Puskesmas\PengaduanController;
use App\Http\Controllers\Puskesmas\PesertaController;
use App\Http\Controllers\Puskesmas\PosyanduController;
use App\Http\Controllers\Puskesmas\TindakLanjutController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Modul 2: Puskesmas (Tenaga Kesehatan)
|--------------------------------------------------------------------------
| Hak akses: role 'tenaga_kesehatan' (atau alias 'puskesmas') dengan penugasan puskesmas_id
| Meliputi: Dashboard operasional, master data Posyandu binaan, manajemen akun Kader, dan respon aduan masyarakat.
*/

Route::prefix('puskesmas')
    ->middleware(['auth', 'puskesmas'])
    ->name('puskesmas.')
    ->group(function () {
        // Dashboard Operasional Puskesmas
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Master Data Posyandu
        Route::get('posyandu', [PosyanduController::class, 'index'])->name('posyandu.index');
        Route::get('posyandu/create', [PosyanduController::class, 'create'])->name('posyandu.create');
        Route::post('posyandu', [PosyanduController::class, 'store'])->name('posyandu.store');

        // Data Peserta dan Kartu Kesehatan
        Route::get('peserta', [PesertaController::class, 'index'])->name('peserta.index');
        Route::get('peserta/{data}', [PesertaController::class, 'show'])->name('peserta.show');
        Route::get('monitoring', [PesertaController::class, 'index'])->name('monitoring.index');

        // Kegiatan, imunisasi, dan tindak lanjut kesehatan
        Route::resource('kegiatan', KegiatanController::class);
        Route::resource('imunisasi', ImunisasiController::class)->except(['show']);
        Route::get('tindak-lanjut', [TindakLanjutController::class, 'index'])->name('tindak-lanjut.index');
        Route::put('tindak-lanjut/{id}', [TindakLanjutController::class, 'update'])->name('tindak-lanjut.update');

        // Pengaduan & Layanan Masyarakat
        Route::get('pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
        Route::get('pengaduan/{pengaduan}', [PengaduanController::class, 'show'])->name('pengaduan.show');
        Route::put('pengaduan/{pengaduan}', [PengaduanController::class, 'update'])->name('pengaduan.update');

        // Pendaftaran Akun Kader
        Route::get('kader', [KaderController::class, 'index'])->name('kader.index');
        Route::get('kader/create', [KaderController::class, 'create'])->name('kader.create');
        Route::post('kader', [KaderController::class, 'store'])->name('kader.store');
    });
