<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserAccessTest extends TestCase
{
    /**
     * Test 1: Halaman Login harus bisa dibuka oleh tamu.
     */
    use RefreshDatabase;
    /** @test */
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
        $user = User::factory()->create(['role' => 'user']);

        // 2. Coba paksa masuk ke halaman admin/users
        $response = $this->actingAs($user)->get('/admin/users');

        // 3. Ubah dari 302 menjadi 403 (Forbidden)
        $response->assertStatus(403);
    }
}