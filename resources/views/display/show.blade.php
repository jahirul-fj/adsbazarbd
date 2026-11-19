@extends('layouts.app')

@section('title', 'ডিসপ্লে বিজ্ঞাপন ইনভয়েস - ' . $ad->tracking_no)

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="text-center space-y-3 mb-8">
        <div class="w-16 h-16 bg-teal-100 text-teal-600 rounded-full flex items-center justify-center text-3xl mx-auto shadow-md">
            <i class="fa-solid fa-check"></i>
        </div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900">ডিসপ্লে বিজ্ঞাপন সফলভাবে জমা হয়েছে!</h1>
        <p class="text-sm text-slate-600">আমাদের প্রতিনিধি শীঘ্রই আপনার দেওয়া ফোন নম্বরে যোগাযোগ করবেন।</p>
    </div>

    <div class="bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden" id="printableArea">
        <div class="bg-slate-900 text-white p-6 sm:p-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <div class="text-xs uppercase tracking-wider text-teal-400 font-bold mb-1">ডিসপ্লে অ্যাড অর্ডার ইনভয়েস</div>
                <div class="text-xl sm:text-2xl font-black flex items-center gap-2">
                    {{ $ad->tracking_no }}
                    <button onclick="navigator.clipboard.writeText('{{ $ad->tracking_no }}'); alert('ট্র্যাকিং নম্বর কপি করা হয়েছে!');" class="text-xs text-slate-400 hover:text-white px-2 py-1 bg-slate-800 rounded-md">
                        <i class="fa-regular fa-copy"></i> কপি
                    </button>
                </div>
            </div>
            <div class="text-left sm:text-right">
                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase {{ $ad->status === 'published' ? 'bg-emerald-500 text-white' : ($ad->status === 'approved' ? 'bg-blue-500 text-white' : 'bg-amber-400 text-slate-950') }}">
                    {{ $ad->status === 'published' ? 'পত্রিকায় প্রকাশিত' : ($ad->status === 'approved' ? 'অনুমোদিত' : 'অপেক্ষমাণ (In Review)') }}
                </span>
                <div class="text-xs text-slate-400 mt-1.5">তারিখ: {{ $ad->created_at->format('d M, Y h:i A') }}</div>
            </div>
        </div>

        <div class="p-6 sm:p-8 space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pb-6 border-b border-slate-100 text-sm">
                <div>
                    <div class="text-xs text-slate-400 font-semibold">গ্রাহকের নাম ও যোগাযোগ</div>
                    <div class="font-bold text-slate-900 mt-0.5">{{ $ad->customer_name }}</div>
                    <div class="text-xs text-slate-500">{{ $ad->customer_phone }} | {{ $ad->customer_email }}</div>
                </div>
                <div>
                    <div class="text-xs text-slate-400 font-semibold">সংবাদপত্র ও প্রকাশের তারিখ</div>
                    <div class="font-bold text-teal-700 mt-0.5">{{ $ad->newspaper->name }}</div>
                    <div class="text-xs text-slate-600 font-semibold">তারিখ: {{ date('d F, Y', strtotime($ad->publish_date)) }}</div>
                </div>
            </div>

            <!-- Ad Details & Specs -->
            <div class="space-y-3">
                <div class="text-xs font-bold text-slate-400 uppercase tracking-wider">বিজ্ঞাপনের সাইজ ও স্পেসিফিকেশন</div>
                <div class="text-base font-bold text-slate-900">{{ $ad->title }}</div>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs">
                    <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl">
                        <span class="text-slate-400">সাইজ:</span>
                        <div class="font-bold text-slate-800">{{ $ad->columns }} কলাম × {{ $ad->height_inches }}"</div>
                    </div>
                    <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl">
                        <span class="text-slate-400">মোট কলাম ইঞ্চি:</span>
                        <div class="font-bold text-slate-800">{{ $ad->total_col_inches }} Col-Inch</div>
                    </div>
                    <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl">
                        <span class="text-slate-400">পৃষ্ঠার অবস্থান:</span>
                        <div class="font-bold text-slate-800 uppercase">{{ str_replace('_', ' ', $ad->page_position) }}</div>
                    </div>
                    <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl">
                        <span class="text-slate-400">কালার মোড:</span>
                        <div class="font-bold text-slate-800 uppercase">{{ $ad->color_type === 'color' ? 'Multi-Color' : 'Black & White' }}</div>
                    </div>
                </div>
            </div>

            <!-- Billing Details -->
            <div class="border border-slate-200 rounded-2xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs sm:text-sm min-w-[500px]">
                        <thead class="bg-slate-100 text-slate-700 font-bold border-b border-slate-200">
                            <tr>
                                <th class="p-3.5">বিবরণ</th>
                                <th class="p-3.5 text-center">কলাম ইঞ্চি</th>
                                <th class="p-3.5 text-right">কার্যকর রেট</th>
                                <th class="p-3.5 text-right">মোট টাকা</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <tr>
                                <td class="p-3.5 font-medium">
                                    ডিসপ্লে বিজ্ঞাপন প্রকাশনা<br>
                                    <span class="text-xs text-slate-400">{{ $ad->newspaper->name }} ({{ $ad->page_position }})</span>
                                </td>
                                <td class="p-3.5 text-center font-bold">{{ $ad->total_col_inches }}</td>
                                <td class="p-3.5 text-right">৳{{ number_format($ad->rate_applied, 2) }}</td>
                                <td class="p-3.5 text-right font-bold text-slate-900">৳{{ number_format($ad->total_amount, 2) }}</td>
                            </tr>
                            <tr class="bg-slate-50 font-bold text-slate-900">
                                <td colspan="3" class="p-3.5 text-right uppercase tracking-wider text-xs">সর্বমোট প্রদেয়:</td>
                                <td class="p-3.5 text-right text-base text-teal-600">৳{{ number_format($ad->total_amount, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Payment details -->
            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 text-xs">
                <div>
                    <span class="text-slate-500">পেমেন্ট মাধ্যম:</span> <strong class="uppercase text-slate-800">{{ $ad->payment_method }}</strong>
                    @if($ad->payment_trx_id)
                        | <span class="text-slate-500">রেফারেন্স / TrxID:</span> <strong class="text-slate-800 font-mono">{{ $ad->payment_trx_id }}</strong>
                    @endif
                </div>
                <div>
                    <span class="px-2.5 py-1 rounded-full font-bold uppercase {{ $ad->payment_status === 'paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                        পেমেন্ট: {{ $ad->payment_status === 'paid' ? 'ভেরিফাইড (Paid)' : 'অপেক্ষমাণ (Pending)' }}
                    </span>
                </div>
            </div>
        </div>

        <div class="bg-slate-50 px-6 sm:px-8 py-4 border-t border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-3 text-xs text-slate-500">
            <div>সহায়তার জন্য হেল্পলাইন: <strong>{{ $siteSettings['helpline_phone'] ?? '01854-820303' }}</strong></div>
            <div class="flex gap-2">
                <button type="button" onclick="window.print()" class="px-4 py-2 bg-slate-900 text-white font-bold rounded-xl hover:bg-slate-800 transition-colors">
                    <i class="fa-solid fa-print mr-1"></i> প্রিন্ট ইনভয়েস
                </button>
                <a href="{{ route('track', ['tracking_no' => $ad->tracking_no]) }}" class="px-4 py-2 bg-teal-600 text-white font-bold rounded-xl hover:bg-teal-700 transition-colors">
                    লাইভ ট্র্যাকিং
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
