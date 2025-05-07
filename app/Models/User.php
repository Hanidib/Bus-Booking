<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $primaryKey = 'userId';

    protected $fillable = [
        'firstName',
        'lastName',
        'rank',
        'militaryId',
        'phoneNumber',
        'address',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'adminId', 'adminId');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'userId', 'userId');
    }
}
