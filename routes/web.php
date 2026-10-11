<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\PosyanduController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PuskesmasDashboardController;
use App\Http\Controllers\Peserta\KeluargaController;
use App\Http\Controllers\Peserta\PesertaController;
use App\Http\Controllers\Peserta\PesertaDashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dinas\DinasDashboardController;
use App\Http\Controllers\Dinas\PuskesmasController;
use App\Http\Controllers\Dinas\EdukasiController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return redirect()->route('kader.pemeriksaan.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
// Route Dinas Kesehatan
Route::prefix('dinas')->name('dinas.')->group(function () {

    // Dashboard Dinas Kesehatan
    Route::get('/', [DinasDashboardController::class, 'index'])
        ->name('dashboard');

    // CRUD Puskesmas
    Route::resource('puskesmas', PuskesmasController::class)
        ->except(['show']);
    
   //CRUD Edukasi
    Route::resource('edukasi', EdukasiController::class)
        ->except(['show']);

});
Route::get('login', [LoginController::class, 'create'])->name('login')->middleware('guest');
Route::post('login', [LoginController::class, 'store'])->middleware('guest');
Route::post('logout', [LoginController::class, 'destroy'])->name('logout')->middleware('auth');

Route::get('profile', [ProfileController::class, 'index'])->name('profile')->middleware('auth');
Route::put('profile', [ProfileController::class, 'update'])->middleware('auth');

Route::prefix('puskesmas')
    ->middleware(['auth', 'puskesmas'])
    ->name('puskesmas.')
    ->group(function () {
        Route::get('dashboard', [PuskesmasDashboardController::class, 'index'])->name('dashboard');

        Route::apiResource('posyandu', PosyanduController::class);

        Route::apiResource('pengaduan', PengaduanController::class)
            ->only(['index', 'show', 'update']);

        Route::get('kader', [RegisterController::class, 'create'])->name('kader.create');
        Route::post('kader', [RegisterController::class, 'store'])->name('kader.store');
    });
Route::prefix('peserta')->name('peserta.')->group(function () {

    Route::get('/', PesertaDashboardController::class)->name('dashboard');

    Route::resource('keluarga', KeluargaController::class);

    Route::resource('data', PesertaController::class);
});
