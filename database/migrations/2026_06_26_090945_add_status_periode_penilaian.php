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
        // Mengarah langsung ke tabel 'periode_penilaian' Anda
        Schema::table('periode_penilaian', function (Blueprint $table) {
            $table->enum('status_validasi', ['menunggu', 'disetujui', 'ditolak'])->default('menunggu');
            $table->text('catatan_validasi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('periode_penilaian', function (Blueprint $table) {
            // Menghapus kolom jika migration di-rollback
            $table->dropColumn(['status_validasi', 'catatan_validasi']);
        });
    }
};