@extends('layouts.app')

@section('title', 'যোগাযোগ - Ads Bazar BD')

@section('content')
<div class="bg-slate-900 text-white py-12 px-4 sm:px-6 lg:px-8 border-b border-slate-800">
    <div class="max-w-3xl mx-auto text-center space-y-3">
        <span class="px-3 py-1 bg-emerald-500/20 text-emerald-400 rounded-full text-xs font-semibold uppercase tracking-wider">২৪/৭ কাস্টমার সাপোর্ট</span>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">আমাদের সাথে যোগাযোগ করুন</h1>
        <p class="text-slate-400 text-sm max-w-lg mx-auto">
            যেকোনো সংবাদপত্র বিজ্ঞাপন বুকিং, স্পট সাইজ বা বিশেষ সহায়তার জন্য সরাসরি যোগাযোগ করুন।
        </p>
    </div>
</div>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Contact Cards -->
        <div class="space-y-4">
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-2">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-phone"></i>
                </div>
                <h3 class="font-bold text-slate-900 text-sm">সরাসরি ফোন হেল্পলাইন</h3>
                <p class="text-xs text-slate-500">সকাল ৯টা থেকে রাত ১০টা পর্যন্ত</p>
                <div class="text-base font-extrabold text-emerald-700">01854-820303</div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-2">
                <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-envelope"></i>
                </div>
                <h3 class="font-bold text-slate-900 text-sm">ইমেইল সাপোর্ট</h3>
                <p class="text-xs text-slate-500">বিজ্ঞাপন টেক্সট বা কোটেশনের জন্য</p>
                <div class="text-sm font-bold text-slate-800">contact@adsbazarbd.com</div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-2">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-location-dot"></i>
                </div>
                <h3 class="font-bold text-slate-900 text-sm">কর্পোরেট অফিস</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    বাড়ি # ১২, রোড # ০৫, ধানমন্ডি, ঢাকা-১২০৫, বাংলাদেশ
                </p>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="md:col-span-2 bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm space-y-5">
            <h2 class="text-lg font-bold text-slate-900 pb-2 border-b border-slate-100">মেসেজ পাঠান</h2>
            <form onsubmit="event.preventDefault(); alert('আপনার বার্তা সফলভাবে গ্রহণ করা হয়েছে! আমাদের প্রতিনিধি শীঘ্রই যোগাযোগ করবেন।'); this.reset();" class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">আপনার নাম</label>
                        <input type="text" placeholder="সম্পূর্ণ নাম" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-hidden" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">মোবাইল নম্বর</label>
                        <input type="text" placeholder="01xxxxxxxxx" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-hidden" required>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">বিজ্ঞাপনের বিষয়</label>
                    <input type="text" placeholder="যেমন: প্রথম আলোতে কোয়ার্টার পেজ রঙিন বিজ্ঞাপনের কোটেশন" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-hidden" required>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">বার্তা / প্রশ্ন</label>
                    <textarea rows="4" placeholder="আপনার প্রশ্ন বা প্রয়োজনীয় বিবরণ বিস্তারিত লিখুন..." class="w-full bg-slate-50 border border-slate-300 rounded-xl p-3 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-hidden" required></textarea>
                </div>

                <button type="submit" class="px-8 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-md transition-colors">
                    মেসেজ পাঠান
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
