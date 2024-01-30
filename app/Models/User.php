<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    use SoftDeletes;
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];
    protected $casts = [
        'is_active' => 'boolean'
    ];



    /**
     * Always encrypt the password when it is updated.
     *
     * @param $value
     * @return string
     */

    public function setPasswordAttribute($value): void
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function wilayah()
    {
        return $this->belongsTo(Region::class);
    }

    public function absens()
    {
        return $this->hasMany(Absen::class);
    }
    public function absen_details()
    {
        return $this->hasManyThrough(AbsenDetail::class,Absen::class,'user_id','absen_id');
        // return $this->hasManyThrough(Absen::class,AbsenDetail::class,'absen_id','user_id');
    }
    public function poins()
    {
        return $this->hasMany(Poin::class);
    }
    public function phone(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => '0' . substr($value, 2),
        );
    }
}
