<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    const ROLE_ADMIN = 'ADMIN';
    const ROLE_STAFF = 'STAFF';
    const ROLE_USER = 'USER';
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'roles',
        // Tambahkan ini jika perlu:
        'created_at',
        'updated_at',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
    'email_verified_at' => 'datetime',
    'password' => 'hashed',
    'roles' => 'string', // Add this line
    ];

        public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }
}
