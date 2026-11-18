<?php

namespace App\Http\Controllers;

use App\Models\AdCategory;
use App\Models\DisplayAd;
use App\Models\Newspaper;
use App\Models\PaymentRecord;
use Illuminate\Http\Request;

class DisplayAdController extends Controller
{
    public function index()
    {
        $newspapers = Newspaper::where('is_active', true)->orderBy('sort_order')->get();
        $categories = AdCategory::where('is_active', true)
            ->whereIn('type', ['all', 'display'])
            ->orderBy('sort_order')
            ->get();

        return view('display.index', compact('newspapers', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:30',
            'newspaper_id' => 'required|exists:newspapers,id',
            'ad_category_id' => 'nullable|exists:ad_categories,id',
            'publish_date' => 'required|date|after_or_equal:today',
            'title' => 'required|string|max:255',
            'page_position' => 'required|in:front_page,back_page,inner_page',
            'color_type' => 'required|in:color,black_white',
            'columns' => 'required|integer|min:1|max:8',
            'height_inches' => 'required|numeric|min:1|max:21',
            'artwork_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,eps,ai,psd|max:20480',
            'needs_designer' => 'nullable|boolean',
            'payment_method' => 'required|in:bkash,nagad,rocket,bank,cash_pickup',
            'payment_trx_id' => 'nullable|string|max:100',
            'payment_sender_phone' => 'nullable|string|max:30',
        ]);

        $newspaper = Newspaper::findOrFail($validated['newspaper_id']);
        
        $columns = (int)$validated['columns'];
        $height = (float)$validated['height_inches'];
        $totalColInches = round($columns * $height, 2);

        // Page multiplier
        $multiplier = match ($validated['page_position']) {
            'front_page' => (float)$newspaper->front_page_multiplier,
            'back_page' => (float)$newspaper->back_page_multiplier,
            default => (float)$newspaper->inner_page_multiplier,
        };

        // Base rate
        $baseRate = (float)$newspaper->display_rate_col_inch * $multiplier;

        // Color surcharge
        if ($validated['color_type'] === 'color') {
            $baseRate = $baseRate * (1 + ($newspaper->color_charge_percent / 100));
        }

        $totalAmount = round($totalColInches * $baseRate, 2);

        $artworkPath = null;
        if ($request->hasFile('artwork_file')) {
            $artworkPath = $request->file('artwork_file')->store('artworks', 'public');
        }

        $trackingNo = DisplayAd::generateTrackingNo();

        $ad = DisplayAd::create([
            'tracking_no' => $trackingNo,
            'user_id' => auth()->id(),
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'],
            'newspaper_id' => $validated['newspaper_id'],
            'ad_category_id' => $validated['ad_category_id'] ?? null,
            'publish_date' => $validated['publish_date'],
            'title' => $validated['title'],
            'page_position' => $validated['page_position'],
            'color_type' => $validated['color_type'],
            'columns' => $columns,
            'height_inches' => $height,
            'total_col_inches' => $totalColInches,
            'rate_applied' => $baseRate,
            'artwork_file' => $artworkPath,
            'needs_designer' => $request->boolean('needs_designer'),
            'total_amount' => $totalAmount,
            'payment_method' => $validated['payment_method'],
            'payment_trx_id' => $validated['payment_trx_id'],
            'payment_sender_phone' => $validated['payment_sender_phone'],
            'payment_status' => $validated['payment_trx_id'] ? 'pending_verification' : 'unpaid',
            'status' => 'pending',
        ]);

        PaymentRecord::create([
            'invoice_no' => PaymentRecord::generateInvoiceNo(),
            'user_id' => auth()->id(),
            'order_type' => 'display_ad',
            'order_id' => $ad->id,
            'amount' => $totalAmount,
            'payment_method' => $validated['payment_method'],
            'trx_id' => $validated['payment_trx_id'],
            'sender_phone' => $validated['payment_sender_phone'],
            'status' => 'pending',
            'notes' => 'Customer submitted payment for display ad #' . $trackingNo,
        ]);

        return redirect()->route('display.show', $ad->tracking_no)
            ->with('success', 'আপনার ডিসপ্লে বিজ্ঞাপনটি সফলভাবে জমা হয়েছে! ট্র্যাকিং নম্বরটি সংরক্ষণ করুন।');
    }

    public function show($trackingNo)
    {
        $ad = DisplayAd::with(['newspaper', 'category'])->where('tracking_no', $trackingNo)->firstOrFail();
        return view('display.show', compact('ad'));
    }
}
