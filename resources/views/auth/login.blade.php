@extends('layouts.app')

@section('title', 'লগইন - Ads Bazar BD')

@section('content')
<div class="max-w-md mx-auto px-4 sm:px-6 py-12">
    <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-xl space-y-6">
        <div class="text-center space-y-2">
            <img src="{{ asset('images/logo-icon.svg') }}" alt="Ads Bazar BD" class="w-14 h-14 rounded-2xl mx-auto shadow-md object-contain">
            <h1 class="text-2xl font-black text-slate-900">লগইন করুন</h1>
            <p class="text-xs text-slate-500">আপনার একাউন্টে প্রবেশ করে বিজ্ঞাপন ও অর্ডার পরিচালনা করুন</p>
        </div>


        <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">ইমেইল এড্রেস</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="আপনার ইমেইল এড্রেস" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 focus:bg-white focus:outline-hidden" required>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">পাসওয়ার্ড</label>
                <input type="password" name="password" placeholder="••••••••" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 focus:bg-white focus:outline-hidden" required>
            </div>

            <div class="flex items-center justify-between text-xs">
                <label class="flex items-center gap-2 cursor-pointer text-slate-600">
                    <input type="checkbox" name="remember" class="w-4 h-4 text-emerald-600 rounded-sm border-slate-300 focus:ring-emerald-500">
                    <span>মনে রাখুন</span>
                </label>
            </div>

            <button type="submit" class="w-full py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-sm rounded-xl shadow-md transition-all">
                লগইন করুন
            </button>
        </form>

        <div class="text-center pt-2 text-xs text-slate-500 border-t border-slate-100">
            অ্যাকাউন্ট নেই? <a href="{{ route('register') }}" class="font-bold text-emerald-600 hover:underline">নতুন সাইনআপ করুন</a>
        </div>
    </div>
</div>
@endsection
