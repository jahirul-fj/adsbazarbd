@extends('layouts.admin')

@section('title', 'ডিজাইনার এসক্রো অর্ডার মনিটরিং - Admin')
@section('page_title', 'ডিজাইনার এসক্রো অর্ডার ও কাজের অগ্রগতি')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-xl font-bold text-slate-900">ডিজাইনার এসক্রো অর্ডার মনিটরিং</h1>
        <p class="text-xs text-slate-500">সকল ক্লায়েন্ট-ডিজাইনার লেনদেন ও সুরক্ষিত এসক্রো ফান্ড তালিকা</p>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <table class="w-full text-left text-xs">
            <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] font-bold border-b border-slate-200/70">
                <tr>
                    <th class="p-4">অর্ডার নং</th>
                    <th class="p-4">ক্লায়েন্ট</th>
                    <th class="p-4">ডিজাইনার</th>
                    <th class="p-4">শিরোনাম</th>
                    <th class="p-4">বাজেট</th>
                    <th class="p-4">এসক্রো স্ট্যাটাস</th>
                    <th class="p-4">কাজের অবস্থা</th>
                    <th class="p-4 text-right">তারিখ</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($orders as $order)
                    <tr class="hover:bg-slate-50/70 transition-colors">
                        <td class="p-4 font-mono font-bold text-slate-900">{{ $order->order_no }}</td>
                        <td class="p-4 text-slate-700 font-medium">{{ $order->client->name }}</td>
                        <td class="p-4 font-bold text-indigo-700">{{ $order->designer->name }}</td>
                        <td class="p-4 text-slate-600 max-w-xs truncate">{{ $order->title }}</td>
                        <td class="p-4 font-bold text-emerald-700">৳{{ number_format($order->budget, 2) }}</td>
                        <td class="p-4">
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-emerald-100 text-emerald-800 border border-emerald-200">
                                এসক্রো সুরক্ষিত
                            </span>
                        </td>
                        <td class="p-4">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $order->status === 'completed' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                {{ $order->status === 'draft_submitted' ? 'ড্রাফট সাবমিট' : ($order->status === 'completed' ? 'সম্পন্ন' : 'কাজ চলমান') }}
                            </span>
                        </td>
                        <td class="p-4 text-right text-slate-500">{{ $order->created_at->format('d/m/Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="p-8 text-center text-xs text-slate-400">কোনো অর্ডার নেই।</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if($orders->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
