<?php

namespace App\Http\Controllers;

use App\Models\DesignerProfile;
use App\Models\DesignOrder;
use App\Models\DesignOrderMessage;
use App\Models\PaymentRecord;
use App\Models\User;
use Illuminate\Http\Request;

class DesignerController extends Controller
{
    public function index(Request $request)
    {
        $query = DesignerProfile::with('user')->where('is_available', true);

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('tagline', 'like', "%{$s}%")
                  ->orWhere('skills', 'like', "%{$s}%")
                  ->orWhereHas('user', function ($uq) use ($s) {
                      $uq->where('name', 'like', "%{$s}%");
                  });
            });
        }

        $designers = $query->orderByDesc('rating')->paginate(9);

        return view('designers.index', compact('designers'));
    }

    public function show($id)
    {
        $profile = DesignerProfile::with('user')->findOrFail($id);
        return view('designers.show', compact('profile'));
    }

    public function hire($id)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('info', 'ডিজাইনার নিয়োগ করতে অনুগ্রহ করে আগে লগইন বা সাইনআপ করুন।');
        }

        $profile = DesignerProfile::with('user')->findOrFail($id);
        return view('designers.hire', compact('profile'));
    }

    public function storeOrder(Request $request, $id)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $profile = DesignerProfile::with('user')->findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'brief_description' => 'required|string|min:20',
            'ad_size_requirement' => 'required|string|max:100',
            'attachment_file' => 'nullable|file|mimes:pdf,jpg,png,zip,doc,docx|max:15360',
            'budget' => 'required|numeric|min:' . $profile->starting_rate,
            'payment_method' => 'required|in:bkash,nagad,rocket,bank',
            'trx_id' => 'required|string|max:100',
            'sender_phone' => 'required|string|max:30',
        ]);

        $filePath = null;
        if ($request->hasFile('attachment_file')) {
            $filePath = $request->file('attachment_file')->store('design_briefs', 'public');
        }

        $orderNo = DesignOrder::generateOrderNo();

        $order = DesignOrder::create([
            'order_no' => $orderNo,
            'client_id' => auth()->id(),
            'designer_id' => $profile->user_id,
            'title' => $validated['title'],
            'brief_description' => $validated['brief_description'],
            'ad_size_requirement' => $validated['ad_size_requirement'],
            'attachment_file' => $filePath,
            'budget' => $validated['budget'],
            'revisions_remaining' => 3,
            'status' => 'in_progress',
            'escrow_funded' => true,
        ]);

        // First message in thread
        DesignOrderMessage::create([
            'design_order_id' => $order->id,
            'sender_id' => auth()->id(),
            'message' => 'অর্ডারের বিবরণ: ' . $validated['brief_description'],
            'attachment_file' => $filePath,
        ]);

        // Payment record
        PaymentRecord::create([
            'invoice_no' => PaymentRecord::generateInvoiceNo(),
            'user_id' => auth()->id(),
            'order_type' => 'design_order',
            'order_id' => $order->id,
            'amount' => $validated['budget'],
            'payment_method' => $validated['payment_method'],
            'trx_id' => $validated['trx_id'],
            'sender_phone' => $validated['sender_phone'],
            'status' => 'approved',
            'notes' => 'Escrow payment funded for design order #' . $orderNo,
        ]);

        return redirect()->route('client.order.show', $order->id)
            ->with('success', 'ডিজাইনার সফলভাবে হায়ার করা হয়েছে! এসক্রো পেমেন্ট নিরাপদ রাখা হয়েছে।');
    }
}
