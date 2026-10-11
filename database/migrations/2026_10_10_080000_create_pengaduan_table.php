<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaduan', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pelapor_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            $table->foreignId('posyandu_id')
                  ->nullable()
                  ->constrained('posyandu')
                  ->nullOnDelete();

            $table->string('judul');
            $table->text('deskripsi');

            $table->enum('jenis', ['layanan', 'fasilitas', 'kader', 'lainnya'])
                  ->default('layanan');

            $table->enum('status', ['baru', 'diproses', 'selesai'])
                  ->default('baru');

            $table->text('tanggapan_puskesmas')->nullable();

            $table->timestamps();

            $table->index(['status', 'posyandu_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaduan');
    }
};
