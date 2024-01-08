<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstallationProcedure extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function installation()
    {
        return $this->belongsTo(Installation::class, 'installation_id');
    }
    public function details()
    {
        return $this->hasMany(InstallationProcedureDetail::class);
    }
}
