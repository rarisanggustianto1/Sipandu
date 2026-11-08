<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes — Bootstrap File
|--------------------------------------------------------------------------
| File ini hanya berisi rute utama (home/dashboard redirect) dan
| mem-require setiap file modul secara terpisah.
|
| Struktur Modul:
|   routes/modules/auth.php     → Login, logout, profil
|   routes/modules/dinas.php    → Modul 1: Dinas Kesehatan
|   routes/modules/puskesmas.php→ Modul 2: Puskesmas / Tenaga Kesehatan
|   routes/modules/kader.php    → Modul 3: Kader Posyandu
|   routes/modules/peserta.php  → Modul 4: Peserta / Keluarga
*/

// -------------------------------------------------------------------------
// Rute Utama: Redirect ke dashboard sesuai role pengguna
// -------------------------------------------------------------------------
Route::get('/', function () {
    if (! auth()->check()) {
        return redirect()->route('login');
    }

    $user = auth()->user();

    return match ($user->role) {
        'dinas_kesehatan', 'dinas'      => redirect()->route('dinas.dashboard'),
        'tenaga_kesehatan', 'puskesmas' => $user->puskesmas_id
                                            ? redirect()->route('puskesmas.dashboard')
                                            : redirect()->route('profile'),
        'kader', 'kader_posyandu'       => redirect()->route('kader.dashboard'),
        'keluarga', 'peserta'           => redirect()->route('peserta.dashboard'),
        default                         => redirect()->route('profile'),
    };
})->name('home');

Route::get('/dashboard', function () {
    return redirect('/');
})->middleware('auth')->name('dashboard');

// -------------------------------------------------------------------------
// Muat Modul-Modul Rute
// -------------------------------------------------------------------------
require __DIR__ . '/modules/auth.php';
require __DIR__ . '/modules/dinas.php';
require __DIR__ . '/modules/puskesmas.php';
require __DIR__ . '/modules/kader.php';
require __DIR__ . '/modules/peserta.php';
