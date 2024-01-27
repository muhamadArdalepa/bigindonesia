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
        '07:15',
        '11:00',
        '13:30',
        '16:00'
    ];

    // public function getTimes()
    // {
    //     foreach ($this::$settedTime as $i => $time) {
    //         $aktivitas[$i] = '';
    //     }
    //     foreach (AbsenDetail::select('created_at')->where('absen_id', $this->id)->pluck('created_at') as $h => $a) {
    //         $hour = $a->format('H:i');
    //         foreach ($this::$settedTime as $i => $time) {
    //             if ($i == count($this::$settedTime) - 1) {
    //                 if ($hour >= $time && $hour < $this::$max) {
    //                     $aktivitas[$i] = $hour;
    //                 }
    //                 break;
    //             }
    //             if ($hour >= $time && $hour < $this::$settedTime[$i + 1]) {
    //                 $aktivitas[$i] = $hour;
    //             }
    //         }
    //         $aktivitas;
    //     };
    //     return $aktivitas;
    // }
    // public function getAktivitass()
    // {
    //     foreach ($this::$settedTime as $i => $time) {
    //         $aktivitas[$i] = '';
    //     }
    //     foreach (AbsenDetail::select('id', 'desc as aktivitas', 'picture as foto', 'address as alamat', 'coordinate as koordinat', 'created_at')->where('absen_id', $this->id)->get() as $a) {
    //         $hour = $a->created_at->format('H:i');

    //         foreach ($this::$settedTime as $i => $time) {
    //             if ($i == count($this::$settedTime) - 1) {
    //                 if ($hour >= $time && $hour < $this::$max) {
    //                     $aktivitas[$i] = $a;
    //                     $a->time = $a->created_at->format('H:i');
    //                 }
    //                 break;
    //             }
    //             if ($hour >= $time && $hour < $this::$settedTime[$i + 1]) {
    //                 $aktivitas[$i] = $a;
    //                 $a->time = $a->created_at->format('H:i');
    //             }
    //         }
    //     };
    //     return $aktivitas;
    // }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function absen_details()
    {
        return $this->hasMany(AbsenDetail::class);
    }
}
