@extends('layouts.admin')

@section('title', 'পেমেন্ট ট্রানজেকশন ভেরিফিকেশন - Admin')
@section('page_title', 'পেমেন্ট ট্রানজেকশন ও ভেরিফিকেশন')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-xl font-bold text-white">পেমেন্ট ট্রানজেকশন ভেরিফিকেশন</h1>
            <p class="text-xs text-slate-400">বিকাশ, নগদ, রকেট ও ব্যাংক ট্রান্সফারের Trx ID যাচাই করে অনুমোদন বা বাতিল করুন</p>
        </div>
        <div class="flex flex-wrap gap-2 text-xs font-bold">
            <a href="{{ route('admin.payments') }}" class="px-3.5 py-1.5 rounded-lg {{ !request('status') ? 'bg-indigo-600 text-white' : 'bg-slate-800 text-slate-300 hover:bg-slate-700' }}">সব পেমেন্ট</a>
            <a href="{{ route('admin.payments', ['status' => 'pending']) }}" class="px-3.5 py-1.5 rounded-lg {{ request('status') === 'pending' ? 'bg-indigo-600 text-white' : 'bg-slate-800 text-slate-300 hover:bg-slate-700' }}">পেন্ডিং পেমেন্ট</a>
            <a href="{{ route('admin.payments', ['status' => 'approved']) }}" class="px-3.5 py-1.5 rounded-lg {{ request('status') === 'approved' ? 'bg-indigo-600 text-white' : 'bg-slate-800 text-slate-300 hover:bg-slate-700' }}">অনুমোদিত</a>
            <a href="{{ route('admin.payments', ['status' => 'rejected']) }}" class="px-3.5 py-1.5 rounded-lg {{ request('status') === 'rejected' ? 'bg-indigo-600 text-white' : 'bg-slate-800 text-slate-300 hover:bg-slate-700' }}">বাতিলকৃত</a>
        </div>
    </div>

    <div class="bg-slate-950 rounded-2xl border border-slate-800 overflow-hidden shadow-lg">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead class="bg-slate-900 text-slate-400 uppercase text-[11px] font-bold border-b border-slate-800">
                    <tr>
                        <th class="p-4">ইনভয়েস নং</th>
                        <th class="p-4">অর্ডারের ধরন</th>
                        <th class="p-4">পরিমাণ</th>
                        <th class="p-4">পেমেন্ট মেথড</th>
                        <th class="p-4">Trx ID / রেফারেন্স</th>
                        <th class="p-4">প্রেরক ফোন</th>
                        <th class="p-4">স্ট্যাটাস</th>
                        <th class="p-4 text-right">ভেরিফিকেশন অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/80">
                    @forelse($payments as $pm)
                        <tr class="hover:bg-slate-900/50 transition-colors">
                            <td class="p-4 font-mono font-bold text-white">{{ $pm->invoice_no }}</td>
                            <td class="p-4">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-slate-800 text-slate-300 border border-slate-700">
                                    {{ str_replace('_', ' ', $pm->order_type) }}
                                </span>
                            </td>
                            <td class="p-4 font-black text-emerald-400">৳{{ number_format($pm->amount, 2) }}</td>
                            <td class="p-4 font-bold uppercase text-slate-200">
                                <span class="px-2 py-0.5 rounded text-[10px] {{ $pm->payment_method === 'bkash' ? 'bg-pink-900/30 text-pink-400 border border-pink-700/50' : ($pm->payment_method === 'nagad' ? 'bg-orange-900/30 text-orange-400 border border-orange-700/50' : 'bg-purple-900/30 text-purple-400 border border-purple-700/50') }}">
                                    {{ $pm->payment_method }}
                                </span>
                            </td>
                            <td class="p-4 font-mono font-bold text-amber-300 bg-slate-900/60 rounded px-2">{{ $pm->trx_id ?? 'N/A' }}</td>
                            <td class="p-4 text-slate-300">{{ $pm->sender_phone ?? 'N/A' }}</td>
                            <td class="p-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $pm->status === 'approved' ? 'bg-emerald-950 text-emerald-400 border border-emerald-800' : ($pm->status === 'rejected' ? 'bg-rose-950 text-rose-400 border border-rose-800' : 'bg-amber-950 text-amber-400 border border-amber-800') }}">
                                    {{ $pm->status }}
                                </span>
                            </td>
                            <td class="p-4 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    @if($pm->status !== 'approved')
                                        <form action="{{ route('admin.payments.status', $pm->id) }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" class="px-3 py-1 bg-emerald-600 hover:bg-emerald-500 text-white rounded-lg text-xs font-bold shadow-xs transition-colors">
                                                <i class="fa-solid fa-check mr-1"></i> অনুমোদন
                                            </button>
                                        </form>
                                    @endif
                                    @if($pm->status !== 'rejected')
                                        <form action="{{ route('admin.payments.status', $pm->id) }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="px-3 py-1 bg-rose-900/40 hover:bg-rose-900/60 text-rose-300 rounded-lg text-xs font-bold border border-rose-700/50 transition-colors">
                                                <i class="fa-solid fa-xmark mr-1"></i> বাতিল
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-8 text-center text-xs text-slate-500">কোনো পেমেন্ট রেকর্ড পাওয়া যায়নি।</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($payments->hasPages())
            <div class="p-4 border-t border-slate-800">
                {{ $payments->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
