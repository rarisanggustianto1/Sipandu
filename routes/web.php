<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\PosyanduController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PuskesmasDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
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
