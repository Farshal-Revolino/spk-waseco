<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValidasiHasil extends Model
{
    use HasFactory;

    protected $table = 'validasi_hasil';

    protected $fillable = [
        'periode_id',
        'user_id',
        'status_validasi',
        'catatan_validasi',
        'tanggal_validasi',
    ];

    public function periode()
    {
        return $this->belongsTo(PeriodePenilaian::class, 'periode_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}