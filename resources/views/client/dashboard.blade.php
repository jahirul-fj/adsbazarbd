@extends('layouts.client')

@section('title', 'গ্রাহক ড্যাশবোর্ড - Ads Bazar BD')
@section('page_title', 'ড্যাশবোর্ড ওভারভিউ')

@section('content')
<div class="space-y-8">
    <!-- Top Welcome Card -->
    <div class="bg-gradient-to-r from-emerald-800 to-slate-900 text-white rounded-3xl p-6 sm:p-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 shadow-xl">
        <div class="space-y-1">
            <span class="text-xs font-semibold text-emerald-300 uppercase tracking-wider">বিজ্ঞাপনদাতা ড্যাশবোর্ড</span>
            <h1 class="text-2xl sm:text-3xl font-black">স্বাগতম, {{ auth()->user()->name }}!</h1>
            <p class="text-xs text-slate-300">আপনার বুকিং করা বিজ্ঞাপন, অনুমোদন স্ট্যাটাস ও ডিজাইনার অর্ডারগুলো এখান থেকে পরিচালনা করুন।</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('classified.index') }}" class="px-4 py-2.5 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs rounded-xl shadow-md transition-all flex items-center gap-1.5">
                <i class="fa-solid fa-plus text-xs"></i> শ্রেণীভুক্ত বিজ্ঞাপন
            </a>
            <a href="{{ route('display.index') }}" class="px-4 py-2.5 bg-teal-500 hover:bg-teal-400 text-slate-950 font-bold text-xs rounded-xl shadow-md transition-all flex items-center gap-1.5">
                <i class="fa-solid fa-plus text-xs"></i> ডিসপ্লে বিজ্ঞাপন
            </a>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <div class="text-xs font-bold text-slate-400 uppercase tracking-wider">শ্রেণীভুক্ত বিজ্ঞাপন</div>
                <div class="text-3xl font-black text-slate-900 mt-1">{{ $classifiedCount }}</div>
                <a href="{{ route('client.classified') }}" class="text-xs font-bold text-emerald-600 hover:underline mt-2 inline-block">সবগুলো দেখুন &rarr;</a>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-list-check"></i>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <div class="text-xs font-bold text-slate-400 uppercase tracking-wider">ডিসপ্লে বিজ্ঞাপন</div>
                <div class="text-3xl font-black text-slate-900 mt-1">{{ $displayCount }}</div>
                <a href="{{ route('client.display') }}" class="text-xs font-bold text-teal-600 hover:underline mt-2 inline-block">সবগুলো দেখুন &rarr;</a>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-images"></i>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <div class="text-xs font-bold text-slate-400 uppercase tracking-wider">চলমান ডিজাইন অর্ডার</div>
                <div class="text-3xl font-black text-slate-900 mt-1">{{ $activeOrdersCount }}</div>
                <a href="{{ route('client.orders') }}" class="text-xs font-bold text-indigo-600 hover:underline mt-2 inline-block">অর্ডার দেখুন &rarr;</a>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-pen-nib"></i>
            </div>
        </div>
    </div>

    <!-- Recent Classified Ads -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex justify-between items-center">
            <h2 class="font-bold text-base text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-list-check text-emerald-600"></i> সাম্প্রতিক শ্রেণীভুক্ত বিজ্ঞাপনসমূহ
            </h2>
            <a href="{{ route('client.classified') }}" class="text-xs font-bold text-emerald-600 hover:underline">সকল বিজ্ঞাপন &rarr;</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm min-w-[650px]">
                <thead class="bg-slate-50 text-slate-500 uppercase text-[11px] font-bold">
                    <tr>
                        <th class="p-3.5">ট্র্যাকিং নং</th>
                        <th class="p-3.5">পত্রিকা</th>
                        <th class="p-3.5">শিরোনাম</th>
                        <th class="p-3.5">তারিখ</th>
                        <th class="p-3.5">মূল্য</th>
                        <th class="p-3.5">স্ট্যাটাস</th>
                        <th class="p-3.5 text-right">ইনভয়েস</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentClassified as $ad)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="p-3.5 font-bold font-mono text-slate-900">
                                <a href="{{ route('track', ['tracking_no' => $ad->tracking_no]) }}" class="text-emerald-700 hover:underline">
                                    {{ $ad->tracking_no }}
                                </a>
                            </td>
                            <td class="p-3.5 font-semibold text-slate-700">{{ $ad->newspaper->name }}</td>
                            <td class="p-3.5 font-medium max-w-xs truncate text-slate-800">{{ $ad->title }}</td>
                            <td class="p-3.5 text-slate-500">{{ date('d/m/Y', strtotime($ad->publish_date)) }}</td>
                            <td class="p-3.5 font-bold text-emerald-700">৳{{ number_format($ad->total_amount, 2) }}</td>
                            <td class="p-3.5">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $ad->status === 'published' ? 'bg-emerald-100 text-emerald-800' : ($ad->status === 'approved' ? 'bg-blue-100 text-blue-800' : 'bg-amber-100 text-amber-800') }}">
                                    {{ $ad->status }}
                                </span>
                            </td>
                            <td class="p-3.5 text-right">
                                <a href="{{ route('classified.show', $ad->tracking_no) }}" class="px-3 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-bold inline-block">
                                    রসিদ
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-6 text-center text-xs text-slate-400">এখনো কোনো শ্রেণীভুক্ত বিজ্ঞাপন দেননি।</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
