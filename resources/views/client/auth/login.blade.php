@extends('layouts.app')

@section('title', 'গ্রাহক / ক্লায়েন্ট লগইন - Ads Bazar BD')

@section('content')
<div class="min-h-[75vh] flex items-center justify-center px-4 py-12">
    <div class="max-w-md w-full bg-white rounded-3xl p-8 border border-slate-200 shadow-xl space-y-6">
        <div class="text-center space-y-2">
            <img src="{{ asset('images/logo-icon.svg') }}" alt="Ads Bazar BD" class="w-14 h-14 rounded-2xl mx-auto shadow-md object-contain">
            <span class="inline-block px-3 py-1 bg-emerald-100 text-emerald-800 rounded-full text-[11px] font-bold uppercase tracking-wider">
                গ্রাহক পোর্টাল
            </span>
            <h1 class="text-2xl font-black text-slate-900">বিজ্ঞাপনদাতা গ্রাহক লগইন</h1>
            <p class="text-xs text-slate-500">আপনার বুকিং করা বিজ্ঞাপন ও অর্ডার দেখতে লগইন করুন</p>
        </div>


        <form action="{{ route('client.login.post') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">ইমেইল এড্রেস</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="client@adsbazarbd.com" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 focus:bg-white focus:outline-hidden" required>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">পাসওয়ার্ড</label>
                <input type="password" name="password" id="password" placeholder="••••••••" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 focus:bg-white focus:outline-hidden" required>
            </div>

            <div class="flex items-center justify-between text-xs text-slate-600">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remember" class="w-4 h-4 text-emerald-600 rounded-sm">
                    <span>লগইন মনে রাখুন</span>
                </label>
            </div>

            <button type="submit" class="w-full py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-sm rounded-xl shadow-md transition-all flex items-center justify-center gap-2">
                <i class="fa-solid fa-arrow-right-to-bracket"></i> গ্রাহক ড্যাশবোর্ডে প্রবেশ করুন
            </button>
        </form>

        <div class="text-center pt-2 text-xs text-slate-500 border-t border-slate-100 flex justify-between items-center">
            <span>নতুন বিজ্ঞাপনদাতা? <a href="{{ route('client.register') }}" class="font-bold text-emerald-600 hover:underline">রেজিস্টার করুন</a></span>
            <a href="{{ route('designer.login') }}" class="text-slate-400 hover:text-slate-600">ডিজাইনার লগইন &rarr;</a>
        </div>
    </div>
</div>
@endsection
