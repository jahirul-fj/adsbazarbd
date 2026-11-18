<?php

namespace App\Http\Controllers;

use App\Models\AdCategory;
use App\Models\ClassifiedAd;
use App\Models\Newspaper;
use App\Models\PaymentRecord;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class ClassifiedAdController extends Controller
{
    public function index()
    {
        $newspapers = Newspaper::where('is_active', true)->orderBy('sort_order')->get();
        $categories = AdCategory::where('is_active', true)
            ->whereIn('type', ['all', 'classified'])
            ->orderBy('sort_order')
            ->get();

        return view('classified.index', compact('newspapers', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:30',
            'newspaper_id' => 'required|exists:newspapers,id',
            'ad_category_id' => 'required|exists:ad_categories,id',
            'publish_date' => 'required|date|after_or_equal:today',
            'title' => 'required|string|max:255',
            'ad_body' => 'required|string|min:10',
            'document_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'payment_method' => 'required|in:bkash,nagad,rocket,bank,cash_pickup',
            'payment_trx_id' => 'nullable|string|max:100',
            'payment_sender_phone' => 'nullable|string|max:30',
        ]);

        $newspaper = Newspaper::findOrFail($validated['newspaper_id']);
        
        // Count words (supporting Bengali words split by whitespace)
        $words = preg_split('/\s+/u', trim($validated['ad_body']));
        $wordCount = max(count(array_filter($words)), $newspaper->min_words);

        // Price calculation: words * rate
        $totalAmount = round($wordCount * $newspaper->classified_rate_per_word, 2);

        $documentPath = null;
        if ($request->hasFile('document_file')) {
            $documentPath = $request->file('document_file')->store('documents', 'public');
        }

        $trackingNo = ClassifiedAd::generateTrackingNo();

        $ad = ClassifiedAd::create([
            'tracking_no' => $trackingNo,
            'user_id' => auth()->id(),
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'],
            'newspaper_id' => $validated['newspaper_id'],
            'ad_category_id' => $validated['ad_category_id'],
            'publish_date' => $validated['publish_date'],
            'title' => $validated['title'],
            'ad_body' => $validated['ad_body'],
            'word_count' => $wordCount,
            'document_file' => $documentPath,
            'total_amount' => $totalAmount,
            'payment_method' => $validated['payment_method'],
            'payment_trx_id' => $validated['payment_trx_id'],
            'payment_sender_phone' => $validated['payment_sender_phone'],
            'payment_status' => $validated['payment_trx_id'] ? 'pending_verification' : 'unpaid',
            'status' => 'pending',
        ]);

        // Record payment
        PaymentRecord::create([
            'invoice_no' => PaymentRecord::generateInvoiceNo(),
            'user_id' => auth()->id(),
            'order_type' => 'classified_ad',
            'order_id' => $ad->id,
            'amount' => $totalAmount,
            'payment_method' => $validated['payment_method'],
            'trx_id' => $validated['payment_trx_id'],
            'sender_phone' => $validated['payment_sender_phone'],
            'status' => 'pending',
            'notes' => 'Customer submitted payment for classified ad #' . $trackingNo,
        ]);

        return redirect()->route('classified.show', $ad->tracking_no)
            ->with('success', 'আপনার শ্রেণীভুক্ত বিজ্ঞাপনটি সফলভাবে জমা হয়েছে! ট্র্যাকিং নম্বরটি সংরক্ষণ করুন।');
    }

    public function show($trackingNo)
    {
        $ad = ClassifiedAd::with(['newspaper', 'category'])->where('tracking_no', $trackingNo)->firstOrFail();
        return view('classified.show', compact('ad'));
    }
}
