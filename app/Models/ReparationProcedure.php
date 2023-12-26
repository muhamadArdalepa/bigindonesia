<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReparationProcedure extends Model
{
    use HasFactory;

    public function reparation()
    {
        return $this->belongsTo(Reparation::class, 'reparation_id');
    }
}
