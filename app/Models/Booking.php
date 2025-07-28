<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $primaryKey = 'bookingId';

    protected $fillable = [
        'userId',
        'seatId',
        'routeId',
        'bookingDate',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    public function seat()
    {
        return $this->belongsTo(Seat::class, 'seatId');
    }

    public function route()
    {
        return $this->belongsTo(Route::class, 'routeId');
    }

    public function pnr()
    {
        return $this->hasOne(Pnr::class, 'bookingId');
    }
}
