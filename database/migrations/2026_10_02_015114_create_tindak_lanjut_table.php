<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tindak_lanjut', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pemeriksaan_id')
                  ->constrained('pemeriksaan')
                  ->cascadeOnDelete();

            $table->date('tanggal_pengajuan');

            $table->text('alasan_tindak_lanjut');

            $table->string('jenis_tindak_lanjut')->nullable();

            $table->date('tanggal_tindak_lanjut')->nullable();

            $table->enum('status', [
                'diajukan',
                'diproses',
                'selesai'
            ])->default('diajukan');

            $table->text('hasil_tindak_lanjut')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tindak_lanjut');
    }
};