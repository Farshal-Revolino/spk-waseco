<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    protected $table = 'kriteria';

    protected $fillable = ['kode', 'nama', 'bobot', 'urutan'];

    public function subKriteria()
    {
        return $this->hasMany(SubKriteria::class, 'kriteria_id')->orderBy('urutan');
    }
}