<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $price
 * @property int $stock
 * @property bool $is_promo
 * @property string|null $image
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class Product extends Model
{
    use HasFactory;
    
    // Nama tabel di database
    protected $table = 'products';

    // Kolom yang aman diisi (Mass Assignment)
    // HAPUS 'array' type hint.
    protected $fillable = [ 
        'name',
        'description',
        'price',
        'stock',
        'is_promo',
        'image'
    ];
    
    // Konversi tipe data otomatis
    // HAPUS 'array' type hint.
    protected $casts = [ 
        'is_promo' => 'boolean',
        'price' => 'integer',
        'stock' => 'integer',
    ];
}