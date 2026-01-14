<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke ID User yang memesan
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Data produk (disimpan string agar history tetap ada jika produk dihapus)
            $table->string('product_name');
            $table->integer('price');
            
            // Status Pembayaran: 'pending', 'success', 'expired', 'failed'
            $table->string('status')->default('pending');
            
            // Kolom khusus Midtrans
            $table->string('order_id_midtrans')->unique()->nullable(); // ID unik untuk transaksi Midtrans
            $table->string('snap_token')->nullable(); // Token untuk memunculkan modal pembayaran Snap
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};