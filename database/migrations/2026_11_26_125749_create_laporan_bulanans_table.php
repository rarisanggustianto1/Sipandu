<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_bulanan', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('puskesmas_id')->constrained('puskesmas')->cascadeOnDelete();
            $table->unsignedSmallInteger('tahun');
            $table->unsignedTinyInteger('bulan');
            $table->json('data');
            $table->text('catatan')->nullable();
            $table->string('status', 20)->default('draft');
            $table->timestamp('dikirim_pada')->nullable();
            $table->timestamps();

            $table->unique(['puskesmas_id', 'tahun', 'bulan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_bulanan');
    }
};
