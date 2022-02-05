<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    // Use modules, traits, plugins ...
    use HasApiTokens, HasFactory, Notifiable;

    // Config the model

    protected $guarded = ['id'];

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
    ];


    // Filters
    public function scopeMobile($query, $mobile = null)
    {
        if (filled($mobile)) {
            return $query->whereRaw("LOWER(`mobile`) = ?", [strtolower($mobile)]);
        }
        return $query;
    }


    // Relations


    // Accessors


    // Mutators


    // Extra methods

}
