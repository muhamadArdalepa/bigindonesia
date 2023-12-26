<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Installation extends Model
{
    use HasFactory;


    // relations

    protected $guarded = ['id'];

    public $timestamps = false;

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

    // custom method
    public function getBadge($key)
    {
        $badge = [];
        switch ($this->status) {
            case 0:
                $badge = [
                    'status' => 'Open',
                    'class' => 'bg-gradient-light text-dark',
                ];
                break;
            case 1:
                $badge = [
                    'status' => 'Proses',
                    'class' => 'bg-gradient-warning',
                ];
                break;
            case 2:
                $badge = [
                    'status' => 'Dibayar',
                    'class' => 'bg-gradient-info',
                ];
                break;
            case 3:
                $badge = [
                    'status' => 'Divalidasi',
                    'class' => 'bg-gradient-primary',
                ];
                break;
            case 4:
                $badge = [
                    'status' => 'Aktif',
                    'class' => 'bg-gradient-success',
                ];
                break;
            case 5:
                $badge = [
                    'status' => 'Pending',
                    'class' => 'bg-gradient-danger',
                ];
                break;
            case 6:
                $badge = [
                    'status' => 'Batal',
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
