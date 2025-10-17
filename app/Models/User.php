<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // ✅ Use property instead of method
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // ✅ Relationship to Role
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}


