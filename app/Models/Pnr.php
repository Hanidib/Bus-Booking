<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pnr extends Model
{
    use HasFactory;

    protected $table = 'pnrs';

    protected $primaryKey = 'pnrId';

    protected $fillable = [
        'bookingId',
        'pnrCode',
        'issuedAt',

    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'bookingId');
    }
}
