<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeriodePenilaian extends Model
{
    protected $table = 'periode_penilaian';

    // Bersihkan komentar di tengah array
    protected $fillable = [
        'nama_periode', 
        'tanggal_mulai', 
        'tanggal_selesai',
        'status', // Pastikan kolom status yang Anda pakai di Controller ada di sini
        'status_validasi',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function penilaian()
    {
        return $this->hasMany(Penilaian::class, 'periode_id');
    }

    public function hasilPerhitungan()
    {
        return $this->hasMany(HasilPerhitungan::class, 'periode_id');
    }
}