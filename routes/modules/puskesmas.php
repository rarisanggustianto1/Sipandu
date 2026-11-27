<?php

use App\Http\Controllers\Puskesmas\DashboardController;
use App\Http\Controllers\Puskesmas\ImunisasiController;
use App\Http\Controllers\Puskesmas\KaderController;
use App\Http\Controllers\Puskesmas\KegiatanController;
use App\Http\Controllers\Puskesmas\LaporanBulananController;
use App\Http\Controllers\Puskesmas\PesertaController;
use App\Http\Controllers\Puskesmas\PosyanduController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Modul 2: Puskesmas (Tenaga Kesehatan)
|--------------------------------------------------------------------------
| Hak akses: role 'tenaga_kesehatan' (atau alias 'puskesmas') dengan penugasan puskesmas_id
| Meliputi: Dashboard operasional, master data Posyandu binaan, manajemen akun Kader, agenda, dan laporan bulanan.
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

        // Agenda kegiatan, imunisasi, dan pelaporan bulanan ke Dinas
        Route::resource('kegiatan', KegiatanController::class);
        Route::resource('imunisasi', ImunisasiController::class)->except(['show']);
        Route::get('laporan-bulanan', [LaporanBulananController::class, 'index'])->name('laporan-bulanan.index');
        Route::get('laporan-bulanan/create', [LaporanBulananController::class, 'create'])->name('laporan-bulanan.create');
        Route::post('laporan-bulanan', [LaporanBulananController::class, 'store'])->name('laporan-bulanan.store');
        Route::get('laporan-bulanan/{laporanBulanan}', [LaporanBulananController::class, 'show'])->name('laporan-bulanan.show');
        Route::put('laporan-bulanan/{laporanBulanan}', [LaporanBulananController::class, 'update'])->name('laporan-bulanan.update');
        Route::put('laporan-bulanan/{laporanBulanan}/refresh', [LaporanBulananController::class, 'refresh'])->name('laporan-bulanan.refresh');
        Route::post('laporan-bulanan/{laporanBulanan}/submit', [LaporanBulananController::class, 'submit'])->name('laporan-bulanan.submit');

        // Pendaftaran Akun Kader
        Route::get('kader', [KaderController::class, 'index'])->name('kader.index');
        Route::get('kader/create', [KaderController::class, 'create'])->name('kader.create');
        Route::post('kader', [KaderController::class, 'store'])->name('kader.store');
    });
