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
    Schema::create('penilaian', function (Blueprint $table) {
        $table->id();
        $table->foreignId('karyawan_id')->constrained('karyawan')->onDelete('cascade');
        $table->foreignId('sub_kriteria_id')->constrained('sub_kriteria')->onDelete('cascade');
        $table->foreignId('periode_id')->constrained('periode_penilaian')->onDelete('cascade');
        $table->integer('nilai');
        $table->timestamps();
    });
}
    public function down(): void
    {
        Schema::dropIfExists('penilaian');
    }
};
