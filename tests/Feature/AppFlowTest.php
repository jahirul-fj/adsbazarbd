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

    public function test_comprehensive_display_rates_chart_and_booking(): void
    {
        // Find Prothom Alo
        $newspaper = Newspaper::where('slug', 'prothom-alo')->first();
        $this->assertNotNull($newspaper);
        $this->assertEquals(30000, $newspaper->getDisplayRate('fp', 'color'));
        $this->assertEquals(23000, $newspaper->getDisplayRate('page_3', 'color'));

        // Book ad for Page 3 Color: 2 cols x 5 inches = 10 col-in @ 23000 = 230,000
        $response = $this->post('/display-advertisement', [
            'customer_name' => 'মেঘনা গ্রুপ',
            'customer_email' => 'ad@meghnagroup.test',
            'customer_phone' => '01711998877',
            'newspaper_id' => $newspaper->id,
            'publish_date' => now()->addDays(2)->toDateString(),
            'title' => 'প্রোডাক্ট লঞ্চিং বিজ্ঞাপন',
            'page_position' => 'page_3',
            'color_type' => 'color',
            'columns' => 2,
            'height_inches' => 5.0,
            'payment_method' => 'bkash',
            'payment_trx_id' => 'BK-MEGHNA-101',
            'payment_sender_phone' => '01711998877',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('display_ads', [
            'customer_name' => 'মেঘনা গ্রুপ',
            'page_position' => 'page_3',
            'rate_applied' => 23000,
            'total_amount' => 230000.00,
        ]);

        // Admin updates rate for newspaper
        $admin = User::where('role', 'admin')->first();
        $this->actingAs($admin)
            ->post('/admin/newspapers/' . $newspaper->id, [
                'name' => 'দৈনিক প্রথম আলো (Prothom Alo)',
                'classified_rate_per_word' => 25,
                'display_rates' => [
                    'inner_bw' => 6500,
                    'inner_color' => 9500,
                    'fp_color' => 32000, // increased
                    'page_3_color' => 24000, // increased
                ]
            ])->assertRedirect();

        $newspaper->refresh();
        $this->assertEquals(32000, $newspaper->getDisplayRate('fp', 'color'));
        $this->assertEquals(24000, $newspaper->getDisplayRate('page_3', 'color'));
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

    public function test_admin_profile_and_password_update(): void
    {
        $admin = User::where('role', 'admin')->first();
        $this->actingAs($admin);

        // View profile
        $this->get('/admin/profile')->assertStatus(200);

        // Update profile
        $this->post('/admin/profile', [
            'name' => 'সুপার অ্যাডমিন আপডেট',
            'email' => 'admin_updated@adsbazarbd.com',
            'phone' => '01999887766',
            'bio' => 'আপডেটেড বায়ো বিবরণ',
        ])->assertRedirect();

        $admin->refresh();
        $this->assertEquals('সুপার অ্যাডমিন আপডেট', $admin->name);
        $this->assertEquals('admin_updated@adsbazarbd.com', $admin->email);
        $this->assertEquals('01999887766', $admin->phone);
        $this->assertEquals('আপডেটেড বায়ো বিবরণ', $admin->bio);

        // Password update fail on incorrect current password
        $failPass = $this->post('/admin/password', [
            'current_password' => 'wrong_password',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);
        $failPass->assertSessionHas('error');

        // Password update success
        $successPass = $this->post('/admin/password', [
            'current_password' => 'password',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);
        $successPass->assertRedirect();
        $admin->refresh();
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('newpassword123', $admin->password));
    }

    public function test_client_profile_and_password_update(): void
    {
        $client = User::where('role', 'client')->first();
        $this->actingAs($client);

        // View profile
        $this->get('/client/profile')->assertStatus(200);

        // Update profile
        $this->post('/client/profile', [
            'name' => 'ক্লায়েন্ট ইউজার আপডেট',
            'email' => 'client_updated@adsbazarbd.com',
            'phone' => '01777665544',
            'bio' => 'গুলশান ২, ঢাকা',
        ])->assertRedirect();

        $client->refresh();
        $this->assertEquals('ক্লায়েন্ট ইউজার আপডেট', $client->name);
        $this->assertEquals('client_updated@adsbazarbd.com', $client->email);
        $this->assertEquals('01777665544', $client->phone);

        // Password update
        $this->post('/client/password', [
            'current_password' => 'password',
            'password' => 'clientSecret456',
            'password_confirmation' => 'clientSecret456',
        ])->assertRedirect();

        $client->refresh();
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('clientSecret456', $client->password));
    }

    public function test_designer_profile_and_password_update(): void
    {
        $designer = User::where('role', 'designer')->first();
        $this->actingAs($designer);

        // View profile
        $this->get('/designer/profile')->assertStatus(200);

        // Update profile
        $this->post('/designer/profile', [
            'name' => 'তানভীর রহমান প্রো',
            'email' => 'tanvir_pro@adsbazarbd.com',
            'phone' => '01888776655',
            'tagline' => 'সিনিয়র বিজ্ঞাপন আর্ট ডিরেক্টর',
            'about' => '৮ বছরের অধিক প্রি-প্রেস ও পত্রিকা বিজ্ঞাপন ডিজাইনের দীর্ঘ অভিজ্ঞতা রয়েছে।',
            'experience_years' => 8,
            'starting_rate' => 800,
            'skills' => 'Illustrator, Photoshop, InDesign',
            'is_available' => 1,
        ])->assertRedirect();

        $designer->refresh();
        $this->assertEquals('তানভীর রহমান প্রো', $designer->name);
        $this->assertEquals('tanvir_pro@adsbazarbd.com', $designer->email);
        $this->assertEquals('সিনিয়র বিজ্ঞাপন আর্ট ডিরেক্টর', $designer->designerProfile->tagline);

        // Password update
        $this->post('/designer/password', [
            'current_password' => 'password',
            'password' => 'designerSecret789',
            'password_confirmation' => 'designerSecret789',
        ])->assertRedirect();

        $designer->refresh();
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('designerSecret789', $designer->password));
    }

    public function test_ad_forms_preselect_newspaper_from_query_parameters(): void
    {
        $newspaper = Newspaper::where('slug', 'jugantor')->first();
        $this->assertNotNull($newspaper);

        // Classified advertisement preselects newspaper
        $response = $this->get('/classified-advertisement?newspaper_id=' . $newspaper->id);
        $response->assertStatus(200);
        $response->assertSee('value="' . $newspaper->id . '"', false);
        $response->assertSee('selected>' . "\n" . '                                ' . $newspaper->name, false);

        // Display advertisement preselects newspaper
        $response = $this->get('/display-advertisement?newspaper_id=' . $newspaper->id);
        $response->assertStatus(200);
        $response->assertSee('selected>' . "\n" . '                                ' . $newspaper->name, false);
    }

    public function test_comprehensive_full_site_crawler_for_all_roles(): void
    {
        // 1. Guest / Public Visitors
        $publicUrls = [
            '/',
            '/about',
            '/faq',
            '/contact',
            '/pricing',
            '/classified-advertisement',
            '/display-advertisement',
            '/designers',
            '/designers/1',
            '/login',
            '/portal-select',
            '/register',
            '/admin/login',
            '/client/login',
            '/client/register',
            '/designer/login',
            '/designer/register',
            '/track-ad',
            '/track-ad?tracking_no=CLS-202611-1001',
            '/track-ad?tracking_no=cls-202611-1001',
            '/track-ad?tracking_no=DSP-202611-2001',
            '/track-ad?tracking_no=dsp-202611-2001',
            '/classified-advertisement/CLS-202611-1001',
            '/classified-advertisement/cls-202611-1001',
            '/display-advertisement/DSP-202611-2001',
            '/display-advertisement/dsp-202611-2001',
        ];

        foreach ($publicUrls as $url) {
            $res = $this->get($url);
            $this->assertEquals(200, $res->status(), "Failed loading public URL: {$url}");
        }

        // 2. Admin User
        $admin = User::where('role', 'admin')->first();
        $adminUrls = [
            '/admin/dashboard',
            '/admin/classified-ads',
            '/admin/display-ads',
            '/admin/newspapers',
            '/admin/categories',
            '/admin/designers',
            '/admin/users',
            '/admin/design-orders',
            '/admin/payments',
            '/admin/withdrawals',
            '/admin/settings',
            '/admin/profile',
        ];

        foreach ($adminUrls as $url) {
            $res = $this->actingAs($admin)->get($url);
            $this->assertEquals(200, $res->status(), "Failed loading admin URL: {$url}");
        }

        // 3. Client User
        $client = User::where('role', 'client')->first();
        $clientUrls = [
            '/client/dashboard',
            '/client/classified-ads',
            '/client/display-ads',
            '/client/orders',
            '/client/orders/1',
            '/client/profile',
            '/designers/1/hire',
        ];

        foreach ($clientUrls as $url) {
            $res = $this->actingAs($client)->get($url);
            $this->assertEquals(200, $res->status(), "Failed loading client URL: {$url}");
        }

        // 4. Designer User
        $designer = User::where('role', 'designer')->first();
        $designerUrls = [
            '/designer/dashboard',
            '/designer/orders',
            '/designer/orders/1',
            '/designer/withdrawals',
            '/designer/profile',
        ];

        foreach ($designerUrls as $url) {
            $res = $this->actingAs($designer)->get($url);
            $this->assertEquals(200, $res->status(), "Failed loading designer URL: {$url}");
        }
    }
}
