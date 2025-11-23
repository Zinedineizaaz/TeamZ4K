<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    // Nama tabel di database
    protected $table = 'products';

    // Kolom yang aman diisi (Mass Assignment)
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'is_promo',
        'image'
    ];
    
    // Konversi tipe data otomatis
    protected $casts = [
        'is_promo' => 'boolean',
        'price' => 'integer',
        'stock' => 'integer',
    ];
}