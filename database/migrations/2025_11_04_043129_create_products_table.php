<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            // Kolom-kolom baru
            $table->string('name', 100); // Nama Dimsum
            $table->text('description')->nullable(); // Deskripsi produk
            $table->unsignedInteger('price'); // Harga dalam Rupiah (unsigned untuk memastikan tidak negatif)
            $table->unsignedSmallInteger('stock')->default(0); // Stok
            $table->boolean('is_promo')->default(false); // Status promo (untuk koleksi)
            $table->string('image')->nullable(); // Path gambar produk
            // Kolom default
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};