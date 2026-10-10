<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('puskesmas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('dinas_kesehatan_id')
                  ->constrained('dinas_kesehatan')
                  ->cascadeOnDelete();

            $table->string('nama_puskesmas');
            $table->text('alamat');
            $table->string('kecamatan');
            $table->string('telepon', 20)->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('puskesmas');
    }
};