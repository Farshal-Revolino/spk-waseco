<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    protected $table = 'karyawan';

    protected $fillable = [
        'nik', 'nama', 'jabatan', 'unit_kerja', 'tanggal_masuk', 'status', 'foto'
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
    ];

    public function penilaian()
    {
        return $this->hasMany(Penilaian::class, 'karyawan_id');
    }

    public function hasilPerhitungan()
    {
        return $this->hasMany(HasilPerhitungan::class, 'karyawan_id');
    }
}