<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    protected $primaryKey = 'routeId';

    protected $fillable = [
        'departure',
        'destination',
        'departureDate',
        'departureTime',
    ];
    public function bus()
    {
        return $this->belongsTo(Bus::class, 'busId', 'busId');
    }
}
