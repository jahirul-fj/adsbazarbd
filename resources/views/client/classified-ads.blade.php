@extends('layouts.app')

@section('title', 'আমার শ্রেণীভুক্ত বিজ্ঞাপনসমূহ - Reporter')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900">আমার শ্রেণীভুক্ত বিজ্ঞাপনসমূহ</h1>
            <p class="text-xs text-slate-500">আপনার বুকিং করা সকল শ্রেণীভুক্ত বিজ্ঞাপনের তালিকা ও লাইভ অবস্থা</p>
        </div>
        <a href="{{ route('classified.index') }}" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition-colors">
            + নতুন বিজ্ঞাপন দিন
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead class="bg-slate-50 text-slate-500 uppercase text-[11px] font-bold">
                    <tr>
                        <th class="p-4">ট্র্যাকিং নং</th>
                        <th class="p-4">সংবাদপত্র</th>
                        <th class="p-4">ক্যাটাগরি</th>
                        <th class="p-4">শিরোনাম</th>
                        <th class="p-4">প্রকাশের তারিখ</th>
                        <th class="p-4">শব্দ</th>
                        <th class="p-4">মূল্য</th>
                        <th class="p-4">স্ট্যাটাস</th>
                        <th class="p-4 text-right">অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($ads as $ad)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="p-4 font-mono font-bold text-slate-900">
                                <a href="{{ route('track', ['tracking_no' => $ad->tracking_no]) }}" class="hover:text-emerald-600 hover:underline">
                                    {{ $ad->tracking_no }}
                                </a>
                            </td>
                            <td class="p-4 font-medium">{{ $ad->newspaper->name }}</td>
                            <td class="p-4 text-slate-500">{{ $ad->category->name }}</td>
                            <td class="p-4 font-medium max-w-xs truncate">{{ $ad->title }}</td>
                            <td class="p-4">{{ date('d/m/Y', strtotime($ad->publish_date)) }}</td>
                            <td class="p-4">{{ $ad->word_count }}</td>
                            <td class="p-4 font-bold text-emerald-700">৳{{ number_format($ad->total_amount, 2) }}</td>
                            <td class="p-4">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $ad->status === 'published' ? 'bg-emerald-100 text-emerald-800' : ($ad->status === 'approved' ? 'bg-blue-100 text-blue-800' : 'bg-amber-100 text-amber-800') }}">
                                    {{ $ad->status }}
                                </span>
                            </td>
                            <td class="p-4 text-right space-x-2">
                                <a href="{{ route('classified.show', $ad->tracking_no) }}" class="font-bold text-xs text-slate-700 hover:text-emerald-600">
                                    ইনভয়েস
                                </a>
                                <a href="{{ route('track', ['tracking_no' => $ad->tracking_no]) }}" class="font-bold text-xs text-emerald-600 hover:underline">
                                    ট্র্যাক
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="p-8 text-center text-xs text-slate-400">কোনো বিজ্ঞাপন পাওয়া যায়নি।</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-100">
            {{ $ads->links() }}
        </div>
    </div>
</div>
@endsection
