<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Absen extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    const minAbsen = 3;
    const late = '08:55';
    const alpa = '09:30';
    const max = '20:00';
    const times =  [
        '06:00',
        '11:00',
        '13:30',
        '16:00'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function absen_details()
    {
        return $this->hasMany(AbsenDetail::class);
    }
}
