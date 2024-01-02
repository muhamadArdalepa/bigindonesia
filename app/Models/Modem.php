<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Modem extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = ['id'];

    public function odp(): BelongsTo
    {
        return $this->belongsTo(Odp::class);
    }
}
