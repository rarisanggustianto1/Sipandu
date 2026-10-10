<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dinas\DinasDashboardController;
use App\Http\Controllers\Dinas\PuskesmasController;
use App\Http\Controllers\Dinas\EdukasiController;

Route::get('/', function () {
    return view('welcome');
});

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
