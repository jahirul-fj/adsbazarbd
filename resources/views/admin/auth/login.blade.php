@extends('layouts.app')

@section('title', 'অ্যাডমিন সিকিউরিটি লগইন - Reporter Management')

@section('content')
<div class="min-h-[75vh] flex items-center justify-center px-4 py-12">
    <div class="max-w-md w-full bg-slate-900 text-white rounded-3xl p-8 border border-slate-800 shadow-2xl space-y-6 relative overflow-hidden">
        <div class="absolute -top-16 -right-16 w-36 h-36 bg-indigo-500/20 rounded-full blur-2xl"></div>

        <div class="text-center space-y-2 relative">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-indigo-500 to-indigo-700 text-white flex items-center justify-center text-2xl mx-auto shadow-lg">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
            <span class="inline-block px-3 py-1 bg-indigo-500/20 text-indigo-300 rounded-full text-[11px] font-bold uppercase tracking-wider">
                Restricted Access
            </span>
            <h1 class="text-2xl font-black tracking-tight">সিস্টেম অ্যাডমিন লগইন</h1>
            <p class="text-xs text-slate-400">বিজ্ঞাপন ও প্ল্যাটফর্ম পরিচালনার জন্য অ্যাডমিন একাউন্টে প্রবেশ করুন</p>
        </div>

        <!-- 1-Click Demo Auto-fill -->
        <div class="p-3.5 bg-slate-800/80 rounded-2xl border border-slate-700 text-xs flex items-center justify-between">
            <div>
                <div class="font-bold text-indigo-300">অ্যাডমিন ডেমো একাউন্ট:</div>
                <div class="text-[11px] text-slate-400 font-mono">admin@reporter.test | password</div>
            </div>
            <button type="button" onclick="document.getElementById('email').value='admin@reporter.test'; document.getElementById('password').value='password';" class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-500 text-white text-[11px] font-bold rounded-lg transition-colors shadow-xs">
                অটো-ফিল
            </button>
        </div>

        <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1.5">অ্যাডমিন ইমেইল</label>
                <div class="relative">
                    <i class="fa-solid fa-envelope absolute left-4 top-3.5 text-slate-500 text-xs"></i>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="admin@reporter.test" class="w-full bg-slate-800 border border-slate-700 rounded-xl pl-10 pr-4 py-3 text-xs sm:text-sm text-white placeholder-slate-500 focus:ring-2 focus:ring-indigo-500 focus:outline-hidden" required>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1.5">সিক্রেট পাসওয়ার্ড</label>
                <div class="relative">
                    <i class="fa-solid fa-lock absolute left-4 top-3.5 text-slate-500 text-xs"></i>
                    <input type="password" name="password" id="password" placeholder="••••••••" class="w-full bg-slate-800 border border-slate-700 rounded-xl pl-10 pr-4 py-3 text-xs sm:text-sm text-white placeholder-slate-500 focus:ring-2 focus:ring-indigo-500 focus:outline-hidden" required>
                </div>
            </div>

            <div class="flex items-center justify-between text-xs text-slate-400">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remember" class="w-4 h-4 bg-slate-800 border-slate-700 text-indigo-600 rounded-sm">
                    <span>লগইন মনে রাখুন</span>
                </label>
            </div>

            <button type="submit" class="w-full py-3.5 bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-500 hover:to-indigo-600 text-white font-extrabold text-sm rounded-xl shadow-lg transition-all flex items-center justify-center gap-2">
                <i class="fa-solid fa-arrow-right-to-bracket"></i> অ্যাডমিন প্যানেলে প্রবেশ করুন
            </button>
        </form>

        <div class="text-center pt-2 text-xs text-slate-500 border-t border-slate-800">
            ক্লায়েন্ট বা ডিজাইনার? <a href="{{ route('portal.select') }}" class="text-indigo-400 font-bold hover:underline">অন্যান্য পোর্টালে যান</a>
        </div>
    </div>
</div>
@endsection
