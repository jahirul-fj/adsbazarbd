@extends('layouts.app')

@section('title', 'অ্যাডমিন ড্যাশবোর্ড - Reporter')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">
    <!-- Top Ribbon -->
    <div class="bg-gradient-to-r from-slate-900 to-indigo-950 text-white rounded-3xl p-6 sm:p-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 shadow-xl">
        <div class="space-y-1">
            <span class="text-xs font-semibold text-indigo-400 uppercase tracking-wider">সুপার অ্যাডমিন কন্ট্রোল প্যানেল</span>
            <h1 class="text-2xl sm:text-3xl font-black">সিস্টেম ম্যানেজমেন্ট ড্যাশবোর্ড</h1>
            <p class="text-xs text-slate-400">সকল সংবাদপত্র বিজ্ঞাপন, পেমেন্ট ও ডিজাইনার অর্ডার কেন্দ্রীয়ভাবে নিয়ন্ত্রণ করুন।</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.classified') }}" class="px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition-colors">
                শ্রেণীভুক্ত বিজ্ঞাপন ({{ $metrics['pending_classified'] }})
            </a>
            <a href="{{ route('admin.display') }}" class="px-3.5 py-2 bg-teal-600 hover:bg-teal-700 text-white font-bold text-xs rounded-xl shadow-xs transition-colors">
                ডিসপ্লে বিজ্ঞাপন ({{ $metrics['pending_display'] }})
            </a>
            <a href="{{ route('admin.payments') }}" class="px-3.5 py-2 bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold text-xs rounded-xl shadow-xs transition-colors">
                পেমেন্ট ভেরিফাই ({{ $metrics['pending_payments'] }})
            </a>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-5">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">মোট আদায়কৃত রেভিনিউ</div>
            <div class="text-2xl sm:text-3xl font-black text-emerald-600 mt-1">৳{{ number_format($metrics['total_revenue'], 0) }}</div>
            <div class="text-xs text-slate-400 mt-1">ভেরিফাইড ট্রানজেকশন</div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">অপেক্ষমাণ বিজ্ঞাপন</div>
            <div class="text-2xl sm:text-3xl font-black text-amber-500 mt-1">
                {{ $metrics['pending_classified'] + $metrics['pending_display'] }} টি
            </div>
            <div class="text-xs text-slate-400 mt-1">অনুমোদন প্রয়োজন</div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">চলমান ডিজাইন কাজ</div>
            <div class="text-2xl sm:text-3xl font-black text-indigo-600 mt-1">{{ $metrics['active_orders'] }} টি</div>
            <div class="text-xs text-slate-400 mt-1">এসক্রো ফান্ড সুরক্ষিত</div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">সংযুক্ত সংবাদপত্র</div>
            <div class="text-2xl sm:text-3xl font-black text-slate-900 mt-1">{{ $metrics['total_newspapers'] }} টি</div>
            <div class="text-xs text-slate-400 mt-1">জাতীয় দৈনিক</div>
        </div>
    </div>

    <!-- Quick Navigation Tabs for Admin -->
    <div class="flex flex-wrap gap-2 text-xs font-bold border-b border-slate-200 pb-3">
        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-xl">ওভারভিউ</a>
        <a href="{{ route('admin.classified') }}" class="px-4 py-2 bg-white text-slate-700 hover:bg-slate-100 rounded-xl border border-slate-200">শ্রেণীভুক্ত বিজ্ঞাপন</a>
        <a href="{{ route('admin.display') }}" class="px-4 py-2 bg-white text-slate-700 hover:bg-slate-100 rounded-xl border border-slate-200">ডিসপ্লে বিজ্ঞাপন</a>
        <a href="{{ route('admin.payments') }}" class="px-4 py-2 bg-white text-slate-700 hover:bg-slate-100 rounded-xl border border-slate-200">পেমেন্ট ভেরিফিকেশন</a>
        <a href="{{ route('admin.orders') }}" class="px-4 py-2 bg-white text-slate-700 hover:bg-slate-100 rounded-xl border border-slate-200">ডিজাইন এসক্রো অর্ডার</a>
        <a href="{{ route('admin.newspapers') }}" class="px-4 py-2 bg-white text-slate-700 hover:bg-slate-100 rounded-xl border border-slate-200">সংবাদপত্রের রেট</a>
        <a href="{{ route('admin.categories') }}" class="px-4 py-2 bg-white text-slate-700 hover:bg-slate-100 rounded-xl border border-slate-200">ক্যাটাগরি ও স্যাম্পল</a>
        <a href="{{ route('admin.settings') }}" class="px-4 py-2 bg-white text-slate-700 hover:bg-slate-100 rounded-xl border border-slate-200">সাইট সেটিংস</a>
    </div>

    <!-- Recent Classified Ads Needing Action -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex justify-between items-center">
            <h2 class="font-bold text-base text-slate-900">সাম্প্রতিক শ্রেণীভুক্ত বিজ্ঞাপনের আবেদন</h2>
            <a href="{{ route('admin.classified') }}" class="text-xs font-bold text-indigo-600 hover:underline">সবগুলো পরিচালনা করুন &rarr;</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead class="bg-slate-50 text-slate-500 uppercase text-[11px] font-bold">
                    <tr>
                        <th class="p-3.5">ট্র্যাকিং নং</th>
                        <th class="p-3.5">গ্রাহক</th>
                        <th class="p-3.5">পত্রিকা</th>
                        <th class="p-3.5">তারিখ</th>
                        <th class="p-3.5">মূল্য</th>
                        <th class="p-3.5">পেমেন্ট</th>
                        <th class="p-3.5">স্ট্যাটাস</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentClassified as $ad)
                        <tr>
                            <td class="p-3.5 font-mono font-bold text-slate-900">{{ $ad->tracking_no }}</td>
                            <td class="p-3.5">{{ $ad->customer_name }} ({{ $ad->customer_phone }})</td>
                            <td class="p-3.5 font-medium">{{ $ad->newspaper->name }}</td>
                            <td class="p-3.5">{{ date('d/m/Y', strtotime($ad->publish_date)) }}</td>
                            <td class="p-3.5 font-bold text-emerald-700">৳{{ number_format($ad->total_amount, 2) }}</td>
                            <td class="p-3.5">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $ad->payment_status === 'paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                    {{ $ad->payment_status }}
                                </span>
                            </td>
                            <td class="p-3.5">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $ad->status === 'published' ? 'bg-emerald-100 text-emerald-800' : ($ad->status === 'approved' ? 'bg-blue-100 text-blue-800' : 'bg-amber-100 text-amber-800') }}">
                                    {{ $ad->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-6 text-center text-xs text-slate-400">কোনো বিজ্ঞাপন নেই।</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
