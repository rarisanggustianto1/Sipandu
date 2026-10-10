<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('dinas_kesehatan_id')
                  ->nullable()
                  ->constrained('dinas_kesehatan')
                  ->nullOnDelete();

            $table->foreignId('puskesmas_id')
                  ->nullable()
                  ->constrained('puskesmas')
                  ->nullOnDelete();

            $table->foreignId('posyandu_id')
                  ->nullable()
                  ->constrained('posyandu')
                  ->nullOnDelete();

            $table->foreignId('keluarga_id')
                  ->nullable()
                  ->constrained('keluarga')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['dinas_kesehatan_id']);
            $table->dropForeign(['puskesmas_id']);
            $table->dropForeign(['posyandu_id']);
            $table->dropForeign(['keluarga_id']);

            $table->dropColumn([
                'dinas_kesehatan_id',
                'puskesmas_id',
                'posyandu_id',
                'keluarga_id'
            ]);
        });
    }
};