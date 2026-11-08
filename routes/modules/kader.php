<?php

use App\Http\Controllers\Kader\DashboardController;
use App\Http\Controllers\Kader\ImunisasiController;
use App\Http\Controllers\Kader\JadwalKegiatanController;
use App\Http\Controllers\Kader\MonitoringController;
use App\Http\Controllers\Kader\PemeriksaanController;
use App\Http\Controllers\Kader\PesertaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Modul 3: Kader Posyandu
|--------------------------------------------------------------------------
| Hak akses: role 'kader' (atau alias 'kader_posyandu')
| Meliputi: Beranda statistik lapangan, registrasi peserta, form pemeriksaan antropometri, monitoring gizi, jadwal kegiatan, dan pencatatan imunisasi.
*/

Route::prefix('kader')
    ->middleware(['auth', 'role:kader'])
    ->name('kader.')
    ->group(function () {
        // Beranda Ringkasan Kader
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Manajemen Data Peserta Posyandu
        Route::get('peserta', [PesertaController::class, 'index'])->name('peserta.index');
        Route::get('peserta/create', [PesertaController::class, 'create'])->name('peserta.create');
        Route::get('peserta/{data}', [PesertaController::class, 'show'])->name('peserta.show');
        Route::post('peserta', [PesertaController::class, 'store'])->name('peserta.store');

        // Monitoring Perkembangan & Evaluasi
        Route::get('monitoring', [MonitoringController::class, 'index'])->name('monitoring.index');
        Route::get('monitoring/{kategori}', [MonitoringController::class, 'show'])->name('monitoring.show');

        // Pemeriksaan Rutin (Balita, Ibu Hamil, Lansia)
        Route::resource('pemeriksaan', PemeriksaanController::class)
            ->only(['index', 'create', 'store', 'show', 'destroy']);

        // Jadwal Posyandu ditetapkan Puskesmas; Kader menjalankan pertemuan dan absensi.
        Route::get('jadwal', [JadwalKegiatanController::class, 'index'])->name('jadwal.index');
        Route::get('jadwal/{id}', [JadwalKegiatanController::class, 'show'])->name('jadwal.show');
        Route::post('jadwal/{id}/mulai', [JadwalKegiatanController::class, 'start'])->name('jadwal.start');
        Route::post('jadwal/{id}/selesai', [JadwalKegiatanController::class, 'finish'])->name('jadwal.finish');
        Route::put('jadwal/{id}/absensi', [JadwalKegiatanController::class, 'attendance'])->name('jadwal.attendance');
        Route::post('jadwal/{id}/petugas/hadir', [JadwalKegiatanController::class, 'checkIn'])->name('jadwal.check-in');

        // Pencatatan Imunisasi & Vitamin
        Route::resource('imunisasi', ImunisasiController::class);
    });
