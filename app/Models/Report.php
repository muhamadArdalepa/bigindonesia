<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $incrementing = false;
    public function cs () {
        return $this->belongsTo(User::class);
    }
    public function customer () {
        return $this->belongsTo(Customer::class);
    }
    public function reparation()
    {
        return $this->hasMany(Reparation::class, 'report_id', 'id');
    }
}
