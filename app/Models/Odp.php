<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Odp extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function odc()
    {
        return $this->belongsTo(Odc::class);
    }

    public function modem()
    {
        return $this->hasMany(Modem::class);
    }
}
