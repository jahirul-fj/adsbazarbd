@extends('layouts.app')

@section('title', 'বিজ্ঞাপন ট্র্যাকিং - Ads Bazar BD')

@section('content')
<div class="bg-slate-900 text-white py-12 px-4 sm:px-6 lg:px-8 border-b border-slate-800">
    <div class="max-w-3xl mx-auto text-center space-y-3">
        <span class="px-3 py-1 bg-emerald-500/20 text-emerald-400 rounded-full text-xs font-semibold uppercase tracking-wider">রিয়েল-টাইম স্ট্যাটাস</span>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">বিজ্ঞাপন লাইভ ট্র্যাকিং</h1>
        <p class="text-slate-400 text-sm max-w-lg mx-auto">
            আপনার বিজ্ঞাপনের ট্র্যাকিং নম্বর (Tracking Number) লিখে সার্চ করে বর্তমান অবস্থা ও পত্রিকা প্রকাশের প্রমাণ দেখুন।
        </p>

        <!-- Search Input -->
        <div class="max-w-xl mx-auto pt-4">
            <form action="{{ route('track') }}" method="GET" class="flex gap-2 bg-white/10 p-2 rounded-2xl border border-white/20 backdrop-blur-md">
                <input type="text" name="tracking_no" value="{{ $trackingNo }}" placeholder="বিজ্ঞাপন ট্র্যাকিং নং লিখুন (যেমন: CLS-202611-1001)" class="flex-1 bg-transparent px-4 py-2.5 text-sm text-white placeholder-slate-400 focus:outline-hidden" required>
                <button type="submit" class="px-6 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-sm rounded-xl transition-all shadow-md">
                    সার্চ করুন
                </button>
            </form>
            <div class="flex items-center justify-center gap-2 mt-3 text-xs text-slate-400">
                <span>নমুনা টেস্ট কোড:</span>
                <a href="{{ route('track', ['tracking_no' => 'CLS-202611-1001']) }}" class="text-emerald-400 underline font-mono">CLS-202611-1001</a>
                <span>|</span>
                <a href="{{ route('track', ['tracking_no' => 'CLS-202611-1002']) }}" class="text-emerald-400 underline font-mono">CLS-202611-1002</a>
            </div>
        </div>
    </div>
</div>

<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    @if($trackingNo)
        @if($ad)
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-xl space-y-8">
                <!-- Status Stepper Bar -->
                <div>
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <span class="text-xs uppercase font-bold text-slate-400">বিজ্ঞাপন ট্র্যাকিং নং</span>
                            <div class="text-xl font-extrabold text-slate-900 font-mono">{{ $ad->tracking_no }}</div>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase {{ $ad->status === 'published' ? 'bg-emerald-100 text-emerald-800' : ($ad->status === 'approved' ? 'bg-blue-100 text-blue-800' : 'bg-amber-100 text-amber-800') }}">
                            {{ $ad->status === 'published' ? 'পত্রিকায় প্রকাশিত' : ($ad->status === 'approved' ? 'অনুমোদিত' : 'অপেক্ষমাণ') }}
                        </span>
                    </div>

                    <!-- Visual Timeline -->
                    <div class="grid grid-cols-4 text-center relative py-4">
                        <!-- Progress Line -->
                        <div class="absolute top-8 left-0 right-0 h-1 bg-slate-200 -z-0">
                            <div class="h-1 bg-emerald-500 transition-all duration-500" 
                                 style="width: {{ $ad->status === 'published' ? '100%' : ($ad->status === 'approved' ? '66%' : ($ad->payment_status === 'paid' ? '33%' : '15%')) }}">
                            </div>
                        </div>

                        <!-- Step 1 -->
                        <div class="space-y-2 relative z-10">
                            <div class="w-10 h-10 rounded-full bg-emerald-500 text-white flex items-center justify-center font-bold text-sm mx-auto shadow-md">
                                <i class="fa-solid fa-check"></i>
                            </div>
                            <div class="font-bold text-xs text-slate-900">আবেদন জমা</div>
                            <div class="text-[10px] text-slate-400">{{ $ad->created_at->format('d/m/Y') }}</div>
                        </div>

                        <!-- Step 2 -->
                        <div class="space-y-2 relative z-10">
                            <div class="w-10 h-10 rounded-full {{ in_array($ad->payment_status, ['paid', 'verified']) ? 'bg-emerald-500 text-white' : 'bg-slate-200 text-slate-500' }} flex items-center justify-center font-bold text-sm mx-auto shadow-md">
                                <i class="fa-solid {{ in_array($ad->payment_status, ['paid', 'verified']) ? 'fa-check' : 'fa-credit-card' }}"></i>
                            </div>
                            <div class="font-bold text-xs text-slate-900">পেমেন্ট ভেরিফাই</div>
                            <div class="text-[10px] text-slate-400">{{ in_array($ad->payment_status, ['paid', 'verified']) ? 'সম্পন্ন' : 'অপেক্ষমাণ' }}</div>
                        </div>

                        <!-- Step 3 -->
                        <div class="space-y-2 relative z-10">
                            <div class="w-10 h-10 rounded-full {{ in_array($ad->status, ['approved', 'published']) ? 'bg-emerald-500 text-white' : 'bg-slate-200 text-slate-500' }} flex items-center justify-center font-bold text-sm mx-auto shadow-md">
                                <i class="fa-solid {{ in_array($ad->status, ['approved', 'published']) ? 'fa-check' : 'fa-gear' }}"></i>
                            </div>
                            <div class="font-bold text-xs text-slate-900">পত্রিকায় শিডিউল</div>
                            <div class="text-[10px] text-slate-400">{{ in_array($ad->status, ['approved', 'published']) ? 'অনুমোদিত' : 'প্রক্রিয়াধীন' }}</div>
                        </div>

                        <!-- Step 4 -->
                        <div class="space-y-2 relative z-10">
                            <div class="w-10 h-10 rounded-full {{ $ad->status === 'published' ? 'bg-emerald-600 text-white animate-bounce' : 'bg-slate-200 text-slate-500' }} flex items-center justify-center font-bold text-sm mx-auto shadow-md">
                                <i class="fa-solid fa-newspaper"></i>
                            </div>
                            <div class="font-bold text-xs text-slate-900">পত্রিকায় প্রকাশ</div>
                            <div class="text-[10px] text-slate-400">{{ $ad->status === 'published' ? 'প্রকাশিত!' : date('d/m/Y', strtotime($ad->publish_date)) }}</div>
                        </div>
                    </div>
                </div>

                <!-- Ad Summary Details -->
                <div class="p-6 bg-slate-50 rounded-2xl border border-slate-200/80 space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                        <div>
                            <span class="text-slate-400">সংবাদপত্র:</span>
                            <div class="font-bold text-slate-900 text-sm mt-0.5">{{ $ad->newspaper->name }}</div>
                        </div>
                        <div>
                            <span class="text-slate-400">প্রকাশের তারিখ:</span>
                            <div class="font-bold text-slate-900 text-sm mt-0.5">{{ date('d F, Y', strtotime($ad->publish_date)) }}</div>
                        </div>
                        <div>
                            <span class="text-slate-400">বিজ্ঞাপনের ধরন:</span>
                            <div class="font-bold text-slate-900 mt-0.5 uppercase">{{ $adType === 'display' ? 'ডিসপ্লে বিজ্ঞাপন' : 'শ্রেণীভুক্ত বিজ্ঞাপন' }}</div>
                        </div>
                        <div>
                            <span class="text-slate-400">বিলিং মূল্য:</span>
                            <div class="font-bold text-emerald-600 text-sm mt-0.5">৳{{ number_format($ad->total_amount, 2) }}</div>
                        </div>
                    </div>

                    <div class="pt-3 border-t border-slate-200 text-xs">
                        <span class="text-slate-400">বিজ্ঞাপনের শিরোনাম:</span>
                        <div class="font-bold text-slate-800 text-sm mt-0.5">{{ $ad->title }}</div>
                    </div>

                    @if($adType === 'classified')
                        <div class="p-3 bg-white border border-slate-200 rounded-xl text-xs text-slate-700 leading-relaxed whitespace-pre-line">
                            {{ $ad->ad_body }}
                        </div>
                    @endif

                    @if($ad->status === 'published' && $ad->published_proof_url)
                        <div class="p-4 bg-emerald-100/70 border border-emerald-300 rounded-xl text-xs text-emerald-950 flex items-center justify-between gap-3">
                            <div>
                                <div class="font-bold">পত্রিকায় বিজ্ঞাপনের প্রমাণ (E-Paper Copy) প্রস্তুত আছে!</div>
                                <div class="text-[11px] text-emerald-800">অনলাইনে দেখার জন্য পাশের বাটনে ক্লিক করুন।</div>
                            </div>
                            <a href="{{ $ad->published_proof_url }}" target="_blank" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg whitespace-nowrap shadow-xs">
                                প্রমাণ দেখুন <i class="fa-solid fa-arrow-up-right-from-square text-[10px] ml-1"></i>
                            </a>
                        </div>
                    @endif
                </div>

                <div class="flex justify-between items-center text-xs text-slate-500 pt-2">
                    <div>কোনো জিজ্ঞাসা থাকলে কল করুন: <strong>{{ $siteSettings['helpline_phone'] ?? '01854-820303' }}</strong></div>
                    <a href="{{ $adType === 'display' ? route('display.show', $ad->tracking_no) : route('classified.show', $ad->tracking_no) }}" class="font-bold text-emerald-600 hover:underline">
                        পূর্ণাঙ্গ ইনভয়েস দেখুন &rarr;
                    </a>
                </div>
            </div>
        @else
            <div class="text-center py-16 bg-white rounded-3xl border border-slate-200 p-8 space-y-3">
                <div class="w-16 h-16 bg-rose-100 text-rose-600 rounded-full flex items-center justify-center text-2xl mx-auto">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-900">কোনো তথ্য পাওয়া যায়নি</h3>
                <p class="text-xs text-slate-500 max-w-sm mx-auto">
                    "{{ $trackingNo }}" ট্র্যাকিং নম্বরের বিপরীতে কোনো বিজ্ঞাপন রেকর্ড মেলেনি। অনুগ্রহ করে সঠিক ট্র্যাকিং নম্বরটি প্রদান করুন।
                </p>
            </div>
        @endif
    @endif
</div>
@endsection
