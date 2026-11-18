@extends('layouts.app')

@section('title', 'ডিজাইনার রেজিস্ট্রেশন - Ads Bazar BD')

@section('content')
<div class="max-w-xl mx-auto px-4 sm:px-6 py-12">
    <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-xl space-y-6">
        <div class="text-center space-y-2">
            <div class="w-14 h-14 rounded-2xl bg-teal-100 text-teal-700 flex items-center justify-center text-2xl mx-auto shadow-xs">
                <i class="fa-solid fa-paintbrush"></i>
            </div>
            <span class="inline-block px-3 py-1 bg-teal-100 text-teal-800 rounded-full text-[11px] font-bold uppercase tracking-wider">
                ডিজাইনার অনবোর্ডিং
            </span>
            <h1 class="text-2xl font-black text-slate-900">গ্রাফিক ডিজাইনার সাইনআপ</h1>
            <p class="text-xs text-slate-500">সংবাদপত্র বিজ্ঞাপনের কাজ করে নিশ্চিত আয় করতে একাউন্ট খুলুন</p>
        </div>

        <form action="{{ route('designer.register.post') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">আপনার নাম <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="সম্পূর্ণ নাম" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-teal-500 focus:outline-hidden" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">মোবাইল নম্বর <span class="text-rose-500">*</span></label>
                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="01xxxxxxxxx" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-teal-500 focus:outline-hidden" required>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">ইমেইল এড্রেস <span class="text-rose-500">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="name@example.com" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-teal-500 focus:outline-hidden" required>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">পেশাগত ট্যাগলাইন <span class="text-rose-500">*</span></label>
                <input type="text" name="tagline" value="{{ old('tagline') }}" placeholder="যেমন: পেশাদার প্রি-প্রেস ও ডিসপ্লে অ্যাড স্পেশালিস্ট" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-teal-500 focus:outline-hidden" required>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">অভিজ্ঞতা (বছর) <span class="text-rose-500">*</span></label>
                    <input type="number" name="experience_years" value="{{ old('experience_years', 2) }}" min="0" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-teal-500 focus:outline-hidden" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">শুরুর রেট (৳ / প্রতি কাজ) <span class="text-rose-500">*</span></label>
                    <input type="number" name="starting_rate" value="{{ old('starting_rate', 500) }}" min="100" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm font-bold text-teal-700 focus:ring-2 focus:ring-teal-500 focus:outline-hidden" required>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">দক্ষতা ও টুলস (কমা দিয়ে লিখুন) <span class="text-rose-500">*</span></label>
                <input type="text" name="skills" value="{{ old('skills', 'Newspaper Ads, Adobe Illustrator, Photoshop, Typography') }}" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-teal-500 focus:outline-hidden" required>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">পাসওয়ার্ড <span class="text-rose-500">*</span></label>
                    <input type="password" name="password" placeholder="নূন্যতম ৬ অক্ষর" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-teal-500 focus:outline-hidden" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">কনফার্ম পাসওয়ার্ড <span class="text-rose-500">*</span></label>
                    <input type="password" name="password_confirmation" placeholder="পুনরায় পাসওয়ার্ড" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-teal-500 focus:outline-hidden" required>
                </div>
            </div>

            <button type="submit" class="w-full py-3.5 bg-teal-600 hover:bg-teal-700 text-white font-extrabold text-sm rounded-xl shadow-md transition-all">
                ডিজাইনার একাউন্ট খুলুন
            </button>
        </form>

        <div class="text-center pt-2 text-xs text-slate-500 border-t border-slate-100 flex justify-between items-center">
            <span>পূর্বেই অ্যাকাউন্ট আছে? <a href="{{ route('designer.login') }}" class="font-bold text-teal-600 hover:underline">লগইন করুন</a></span>
            <a href="{{ route('client.register') }}" class="text-slate-400 hover:text-slate-600">বিজ্ঞাপনদাতা সাইনআপ &rarr;</a>
        </div>
    </div>
</div>
@endsection
