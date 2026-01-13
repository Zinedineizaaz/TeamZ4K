<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    public function run()
    {
        // 1. Ambil User yang ada (biar relasinya aman)
        // Kalau user kosong, kita bikin user dummy dulu
        if (User::count() == 0) {
            User::factory(10)->create();
        }
        
        $users = User::pluck('id')->toArray();
        $statuses = ['PAID', 'SETTLEMENT', 'SUCCESS', 'PENDING', 'CANCELLED'];
        $products = [
            'Dimsum Ayam Original', 
            'Dimsum Udang Keju', 
            'Dimsum Mentai', 
            'Lumpia Kulit Tahu', 
            'Hakau Udang Premium'
        ];

        // 2. Bikin 50 Data Dummy
        for ($i = 0; $i < 50; $i++) {
            
            // Random Tanggal (Mundur 0 sampai 10 hari ke belakang)
            $date = Carbon::now()->subDays(rand(0, 10));

            Order::create([
                'user_id'           => $users[array_rand($users)], // Pilih user acak
                'product_name'      => $products[array_rand($products)], // Pilih menu acak
                'price'             => rand(15, 50) * 1000, // Harga 15rb - 50rb
                'status'            => $statuses[array_rand($statuses)], // Status acak
                'order_id_midtrans' => 'ORDER-' . uniqid(),
                'snap_token'        => 'dummy_token_' . uniqid(),
                'created_at'        => $date,
                'updated_at'        => $date,
            ]);
        }
    }
}