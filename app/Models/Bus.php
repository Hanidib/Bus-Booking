<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    use HasFactory;

    protected $primaryKey = 'busId'; // Custom PK

    protected $fillable = [
        'busNumber',
        'busType',
        'totalSeats',
        'routeId',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'adminId', 'adminId');
    }

    public function route()
    {
        return $this->belongsTo(Route::class, 'busId', 'busId');
    }

    public function seats()
    {
        return $this->hasMany(Seat::class, 'busId', 'busId');
    }
}
