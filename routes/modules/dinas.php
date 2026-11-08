<?php

use App\Http\Controllers\Dinas\DinasDashboardController;
use App\Http\Controllers\Dinas\EdukasiController;
use App\Http\Controllers\Dinas\PuskesmasController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Modul 1: Dinas Kesehatan
|--------------------------------------------------------------------------
| Hak akses: role 'dinas_kesehatan' (atau alias 'dinas')
| Meliputi: Pemantauan agregat wilayah, manajemen Puskesmas, edukasi kesehatan, dan rekapitulasi laporan.
*/

Route::prefix('dinas')
    ->middleware(['auth', 'role:dinas_kesehatan'])
    ->name('dinas.')
    ->group(function () {
        // Dashboard Ringkasan Wilayah
        Route::get('/', [DinasDashboardController::class, 'index'])->name('dashboard');

        // Pengelolaan Puskesmas
        Route::resource('puskesmas', PuskesmasController::class)->except(['show']);

        // Edukasi Kesehatan & Ekstraksi PDF
        Route::post('edukasi/import-pdf', [EdukasiController::class, 'importPdf'])->name('edukasi.import-pdf');
        Route::resource('edukasi', EdukasiController::class)->except(['show']);

        // Laporan Rekapitulasi Wilayah
        Route::view('laporan', 'dinas.laporan.index')->name('laporan.index');
    });

