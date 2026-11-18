@extends('layouts.app')

@section('title', 'ডিজাইনার পোর্টাল লগইন - Reporter')

@section('content')
<div class="min-h-[75vh] flex items-center justify-center px-4 py-12">
    <div class="max-w-md w-full bg-white rounded-3xl p-8 border border-slate-200 shadow-xl space-y-6">
        <div class="text-center space-y-2">
            <div class="w-14 h-14 rounded-2xl bg-teal-100 text-teal-700 flex items-center justify-center text-2xl mx-auto shadow-xs">
                <i class="fa-solid fa-paintbrush"></i>
            </div>
            <span class="inline-block px-3 py-1 bg-teal-100 text-teal-800 rounded-full text-[11px] font-bold uppercase tracking-wider">
                ফ্রিল্যান্স ডিজাইনার পোর্টাল
            </span>
            <h1 class="text-2xl font-black text-slate-900">ডিজাইনার লগইন</h1>
            <p class="text-xs text-slate-500">বিজ্ঞাপন ডিজাইন অর্ডার ও আয় পরিচালনা করতে লগইন করুন</p>
        </div>

        <!-- Demo auto-fill -->
        <div class="p-3.5 bg-teal-50/70 rounded-2xl border border-teal-200 text-xs flex items-center justify-between">
            <div>
                <div class="font-bold text-teal-900">ডিজাইনার ডেমো অ্যাকাউন্ট:</div>
                <div class="text-[11px] text-slate-600 font-mono">tanvir@reporter.test | password</div>
            </div>
            <button type="button" onclick="document.getElementById('email').value='tanvir@reporter.test'; document.getElementById('password').value='password';" class="px-3 py-1.5 bg-teal-600 hover:bg-teal-700 text-white text-[11px] font-bold rounded-lg transition-colors shadow-xs">
                অটো-ফিল
            </button>
        </div>

        <form action="{{ route('designer.login.post') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">ডিজাইনার ইমেইল</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="tanvir@reporter.test" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-teal-500 focus:bg-white focus:outline-hidden" required>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">পাসওয়ার্ড</label>
                <input type="password" name="password" id="password" placeholder="••••••••" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-teal-500 focus:bg-white focus:outline-hidden" required>
            </div>

            <div class="flex items-center justify-between text-xs text-slate-600">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remember" class="w-4 h-4 text-teal-600 rounded-sm">
                    <span>লগইন মনে রাখুন</span>
                </label>
            </div>

            <button type="submit" class="w-full py-3.5 bg-teal-600 hover:bg-teal-700 text-white font-extrabold text-sm rounded-xl shadow-md transition-all flex items-center justify-center gap-2">
                <i class="fa-solid fa-arrow-right-to-bracket"></i> ডিজাইনার প্যানেলে প্রবেশ করুন
            </button>
        </form>

        <div class="text-center pt-2 text-xs text-slate-500 border-t border-slate-100 flex justify-between items-center">
            <span>নতুন ডিজাইনার? <a href="{{ route('designer.register') }}" class="font-bold text-teal-600 hover:underline">জয়েন করুন</a></span>
            <a href="{{ route('client.login') }}" class="text-slate-400 hover:text-slate-600">বিজ্ঞাপনদাতা লগইন &rarr;</a>
        </div>
    </div>
</div>
@endsection
