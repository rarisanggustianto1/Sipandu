<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pemeriksaan', function (Blueprint $table): void {
            $table->foreignId('kegiatan_id')
                ->nullable()
                ->after('peserta_id')
                ->constrained('kegiatan')
                ->nullOnDelete();
        });

        Schema::create('kegiatan_petugas', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('kegiatan_id')->constrained('kegiatan')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('status_kehadiran', ['hadir', 'tidak_hadir'])->default('hadir');
            $table->timestamps();
            $table->unique(['kegiatan_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kegiatan_petugas');

        Schema::table('pemeriksaan', function (Blueprint $table): void {
            $table->dropConstrainedForeignId('kegiatan_id');
        });
    }
};
