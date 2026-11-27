<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (! auth()->check()) {
        return view('welcome');
    }

    $user = auth()->user();

    return match ($user->role) {
        'dinas_kesehatan', 'dinas' => redirect()->route('dinas.dashboard'),
        'tenaga_kesehatan', 'puskesmas' => $user->puskesmas_id
                                            ? redirect()->route('puskesmas.dashboard')
                                            : redirect()->route('profile'),
        'kader', 'kader_posyandu' => redirect()->route('kader.dashboard'),
        'keluarga', 'peserta' => redirect()->route('peserta.dashboard'),
        default => redirect()->route('profile'),
    };
})->name('home');

Route::get('/dashboard', function () {
    return redirect('/');
})->middleware('auth')->name('dashboard');

// -------------------------------------------------------------------------
// Muat Modul-Modul Rute
// -------------------------------------------------------------------------
require __DIR__.'/modules/auth.php';
require __DIR__.'/modules/dinas.php';
require __DIR__.'/modules/puskesmas.php';
require __DIR__.'/modules/kader.php';
require __DIR__.'/modules/peserta.php';
