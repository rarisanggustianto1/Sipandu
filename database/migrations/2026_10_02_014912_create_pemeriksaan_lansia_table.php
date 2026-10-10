<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemeriksaan_lansia', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pemeriksaan_id')
                  ->unique()
                  ->constrained('pemeriksaan')
                  ->cascadeOnDelete();

            $table->string('tekanan_darah', 10)->nullable();
            $table->decimal('gula_darah', 6, 2)->nullable();
            $table->decimal('kolesterol', 6, 2)->nullable();
            $table->decimal('asam_urat', 5, 2)->nullable();
            $table->decimal('berat_badan', 5, 2)->nullable();
            $table->text('catatan_kesehatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemeriksaan_lansia');
    }
};