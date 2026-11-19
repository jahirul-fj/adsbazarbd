@extends('layouts.admin')

@section('title', 'ডিজাইনার উইথড্র রিকোয়েস্ট - Admin')
@section('page_title', 'ডিজাইনার টাকা উত্তোলনের আবেদন ও পে-আউট')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-xl font-bold text-slate-900">ডিজাইনার পে-আউট ও উইথড্র রিকোয়েস্ট</h1>
            <p class="text-xs text-slate-500">গ্রাফিক ডিজাইনারদের উপার্জিত ব্যালেন্স বিকাশ, নগদ বা ব্যাংকে পরিশোধ করে অনুমোদন দিন</p>
        </div>
        <div class="flex flex-wrap gap-2 text-xs font-bold">
            <a href="{{ route('admin.withdrawals') }}" class="px-3.5 py-1.5 rounded-lg {{ !request('status') ? 'bg-indigo-600 text-white' : 'bg-white border border-slate-200 text-slate-700 hover:bg-slate-50' }}">সব আবেদন</a>
            <a href="{{ route('admin.withdrawals', ['status' => 'pending']) }}" class="px-3.5 py-1.5 rounded-lg {{ request('status') === 'pending' ? 'bg-indigo-600 text-white' : 'bg-white border border-slate-200 text-slate-700 hover:bg-slate-50' }}">পেন্ডিং</a>
            <a href="{{ route('admin.withdrawals', ['status' => 'approved']) }}" class="px-3.5 py-1.5 rounded-lg {{ request('status') === 'approved' ? 'bg-indigo-600 text-white' : 'bg-white border border-slate-200 text-slate-700 hover:bg-slate-50' }}">পরিশোধিত (Approved)</a>
            <a href="{{ route('admin.withdrawals', ['status' => 'rejected']) }}" class="px-3.5 py-1.5 rounded-lg {{ request('status') === 'rejected' ? 'bg-indigo-600 text-white' : 'bg-white border border-slate-200 text-slate-700 hover:bg-slate-50' }}">বাতিলকৃত</a>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm min-w-[750px]">
                <thead class="bg-slate-50 text-slate-500 uppercase text-[11px] font-bold border-b border-slate-200/70">
                    <tr>
                        <th class="p-4">রিকোয়েস্ট নং</th>
                        <th class="p-4">ডিজাইনার</th>
                        <th class="p-4">পরিমাণ</th>
                        <th class="p-4">মেথড</th>
                        <th class="p-4">অ্যাকাউন্ট নম্বর ও বিবরণ</th>
                        <th class="p-4">Trx ID / রেফারেন্স</th>
                        <th class="p-4">স্ট্যাটাস</th>
                        <th class="p-4 text-right">পে-আউট অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($withdrawals as $wth)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="p-4 font-mono font-bold text-slate-900">{{ $wth->request_no }}</td>
                            <td class="p-4">
                                <div class="font-bold text-slate-900">{{ $wth->user->name }}</div>
                                <div class="text-[10px] text-slate-400">{{ $wth->user->email }} | {{ $wth->user->phone }}</div>
                            </td>
                            <td class="p-4 font-black text-emerald-700 text-sm">৳{{ number_format($wth->amount, 2) }}</td>
                            <td class="p-4">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $wth->payment_method === 'bkash' ? 'bg-pink-50 text-pink-700 border border-pink-200' : ($wth->payment_method === 'nagad' ? 'bg-orange-50 text-orange-700 border border-orange-200' : 'bg-sky-50 text-sky-700 border border-sky-200') }}">
                                    {{ $wth->payment_method }}
                                </span>
                            </td>
                            <td class="p-4">
                                <div class="font-mono font-bold text-slate-900">{{ $wth->account_number }}</div>
                                @if($wth->account_details)
                                    <div class="text-[10px] text-slate-500 mt-0.5">{{ $wth->account_details }}</div>
                                @endif
                            </td>
                            <td class="p-4 font-mono text-slate-700">
                                {{ $wth->trx_id ?? 'N/A' }}
                            </td>
                            <td class="p-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $wth->status === 'approved' ? 'bg-emerald-100 text-emerald-800' : ($wth->status === 'rejected' ? 'bg-rose-100 text-rose-800' : 'bg-amber-100 text-amber-800') }}">
                                    {{ $wth->status === 'approved' ? 'পরিশোধিত' : ($wth->status === 'rejected' ? 'বাতিল' : 'পেন্ডিং') }}
                                </span>
                            </td>
                            <td class="p-4 text-right">
                                @if($wth->status === 'pending')
                                    <div class="flex items-center justify-end gap-2">
                                        <!-- Approve Modal / Form -->
                                        <form action="{{ route('admin.withdrawals.status', $wth->id) }}" method="POST" class="inline-flex items-center gap-1.5">
                                            @csrf
                                            <input type="hidden" name="status" value="approved">
                                            <input type="text" name="trx_id" placeholder="Trx ID দিন..." class="w-28 bg-slate-50 border border-slate-300 rounded-lg px-2 py-1 text-xs text-slate-900" required>
                                            <button type="submit" class="px-3 py-1 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold shadow-xs transition-colors whitespace-nowrap">
                                                পরিশোধ ও অনুমোদন
                                            </button>
                                        </form>

                                        <!-- Reject Form -->
                                        <form action="{{ route('admin.withdrawals.status', $wth->id) }}" method="POST" onsubmit="return confirm('আপনি কি নিশ্চিত যে আবেদনটি বাতিল করবেন? বাতিল করলে ডিজাইনারের ব্যালেন্সে টাকা স্বয়ংক্রিয়ভাবে ফেরত যাবে।');" class="inline">
                                            @csrf
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="px-2.5 py-1 bg-rose-50 hover:bg-rose-100 text-rose-700 rounded-lg text-xs font-bold border border-rose-200 transition-colors">
                                                বাতিল
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-xs text-slate-400 font-medium">
                                        {{ $wth->processed_at ? $wth->processed_at->format('d/m/Y h:i A') : 'প্রসেস সম্পন্ন' }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-8 text-center text-xs text-slate-400">কোনো উইথড্র রিকোয়েস্ট রেকর্ড পাওয়া যায়নি।</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($withdrawals->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $withdrawals->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
