<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsenPlace extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    public static function getSettedPlace()
    {
        $places = self::select('coordinate')->pluck('coordinate');
        $data = [];
        foreach ($places as $place) {
            array_push($data, explode(',', $place));
        }
        return $data;
    }
}
