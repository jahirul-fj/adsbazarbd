<?php

namespace App\Http\Controllers;

use App\Models\ClassifiedAd;
use App\Models\DesignOrder;
use App\Models\DesignOrderMessage;
use App\Models\DisplayAd;
use App\Models\SystemSetting;
use App\Models\User;
use Illuminate\Http\Request;

class ClientDashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        $userEmail = auth()->user()->email;

        $classifiedCount = ClassifiedAd::where('user_id', $userId)->orWhere('customer_email', $userEmail)->count();
        $displayCount = DisplayAd::where('user_id', $userId)->orWhere('customer_email', $userEmail)->count();
        $activeOrdersCount = DesignOrder::where('client_id', $userId)->whereIn('status', ['in_progress', 'draft_submitted', 'revision_requested'])->count();

        $recentClassified = ClassifiedAd::with('newspaper')
            ->where(function ($q) use ($userId, $userEmail) {
                $q->where('user_id', $userId)->orWhere('customer_email', $userEmail);
            })
            ->latest()
            ->take(5)
            ->get();

        $recentDisplay = DisplayAd::with('newspaper')
            ->where(function ($q) use ($userId, $userEmail) {
                $q->where('user_id', $userId)->orWhere('customer_email', $userEmail);
            })
            ->latest()
            ->take(5)
            ->get();

        $recentOrders = DesignOrder::with('designer')
            ->where('client_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        return view('client.dashboard', compact('classifiedCount', 'displayCount', 'activeOrdersCount', 'recentClassified', 'recentDisplay', 'recentOrders'));
    }

    public function myClassifiedAds()
    {
        $userId = auth()->id();
        $userEmail = auth()->user()->email;

        $ads = ClassifiedAd::with(['newspaper', 'category'])
            ->where(function ($q) use ($userId, $userEmail) {
                $q->where('user_id', $userId)->orWhere('customer_email', $userEmail);
            })
            ->latest()
            ->paginate(10);

        return view('client.classified-ads', compact('ads'));
    }

    public function myDisplayAds()
    {
        $userId = auth()->id();
        $userEmail = auth()->user()->email;

        $ads = DisplayAd::with(['newspaper', 'category'])
            ->where(function ($q) use ($userId, $userEmail) {
                $q->where('user_id', $userId)->orWhere('customer_email', $userEmail);
            })
            ->latest()
            ->paginate(10);

        return view('client.display-ads', compact('ads'));
    }

    public function myDesignOrders()
    {
        $orders = DesignOrder::with('designer')
            ->where('client_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('client.orders', compact('orders'));
    }

    public function showOrder($id)
    {
        $order = DesignOrder::with(['designer.designerProfile', 'messages.sender'])
            ->where('client_id', auth()->id())
            ->findOrFail($id);

        return view('client.order-show', compact('order'));
    }

    public function sendOrderMessage(Request $request, $id)
    {
        $order = DesignOrder::where('client_id', auth()->id())->findOrFail($id);

        $validated = $request->validate([
            'message' => 'required|string|min:2',
            'attachment_file' => 'nullable|file|mimes:pdf,jpg,png,zip,doc,docx|max:10240',
            'request_revision' => 'nullable|boolean',
        ]);

        $attachment = null;
        if ($request->hasFile('attachment_file')) {
            $attachment = $request->file('attachment_file')->store('order_attachments', 'public');
        }

        if ($request->boolean('request_revision') && $order->revisions_remaining > 0) {
            $order->status = 'revision_requested';
            $order->revisions_remaining -= 1;
            $order->save();
        }

        DesignOrderMessage::create([
            'design_order_id' => $order->id,
            'sender_id' => auth()->id(),
            'message' => $validated['message'],
            'attachment_file' => $attachment,
        ]);

        return back()->with('success', 'আপনার মেসেজ সফলভাবে পাঠানো হয়েছে।');
    }

    public function approveOrder(Request $request, $id)
    {
        $order = DesignOrder::where('client_id', auth()->id())->findOrFail($id);

        if ($order->status === 'completed') {
            return back()->with('info', 'অর্ডারটি ইতিমধ্যে সম্পন্ন হয়েছে।');
        }

        // Calculate dynamic platform commission
        $commissionPercent = (float) SystemSetting::get('designer_commission_percent', 15.00);
        $commissionAmount = round($order->budget * ($commissionPercent / 100), 2);
        $designerEarning = round($order->budget - $commissionAmount, 2);

        $order->status = 'completed';
        $order->platform_commission_percent = $commissionPercent;
        $order->platform_commission_amount = $commissionAmount;
        $order->designer_earning = $designerEarning;
        $order->save();

        // Release net earnings to designer balance
        $designer = User::find($order->designer_id);
        if ($designer) {
            $designer->balance += $designerEarning;
            $designer->save();

            if ($designer->designerProfile) {
                $designer->designerProfile->increment('completed_orders');
            }
        }

        return back()->with('success', 'ডিজাইনটি চূড়ান্তভাবে অনুমোদিত হয়েছে এবং ডিজাইনারকে নিট পেমেন্ট (৳' . number_format($designerEarning, 2) . ') প্রদান করা হয়েছে!');
    }

    public function submitReview(Request $request, $id)
    {
        $order = DesignOrder::where('client_id', auth()->id())->findOrFail($id);

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review_comment' => 'required|string|min:5|max:1000',
        ]);

        $order->rating = $validated['rating'];
        $order->review_comment = $validated['review_comment'];
        $order->save();

        // Update designer profile rating
        $designer = User::find($order->designer_id);
        if ($designer && $designer->designerProfile) {
            $profile = $designer->designerProfile;
            $profile->increment('total_reviews');
            // update running average
            $profile->rating = round((($profile->rating * ($profile->total_reviews - 1)) + $validated['rating']) / $profile->total_reviews, 2);
            $profile->save();
        }

        return back()->with('success', 'আপনার মূল্যবান রিভিউ প্রদানের জন্য ধন্যবাদ!');
    }
}
