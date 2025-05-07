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
        'bookingDate',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userId', 'userId');
    }

    public function seat()
    {
        return $this->belongsTo(Seat::class, 'seatId', 'seatId');
    }

    public function pnr()
    {
        return $this->hasOne(Pnr::class, 'bookingId', 'bookingId');
    }
}
