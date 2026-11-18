<?php

namespace App\Http\Controllers;

use App\Models\AdCategory;
use App\Models\ClassifiedAd;
use App\Models\DesignerProfile;
use App\Models\DesignOrder;
use App\Models\DisplayAd;
use App\Models\Newspaper;
use App\Models\PaymentRecord;
use App\Models\SystemSetting;
use App\Models\User;
use App\Models\WithdrawalRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $metrics = [
            'total_revenue' => PaymentRecord::where('status', 'approved')->sum('amount'),
            'today_revenue' => PaymentRecord::where('status', 'approved')->whereDate('created_at', today())->sum('amount'),
            'pending_classified' => ClassifiedAd::where('status', 'pending')->count(),
            'pending_display' => DisplayAd::where('status', 'pending')->count(),
            'pending_payments' => PaymentRecord::where('status', 'pending')->count(),
            'total_users' => User::where('role', 'client')->count(),
            'total_designers' => User::where('role', 'designer')->count(),
            'total_newspapers' => Newspaper::count(),
            'active_orders' => DesignOrder::whereIn('status', ['in_progress', 'draft_submitted', 'revision_requested'])->count(),
            'completed_ads' => ClassifiedAd::where('status', 'published')->count() + DisplayAd::where('status', 'published')->count(),
            'total_commission_earnings' => DesignOrder::where('status', 'completed')->sum('platform_commission_amount'),
            'pending_withdrawals' => WithdrawalRequest::where('status', 'pending')->count(),
        ];

        // Monthly revenue chart data (last 6 months)
        $monthlyRevenue = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $revenue = PaymentRecord::where('status', 'approved')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('amount');
            $monthlyRevenue[] = [
                'month' => $month->format('M'),
                'amount' => (float)$revenue,
            ];
        }

        // Ad distribution by category
        $categoryStats = AdCategory::withCount('classifiedAds')->get();

        $recentClassified = ClassifiedAd::with('newspaper')->latest()->take(6)->get();
        $recentDisplay = DisplayAd::with('newspaper')->latest()->take(6)->get();
        $recentPayments = PaymentRecord::latest()->take(6)->get();

        return view('admin.dashboard', compact('metrics', 'monthlyRevenue', 'categoryStats', 'recentClassified', 'recentDisplay', 'recentPayments'));
    }

    public function classifiedAds(Request $request)
    {
        $query = ClassifiedAd::with(['newspaper', 'category'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('newspaper_id')) {
            $query->where('newspaper_id', $request->newspaper_id);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('tracking_no', 'like', "%{$s}%")
                  ->orWhere('customer_name', 'like', "%{$s}%")
                  ->orWhere('customer_phone', 'like', "%{$s}%");
            });
        }

        $ads = $query->paginate(15)->withQueryString();
        $newspapers = Newspaper::all();

        return view('admin.classified-ads', compact('ads', 'newspapers'));
    }

    public function updateClassifiedStatus(Request $request, $id)
    {
        $ad = ClassifiedAd::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:pending,approved,published,rejected',
            'payment_status' => 'required|in:unpaid,pending_verification,paid,rejected',
            'published_proof_url' => 'nullable|url|max:500',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $ad->update($validated);

        return back()->with('success', 'শ্রেণীভুক্ত বিজ্ঞাপনের স্ট্যাটাস সফলভাবে আপডেট করা হয়েছে!');
    }

    public function displayAds(Request $request)
    {
        $query = DisplayAd::with(['newspaper', 'category'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('newspaper_id')) {
            $query->where('newspaper_id', $request->newspaper_id);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('tracking_no', 'like', "%{$s}%")
                  ->orWhere('customer_name', 'like', "%{$s}%")
                  ->orWhere('customer_phone', 'like', "%{$s}%");
            });
        }

        $ads = $query->paginate(15)->withQueryString();
        $newspapers = Newspaper::all();

        return view('admin.display-ads', compact('ads', 'newspapers'));
    }

    public function updateDisplayStatus(Request $request, $id)
    {
        $ad = DisplayAd::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:pending,in_review,approved,published,rejected',
            'payment_status' => 'required|in:unpaid,pending_verification,paid,rejected',
            'published_proof_url' => 'nullable|url|max:500',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $ad->update($validated);

        return back()->with('success', 'ডিসপ্লে বিজ্ঞাপনের স্ট্যাটাস সফলভাবে আপডেট করা হয়েছে!');
    }

    public function newspapers()
    {
        $newspapers = Newspaper::orderBy('sort_order')->get();
        return view('admin.newspapers', compact('newspapers'));
    }

    public function storeNewspaper(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'language' => 'required|in:bangla,english',
            'classified_rate_per_word' => 'required|numeric|min:1',
            'display_rate_col_inch' => 'nullable|numeric|min:1',
            'front_page_multiplier' => 'nullable|numeric|min:1',
            'back_page_multiplier' => 'nullable|numeric|min:1',
            'color_charge_percent' => 'nullable|integer|min:0',
            'min_words' => 'required|integer|min:5',
            'display_rates' => 'nullable|array',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        if ($request->has('display_rates')) {
            $rates = [];
            foreach ($request->input('display_rates', []) as $k => $v) {
                $rates[$k] = ($v !== '' && $v !== null) ? (float)$v : null;
            }
            $validated['display_rates'] = $rates;
            if (!empty($rates['inner_bw'])) {
                $validated['display_rate_col_inch'] = $rates['inner_bw'];
            }
        }

        $validated['display_rate_col_inch'] = $validated['display_rate_col_inch'] ?? 2000.00;
        $validated['front_page_multiplier'] = $validated['front_page_multiplier'] ?? 2.50;
        $validated['back_page_multiplier'] = $validated['back_page_multiplier'] ?? 1.80;
        $validated['color_charge_percent'] = $validated['color_charge_percent'] ?? 30;

        Newspaper::create($validated);

        return back()->with('success', 'নতুন সংবাদপত্র সফলভাবে যোগ করা হয়েছে!');
    }

    public function updateNewspaper(Request $request, $id)
    {
        $newspaper = Newspaper::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'classified_rate_per_word' => 'required|numeric|min:1',
            'display_rate_col_inch' => 'nullable|numeric|min:1',
            'front_page_multiplier' => 'nullable|numeric|min:1',
            'back_page_multiplier' => 'nullable|numeric|min:1',
            'color_charge_percent' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
            'display_rates' => 'nullable|array',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->has('display_rates')) {
            $rates = $newspaper->display_rates ?? [];
            foreach ($request->input('display_rates', []) as $k => $v) {
                $rates[$k] = ($v !== '' && $v !== null) ? (float)$v : null;
            }
            $validated['display_rates'] = $rates;
            if (!empty($rates['inner_bw'])) {
                $validated['display_rate_col_inch'] = $rates['inner_bw'];
            }
        }

        $newspaper->update($validated);

        return back()->with('success', 'সংবাদপত্রের রেট ও তথ্য আপডেট করা হয়েছে!');
    }

    public function categories()
    {
        $categories = AdCategory::orderBy('sort_order')->get();
        return view('admin.categories', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:all,classified,display',
            'sample_text' => 'nullable|string',
            'requires_document' => 'nullable|boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['requires_document'] = $request->boolean('requires_document');
        AdCategory::create($validated);

        return back()->with('success', 'নতুন ক্যাটাগরি সফলভাবে তৈরি করা হয়েছে!');
    }

    public function designers()
    {
        $designers = DesignerProfile::with('user')->latest()->paginate(15);
        return view('admin.designers', compact('designers'));
    }

    public function toggleDesignerFeatured($id)
    {
        $profile = DesignerProfile::findOrFail($id);
        $profile->is_featured = !$profile->is_featured;
        $profile->save();

        return back()->with('success', 'ডিজাইনার ফিচার্ড স্ট্যাটাস আপডেট করা হয়েছে!');
    }

    public function users()
    {
        $users = User::where('role', 'client')->withCount(['classifiedAds', 'displayAds'])->latest()->paginate(15);
        return view('admin.users', compact('users'));
    }

    public function designOrders()
    {
        $orders = DesignOrder::with(['client', 'designer'])->latest()->paginate(15);
        return view('admin.design-orders', compact('orders'));
    }

    public function payments(Request $request)
    {
        $query = PaymentRecord::latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $payments = $query->paginate(15)->withQueryString();
        return view('admin.payments', compact('payments'));
    }

    public function updatePaymentStatus(Request $request, $id)
    {
        $payment = PaymentRecord::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'notes' => 'nullable|string|max:500',
        ]);

        $payment->status = $validated['status'];
        $payment->notes = $validated['notes'];
        $payment->verified_by = auth()->id();
        $payment->verified_at = now();
        $payment->save();

        if ($payment->order_type === 'classified_ad') {
            $ad = ClassifiedAd::find($payment->order_id);
            if ($ad) {
                $ad->payment_status = $payment->status === 'approved' ? 'paid' : ($payment->status === 'rejected' ? 'rejected' : 'pending_verification');
                if ($payment->status === 'approved' && $ad->status === 'pending') {
                    $ad->status = 'approved';
                }
                $ad->save();
            }
        } elseif ($payment->order_type === 'display_ad') {
            $ad = DisplayAd::find($payment->order_id);
            if ($ad) {
                $ad->payment_status = $payment->status === 'approved' ? 'paid' : ($payment->status === 'rejected' ? 'rejected' : 'pending_verification');
                if ($payment->status === 'approved' && $ad->status === 'pending') {
                    $ad->status = 'approved';
                }
                $ad->save();
            }
        }

        return back()->with('success', 'পেমেন্ট ট্রানজেকশন সফলভাবে ভেরিফাই ও আপডেট করা হয়েছে!');
    }

    public function settings()
    {
        $settings = SystemSetting::all()->pluck('value', 'key');
        return view('admin.settings', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        $keys = [
            'site_name',
            'site_tagline',
            'helpline_phone',
            'helpline_email',
            'office_address',
            'bkash_merchant_number',
            'nagad_merchant_number',
            'rocket_number',
            'bank_info',
            'cash_pickup_notice',
            'designer_commission_percent',
            'min_withdrawal_amount',
        ];

        foreach ($keys as $k) {
            if ($request->has($k)) {
                SystemSetting::set($k, $request->input($k));
            }
        }

        return back()->with('success', 'সিস্টেম সেটিংস সফলভাবে সেভ করা হয়েছে!');
    }

    public function withdrawals(Request $request)
    {
        $query = WithdrawalRequest::with('user.designerProfile')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $withdrawals = $query->paginate(15)->withQueryString();

        return view('admin.withdrawals', compact('withdrawals'));
    }

    public function updateWithdrawalStatus(Request $request, $id)
    {
        $withdrawal = WithdrawalRequest::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
            'trx_id' => 'nullable|string|max:100',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        if ($withdrawal->status === 'pending' && $validated['status'] === 'rejected') {
            // Refund the requested amount back to designer balance
            $designer = $withdrawal->user;
            if ($designer) {
                $designer->balance += $withdrawal->amount;
                $designer->save();
            }
        }

        $withdrawal->update([
            'status' => $validated['status'],
            'trx_id' => $validated['trx_id'] ?? $withdrawal->trx_id,
            'admin_notes' => $validated['admin_notes'] ?? $withdrawal->admin_notes,
            'processed_at' => now(),
        ]);

        $msg = $validated['status'] === 'approved' 
            ? 'টাকা উত্তোলনের আবেদন সফলভাবে অনুমোদন ও পরিশোধিত হিসেবে মার্ক করা হয়েছে!' 
            : 'টাকা উত্তোলনের আবেদন বাতিল করা হয়েছে এবং ডিজাইনারের ব্যালেন্সে টাকা রিফান্ড করা হয়েছে।';

        return back()->with('success', $msg);
    }

    public function profile()
    {
        $user = auth()->user();
        return view('admin.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:30',
            'bio' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];
        $user->bio = $validated['bio'] ?? null;
        $user->save();

        return back()->with('success', 'আপনার অ্যাডমিন প্রোফাইল সফলভাবে আপডেট করা হয়েছে!');
    }

    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'password.confirmed' => 'নতুন পাসওয়ার্ড নিশ্চিতকরণ মিলছে না।',
            'password.min' => 'নতুন পাসওয়ার্ড অন্তত ৬ অক্ষরের হতে হবে।',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'আপনার বর্তমান পাসওয়ার্ডটি সঠিক নয়!');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'আপনার পাসওয়ার্ড সফলভাবে পরিবর্তন করা হয়েছে!');
    }
}
