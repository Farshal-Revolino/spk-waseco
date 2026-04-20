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
    Schema::create('hasil_perhitungan', function (Blueprint $table) {
        $table->id();
        $table->foreignId('karyawan_id')->constrained('karyawan')->onDelete('cascade');
        $table->foreignId('periode_id')->constrained('periode_penilaian')->onDelete('cascade');
        $table->decimal('ncf_teknis', 5, 2)->nullable();
        $table->decimal('nsf_teknis', 5, 2)->nullable();
        $table->decimal('nilai_teknis', 5, 2)->nullable();
        $table->decimal('ncf_non_teknis', 5, 2)->nullable();
        $table->decimal('nsf_non_teknis', 5, 2)->nullable();
        $table->decimal('nilai_non_teknis', 5, 2)->nullable();
        $table->decimal('ncf_kepribadian', 5, 2)->nullable();
        $table->decimal('nsf_kepribadian', 5, 2)->nullable();
        $table->decimal('nilai_kepribadian', 5, 2)->nullable();
        $table->decimal('ncf_kepemimpinan', 5, 2)->nullable();
        $table->decimal('nsf_kepemimpinan', 5, 2)->nullable();
        $table->decimal('nilai_kepemimpinan', 5, 2)->nullable();
        $table->decimal('nilai_total', 8, 2);
        $table->integer('ranking')->nullable();
        $table->enum('klasifikasi', ['A', 'B', 'C', 'D'])->nullable();
        $table->timestamps();
    });
}
    public function down(): void
    {
        Schema::dropIfExists('hasil_perhitungan');
    }
};
