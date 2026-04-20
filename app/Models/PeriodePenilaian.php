<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeriodePenilaian extends Model
{
    protected $table = 'periode_penilaian';

    protected $fillable = [
        'nama', 'tahun', 'triwulan', 'tanggal_mulai', 'tanggal_selesai', 'status'
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