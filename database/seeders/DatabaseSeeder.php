<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. AKUN SUPER ADMIN (POLICE) - Langsung jadi Police
        User::create([
            'name' => 'Komandan Zined (Police)',
            'email' => 'police@team.com', // Email Login Police
            'password' => Hash::make('password123'), // Passwordnya
            'role' => 'superadmin', // KUNCI: Role otomatis superadmin
            'last_login_at' => now(),
        ]);

        // 2. AKUN ADMIN BIASA (STAFF)
        User::create([
            'name' => 'Staff Agus (Admin)',
            'email' => 'admin@team.com', // Email Login Admin Biasa
            'password' => Hash::make('password123'),
            'role' => 'admin', // Role otomatis admin biasa (jika ada logika admin) atau user
            'last_login_at' => now(),
        ]);

        // 3. AKUN USER BIASA (PENGUNJUNG)
        User::create([
            'name' => 'Pengunjung Toko',
            'email' => 'user@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'user', // Role user biasa
            'last_login_at' => now(),
        ]);
    }
}