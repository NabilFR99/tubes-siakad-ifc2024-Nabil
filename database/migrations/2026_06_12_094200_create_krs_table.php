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
        Schema::create('krs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswas')->cascadeOnDelete();
            $table->foreignId('jadwal_kuliah_id')->constrained('jadwal_kuliahs')->cascadeOnDelete();
            $table->string('tahun_akademik')->default('2025/2026');
            $table->string('semester')->default('Genap');
            $table->string('status')->default('diambil');
            $table->timestamps();

            $table->unique(['mahasiswa_id', 'jadwal_kuliah_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('krs');
    }
};
