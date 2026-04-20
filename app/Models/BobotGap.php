<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BobotGap extends Model
{
    protected $table = 'bobot_gap';
    public $timestamps = false;

    protected $fillable = ['selisih', 'bobot', 'keterangan'];

    public static function getBobotBySelisih($selisih)
    {
        $bobot = self::where('selisih', $selisih)->first();
        
        if (!$bobot) {
            if ($selisih == 0) return 5.0;
            if ($selisih > 0) return max(1.0, 5.0 - ($selisih * 0.5));
            if ($selisih < 0) return max(1.0, 5.0 + ($selisih * 0.5));
        }
        
        return $bobot ? $bobot->bobot : 1.0;
    }
}