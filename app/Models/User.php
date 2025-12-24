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
        'role',          // <--- JANGAN LUPA TAMBAHKAN INI (Wajib buat fitur Police)
        'last_login_at', // <--- Tambahkan ini juga biar aman
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
    protected $fillable = [
        'name',
        'email',
        'password',
        'last_login_at', // <-- TAMBAHKAN INI AGAR BISA DISIMPAN KE DATABASE
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'last_login_at' => 'datetime', // <--- Ini yang kamu tambahkan tadi (SUDAH BENAR)
    ];
}