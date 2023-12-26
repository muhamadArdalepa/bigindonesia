<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Packet extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function getPriceAttribute($value): string
    {
        return $this->attributes['price'] = 'Rp. ' . number_format((float) $value);
    }
}
