@extends('layouts.app')

@section('title', 'অ্যাডমিন সিকিউরিটি লগইন - Ads Bazar BD Management')

@section('content')
<div class="min-h-[75vh] flex items-center justify-center px-4 py-12">
    <div class="max-w-md w-full bg-white text-slate-800 rounded-3xl p-8 border border-slate-200 shadow-xl space-y-6 relative overflow-hidden">
        <div class="absolute -top-16 -right-16 w-36 h-36 bg-indigo-50 rounded-full blur-2xl"></div>

        <div class="text-center space-y-2 relative">
            <img src="{{ asset('images/logo-icon.svg') }}" alt="Ads Bazar BD" class="w-14 h-14 rounded-2xl mx-auto shadow-md object-contain">
            <span class="inline-block px-3 py-1 bg-indigo-50 text-indigo-700 border border-indigo-200 rounded-full text-[11px] font-bold uppercase tracking-wider">
                Restricted Access
            </span>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">সিস্টেম অ্যাডমিন লগইন</h1>
            <p class="text-xs text-slate-500">বিজ্ঞাপন ও প্ল্যাটফর্ম পরিচালনার জন্য অ্যাডমিন একাউন্টে প্রবেশ করুন</p>
        </div>

        <!-- 1-Click Demo Auto-fill -->
        <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-200 text-xs flex items-center justify-between">
            <div>
                <div class="font-bold text-indigo-700">অ্যাডমিন ডেমো একাউন্ট:</div>
                <div class="text-[11px] text-slate-500 font-mono">admin@adsbazarbd.com | password</div>
            </div>
            <button type="button" onclick="document.getElementById('email').value='admin@adsbazarbd.com'; document.getElementById('password').value='password';" class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-[11px] font-bold rounded-lg transition-colors shadow-xs">
                অটো-ফিল
            </button>
        </div>

        <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">অ্যাডমিন ইমেইল</label>
                <div class="relative">
                    <i class="fa-solid fa-envelope absolute left-4 top-3.5 text-slate-400 text-xs"></i>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="admin@adsbazarbd.com" class="w-full bg-slate-50 border border-slate-300 rounded-xl pl-10 pr-4 py-3 text-xs sm:text-sm text-slate-900 placeholder-slate-400 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:outline-hidden" required>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">সিক্রেট পাসওয়ার্ড</label>
                <div class="relative">
                    <i class="fa-solid fa-lock absolute left-4 top-3.5 text-slate-400 text-xs"></i>
                    <input type="password" name="password" id="password" placeholder="••••••••" class="w-full bg-slate-50 border border-slate-300 rounded-xl pl-10 pr-4 py-3 text-xs sm:text-sm text-slate-900 placeholder-slate-400 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:outline-hidden" required>
                </div>
            </div>

            <div class="flex items-center justify-between text-xs text-slate-600">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remember" class="w-4 h-4 text-indigo-600 rounded-sm border-slate-300">
                    <span>লগইন মনে রাখুন</span>
                </label>
            </div>

            <button type="submit" class="w-full py-3.5 bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white font-extrabold text-sm rounded-xl shadow-md transition-all flex items-center justify-center gap-2">
                <i class="fa-solid fa-arrow-right-to-bracket"></i> অ্যাডমিন প্যানেলে প্রবেশ করুন
            </button>
        </form>

        <div class="text-center pt-2 text-xs text-slate-500 border-t border-slate-100">
            ক্লায়েন্ট বা ডিজাইনার? <a href="{{ route('portal.select') }}" class="text-indigo-600 font-bold hover:underline">অন্যান্য পোর্টালে যান</a>
        </div>
    </div>
</div>
@endsection
