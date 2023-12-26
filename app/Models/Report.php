<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    public $incrementing = false;

    public function reparation()
    {
        return $this->hasMany(Reparation::class, 'report_id', 'id');
    }
}
