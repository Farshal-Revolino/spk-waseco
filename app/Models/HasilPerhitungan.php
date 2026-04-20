<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilPerhitungan extends Model
{
    protected $table = 'hasil_perhitungan';

    protected $fillable = [
        'karyawan_id', 'periode_id', 'ncf_teknis', 'nsf_teknis', 'nilai_teknis',
        'ncf_non_teknis', 'nsf_non_teknis', 'nilai_non_teknis',
        'ncf_kepribadian', 'nsf_kepribadian', 'nilai_kepribadian',
        'ncf_kepemimpinan', 'nsf_kepemimpinan', 'nilai_kepemimpinan',
        'nilai_total', 'ranking', 'klasifikasi'
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }

    public function periode()
    {
        return $this->belongsTo(PeriodePenilaian::class, 'periode_id');
    }

    public static function determineKlasifikasi($nilaiTotal)
    {
        if ($nilaiTotal >= 241) return 'A';
        if ($nilaiTotal >= 161) return 'B';
        if ($nilaiTotal >= 81) return 'C';
        return 'D';
    }

    public function getKlasifikasiBadgeAttribute()
    {
        $badges = ['A' => 'success', 'B' => 'primary', 'C' => 'warning', 'D' => 'danger'];
        return $badges[$this->klasifikasi] ?? 'secondary';
    }
}