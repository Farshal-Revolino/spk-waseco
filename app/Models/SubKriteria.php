<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubKriteria extends Model
{
    protected $table = 'sub_kriteria';

    protected $fillable = ['kriteria_id', 'kode', 'nama', 'tipe', 'urutan'];

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_id');
    }

    public function profilIdeal()
    {
        return $this->hasOne(ProfilIdeal::class, 'sub_kriteria_id');
    }

    public function penilaian()
    {
        return $this->hasMany(Penilaian::class, 'sub_kriteria_id');
    }
}