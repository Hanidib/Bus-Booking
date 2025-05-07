<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;

    protected $primaryKey = 'seatId';

    protected $fillable = [
        'busId',
        'seatNumber',
        'isAvailable',
    ];

    public function bus()
    {
        return $this->belongsTo(Bus::class, 'busId', 'busId');
    }

    public function booking()
    {
        return $this->hasOne(Booking::class, 'seatId', 'seatId');
    }
}
