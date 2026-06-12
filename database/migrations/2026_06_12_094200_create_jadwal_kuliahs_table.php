<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jadwal_kuliahs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mata_kuliah_id')->constrained('mata_kuliahs')->cascadeOnDelete();
            $table->foreignId('dosen_id')->constrained('dosens')->cascadeOnDelete();
            $table->string('hari');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('kelas', 20);
            $table->string('ruang');
            $table->unsignedSmallInteger('kuota')->default(35);
            $table->string('tahun_akademik')->default('2025/2026');
            $table->string('semester_akademik')->default('Genap');
            $table->timestamps();

            $table->unique(['mata_kuliah_id', 'kelas', 'tahun_akademik', 'semester_akademik'], 'jadwal_kuliah_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_kuliahs');
    }
};
