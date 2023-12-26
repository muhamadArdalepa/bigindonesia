<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstallationProcedure extends Model
{
    use HasFactory;

    public function installation()
    {
        return $this->belongsTo(Installation::class, 'installation_id');
    }
}
