@extends('layouts.app')

@section('title', 'অ্যাসাইন করা অর্ডারসমূহ - Designer Panel')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900">ক্লায়েন্টের সকল ডিজাইন অর্ডার</h1>
            <p class="text-xs text-slate-500">আপনাকে দেওয়া বিজ্ঞাপন নকশার কাজসমূহ ও ডেলিভারি স্ট্যাটাস</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead class="bg-slate-50 text-slate-500 uppercase text-[11px] font-bold">
                    <tr>
                        <th class="p-4">অর্ডার নং</th>
                        <th class="p-4">ক্লায়েন্টের নাম</th>
                        <th class="p-4">কাজের শিরোনাম</th>
                        <th class="p-4">সাইজ</th>
                        <th class="p-4">বাজেট</th>
                        <th class="p-4">রিভিশন বাকি</th>
                        <th class="p-4">স্ট্যাটাস</th>
                        <th class="p-4 text-right">অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($orders as $order)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="p-4 font-mono font-bold text-slate-900">{{ $order->order_no }}</td>
                            <td class="p-4 font-bold text-slate-800">{{ $order->client->name }}</td>
                            <td class="p-4 font-medium max-w-xs truncate">{{ $order->title }}</td>
                            <td class="p-4">{{ $order->ad_size_requirement }}</td>
                            <td class="p-4 font-bold text-slate-900">৳{{ number_format($order->budget, 2) }}</td>
                            <td class="p-4 font-bold {{ $order->revisions_remaining > 0 ? 'text-teal-600' : 'text-slate-400' }}">
                                {{ $order->revisions_remaining }} টি
                            </td>
                            <td class="p-4">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $order->status === 'completed' ? 'bg-emerald-100 text-emerald-800' : ($order->status === 'draft_submitted' ? 'bg-indigo-100 text-indigo-800' : 'bg-amber-100 text-amber-800') }}">
                                    {{ $order->status === 'draft_submitted' ? 'ড্রাফট সাবমিট' : ($order->status === 'completed' ? 'সম্পন্ন' : 'চলমান') }}
                                </span>
                            </td>
                            <td class="p-4 text-right">
                                <a href="{{ route('designer.order.show', $order->id) }}" class="px-3.5 py-1.5 rounded-lg bg-teal-600 hover:bg-teal-700 text-white font-bold text-xs shadow-xs transition-colors">
                                    ওয়ার্কস্পেস &rarr;
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-8 text-center text-xs text-slate-400">কোনো অর্ডার পাওয়া যায়নি।</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-100">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection
