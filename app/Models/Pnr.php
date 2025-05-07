<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PNR extends Model
{
    use HasFactory;

    protected $table = 'pnrs';

    protected $primaryKey = 'pnrId';

    protected $fillable = [
        'bookingId',
        'pnrCode',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'bookingId', 'bookingId');
    }
}
