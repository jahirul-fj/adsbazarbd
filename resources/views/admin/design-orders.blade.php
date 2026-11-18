@extends('layouts.app')

@section('title', 'ডিজাইনার এসক্রো অর্ডার মনিটরিং - Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-6">
    <div>
        <h1 class="text-2xl font-black text-slate-900">ডিজাইনার এসক্রো অর্ডার মনিটরিং</h1>
        <p class="text-xs text-slate-500">সকল ক্লায়েন্ট-ডিজাইনার লেনদেন ও সুরক্ষিত এসক্রো ফান্ড তালিকা</p>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <table class="w-full text-left text-xs sm:text-sm">
            <thead class="bg-slate-50 text-slate-500 uppercase text-[11px] font-bold">
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
                    <tr>
                        <td class="p-4 font-mono font-bold text-slate-900">{{ $order->order_no }}</td>
                        <td class="p-4">{{ $order->client->name }}</td>
                        <td class="p-4 font-bold text-indigo-700">{{ $order->designer->name }}</td>
                        <td class="p-4 font-medium max-w-xs truncate">{{ $order->title }}</td>
                        <td class="p-4 font-bold text-emerald-700">৳{{ number_format($order->budget, 2) }}</td>
                        <td class="p-4">
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-emerald-100 text-emerald-800">
                                এসক্রো সুরক্ষিত
                            </span>
                        </td>
                        <td class="p-4">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $order->status === 'completed' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td class="p-4 text-right text-slate-400">{{ $order->created_at->format('d/m/Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="p-8 text-center text-xs text-slate-400">কোনো অর্ডার নেই।</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4 border-t border-slate-100">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection
