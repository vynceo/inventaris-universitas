<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_requires_authentication(): void
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_admin_can_access_dashboard(): void
    {
        $admin = User::where('role', 'admin')->first() ?? User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Total Barang');
        $response->assertSee('Transaksi Terbaru');
    }

    public function test_staff_can_access_dashboard(): void
    {
        $staff = User::where('role', 'staff')->first() ?? User::factory()->create(['role' => 'staff']);

        $response = $this->actingAs($staff)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Peminjaman Saya');
    }
}
