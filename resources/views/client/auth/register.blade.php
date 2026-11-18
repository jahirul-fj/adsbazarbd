@extends('layouts.app')

@section('title', 'গ্রাহক / বিজ্ঞাপনদাতা রেজিস্ট্রেশন - Reporter')

@section('content')
<div class="max-w-md mx-auto px-4 sm:px-6 py-12">
    <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-xl space-y-6">
        <div class="text-center space-y-2">
            <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-2xl mx-auto shadow-xs">
                <i class="fa-solid fa-user-plus"></i>
            </div>
            <span class="inline-block px-3 py-1 bg-emerald-100 text-emerald-800 rounded-full text-[11px] font-bold uppercase tracking-wider">
                নতুন গ্রাহক অ্যাকাউন্ট
            </span>
            <h1 class="text-2xl font-black text-slate-900">বিজ্ঞাপনদাতা সাইনআপ</h1>
            <p class="text-xs text-slate-500">অনলাইনে সহজে বিজ্ঞাপন বুকিং করতে অ্যাকাউন্ট খুলুন</p>
        </div>

        <form action="{{ route('client.register.post') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">আপনার নাম <span class="text-rose-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="সম্পূর্ণ নাম" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-hidden" required>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">ইমেইল এড্রেস <span class="text-rose-500">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="name@example.com" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-hidden" required>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">মোবাইল নম্বর <span class="text-rose-500">*</span></label>
                <input type="text" name="phone" value="{{ old('phone') }}" placeholder="01xxxxxxxxx" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-hidden" required>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">পাসওয়ার্ড <span class="text-rose-500">*</span></label>
                <input type="password" name="password" placeholder="নূন্যতম ৬ অক্ষর" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-hidden" required>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">কনফার্ম পাসওয়ার্ড <span class="text-rose-500">*</span></label>
                <input type="password" name="password_confirmation" placeholder="পুনরায় পাসওয়ার্ড দিন" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-hidden" required>
            </div>

            <button type="submit" class="w-full py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-sm rounded-xl shadow-md transition-all">
                অ্যাকাউন্ট তৈরি করুন
            </button>
        </form>

        <div class="text-center pt-2 text-xs text-slate-500 border-t border-slate-100 flex justify-between items-center">
            <span>পূর্বেই অ্যাকাউন্ট আছে? <a href="{{ route('client.login') }}" class="font-bold text-emerald-600 hover:underline">লগইন করুন</a></span>
            <a href="{{ route('designer.register') }}" class="text-slate-400 hover:text-slate-600">ডিজাইনার হিসেবে যোগ দিন &rarr;</a>
        </div>
    </div>
</div>
@endsection
