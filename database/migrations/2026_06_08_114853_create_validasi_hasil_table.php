<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('validasi_hasil', function (Blueprint $table) {
            $table->id();
            $table->foreignId('periode_id')->constrained('periode_penilaian')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->string('status_validasi', 20)->default('menunggu');
            $table->text('catatan_validasi')->nullable();
            $table->timestamp('tanggal_validasi')->nullable();

            $table->timestamps();

            $table->unique('periode_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('validasi_hasil');
    }
};