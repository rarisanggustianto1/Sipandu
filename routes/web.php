<?php

use Illuminate\Support\Facades\Route;

// Controller Auth & Profile
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileController;

// 1. Controller Modul Kader Posyandu (Sub-folder Kader)
use App\Http\Controllers\Kader\PemeriksaanController;
use App\Http\Controllers\Kader\JadwalKegiatanController;
use App\Http\Controllers\Kader\ImunisasiController;

// 2. Controller Modul Dinas Kesehatan (Sub-folder Dinas)
use App\Http\Controllers\Dinas\DinasDashboardController;
use App\Http\Controllers\Dinas\PuskesmasController;
use App\Http\Controllers\Dinas\EdukasiController;

// 3. Controller Modul Peserta / Keluarga (Sub-folder Peserta)
use App\Http\Controllers\Peserta\KeluargaController;
use App\Http\Controllers\Peserta\PesertaController;
use App\Http\Controllers\Peserta\PesertaDashboardController;

// 4. Controller Modul Puskesmas (Sub-folder Puskesmas)
use App\Http\Controllers\Puskesmas\PosyanduController;
use App\Http\Controllers\Puskesmas\PengaduanController;
use App\Http\Controllers\Puskesmas\PuskesmasDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Redirect Otomatis ke Halaman Utama Kader
Route::get('/dashboard', function () {
    return redirect()->route('kader.pemeriksaan.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// ROUTE MODUL KADER POSYANDU (Punya Kamu)
Route::prefix('kader')->name('kader.')->group(function () {
    Route::resource('pemeriksaan', PemeriksaanController::class);
    Route::resource('jadwal', JadwalKegiatanController::class);
    Route::resource('imunisasi', ImunisasiController::class);
});

// ROUTE MODUL DINAS KESEHATAN (Punya Dila)
Route::prefix('dinas')->name('dinas.')->group(function () {
    Route::get('/', [DinasDashboardController::class, 'index'])->name('dashboard');
    Route::resource('puskesmas', PuskesmasController::class)->except(['show']);
    Route::resource('edukasi', EdukasiController::class)->except(['show']);
});

// ROUTE MODUL PUSKESMAS (Punya Deva)
Route::prefix('puskesmas')
    ->middleware(['auth', 'puskesmas'])
    ->name('puskesmas.')
    ->group(function () {
        Route::get('dashboard', [PuskesmasDashboardController::class, 'index'])->name('dashboard');
        Route::apiResource('posyandu', PosyanduController::class);
        Route::apiResource('pengaduan', PengaduanController::class)->only(['index', 'show', 'update']);
        Route::get('kader', [RegisterController::class, 'create'])->name('kader.create');
        Route::post('kader', [RegisterController::class, 'store'])->name('kader.store');
    });

// ROUTE MODUL PESERTA / KELUARGA (Punya Ketrin)
Route::prefix('peserta')->name('peserta.')->group(function () {
    Route::get('/', [PesertaDashboardController::class, 'index'])->name('dashboard');
    Route::resource('keluarga', KeluargaController::class);
    Route::resource('data', PesertaController::class);
});