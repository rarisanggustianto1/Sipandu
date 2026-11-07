<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Puskesmas\DashboardController;
use App\Http\Controllers\Puskesmas\KaderController;
use App\Http\Controllers\Puskesmas\PengaduanController;
use App\Http\Controllers\Puskesmas\PosyanduController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (! auth()->check()) {
        return redirect()->route('login');
    }

    return auth()->user()->role === 'tenaga_kesehatan'
        ? redirect()->route('puskesmas.dashboard')
        : redirect()->route('profile');
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
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Posyandu
        Route::get('posyandu', [PosyanduController::class, 'index'])->name('posyandu.index');
        Route::get('posyandu/create', [PosyanduController::class, 'create'])->name('posyandu.create');
        Route::post('posyandu', [PosyanduController::class, 'store'])->name('posyandu.store');

        // Pengaduan
        Route::get('pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
        Route::get('pengaduan/{pengaduan}', [PengaduanController::class, 'show'])->name('pengaduan.show');
        Route::put('pengaduan/{pengaduan}', [PengaduanController::class, 'update'])->name('pengaduan.update');

        // Kader
        Route::get('kader/create', [KaderController::class, 'create'])->name('kader.create');
        Route::post('kader', [KaderController::class, 'store'])->name('kader.store');
    });