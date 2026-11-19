<?php

namespace Tests\Feature;

use App\Models\DesignOrder;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SecurityTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_unauthenticated_users_cannot_access_protected_dashboards(): void
    {
        $this->get('/admin/dashboard')->assertRedirect('/admin/login');
        $this->get('/client/dashboard')->assertRedirect('/client/login');
        $this->get('/designer/dashboard')->assertRedirect('/designer/login');
    }

    public function test_client_cannot_access_admin_or_designer_areas(): void
    {
        $client = User::where('role', 'client')->first();

        $this->actingAs($client)->get('/admin/dashboard')->assertRedirect('/admin/login');
        $this->actingAs($client)->get('/designer/dashboard')->assertRedirect('/designer/login');
    }

    public function test_designer_cannot_access_admin_or_client_areas(): void
    {
        $designer = User::where('role', 'designer')->first();

        $this->actingAs($designer)->get('/admin/dashboard')->assertRedirect('/admin/login');
        $this->actingAs($designer)->get('/client/dashboard')->assertRedirect('/client/login');
    }

    public function test_idor_client_cannot_access_another_client_order(): void
    {
        $client1 = User::where('role', 'client')->first();
        $client2 = User::factory()->create([
            'role' => 'client',
            'email' => 'otherclient@example.com',
            'phone' => '01700000099',
            'password' => bcrypt('password'),
        ]);

        $order = DesignOrder::where('client_id', $client1->id)->first();
        $this->assertNotNull($order);

        // Client 2 attempting to view or message Client 1's order must return 404
        $this->actingAs($client2)->get('/client/orders/' . $order->id)->assertStatus(404);
        $this->actingAs($client2)->post('/client/orders/' . $order->id . '/message', [
            'message' => 'Hacked message',
        ])->assertStatus(404);
        $this->actingAs($client2)->post('/client/orders/' . $order->id . '/approve')->assertStatus(404);
    }

    public function test_idor_designer_cannot_access_another_designer_order(): void
    {
        $designer1 = User::where('role', 'designer')->first();
        $designer2 = User::factory()->create([
            'role' => 'designer',
            'email' => 'otherdesigner@example.com',
            'phone' => '01800000099',
            'password' => bcrypt('password'),
        ]);

        $order = DesignOrder::where('designer_id', $designer1->id)->first();
        $this->assertNotNull($order);

        // Designer 2 attempting to access Designer 1's order must return 404
        $this->actingAs($designer2)->get('/designer/orders/' . $order->id)->assertStatus(404);
        $this->actingAs($designer2)->post('/designer/orders/' . $order->id . '/message', [
            'message' => 'Hacked message',
        ])->assertStatus(404);
    }

    public function test_quick_login_aborts_404_in_production(): void
    {
        config(['app.env' => 'production']);
        $this->get('/quick-login/admin')->assertStatus(404);
    }

    public function test_designer_withdrawal_rejected_if_insufficient_balance(): void
    {
        $designer = User::where('role', 'designer')->first();
        $designer->update(['balance' => 100.00]);

        $response = $this->actingAs($designer)->post('/designer/withdrawals', [
            'amount' => 500.00,
            'payment_method' => 'bkash',
            'account_number' => '01712345678',
        ]);

        $response->assertSessionHas('error');
        $this->assertEquals(100.00, $designer->fresh()->balance);
    }

    public function test_admin_settings_validation_blocks_invalid_commission(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->post('/admin/settings', [
            'designer_commission_percent' => 150, // Invalid > 100
        ]);

        $response->assertSessionHasErrors('designer_commission_percent');
    }
}
