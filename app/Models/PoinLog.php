<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoinLog extends Model
{
    use HasFactory;
    protected $primaryKey = null;
    public $incrementing = false;
    public $guarded = [];

    public function poin()
    {
        return $this->belongsTo(Poin::class);
    }
}
