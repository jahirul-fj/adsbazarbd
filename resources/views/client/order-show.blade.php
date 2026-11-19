@extends('layouts.client')

@section('title', 'ডিজাইন ওয়ার্কস্পেস - ' . $order->order_no)
@section('page_title', 'ডিজাইন ওয়ার্কস্পেস ও চ্যাট')

@section('content')
<div class="max-w-5xl space-y-6">
    <!-- Top Order Status Ribbon -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div class="space-y-1">
            <div class="flex items-center gap-2">
                <span class="text-xs uppercase font-bold text-slate-400">অর্ডার নম্বর:</span>
                <span class="font-mono font-bold text-slate-900">{{ $order->order_no }}</span>
                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $order->status === 'completed' ? 'bg-emerald-100 text-emerald-800' : 'bg-indigo-100 text-indigo-800' }}">
                    {{ $order->status === 'completed' ? 'সম্পন্ন (Completed)' : ($order->status === 'draft_submitted' ? 'ড্রাফট জমা হয়েছে' : 'কাজ চলছে') }}
                </span>
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900">{{ $order->title }}</h1>
            <div class="text-xs text-slate-500">
                ডিজাইনার: <strong>{{ $order->designer->name }}</strong> | সাইজ: <strong>{{ $order->ad_size_requirement }}</strong>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full md:w-auto">
            <div class="text-left sm:text-right pb-3 sm:pb-0 sm:pr-4 border-b sm:border-b-0 sm:border-r border-slate-100">
                <div class="text-xs text-slate-400">এসক্রো বাজেট</div>
                <div class="text-xl font-black text-emerald-600">৳{{ number_format($order->budget, 2) }}</div>
                <div class="text-[10px] text-slate-400">রিভিশন বাকি: <strong>{{ $order->revisions_remaining }}</strong> টি</div>
            </div>

            @if($order->status !== 'completed')
                <form action="{{ route('client.order.approve', $order->id) }}" method="POST" onsubmit="return confirm('আপনি কি নিশ্চিত যে ডিজাইনটি চূড়ান্তভাবে পছন্দ হয়েছে এবং ডিজাইনারকে এসক্রো ফান্ড রিলিজ করতে চান?');" class="w-full sm:w-auto">
                    @csrf
                    <button type="submit" class="w-full sm:w-auto px-5 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-md transition-all flex items-center justify-center gap-1.5 whitespace-nowrap">
                        <i class="fa-solid fa-circle-check"></i> ডিজাইন অনুমোদন ও পেমেন্ট রিলিজ
                    </button>
                </form>
            @endif
        </div>
    </div>

    <!-- Review Box (If order completed and not yet reviewed) -->
    @if($order->status === 'completed' && !$order->rating)
        <div class="bg-gradient-to-r from-amber-500/10 to-emerald-500/10 border border-amber-300 rounded-2xl p-6 space-y-4">
            <h3 class="font-bold text-base text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-star text-amber-500"></i> ডিজাইনারকে রেটিং ও রিভিউ দিন
            </h3>
            <form action="{{ route('client.order.review', $order->id) }}" method="POST" class="space-y-3">
                @csrf
                <div class="flex items-center gap-4 text-xs font-bold text-slate-700">
                    <span>আপনার রেটিং:</span>
                    <select name="rating" class="bg-white border border-slate-300 rounded-lg px-3 py-1.5 font-bold text-amber-600">
                        <option value="5">⭐⭐⭐⭐⭐ (৫ স্টার - চমৎকার)</option>
                        <option value="4">⭐⭐⭐⭐ (৪ স্টার - খুব ভালো)</option>
                        <option value="3">⭐⭐⭐ (৩ স্টার - সন্তোষজনক)</option>
                    </select>
                </div>
                <div>
                    <textarea name="review_comment" rows="2" placeholder="ডিজাইনারের কাজের মান ও আচরণ কেমন লেগেছে লিখুন..." class="w-full bg-white border border-slate-300 rounded-xl p-3 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-hidden" required></textarea>
                </div>
                <button type="submit" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold text-xs rounded-xl transition-colors">
                    রিভিউ সাবমিট করুন
                </button>
            </form>
        </div>
    @elseif($order->rating)
        <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-4 text-xs flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="text-amber-500 text-sm">
                    @for($i=1; $i<=$order->rating; $i++) ★ @endfor
                </span>
                <span class="font-bold text-slate-800">আপনার রিভিউ: "{{ $order->review_comment }}"</span>
            </div>
            <span class="text-emerald-700 font-bold">রিভিউ প্রদান সম্পন্ন ✓</span>
        </div>
    @endif

    <!-- Workspace Thread (Messages & Design Drafts) -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
        <div class="p-5 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
            <h2 class="font-bold text-sm text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-comments text-indigo-600"></i> মেসেজ ও ডিজাইন ড্রাফট হিস্ট্রি
            </h2>
            <span class="text-xs text-slate-500">মোট মেসেজ: {{ $order->messages->count() }}</span>
        </div>

        <!-- Chat History -->
        <div class="p-6 space-y-6 max-h-[500px] overflow-y-auto">
            @foreach($order->messages as $msg)
                <div class="flex items-start gap-3.5 {{ $msg->sender_id === auth()->id() ? 'flex-row-reverse' : '' }}">
                    <div class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-xs text-white shadow-xs shrink-0 {{ $msg->sender_id === auth()->id() ? 'bg-emerald-600' : 'bg-indigo-600' }}">
                        {{ mb_substr($msg->sender->name, 0, 1) }}
                    </div>
                    <div class="max-w-lg space-y-2">
                        <div class="p-4 rounded-2xl text-xs sm:text-sm leading-relaxed shadow-xs {{ $msg->sender_id === auth()->id() ? 'bg-emerald-50 text-emerald-950 rounded-tr-none border border-emerald-100' : 'bg-slate-100 text-slate-800 rounded-tl-none border border-slate-200' }}">
                            <div class="font-bold text-[11px] mb-1 opacity-70 flex justify-between gap-4">
                                <span>{{ $msg->sender->name }}</span>
                                <span>{{ $msg->created_at->format('h:i A, d M') }}</span>
                            </div>
                            <div class="whitespace-pre-line">{{ $msg->message }}</div>

                            <!-- Draft / Attachment Preview -->
                            @if($msg->attachment_file)
                                <div class="mt-3 pt-3 border-t border-slate-200/60">
                                    @if(preg_match('/\.(jpg|jpeg|png|webp)$/i', $msg->attachment_file))
                                        <div class="rounded-xl overflow-hidden border border-slate-200 my-2">
                                            <img src="{{ str_starts_with($msg->attachment_file, 'http') ? $msg->attachment_file : asset('storage/' . $msg->attachment_file) }}" alt="Draft Artwork" class="max-h-64 object-cover w-full">
                                        </div>
                                    @endif
                                    <a href="{{ str_starts_with($msg->attachment_file, 'http') ? $msg->attachment_file : asset('storage/' . $msg->attachment_file) }}" target="_blank" download class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-slate-300 rounded-lg text-xs font-bold text-slate-700 hover:bg-slate-50 shadow-xs">
                                        <i class="fa-solid fa-download text-emerald-600"></i> সংযুক্ত ফাইল ডাউনলোড করুন
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Reply / Revision Input Form -->
        @if($order->status !== 'completed')
            <div class="p-4 sm:p-6 bg-slate-50 border-t border-slate-200">
                <form action="{{ route('client.order.message', $order->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <textarea name="message" rows="3" placeholder="ডিজাইনারের কাজের বিষয়ে মন্তব্য বা কী কী পরিবর্তন করতে হবে তা লিখুন..." class="w-full bg-white border border-slate-300 rounded-2xl p-4 text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-hidden" required></textarea>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                        <div class="flex items-center gap-4 text-xs">
                            <label class="flex items-center gap-1.5 cursor-pointer text-slate-600 hover:text-slate-900 font-medium">
                                <i class="fa-solid fa-paperclip text-slate-400 text-sm"></i> ফাইল সংযুক্ত করুন
                                <input type="file" name="attachment_file" class="hidden" onchange="document.getElementById('fileName').innerText = this.files[0]?.name || ''">
                            </label>
                            <span id="fileName" class="text-xs text-emerald-600 font-bold truncate max-w-xs"></span>

                            @if($order->revisions_remaining > 0)
                                <label class="flex items-center gap-1.5 text-slate-700 cursor-pointer font-bold">
                                    <input type="checkbox" name="request_revision" value="1" class="w-4 h-4 text-rose-600 rounded-sm border-slate-300">
                                    <span>এটি একটি রিভিশন (সংশোধন) রিকোয়েস্ট (বাকি: {{ $order->revisions_remaining }})</span>
                                </label>
                            @endif
                        </div>

                        <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition-colors flex items-center gap-2">
                            <i class="fa-solid fa-paper-plane"></i> মেসেজ পাঠান
                        </button>
                    </div>
                </form>
            </div>
        @else
            <div class="p-4 bg-emerald-50 text-center text-xs font-bold text-emerald-800 border-t border-emerald-100">
                এই অর্ডারটি সফলভাবে সম্পন্ন হয়েছে। ফাইনাল আর্টওয়ার্ক ফাইল ডাউনলোড করতে উপরের চ্যাট দেখুন।
            </div>
        @endif
    </div>
</div>
@endsection
