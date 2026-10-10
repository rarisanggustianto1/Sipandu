<?php

use App\Http\Controllers\Peserta\KeluargaController;
use App\Http\Controllers\Peserta\PesertaController;
use App\Http\Controllers\Peserta\PesertaDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('peserta')->name('peserta.')->group(function () {

    Route::get('/', PesertaDashboardController::class)->name('dashboard');

    Route::resource('keluarga', KeluargaController::class);

    Route::resource('data', PesertaController::class);
});
