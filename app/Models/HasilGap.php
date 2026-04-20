<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilGap extends Model
{
    protected $table = 'hasil_gap';

    protected $fillable = ['penilaian_id', 'gap', 'bobot'];

    public function penilaian()
    {
        return $this->belongsTo(Penilaian::class, 'penilaian_id');
    }
}