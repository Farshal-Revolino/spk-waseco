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
    Schema::create('periode_penilaian', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->year('tahun');
        $table->enum('triwulan', ['I', 'II', 'III', 'IV']);
        $table->date('tanggal_mulai');
        $table->date('tanggal_selesai');
        $table->enum('status', ['aktif', 'selesai'])->default('aktif');
        $table->timestamps();
    });
}
    public function down(): void
    {
        Schema::dropIfExists('periode_penilaian');
    }
};
