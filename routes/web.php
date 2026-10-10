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

// Auth: login & logout (semua role)
Route::get('login', [LoginController::class, 'create'])->name('login')->middleware('guest');
Route::post('login', [LoginController::class, 'store'])->middleware('guest');
Route::post('logout', [LoginController::class, 'destroy'])->name('logout')->middleware('auth');

// Pendaftaran user posyandu (kader) melalui Dinas Kesehatan
Route::get('register', [RegisterController::class, 'create'])->name('register')->middleware(['auth', 'dinas']);
Route::post('register', [RegisterController::class, 'store'])->middleware(['auth', 'dinas']);

// Profil pengguna
Route::get('profile', [ProfileController::class, 'index'])->name('profile')->middleware('auth');
Route::put('profile', [ProfileController::class, 'update'])->middleware('auth');

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
