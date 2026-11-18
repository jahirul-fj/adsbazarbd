@extends('layouts.designer')

@section('title', 'টাকা উত্তোলন (Payout) - Designer Panel')
@section('page_title', 'টাকা উত্তোলন ও পে-আউট রিকোয়েস্ট')

@section('content')
<div class="space-y-8 max-w-5xl">
    <!-- Balance & Policy Ribbon -->
    <div class="bg-gradient-to-r from-teal-900 to-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl flex flex-col md:flex-row justify-between items-start md:items-center gap-6 border border-teal-500/20">
        <div class="space-y-1">
            <span class="text-xs font-bold text-teal-400 uppercase tracking-wider">উত্তোলনযোগ্য একাউন্ট ব্যালেন্স</span>
            <div class="text-3xl sm:text-4xl font-black text-white">৳{{ number_format(auth()->user()->balance, 2) }}</div>
            <p class="text-xs text-slate-300">
                নূন্যতম উইথড্র সীমা: <strong>৳{{ number_format($minWithdrawal, 0) }}</strong> | প্ল্যাটফর্মের নিট আয় সরাসরি আপনার ওয়ালেটে সংরক্ষিত।
            </p>
        </div>

        <div>
            @if(auth()->user()->balance >= $minWithdrawal)
                <button type="button" onclick="document.getElementById('withdrawalForm').scrollIntoView({behavior: 'smooth'})" class="px-5 py-3 bg-teal-500 hover:bg-teal-400 text-slate-950 font-extrabold text-xs rounded-xl shadow-md transition-all flex items-center gap-2">
                    <i class="fa-solid fa-arrow-down"></i> টাকা তোলার আবেদন ফর্ম
                </button>
            @else
                <div class="px-4 py-2 bg-slate-800/80 rounded-xl border border-slate-700 text-xs text-slate-400">
                    <i class="fa-solid fa-circle-info text-amber-400 mr-1"></i> উইথড্র করতে কমপক্ষে ৳{{ number_format($minWithdrawal, 0) }} ব্যালেন্স থাকতে হবে
                </div>
            @endif
        </div>
    </div>

    <!-- Payout Request Form -->
    <div id="withdrawalForm" class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-6">
        <div class="pb-3 border-b border-slate-100 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center text-lg font-bold">
                <i class="fa-solid fa-money-bill-transfer"></i>
            </div>
            <div>
                <h2 class="font-bold text-base text-slate-900">নতুন উইথড্রয়াল (উত্তোলন) আবেদন</h2>
                <p class="text-xs text-slate-500">বিকাশ, নগদ, রকেট অথবা ব্যাংক একাউন্টে টাকা পাওয়ার জন্য তথ্য দিন</p>
            </div>
        </div>

        <form action="{{ route('designer.withdrawals.request') }}" method="POST" class="space-y-5">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">উত্তোলনের পরিমাণ (৳) <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <input type="number" step="10" name="amount" min="{{ $minWithdrawal }}" max="{{ auth()->user()->balance }}" value="{{ old('amount', min(auth()->user()->balance, 1000)) }}" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-bold text-slate-900 focus:bg-white focus:ring-2 focus:ring-teal-500 focus:outline-hidden" required>
                        <span class="absolute right-4 top-2.5 text-xs text-slate-400 font-bold">৳</span>
                    </div>
                    <span class="text-[11px] text-slate-400">সর্বোচ্চ বর্তমান ব্যালেন্স: ৳{{ number_format(auth()->user()->balance, 2) }}</span>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">পেমেন্ট মেথড <span class="text-rose-500">*</span></label>
                    <select name="payment_method" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-xs font-bold text-slate-800 focus:bg-white focus:ring-2 focus:ring-teal-500 focus:outline-hidden" required>
                        <option value="bkash">বিকাশ (bKash Personal)</option>
                        <option value="nagad">নগদ (Nagad Personal)</option>
                        <option value="rocket">রকেট (Rocket Personal)</option>
                        <option value="bank">ব্যাংক একাউন্ট ট্রান্সফার (Bank Transfer)</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">মোবাইল নম্বর / ব্যাংক একাউন্ট নম্বর <span class="text-rose-500">*</span></label>
                <input type="text" name="account_number" value="{{ old('account_number') }}" placeholder="যেমন: 01700-000000 অথবা ব্যাংক একাউন্ট নং" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-xs text-slate-900 font-mono font-bold focus:bg-white focus:ring-2 focus:ring-teal-500 focus:outline-hidden" required>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">ব্যাংক বিবরণ (ব্যাংক ট্রান্সফার হলে শাখা, রাউটিং ও একাউন্টের নাম লিখুন)</label>
                <textarea name="account_details" rows="2" placeholder="ব্যাংক নাম, ব্রাঞ্চ, একাউন্ট হোল্ডার নাম ইত্যাদি..." class="w-full bg-slate-50 border border-slate-300 rounded-xl p-3 text-xs text-slate-800 focus:bg-white focus:ring-2 focus:ring-teal-500 focus:outline-hidden">{{ old('account_details') }}</textarea>
            </div>

            <div class="flex items-center justify-between pt-2">
                <span class="text-xs text-slate-500">আবেদন জমা দেওয়ার পর অ্যাডমিন টিম ২৪ ঘণ্টার মধ্যে পেমেন্ট পাঠিয়ে দেবে।</span>
                <button type="submit" @if(auth()->user()->balance < $minWithdrawal) disabled @endif class="px-7 py-3 bg-teal-600 hover:bg-teal-700 disabled:opacity-50 text-white font-extrabold text-xs rounded-xl shadow-xs transition-colors flex items-center gap-2">
                    <i class="fa-solid fa-paper-plane"></i> উইথড্র রিকোয়েস্ট পাঠান
                </button>
            </div>
        </form>
    </div>

    <!-- Payout History Table -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center">
            <h2 class="font-bold text-base text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-clock-rotate-left text-teal-600"></i> আপনার টাকা উত্তোলনের হিস্ট্রি
            </h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead class="bg-slate-50 text-slate-500 uppercase text-[11px] font-bold">
                    <tr>
                        <th class="p-4">রিকোয়েস্ট নং</th>
                        <th class="p-4">তারিখ</th>
                        <th class="p-4">পরিমাণ</th>
                        <th class="p-4">মেথড</th>
                        <th class="p-4">অ্যাকাউন্ট নং</th>
                        <th class="p-4">Trx ID / রেফারেন্স</th>
                        <th class="p-4">স্ট্যাটাস</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($withdrawals as $w)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="p-4 font-mono font-bold text-slate-900">{{ $w->request_no }}</td>
                            <td class="p-4 text-slate-500">{{ $w->created_at->format('d/m/Y h:i A') }}</td>
                            <td class="p-4 font-bold text-teal-700">৳{{ number_format($w->amount, 2) }}</td>
                            <td class="p-4 uppercase text-xs font-semibold text-slate-700">
                                <span class="px-2 py-0.5 rounded text-[10px] {{ $w->payment_method === 'bkash' ? 'bg-pink-50 text-pink-700 border border-pink-200' : ($w->payment_method === 'nagad' ? 'bg-orange-50 text-orange-700 border border-orange-200' : 'bg-slate-100 text-slate-700') }}">
                                    {{ $w->payment_method }}
                                </span>
                            </td>
                            <td class="p-4 font-mono text-slate-900">{{ $w->account_number }}</td>
                            <td class="p-4 font-mono text-slate-700">
                                {{ $w->trx_id ?? 'প্রক্রিয়াধীন' }}
                            </td>
                            <td class="p-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $w->status === 'approved' ? 'bg-emerald-100 text-emerald-800' : ($w->status === 'rejected' ? 'bg-rose-100 text-rose-800' : 'bg-amber-100 text-amber-800') }}">
                                    {{ $w->status === 'approved' ? 'পরিশোধিত' : ($w->status === 'rejected' ? 'বাতিল' : 'পেন্ডিং') }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-xs text-slate-400">এখনো কোনো টাকা উত্তোলনের আবেদন করেননি।</td>
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
