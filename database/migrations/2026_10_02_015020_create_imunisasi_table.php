<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('imunisasi', function (Blueprint $table) {
            $table->id();

            $table->foreignId('peserta_id')
                  ->constrained('peserta')
                  ->cascadeOnDelete();

            $table->string('jenis_imunisasi');
            $table->date('tanggal_jadwal')->nullable();
            $table->date('tanggal_pemberian')->nullable();

            $table->enum('status', [
                'terjadwal',
                'selesai',
                'terlewat'
            ])->default('terjadwal');

            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('imunisasi');
    }
};