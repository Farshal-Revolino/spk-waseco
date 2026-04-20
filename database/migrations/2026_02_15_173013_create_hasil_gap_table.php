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
    Schema::create('hasil_gap', function (Blueprint $table) {
        $table->id();
        $table->foreignId('penilaian_id')->constrained('penilaian')->onDelete('cascade');
        $table->integer('gap');
        $table->decimal('bobot', 3, 1);
        $table->timestamps();
    });
}
    public function down(): void
    {
        Schema::dropIfExists('hasil_gap');
    }
};
