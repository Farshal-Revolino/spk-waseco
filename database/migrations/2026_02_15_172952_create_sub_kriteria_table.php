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
    Schema::create('sub_kriteria', function (Blueprint $table) {
        $table->id();
        $table->foreignId('kriteria_id')->constrained('kriteria')->onDelete('cascade');
        $table->string('kode', 20)->unique();
        $table->text('nama');
        $table->enum('tipe', ['core', 'secondary'])->default('core');
        $table->integer('urutan');
        $table->timestamps();
    });
}
    public function down(): void
    {
        Schema::dropIfExists('sub_kriteria');
    }
};
