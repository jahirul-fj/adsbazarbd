<?php

namespace Tests\Feature;

use App\Models\AdCategory;
use App\Models\ClassifiedAd;
use App\Models\DesignerProfile;
use App\Models\DesignOrder;
use App\Models\DisplayAd;
use App\Models\Newspaper;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_public_pages_load_successfully(): void
    {
        $this->get('/')->assertStatus(200);
        $this->get('/about')->assertStatus(200);
        $this->get('/faq')->assertStatus(200);
        $this->get('/pricing')->assertStatus(200);
        $this->get('/contact')->assertStatus(200);
        $this->get('/track-ad?tracking_no=CLS-202611-1001')->assertStatus(200);
        $this->get('/classified-advertisement')->assertStatus(200);
        $this->get('/display-advertisement')->assertStatus(200);
        $this->get('/designers')->assertStatus(200);
        $this->get('/designers/1')->assertStatus(200);
        $this->get('/login')->assertStatus(200);
        $this->get('/admin/login')->assertStatus(200);
        $this->get('/client/login')->assertStatus(200);
        $this->get('/designer/login')->assertStatus(200);

        // Verify public layout renders correctly when logged in as client, admin, and designer
        $client = User::where('role', 'client')->first();
        $this->actingAs($client)->get('/')->assertStatus(200);

        $admin = User::where('role', 'admin')->first();
        $this->actingAs($admin)->get('/')->assertStatus(200);

        $designer = User::where('role', 'designer')->first();
        $this->actingAs($designer)->get('/')->assertStatus(200);
    }

    public function test_strict_role_login_separation(): void
    {
        // 1. Admin Login: Only Admin can log in at /admin/login
        $adminRes = $this->post('/admin/login', [
            'email' => 'admin@adsbazarbd.com',
            'password' => 'password',
        ]);
        $adminRes->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs(User::where('email', 'admin@adsbazarbd.com')->first());

        $this->post('/admin/logout');
        $this->assertGuest();

        // Client attempting admin login fails
        $clientFailRes = $this->post('/admin/login', [
            'email' => 'client@adsbazarbd.com',
            'password' => 'password',
        ]);
        $clientFailRes->assertSessionHas('error');
        $this->assertGuest();

        // 2. Client Login: Only Client can log in at /client/login
        $clientRes = $this->post('/client/login', [
            'email' => 'client@adsbazarbd.com',
            'password' => 'password',
        ]);
        $clientRes->assertRedirect(route('client.dashboard'));
        $this->assertAuthenticatedAs(User::where('email', 'client@adsbazarbd.com')->first());

        $this->post('/client/logout');
        $this->assertGuest();

        // Designer attempting client login fails
        $designerFailRes = $this->post('/client/login', [
            'email' => 'tanvir@adsbazarbd.com',
            'password' => 'password',
        ]);
        $designerFailRes->assertSessionHas('error');
        $this->assertGuest();

        // 3. Designer Login: Only Designer can log in at /designer/login
        $designerRes = $this->post('/designer/login', [
            'email' => 'tanvir@adsbazarbd.com',
            'password' => 'password',
        ]);
        $designerRes->assertRedirect(route('designer.dashboard'));
        $this->assertAuthenticatedAs(User::where('email', 'tanvir@adsbazarbd.com')->first());

        $this->post('/designer/logout');
        $this->assertGuest();

        // Admin attempting designer login fails
        $adminFailRes = $this->post('/designer/login', [
            'email' => 'admin@adsbazarbd.com',
            'password' => 'password',
        ]);
        $adminFailRes->assertSessionHas('error');
        $this->assertGuest();
    }

    public function test_unauthenticated_role_redirects(): void
    {
        // Visiting admin routes when logged out redirects to /admin/login
        $this->get('/admin/dashboard')->assertRedirect(route('admin.login'));

        // Visiting client routes when logged out redirects to /client/login
        $this->get('/client/dashboard')->assertRedirect(route('client.login'));

        // Visiting designer routes when logged out redirects to /designer/login
        $this->get('/designer/dashboard')->assertRedirect(route('designer.login'));
    }

    public function test_can_book_classified_ad(): void
    {
        $newspaper = Newspaper::first();
        $category = AdCategory::first();

        $response = $this->post('/classified-advertisement', [
            'customer_name' => 'জামিল হোসেন',
            'customer_email' => 'jamil@test.com',
            'customer_phone' => '01700112233',
            'newspaper_id' => $newspaper->id,
            'ad_category_id' => $category->id,
            'publish_date' => now()->addDays(2)->toDateString(),
            'title' => 'মিরপুর ১০ এ ৩ বেড বাসা ভাড়া হবে',
            'ad_body' => 'মিরপুর ১০ নম্বর গোলচত্বরের সন্নিকটে ৩ বেড, ২ বাথ, ২ বারান্দা সহ ৫ম তলায় মনোরম পরিবেশে ফ্ল্যাট বাসা ভাড়া দেওয়া হবে। যোগাযোগঃ ০১৭১১০০০০০০',
            'payment_method' => 'bkash',
            'payment_trx_id' => 'BK12345678',
            'payment_sender_phone' => '01700112233',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('classified_ads', [
            'customer_name' => 'জামিল হোসেন',
            'payment_trx_id' => 'BK12345678',
        ]);
    }

    public function test_can_book_display_ad(): void
    {
        $newspaper = Newspaper::first();
        $category = AdCategory::first();

        $response = $this->post('/display-advertisement', [
            'customer_name' => 'প্রাইম গ্রুপ',
            'customer_email' => 'info@primegroup.test',
            'customer_phone' => '01800112233',
            'newspaper_id' => $newspaper->id,
            'ad_category_id' => $category->id,
            'publish_date' => now()->addDays(3)->toDateString(),
            'title' => 'কোম্পানি এনুয়াল সেলস কনফারেন্স ব্যানার',
            'page_position' => 'front_page',
            'color_type' => 'color',
            'columns' => 4,
            'height_inches' => 6.0,
            'payment_method' => 'bank',
            'payment_trx_id' => 'BANK-TRX-9988',
            'payment_sender_phone' => '01800112233',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('display_ads', [
            'customer_name' => 'প্রাইম গ্রুপ',
            'columns' => 4,
        ]);
    }

    public function test_client_dashboard_and_escrow_approval(): void
    {
        $client = User::where('role', 'client')->first();
        $this->actingAs($client);

        $this->get('/client/dashboard')->assertStatus(200);
        $this->get('/client/classified-ads')->assertStatus(200);
        $this->get('/client/display-ads')->assertStatus(200);
        $this->get('/client/orders')->assertStatus(200);

        $order = DesignOrder::first();
        $this->get('/client/orders/' . $order->id)->assertStatus(200);

        // Approve design order
        $this->post('/client/orders/' . $order->id . '/approve')->assertRedirect();
        $this->assertEquals('completed', $order->fresh()->status);
    }

    public function test_designer_dashboard_and_orders(): void
    {
        $designer = User::where('role', 'designer')->first();
        $this->actingAs($designer);

        $this->get('/designer/dashboard')->assertStatus(200);
        $this->get('/designer/orders')->assertStatus(200);
        $this->get('/designer/profile')->assertStatus(200);

        $order = DesignOrder::where('designer_id', $designer->id)->first();
        if ($order) {
            $this->get('/designer/orders/' . $order->id)->assertStatus(200);
        }
    }

    public function test_admin_dashboard_and_controls(): void
    {
        $admin = User::where('role', 'admin')->first();
        $this->actingAs($admin);

        $this->get('/admin/dashboard')->assertStatus(200);
        $this->get('/admin/classified-ads')->assertStatus(200);
        $this->get('/admin/display-ads')->assertStatus(200);
        $this->get('/admin/newspapers')->assertStatus(200);
        $this->get('/admin/categories')->assertStatus(200);
        $this->get('/admin/design-orders')->assertStatus(200);
        $this->get('/admin/withdrawals')->assertStatus(200);
        $this->get('/admin/payments')->assertStatus(200);
        $this->get('/admin/settings')->assertStatus(200);
        $this->get('/admin/designers')->assertStatus(200);
        $this->get('/admin/users')->assertStatus(200);
    }

    public function test_commission_and_withdrawal_lifecycle(): void
    {
        \App\Models\SystemSetting::set('designer_commission_percent', '20');
        \App\Models\SystemSetting::set('min_withdrawal_amount', '500');

        $designer = User::where('role', 'designer')->first();
        $designer->update(['balance' => 0.00]);

        $client = User::where('role', 'client')->first();

        // Create an active order for this designer
        $order = DesignOrder::create([
            'order_no' => 'ORD-TEST-101',
            'client_id' => $client->id,
            'designer_id' => $designer->id,
            'title' => 'টেস্ট ব্যানার ডিজাইন',
            'ad_size_requirement' => '4x4 ইঞ্চি',
            'brief_description' => 'টেস্ট ব্রিফ বিবরণী',
            'budget' => 1000.00,
            'status' => 'draft_submitted',
            'revisions_allowed' => 3,
            'revisions_remaining' => 3,
            'payment_status' => 'escrow_held',
            'payment_trx_id' => 'ESCROW-TRX-101',
        ]);

        // 1. Client approves design order
        $this->actingAs($client)
            ->post('/client/orders/' . $order->id . '/approve')
            ->assertRedirect();

        $order->refresh();
        $designer->refresh();

        $this->assertEquals('completed', $order->status);
        $this->assertEquals(20.00, (float) $order->platform_commission_percent);
        $this->assertEquals(200.00, (float) $order->platform_commission_amount);
        $this->assertEquals(800.00, (float) $order->designer_earning);
        $this->assertEquals(800.00, (float) $designer->balance);

        // 2. Designer attempts withdrawal below minimum (300 < 500)
        $this->actingAs($designer);
        $failMinRes = $this->post('/designer/withdrawals', [
            'amount' => 300,
            'payment_method' => 'bkash',
            'account_number' => '01711223344',
        ]);
        $failMinRes->assertSessionHasErrors(['amount']);
        $this->assertEquals(800.00, (float) $designer->fresh()->balance);

        // 3. Designer attempts withdrawal exceeding balance (1500 > 800)
        $failBalRes = $this->post('/designer/withdrawals', [
            'amount' => 1500,
            'payment_method' => 'bkash',
            'account_number' => '01711223344',
        ]);
        $failBalRes->assertSessionHas('error');
        $this->assertEquals(800.00, (float) $designer->fresh()->balance);

        // 4. Designer submits valid withdrawal of 600
        $validRes = $this->from(route('designer.withdrawals'))->post('/designer/withdrawals', [
            'amount' => 600,
            'payment_method' => 'bkash',
            'account_number' => '01711223344',
            'account_details' => 'Personal Account',
        ]);
        $validRes->assertRedirect(route('designer.withdrawals'));
        $designer->refresh();
        $this->assertEquals(200.00, (float) $designer->balance);

        $withdrawal = \App\Models\WithdrawalRequest::where('user_id', $designer->id)->latest()->first();
        $this->assertNotNull($withdrawal);
        $this->assertEquals('pending', $withdrawal->status);
        $this->assertEquals(600.00, (float) $withdrawal->amount);

        // 5. Admin rejects withdrawal -> balance must be refunded back to designer
        $admin = User::where('role', 'admin')->first();
        $this->actingAs($admin)
            ->post('/admin/withdrawals/' . $withdrawal->id . '/status', [
                'status' => 'rejected',
                'admin_notes' => 'ভুল বিকাশ নম্বর দেওয়া হয়েছে।',
            ])
            ->assertRedirect();

        $withdrawal->refresh();
        $designer->refresh();
        $this->assertEquals('rejected', $withdrawal->status);
        $this->assertEquals(800.00, (float) $designer->balance); // 200 + 600 refunded

        // 6. Designer submits another withdrawal for 700 and Admin approves
        $this->actingAs($designer)
            ->post('/designer/withdrawals', [
                'amount' => 700,
                'payment_method' => 'nagad',
                'account_number' => '01811223344',
            ])
            ->assertRedirect();

        $designer->refresh();
        $this->assertEquals(100.00, (float) $designer->balance); // 800 - 700

        $newWithdrawal = \App\Models\WithdrawalRequest::where('user_id', $designer->id)->latest()->first();

        $this->actingAs($admin)
            ->post('/admin/withdrawals/' . $newWithdrawal->id . '/status', [
                'status' => 'approved',
                'trx_id' => 'NAGAD-TXN-998877',
                'admin_notes' => 'সফলভাবে টাকা পাঠানো হয়েছে।',
            ])
            ->assertRedirect();

        $newWithdrawal->refresh();
        $designer->refresh();
        $this->assertEquals('approved', $newWithdrawal->status);
        $this->assertEquals('NAGAD-TXN-998877', $newWithdrawal->trx_id);
        $this->assertEquals(100.00, (float) $designer->balance);
    }
}
