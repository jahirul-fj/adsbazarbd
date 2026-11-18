@extends('layouts.designer')

@section('title', 'ডিজাইনার ওয়ার্কস্পেস - ' . $order->order_no)
@section('page_title', 'অর্ডার ডেলিভারি ও ক্লায়েন্ট মেসেজ')

@section('content')
<div class="max-w-5xl space-y-6">
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div class="space-y-1">
            <div class="flex items-center gap-2">
                <span class="text-xs uppercase font-bold text-slate-400">অর্ডার নম্বর:</span>
                <span class="font-mono font-bold text-slate-900">{{ $order->order_no }}</span>
                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $order->status === 'completed' ? 'bg-emerald-100 text-emerald-800' : 'bg-teal-100 text-teal-800' }}">
                    {{ $order->status === 'completed' ? 'সম্পন্ন (Completed)' : ($order->status === 'draft_submitted' ? 'ড্রাফট সাবমিট' : 'কাজ চলমান') }}
                </span>
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900">{{ $order->title }}</h1>
            <div class="text-xs text-slate-500">
                ক্লায়েন্ট: <strong>{{ $order->client->name }}</strong> ({{ $order->client->phone }}) | সাইজ: <strong>{{ $order->ad_size_requirement }}</strong>
            </div>
        </div>

        <div class="text-left md:text-right pr-4">
            <div class="text-xs text-slate-400">মোট পারিশ্রমিক (এসক্রো)</div>
            <div class="text-2xl font-black text-teal-600">৳{{ number_format($order->budget, 2) }}</div>
            <div class="text-xs text-slate-500 mt-1">ক্লায়েন্টের রিভিশন বাকি: <strong>{{ $order->revisions_remaining }}</strong> টি</div>
        </div>
    </div>

    <!-- Client Brief Box -->
    <div class="bg-slate-50 rounded-2xl p-6 border border-slate-200 space-y-2">
        <h3 class="font-bold text-xs uppercase tracking-wider text-slate-500">ক্লায়েন্টের মূল ব্রিফ:</h3>
        <p class="text-xs sm:text-sm text-slate-800 leading-relaxed whitespace-pre-line">{{ $order->brief_description }}</p>
        @if($order->attachment_file)
            <div class="pt-2">
                <a href="{{ asset('storage/' . $order->attachment_file) }}" target="_blank" download class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-slate-300 rounded-lg text-xs font-bold text-indigo-700 hover:bg-slate-100 shadow-xs">
                    <i class="fa-solid fa-paperclip"></i> ক্লায়েন্টের পাঠানো ফাইল ডাউনলোড
                </a>
            </div>
        @endif
    </div>

    <!-- Workspace Thread (Messages & Design Drafts) -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
        <div class="p-5 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
            <h2 class="font-bold text-sm text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-comments text-teal-600"></i> মেসেজ ও ডিজাইন ড্রাফট হিস্ট্রি
            </h2>
            <span class="text-xs text-slate-500">মোট মেসেজ: {{ $order->messages->count() }}</span>
        </div>

        <div class="p-6 space-y-6 max-h-[500px] overflow-y-auto">
            @foreach($order->messages as $msg)
                <div class="flex items-start gap-3.5 {{ $msg->sender_id === auth()->id() ? 'flex-row-reverse' : '' }}">
                    <div class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-xs text-white shadow-xs shrink-0 {{ $msg->sender_id === auth()->id() ? 'bg-teal-600' : 'bg-emerald-600' }}">
                        {{ mb_substr($msg->sender->name, 0, 1) }}
                    </div>
                    <div class="max-w-lg space-y-2">
                        <div class="p-4 rounded-2xl text-xs sm:text-sm leading-relaxed shadow-xs {{ $msg->sender_id === auth()->id() ? 'bg-teal-50 text-teal-950 rounded-tr-none border border-teal-100' : 'bg-slate-100 text-slate-800 rounded-tl-none border border-slate-200' }}">
                            <div class="font-bold text-[11px] mb-1 opacity-70 flex justify-between gap-4">
                                <span>{{ $msg->sender->name }}</span>
                                <span>{{ $msg->created_at->format('h:i A, d M') }}</span>
                            </div>
                            <div class="whitespace-pre-line">{{ $msg->message }}</div>

                            @if($msg->attachment_file)
                                <div class="mt-3 pt-3 border-t border-slate-200/60">
                                    @if(preg_match('/\.(jpg|jpeg|png|webp)$/i', $msg->attachment_file))
                                        <div class="rounded-xl overflow-hidden border border-slate-200 my-2">
                                            <img src="{{ str_starts_with($msg->attachment_file, 'http') ? $msg->attachment_file : asset('storage/' . $msg->attachment_file) }}" alt="Draft Artwork" class="max-h-64 object-cover w-full">
                                        </div>
                                    @endif
                                    <a href="{{ str_starts_with($msg->attachment_file, 'http') ? $msg->attachment_file : asset('storage/' . $msg->attachment_file) }}" target="_blank" download class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-slate-300 rounded-lg text-xs font-bold text-slate-700 hover:bg-slate-50 shadow-xs">
                                        <i class="fa-solid fa-download text-teal-600"></i> ফাইল ডাউনলোড
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($order->status !== 'completed')
            <div class="p-4 sm:p-6 bg-slate-50 border-t border-slate-200">
                <form action="{{ route('designer.order.message', $order->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <textarea name="message" rows="3" placeholder="ক্লায়েন্টকে আপনার কাজের আপডেট জানান অথবা ড্রাফট ফাইলের বিবরণ দিন..." class="w-full bg-white border border-slate-300 rounded-2xl p-4 text-xs sm:text-sm focus:ring-2 focus:ring-teal-500 focus:outline-hidden" required></textarea>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                        <div class="flex flex-wrap items-center gap-4 text-xs">
                            <label class="flex items-center gap-1.5 cursor-pointer text-slate-600 hover:text-slate-900 font-medium">
                                <i class="fa-solid fa-upload text-teal-600 text-sm"></i> ডিজাইন ফাইল আপলোড
                                <input type="file" name="attachment_file" class="hidden" onchange="document.getElementById('designerFileName').innerText = this.files[0]?.name || ''">
                            </label>
                            <span id="designerFileName" class="text-xs text-teal-600 font-bold truncate max-w-xs"></span>

                            <label class="flex items-center gap-1.5 text-slate-700 cursor-pointer font-bold">
                                <input type="checkbox" name="is_draft_submission" value="1" class="w-4 h-4 text-teal-600 rounded-sm border-slate-300">
                                <span>এটি একটি খসড়া/চূড়ান্ত ডিজাইন সাবমিশন</span>
                            </label>
                        </div>

                        <button type="submit" class="px-6 py-2.5 bg-teal-600 hover:bg-teal-700 text-white font-bold text-xs rounded-xl shadow-xs transition-colors flex items-center gap-2">
                            <i class="fa-solid fa-paper-plane"></i> মেসেজ ও ড্রাফট পাঠান
                        </button>
                    </div>
                </form>
            </div>
        @else
            <div class="p-4 bg-emerald-50 text-center text-xs font-bold text-emerald-800 border-t border-emerald-100">
                এই অর্ডারটি ক্লায়েন্ট কর্তৃক অনুমোদিত ও সফলভাবে সম্পন্ন হয়েছে। পারিশ্রমিক ৳{{ number_format($order->budget, 2) }} আপনার অ্যাকাউন্টে জমা হয়েছে।
            </div>
        @endif
    </div>
</div>
@endsection
