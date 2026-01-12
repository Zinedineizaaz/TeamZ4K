<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi secara massal (Mass Assignment).
     * Harus sinkron dengan file migrasi Anda.
     */
    protected $fillable = [
        'external_id',  // ID unik untuk referensi Xendit
        'user_id',      // ID user yang membeli
        'amount',       // Total harga
        'status',       // PENDING, PAID, atau EXPIRED
        'checkout_link' // URL halaman pembayaran dari Xendit
    ];

    /**
     * Relasi ke Model User.
     * Menandakan bahwa setiap pesanan dimiliki oleh satu user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}