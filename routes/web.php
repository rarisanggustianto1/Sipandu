<?php

use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\PosyanduController;
use App\Http\Controllers\PuskesmasDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Modul Wilayah & Pengaduan — Admin Puskesmas (Deva)
Route::prefix('puskesmas')
    ->middleware(['auth', 'puskesmas'])
    ->name('puskesmas.')
    ->group(function () {
        Route::get('dashboard', [PuskesmasDashboardController::class, 'index'])->name('dashboard');

        // CRUD Posyandu (wilayah kerja puskesmas)
        Route::apiResource('posyandu', PosyanduController::class);

        // Pengaduan: list, detail, dan tanggapan (response) dari Puskesmas
        Route::apiResource('pengaduan', PengaduanController::class)
            ->only(['index', 'show', 'update']);
    });
