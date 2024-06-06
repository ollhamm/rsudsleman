<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'birthdate',
        'jenis_kelamin_user',
        'address',
        'profile_picture',
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
        'password' => 'hashed', // Adding this for consistency
        'birthdate' => 'date',
        'jenis_kelamin_user' => 'string',
        'address' => 'string',
        'profile_picture' => 'string',
    ];

    /**
     * Get the patient associated with the user.
     */
    public function patient()
    {
        return $this->hasOne(Patient::class, 'user_id');
    }

    /**
     * Check if the user is a regular user.
     *
     * @return bool
     */
    public function isUser()
    {
        return $this->role === 'user';
    }
}
