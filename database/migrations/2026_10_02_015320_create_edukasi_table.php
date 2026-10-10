<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('edukasi', function (Blueprint $table) {
            $table->id();

            $table->string('judul');
            $table->text('isi');

            $table->enum('kategori', [
                'umum',
                'balita',
                'ibu_hamil',
                'lansia'
            ])->default('umum');

            $table->string('gambar')->nullable();
            $table->date('tanggal_publikasi')->nullable();
            $table->boolean('status_aktif')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('edukasi');
    }
};