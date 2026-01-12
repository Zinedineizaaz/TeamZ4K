<?php

use App\Models\Order;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('external_id')->unique(); // ID untuk Xendit
            $table->foreignId('user_id')->constrained(); // Relasi ke User
            $table->decimal('amount', 10, 2); // Harga produk
            $table->string('status')->default('PENDING'); // PENDING, PAID, EXPIRED
            $table->string('checkout_link')->nullable(); // Link dari Xendit
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
