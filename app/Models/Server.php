<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function odc()
    {
        return $this->hasMany(Odc::class);
    }
}
