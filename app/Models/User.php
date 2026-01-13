<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\CustomResetPasswordNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use SoftDeletes;

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
        'avatar',        // <--- Tambahkan ini juga jika Anda menggunakan fitur upload foto
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
     * RELASI (TAMBAHAN BARU)
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
    return $this->hasMany(\App\Models\Favorite::class);
}

    /**
     * ==========================================
     * NOTIFIKASI & ACCESSORS (LAMA ANDA)
     * ==========================================
     */

    public function sendPasswordResetNotification($token)
    {
        // Kita timpa fungsi bawaan Laravel di sini
        $this->notify(new CustomResetPasswordNotification($token));
    }

    public function getJoinedDateAttribute()
    {
        return $this->created_at->format('d F Y, H:i'); // Contoh: 06 January 2026, 13:00
    }

    // Accessor: Bikin nama jadi huruf besar awal kata otomatis
    public function getNameAttribute($value)
    {
        return ucwords(strtolower($value));
    }
}