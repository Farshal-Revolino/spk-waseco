<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilIdeal extends Model
{
    protected $table = 'profil_ideal';

    protected $fillable = ['sub_kriteria_id', 'nilai_ideal', 'keterangan'];

    public function subKriteria()
    {
        return $this->belongsTo(SubKriteria::class, 'sub_kriteria_id');
    }
}