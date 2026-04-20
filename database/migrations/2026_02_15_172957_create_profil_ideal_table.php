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
    Schema::create('profil_ideal', function (Blueprint $table) {
        $table->id();
        $table->foreignId('sub_kriteria_id')->constrained('sub_kriteria')->onDelete('cascade');
        $table->integer('nilai_ideal');
        $table->text('keterangan')->nullable();
        $table->timestamps();
    });
}
    public function down(): void
    {
        Schema::dropIfExists('profil_ideal');
    }
};
