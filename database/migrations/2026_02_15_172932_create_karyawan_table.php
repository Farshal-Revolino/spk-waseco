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
    Schema::create('karyawan', function (Blueprint $table) {
        $table->id();
        $table->string('nik', 50)->unique();
        $table->string('nama');
        $table->string('jabatan', 100)->nullable();
        $table->string('unit_kerja', 100)->nullable();
        $table->date('tanggal_masuk')->nullable();
        $table->enum('status', ['aktif', 'non-aktif'])->default('aktif');
        $table->string('foto')->nullable();
        $table->timestamps();
    });
}
    public function down(): void
    {
        Schema::dropIfExists('karyawan');
    }
};
