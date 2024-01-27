<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Customer extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }
    public function server()
    {
        return $this->belongsTo(Server::class);
    }
    public function packet()
    {
        return $this->belongsTo(Packet::class);
    }
    public function modem()
    {
        return $this->belongsTo(Modem::class);
    }
    public function installation(): HasOne
    {
        return $this->hasOne(Installation::class);
    }
    public function order()
    {
        return $this->hasOne(Order::class, 'customer_id', 'id');
    }
    public function reports()
    {
        return $this->hasMany(Report::class);
    }
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
    public function setNameAttribute($value)
    {
        return $this->attributes['name'] = str($value)->ucfirst();
    }
    public function getCableLengthAttribute($value)
    {
        return $value . ' M';
    }
}
