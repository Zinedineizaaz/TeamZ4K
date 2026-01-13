<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\CustomResetPasswordNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',          // Wajib buat fitur Police/Admin
        'last_login_at', 
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
        'last_login_at' => 'datetime',
    ];

    /**
     * ==========================================
     * RELASI
     * ==========================================
     */

    // Menghubungkan User ke data Keranjang miliknya
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    // Menghubungkan User ke daftar Menu Favorit miliknya
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    // Menghubungkan User ke Riwayat Pesanan (Untuk Dashboard Admin)
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * ==========================================
     * NOTIFIKASI & ACCESSORS
     * ==========================================
     */

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPasswordNotification($token));
    }

    public function getJoinedDateAttribute()
    {
        return $this->created_at->format('d F Y, H:i'); 
    }

    // Accessor: Nama jadi huruf besar tiap awal kata
    public function getNameAttribute($value)
    {
        return ucwords(strtolower($value));
    }
}