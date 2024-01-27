<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsenPlace extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public $timestamps = false;

    const RADIUS = 100;
}
