<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $primaryKey = 'adminId';
    protected $fillable = ['name', 'email', 'password'];
    protected $hidden = ['password', 'remember_token'];

    // Add this method for Sanctum
    public function isAdmin(): bool
    {
        return true; // Or implement your admin check logic
    }

    public function users()
    {
        return $this->hasMany(User::class, 'adminId', 'adminId');
    }

    public function buses()
    {
        return $this->hasMany(Bus::class, 'adminId', 'adminId');
    }

    public function routes()
    {
        return $this->hasMany(Route::class, 'adminId', 'adminId');
    }
}
