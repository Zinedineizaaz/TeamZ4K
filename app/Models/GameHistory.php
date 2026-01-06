<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameHistory extends Model
{
    use HasFactory;

    // 1. Nama Tabel (Opsional kalau sesuai standar, tapi biar aman kita tulis)
    protected $table = 'game_histories';

    // 2. Kolom yang boleh diisi (Mass Assignment)
    // INI WAJIB ADA biar gak error "Add [field] to fillable property"
    protected $fillable = [
        'user_id',
        'prize',
        'played_at',
    ];

    // 3. Casting (Ubah format data otomatis)
    // Biar kolom 'played_at' dibaca sebagai Tanggal (Date), bukan String biasa
    protected $casts = [
        'played_at' => 'date',
    ];

    // 4. Relasi ke User (Opsional, buat jaga-jaga kalau butuh data user)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}