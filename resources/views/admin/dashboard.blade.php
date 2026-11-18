@extends('layouts.admin')

@section('title', 'সুপার অ্যাডমিন ড্যাশবোর্ড - Ads Bazar BD')
@section('page_title', 'অ্যাডমিন ওভারভিউ ও অ্যানালিটিক্স')

@section('content')
<div class="space-y-8">
    <!-- Top KPI Cards with Growth Indicators -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Revenue Card -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs relative overflow-hidden">
            <div class="flex justify-between items-start">
                <div>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">মোট আদায়কৃত রেভিনিউ</span>
                    <div class="text-2xl sm:text-3xl font-black text-emerald-600 mt-1">৳{{ number_format($metrics['total_revenue'], 0) }}</div>
                    <div class="text-[11px] text-emerald-600 mt-2 flex items-center gap-1 font-semibold">
                        <i class="fa-solid fa-arrow-trend-up"></i> আজকের আয়: ৳{{ number_format($metrics['today_revenue'], 0) }}
                    </div>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl font-bold">
                    <i class="fa-solid fa-bangladeshi-taka-sign"></i>
                </div>
            </div>
        </div>

        <!-- Pending Ads Queue -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
            <div class="flex justify-between items-start">
                <div>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">অপেক্ষমাণ বিজ্ঞাপন</span>
                    <div class="text-2xl sm:text-3xl font-black text-amber-600 mt-1">
                        {{ $metrics['pending_classified'] + $metrics['pending_display'] }} <span class="text-sm font-normal text-slate-500">টি</span>
                    </div>
                    <div class="text-[11px] text-slate-500 mt-2">
                        শ্রেণীভুক্ত: {{ $metrics['pending_classified'] }} | ডিসপ্লে: {{ $metrics['pending_display'] }}
                    </div>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl font-bold">
                    <i class="fa-solid fa-clock"></i>
                </div>
            </div>
        </div>

        <!-- Pending Payments -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
            <div class="flex justify-between items-start">
                <div>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">পেমেন্ট ভেরিফিকেশন</span>
                    <div class="text-2xl sm:text-3xl font-black text-teal-600 mt-1">
                        {{ $metrics['pending_payments'] }} <span class="text-sm font-normal text-slate-500">টি</span>
                    </div>
                    <a href="{{ route('admin.payments') }}" class="text-[11px] text-teal-600 hover:underline mt-2 inline-block font-semibold">
                        এখনই ভেরিফাই করুন &rarr;
                    </a>
                </div>
                <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center text-xl font-bold">
                    <i class="fa-solid fa-receipt"></i>
                </div>
            </div>
        </div>

        <!-- Active Designers & Escrow -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
            <div class="flex justify-between items-start">
                <div>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">সক্রিয় ডিজাইনার্স & এসক্রো</span>
                    <div class="text-2xl sm:text-3xl font-black text-indigo-600 mt-1">
                        {{ $metrics['active_orders'] }} <span class="text-sm font-normal text-slate-500">কাজ চলমান</span>
                    </div>
                    <div class="text-[11px] text-slate-500 mt-2">
                        নিবন্ধিত ডিজাইনার: {{ $metrics['total_designers'] }} জন
                    </div>
                </div>
                <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl font-bold">
                    <i class="fa-solid fa-paintbrush"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Analytics Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Monthly Revenue Chart (Visual Bar Representation) -->
        <div class="lg:col-span-2 bg-white p-6 sm:p-7 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
            <div class="flex justify-between items-center pb-3 border-b border-slate-100">
                <div>
                    <h3 class="text-sm font-bold text-slate-900">মাসিক রেভিনিউ প্রবৃদ্ধি (Monthly Revenue)</h3>
                    <p class="text-[11px] text-slate-500">গত ৬ মাসের সংগৃহীত বিজ্ঞাপনের আয়</p>
                </div>
                <span class="text-xs font-bold text-emerald-700 px-2.5 py-1 bg-emerald-50 border border-emerald-200 rounded-lg">
                    মোট আদায়: ৳{{ number_format($metrics['total_revenue'], 0) }}
                </span>
            </div>

            <!-- CSS Bar Graph -->
            <div class="h-56 flex items-end justify-between gap-4 pt-6 px-2">
                @php
                    $maxVal = max(array_column($monthlyRevenue, 'amount')) ?: 1000;
                @endphp
                @foreach($monthlyRevenue as $item)
                    @php
                        $heightPercent = $maxVal > 0 ? max(10, round(($item['amount'] / $maxVal) * 100)) : 10;
                    @endphp
                    <div class="flex-1 flex flex-col items-center gap-2 group h-full justify-end">
                        <div class="text-[10px] font-mono text-slate-500 opacity-0 group-hover:opacity-100 transition-opacity">
                            ৳{{ number_format($item['amount'], 0) }}
                        </div>
                        <div class="w-full bg-slate-100 rounded-t-xl group-hover:bg-indigo-100 transition-all duration-300 relative overflow-hidden" style="height: {{ $heightPercent }}%;">
                            <div class="absolute inset-0 bg-indigo-600 rounded-t-xl opacity-90 group-hover:opacity-100 transition-opacity"></div>
                        </div>
                        <span class="text-[11px] font-bold text-slate-600 mt-1">{{ $item['month'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Ad Category Breakdown -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-4 flex flex-col justify-between">
            <div>
                <h3 class="text-sm font-bold text-slate-900 pb-3 border-b border-slate-100">জনপ্রিয় ক্যাটাগরি বিশ্লেষণ</h3>
                <div class="space-y-3 pt-3">
                    @foreach($categoryStats->take(5) as $cat)
                        <div class="space-y-1">
                            <div class="flex justify-between text-xs">
                                <span class="text-slate-700 font-medium">{{ $cat->name }}</span>
                                <span class="font-bold text-indigo-600">{{ $cat->classified_ads_count }} টি</span>
                            </div>
                            <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                                <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ min(100, $cat->classified_ads_count * 20 + 15) }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="pt-4 border-t border-slate-100 text-center">
                <a href="{{ route('admin.categories') }}" class="text-xs font-bold text-indigo-600 hover:underline">
                    সকল ক্যাটাগরি পরিচালনা &rarr;
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Classified Ads Needing Verification / Approval -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex justify-between items-center">
            <div>
                <h3 class="font-bold text-sm text-slate-900">অপেক্ষমাণ ও সাম্প্রতিক শ্রেণীভুক্ত বিজ্ঞাপন</h3>
                <p class="text-[11px] text-slate-500">স্ট্যাটাস আপডেট ও ই-পেপার কপি লিংক প্রদান করুন</p>
            </div>
            <a href="{{ route('admin.classified') }}" class="text-xs font-bold text-indigo-600 hover:underline">সবগুলো দেখুন &rarr;</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] font-bold border-b border-slate-200/70">
                    <tr>
                        <th class="p-4">ট্র্যাকিং নং</th>
                        <th class="p-4">গ্রাহক</th>
                        <th class="p-4">সংবাদপত্র</th>
                        <th class="p-4">প্রকাশের তারিখ</th>
                        <th class="p-4">মূল্য</th>
                        <th class="p-4">পেমেন্ট</th>
                        <th class="p-4">স্ট্যাটাস</th>
                        <th class="p-4 text-right">অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentClassified as $ad)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="p-4 font-mono font-bold text-slate-900">{{ $ad->tracking_no }}</td>
                            <td class="p-4">
                                <div class="font-bold text-slate-800">{{ $ad->customer_name }}</div>
                                <div class="text-[10px] text-slate-400">{{ $ad->customer_phone }}</div>
                            </td>
                            <td class="p-4 text-emerald-700 font-semibold">{{ $ad->newspaper->name }}</td>
                            <td class="p-4 text-slate-600">{{ date('d/m/Y', strtotime($ad->publish_date)) }}</td>
                            <td class="p-4 font-bold text-slate-900">৳{{ number_format($ad->total_amount, 2) }}</td>
                            <td class="p-4">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $ad->payment_status === 'paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                    {{ $ad->payment_status }}
                                </span>
                            </td>
                            <td class="p-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $ad->status === 'published' ? 'bg-emerald-100 text-emerald-800' : ($ad->status === 'approved' ? 'bg-blue-100 text-blue-800' : 'bg-amber-100 text-amber-800') }}">
                                    {{ $ad->status }}
                                </span>
                            </td>
                            <td class="p-4 text-right">
                                <a href="{{ route('admin.classified', ['search' => $ad->tracking_no]) }}" class="px-3 py-1 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 rounded-lg text-[11px] font-bold border border-indigo-200 transition-colors">
                                    ম্যানেজ &rarr;
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-6 text-center text-xs text-slate-400">কোনো বিজ্ঞাপন নেই।</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
