<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    protected $table = 'penilaian';

    protected $fillable = ['karyawan_id', 'sub_kriteria_id', 'periode_id', 'nilai'];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }

    public function subKriteria()
    {
        return $this->belongsTo(SubKriteria::class, 'sub_kriteria_id');
    }

    public function periode()
    {
        return $this->belongsTo(PeriodePenilaian::class, 'periode_id');
    }

    public function hasilGap()
    {
        return $this->hasOne(HasilGap::class, 'penilaian_id');
    }
}