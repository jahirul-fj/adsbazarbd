<?php

namespace App\Http\Controllers;

use App\Models\DesignerProfile;
use App\Models\DesignOrder;
use App\Models\DesignOrderMessage;
use App\Models\SystemSetting;
use App\Models\WithdrawalRequest;
use Illuminate\Http\Request;

class DesignerDashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        $user = auth()->user();
        $profile = $user->designerProfile ?? DesignerProfile::create([
            'user_id' => $userId,
            'tagline' => 'প্রফেশনাল গ্রাফিক ডিজাইনার',
            'starting_rate' => 500,
        ]);

        $activeOrdersCount = DesignOrder::where('designer_id', $userId)
            ->whereIn('status', ['in_progress', 'draft_submitted', 'revision_requested'])
            ->count();

        $completedOrdersCount = DesignOrder::where('designer_id', $userId)
            ->where('status', 'completed')
            ->count();

        $recentOrders = DesignOrder::with('client')
            ->where('designer_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        $minWithdrawal = (float) SystemSetting::get('min_withdrawal_amount', 500.00);
        $commissionPercent = (float) SystemSetting::get('designer_commission_percent', 15.00);
        $recentWithdrawals = WithdrawalRequest::where('user_id', $userId)->latest()->take(5)->get();

        return view('designer.dashboard', compact('profile', 'activeOrdersCount', 'completedOrdersCount', 'recentOrders', 'minWithdrawal', 'commissionPercent', 'recentWithdrawals'));
    }

    public function myOrders()
    {
        $orders = DesignOrder::with('client')
            ->where('designer_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('designer.orders', compact('orders'));
    }

    public function showOrder($id)
    {
        $order = DesignOrder::with(['client', 'messages.sender'])
            ->where('designer_id', auth()->id())
            ->findOrFail($id);

        $commissionPercent = (float) SystemSetting::get('designer_commission_percent', 15.00);

        return view('designer.order-show', compact('order', 'commissionPercent'));
    }

    public function sendOrderMessage(Request $request, $id)
    {
        $order = DesignOrder::where('designer_id', auth()->id())->findOrFail($id);

        $validated = $request->validate([
            'message' => 'required|string|min:2',
            'attachment_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,eps,ai,psd,zip|max:20480',
            'is_draft_submission' => 'nullable|boolean',
            'is_final_submission' => 'nullable|boolean',
        ]);

        $attachment = null;
        if ($request->hasFile('attachment_file')) {
            $attachment = $request->file('attachment_file')->store('order_deliveries', 'public');
        }

        if ($request->boolean('is_draft_submission')) {
            $order->status = 'draft_submitted';
            $order->save();
        }

        if ($request->boolean('is_final_submission')) {
            $order->status = 'draft_submitted';
            if ($attachment) {
                $order->final_delivery_file = $attachment;
            }
            $order->save();
        }

        DesignOrderMessage::create([
            'design_order_id' => $order->id,
            'sender_id' => auth()->id(),
            'message' => $validated['message'],
            'attachment_file' => $attachment,
            'is_draft_submission' => $request->boolean('is_draft_submission'),
            'is_final_submission' => $request->boolean('is_final_submission'),
        ]);

        return back()->with('success', 'আপনার ডিজাইন ফাইল ও মেসেজ সফলভাবে ক্লায়েন্টকে পাঠানো হয়েছে!');
    }

    public function profile()
    {
        $profile = auth()->user()->designerProfile ?? new DesignerProfile(['user_id' => auth()->id()]);
        return view('designer.profile', compact('profile'));
    }

    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'tagline' => 'required|string|max:255',
            'about' => 'required|string|min:20',
            'experience_years' => 'required|integer|min:0|max:50',
            'starting_rate' => 'required|numeric|min:100',
            'skills' => 'required|string|max:500',
            'is_available' => 'nullable|boolean',
        ]);

        $user = auth()->user();
        $user->name = $validated['name'];
        $user->phone = $validated['phone'];
        $user->save();

        $profile = $user->designerProfile;
        if (!$profile) {
            $profile = new DesignerProfile(['user_id' => $user->id]);
        }

        $profile->tagline = $validated['tagline'];
        $profile->about = $validated['about'];
        $profile->experience_years = $validated['experience_years'];
        $profile->starting_rate = $validated['starting_rate'];
        $profile->skills = $validated['skills'];
        $profile->is_available = $request->boolean('is_available');
        $profile->save();

        return back()->with('success', 'আপনার ডিজাইনার প্রোফাইল সফলভাবে আপডেট করা হয়েছে!');
    }

    public function withdrawals()
    {
        $userId = auth()->id();
        $minWithdrawal = (float) SystemSetting::get('min_withdrawal_amount', 500.00);
        $withdrawals = WithdrawalRequest::where('user_id', $userId)->latest()->paginate(10);

        return view('designer.withdrawals', compact('minWithdrawal', 'withdrawals'));
    }

    public function requestWithdrawal(Request $request)
    {
        $user = auth()->user();
        $minWithdrawal = (float) SystemSetting::get('min_withdrawal_amount', 500.00);

        $validated = $request->validate([
            'amount' => 'required|numeric|min:' . $minWithdrawal,
            'payment_method' => 'required|in:bkash,nagad,rocket,bank',
            'account_number' => 'required|string|max:50',
            'account_details' => 'nullable|string|max:500',
        ], [
            'amount.min' => 'নূন্যতম উইথড্রয়াল পরিমাণ ৳' . number_format($minWithdrawal, 0) . ' হতে হবে।',
        ]);

        if ($user->balance < $validated['amount']) {
            return back()->with('error', 'আপনার অ্যাকাউন্টে পর্যাপ্ত ব্যালেন্স নেই। বর্তমান উত্তোলনযোগ্য ব্যালেন্স: ৳' . number_format($user->balance, 2));
        }

        // Deduct from user balance
        $user->balance -= $validated['amount'];
        $user->save();

        WithdrawalRequest::create([
            'request_no' => 'WTH-' . date('Ymd') . '-' . rand(1000, 9999),
            'user_id' => $user->id,
            'amount' => $validated['amount'],
            'payment_method' => $validated['payment_method'],
            'account_number' => $validated['account_number'],
            'account_details' => $validated['account_details'] ?? null,
            'status' => 'pending',
        ]);

        return back()->with('success', 'টাকা উত্তোলনের আবেদন সফলভাবে গৃহীত হয়েছে! অ্যাডমিন ভেরিফাই করে পেমেন্ট পাঠিয়ে দেবে।');
    }
}
