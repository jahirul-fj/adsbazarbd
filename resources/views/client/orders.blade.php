@extends('layouts.client')

@section('title', 'আমার ডিজাইন অর্ডারসমূহ - Reporter')
@section('page_title', 'ডিজাইন অর্ডার ও এসক্রো')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-xl font-bold text-slate-900">আমার ডিজাইন অর্ডারসমূহ</h1>
            <p class="text-xs text-slate-500">গ্রাফিক ডিজাইনারদের সাথে সরাসরি চ্যাট, ড্রাফট ফাইল অনুমোদন ও রিভিশন ম্যানেজমেন্ট</p>
        </div>
        <a href="{{ route('designers.index') }}" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl shadow-xs transition-colors flex items-center gap-1.5">
            <i class="fa-solid fa-paintbrush text-xs"></i> নতুন ডিজাইনার হায়ার করুন
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead class="bg-slate-50 text-slate-500 uppercase text-[11px] font-bold">
                    <tr>
                        <th class="p-4">অর্ডার নং</th>
                        <th class="p-4">ডিজাইনার</th>
                        <th class="p-4">কাজের শিরোনাম</th>
                        <th class="p-4">সাইজ</th>
                        <th class="p-4">বাজেট (এসক্রো)</th>
                        <th class="p-4">রিভিশন বাকি</th>
                        <th class="p-4">স্ট্যাটাস</th>
                        <th class="p-4 text-right">অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($orders as $order)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="p-4 font-mono font-bold text-slate-900">{{ $order->order_no }}</td>
                            <td class="p-4 font-bold text-indigo-700">{{ $order->designer->name }}</td>
                            <td class="p-4 font-medium max-w-xs truncate text-slate-800">{{ $order->title }}</td>
                            <td class="p-4 text-slate-600">{{ $order->ad_size_requirement }}</td>
                            <td class="p-4 font-bold text-slate-900">৳{{ number_format($order->budget, 2) }}</td>
                            <td class="p-4 font-bold {{ $order->revisions_remaining > 0 ? 'text-emerald-600' : 'text-rose-500' }}">
                                {{ $order->revisions_remaining }} টি
                            </td>
                            <td class="p-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $order->status === 'completed' ? 'bg-emerald-100 text-emerald-800' : ($order->status === 'draft_submitted' ? 'bg-indigo-100 text-indigo-800' : 'bg-amber-100 text-amber-800') }}">
                                    {{ $order->status === 'draft_submitted' ? 'ড্রাফট সাবমিট হয়েছে' : ($order->status === 'completed' ? 'সম্পন্ন' : 'চলমান') }}
                                </span>
                            </td>
                            <td class="p-4 text-right">
                                <a href="{{ route('client.order.show', $order->id) }}" class="px-3.5 py-1.5 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-xs transition-colors inline-flex items-center gap-1.5">
                                    <span>ওয়ার্কস্পেস</span>
                                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-8 text-center text-xs text-slate-400">কোনো ডিজাইন অর্ডার পাওয়া যায়নি।</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($orders->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
