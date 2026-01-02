<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // --- 1. USER SEEDER (SAMA SEPERTI SEBELUMNYA) ---
        User::create([
            'name' => 'Komandan Zined (Police)',
            'email' => 'police@team.com', 
            'password' => Hash::make('password123'),
            'role' => 'superadmin',
            'last_login_at' => now(),
        ]);

        User::create([
            'name' => 'Staff Agus (Admin)',
            'email' => 'admin@team.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'last_login_at' => now(),
        ]);
        
        User::create([
            'name' => 'Pengunjung Toko',
            'email' => 'user@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'last_login_at' => now(),
        ]);

        
    }
}