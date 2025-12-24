<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class UserAccessTest extends TestCase
{
    /**
     * Test 1: Halaman Login harus bisa dibuka oleh tamu.
     */
    public function test_login_page_is_accessible()
    {
        $response = $this->get('/login');
        $response->assertStatus(200); // Kode 200 artinya OK
    }

    /**
     * Test 2: User biasa TIDAK BISA akses halaman user management.
     */
    public function test_user_cannot_access_police_area()
    {
        // 1. Buat user palsu (bukan superadmin)
        $user = User::factory()->create([
            'role' => 'user',
        ]);

        // 2. Coba paksa masuk ke halaman users
        $response = $this->actingAs($user)->get('/admin/users');

        // 3. Harusnya ditendang (Redirect status 302)
        $response->assertStatus(302);
    }
}