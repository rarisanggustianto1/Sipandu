<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kegiatan', function (Blueprint $table) {
            $table->id();

            $table->foreignId('posyandu_id')
                  ->constrained('posyandu')
                  ->cascadeOnDelete();

            $table->string('nama_kegiatan');
            $table->string('jenis_kegiatan');
            $table->text('deskripsi')->nullable();

            $table->date('tanggal_kegiatan');
            $table->time('waktu_mulai')->nullable();
            $table->string('lokasi')->nullable();

            $table->enum('status', [
                'terjadwal',
                'berlangsung',
                'selesai',
                'dibatalkan'
            ])->default('terjadwal');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kegiatan');
    }
};