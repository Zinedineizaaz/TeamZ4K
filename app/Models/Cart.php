<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
    ];

    // Relasi: Cart ini Milik siapa (User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Cart ini berisi Produk apa
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}