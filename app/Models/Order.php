<?php

namespace App\Models;

use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $incrementing = false;


    // relationship
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'marketer_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function installation(): HasOne
    {
        return $this->hasOne(Installation::class, 'order_id', 'id');
    }

    // custom func
    public function getBadge($key)
    {
        $badge = [];
        switch ($this->status) {
            case 0:
                $badge = [
                    'status' => 'Proses',
                    'class' => 'bg-gradient-light text-dark',
                ];
                break;
            case 1:
                $badge = [
                    'status' => 'Tercover',
                    'class' => 'bg-gradient-success',
                ];
                break;
            case 2:
                $badge = [
                    'status' => 'Tarik Jalur',
                    'class' => 'bg-gradient-warning',
                ];
                break;
            case 3:
                $badge = [
                    'status' => 'Tidak Tercover',
                    'class' => 'bg-gradient-danger',
                ];
                break;
            default:
                $badge = [
                    'status' => 'Proses',
                    'class' => 'bg-gradient-light text-dark',
                ];
        }

        return $badge[$key];
    }
}
