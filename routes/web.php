<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Puskesmas\DashboardController;
use App\Http\Controllers\Puskesmas\KaderController;
use App\Http\Controllers\Puskesmas\PengaduanController;
use App\Http\Controllers\Puskesmas\PosyanduController;
use App\Http\Controllers\Kader\PemeriksaanController;
use App\Http\Controllers\Kader\JadwalKegiatanController;
use App\Http\Controllers\Kader\ImunisasiController;
use App\Http\Controllers\Dinas\DinasDashboardController;
use App\Http\Controllers\Dinas\PuskesmasController as DinasPuskesmasController;
use App\Http\Controllers\Dinas\EdukasiController as DinasEdukasiController;
use App\Http\Controllers\Peserta\KeluargaController;
use App\Http\Controllers\Peserta\PesertaController;
use App\Http\Controllers\Peserta\PesertaDashboardController;
use App\Http\Controllers\Peserta\EdukasiController as PesertaEdukasiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (! auth()->check()) {
        return redirect()->route('login');
    }

    $user = auth()->user();

    return match ($user->role) {
        'dinas_kesehatan' => redirect()->route('dinas.dashboard'),
        'tenaga_kesehatan' => $user->puskesmas_id
            ? redirect()->route('puskesmas.dashboard')
            : redirect()->route('profile'),
        'kader' => redirect()->route('kader.pemeriksaan.index'),
        default => redirect()->route('profile'),
    };
});

Route::get('/dashboard', function () {
    return redirect('/');
})->middleware('auth')->name('dashboard');

Route::get('login', [LoginController::class, 'create'])->name('login')->middleware('guest');
Route::post('login', [LoginController::class, 'store'])->middleware('guest');
Route::post('logout', [LoginController::class, 'destroy'])->name('logout')->middleware('auth');

Route::get('profile', [ProfileController::class, 'index'])->name('profile')->middleware('auth');
Route::put('profile', [ProfileController::class, 'update'])->middleware('auth');

// Modul Puskesmas
Route::prefix('puskesmas')
    ->middleware(['auth', 'puskesmas'])
    ->name('puskesmas.')
    ->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('posyandu', [PosyanduController::class, 'index'])->name('posyandu.index');
        Route::get('posyandu/create', [PosyanduController::class, 'create'])->name('posyandu.create');
        Route::post('posyandu', [PosyanduController::class, 'store'])->name('posyandu.store');

        Route::get('pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
        Route::get('pengaduan/{pengaduan}', [PengaduanController::class, 'show'])->name('pengaduan.show');
        Route::put('pengaduan/{pengaduan}', [PengaduanController::class, 'update'])->name('pengaduan.update');

        Route::get('kader/create', [KaderController::class, 'create'])->name('kader.create');
        Route::post('kader', [KaderController::class, 'store'])->name('kader.store');
    });

// Modul Kader Posyandu
Route::prefix('kader')
    ->middleware('auth')
    ->name('kader.')
    ->group(function () {
        Route::resource('pemeriksaan', PemeriksaanController::class);
        Route::resource('jadwal', JadwalKegiatanController::class);
        Route::resource('imunisasi', ImunisasiController::class);
    });

// Modul Dinas Kesehatan
Route::prefix('dinas')
    ->middleware('auth')
    ->name('dinas.')
    ->group(function () {
        Route::get('/', [DinasDashboardController::class, 'index'])->name('dashboard');
        Route::resource('puskesmas', DinasPuskesmasController::class)->except(['show']);
        Route::post('edukasi/import-pdf', [DinasEdukasiController::class, 'importPdf'])->name('edukasi.import-pdf');
        Route::resource('edukasi', DinasEdukasiController::class)->except(['show']);
        Route::view('laporan', 'dinas.laporan.index')->name('laporan.index');
    });

// Modul Peserta / Keluarga
Route::prefix('peserta')
    ->middleware('auth')
    ->name('peserta.')
    ->group(function () {
        Route::get('/', PesertaDashboardController::class)->name('dashboard');
        Route::resource('keluarga', KeluargaController::class);
        Route::resource('data', PesertaController::class);
        Route::get('edukasi', [PesertaEdukasiController::class, 'index'])->name('edukasi.index');
        Route::get('edukasi/{id}', [PesertaEdukasiController::class, 'show'])->name('edukasi.show');
    });
