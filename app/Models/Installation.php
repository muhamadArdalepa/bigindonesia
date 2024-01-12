<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Installation extends Model
{
    use HasFactory;


    // relations

    protected $guarded = ['id'];


    public function installationProcedure()
    {
        return $this->hasMany(InstallationProcedure::class, 'installation_id', 'id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function noc()
    {
        return $this->belongsTo(User::class);
    }
    public function cs()
    {
        return $this->belongsTo(User::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
    public function procedures()
    {
        return $this->hasMany(InstallationProcedure::class);
    }
}
