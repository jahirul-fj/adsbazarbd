@extends('layouts.app')

@section('title', 'নতুন অ্যাকাউন্ট তৈরি করুন - Ads Bazar BD')

@section('content')
<div class="max-w-md mx-auto px-4 sm:px-6 py-12">
    <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-xl space-y-6">
        <div class="text-center space-y-2">
            <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-xl mx-auto font-black shadow-xs">
                <i class="fa-solid fa-user-plus"></i>
            </div>
            <h1 class="text-2xl font-black text-slate-900">অ্যাকাউন্ট খুলুন</h1>
            <p class="text-xs text-slate-500">বিজ্ঞাপন প্রদান বা ডিজাইনার হিসেবে আয় শুরু করতে রেজিস্টার করুন</p>
        </div>

        <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Role Selector -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">অ্যাকাউন্টের ধরন</label>
                <div class="grid grid-cols-2 gap-3">
                    <label class="flex flex-col items-center justify-center p-3 rounded-xl border border-slate-200 cursor-pointer has-checked:border-emerald-600 has-checked:bg-emerald-50/50 text-center">
                        <input type="radio" name="role" value="client" class="sr-only" checked>
                        <i class="fa-solid fa-user text-emerald-600 mb-1 text-sm"></i>
                        <span class="font-bold text-xs text-slate-900">বিজ্ঞাপনদাতা (Client)</span>
                    </label>
                    <label class="flex flex-col items-center justify-center p-3 rounded-xl border border-slate-200 cursor-pointer has-checked:border-emerald-600 has-checked:bg-emerald-50/50 text-center">
                        <input type="radio" name="role" value="designer" class="sr-only">
                        <i class="fa-solid fa-paintbrush text-teal-600 mb-1 text-sm"></i>
                        <span class="font-bold text-xs text-slate-900">ডিজাইনার (Designer)</span>
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">আপনার নাম <span class="text-rose-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="সম্পূর্ণ নাম লিখুন" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 focus:bg-white focus:outline-hidden" required>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">ইমেইল এড্রেস <span class="text-rose-500">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="name@example.com" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 focus:bg-white focus:outline-hidden" required>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">মোবাইল নম্বর <span class="text-rose-500">*</span></label>
                <input type="text" name="phone" value="{{ old('phone') }}" placeholder="01xxxxxxxxx" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 focus:bg-white focus:outline-hidden" required>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">পাসওয়ার্ড <span class="text-rose-500">*</span></label>
                <input type="password" name="password" placeholder="নূন্যতম ৬ অক্ষর" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 focus:bg-white focus:outline-hidden" required>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">কনফার্ম পাসওয়ার্ড <span class="text-rose-500">*</span></label>
                <input type="password" name="password_confirmation" placeholder="পুনরায় পাসওয়ার্ড দিন" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 focus:bg-white focus:outline-hidden" required>
            </div>

            <button type="submit" class="w-full py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-sm rounded-xl shadow-md transition-all">
                অ্যাকাউন্ট তৈরি করুন
            </button>
        </form>

        <div class="text-center pt-2 text-xs text-slate-500 border-t border-slate-100">
            পূর্বেই অ্যাকাউন্ট আছে? <a href="{{ route('login') }}" class="font-bold text-emerald-600 hover:underline">এখানে লগইন করুন</a>
        </div>
    </div>
</div>
@endsection
