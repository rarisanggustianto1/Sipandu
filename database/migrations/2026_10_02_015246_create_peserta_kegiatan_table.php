<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peserta_kegiatan', function (Blueprint $table) {
            $table->id();

            $table->foreignId('kegiatan_id')
                  ->constrained('kegiatan')
                  ->cascadeOnDelete();

            $table->foreignId('peserta_id')
                  ->constrained('peserta')
                  ->cascadeOnDelete();

            $table->enum('status_kehadiran', [
                'terdaftar',
                'hadir',
                'tidak_hadir'
            ])->default('terdaftar');

            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->unique(['kegiatan_id', 'peserta_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peserta_kegiatan');
    }
};