<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reparation extends Model
{
    use HasFactory;

    public function reparationProcedure()
    {
        return $this->hasMany(ReparationProcedure::class, 'reparation_id', 'id');
    }

    public function report()
    {
        return $this->belongsTo(Report::class, 'report_id');
    }
}
