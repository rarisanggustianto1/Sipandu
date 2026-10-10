<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemeriksaan_bumil', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pemeriksaan_id')
                  ->unique()
                  ->constrained('pemeriksaan')
                  ->cascadeOnDelete();

            $table->integer('usia_kehamilan')->nullable();
            $table->decimal('berat_badan', 5, 2)->nullable();
            $table->string('tekanan_darah', 10)->nullable();
            $table->decimal('tinggi_fundus', 5, 2)->nullable();
            $table->integer('denyut_jantung_janin')->nullable();
            $table->text('catatan_kehamilan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemeriksaan_bumil');
    }
};