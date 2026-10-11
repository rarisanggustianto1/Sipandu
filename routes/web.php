<?php

use App\Http\Controllers\ProfileController;
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
