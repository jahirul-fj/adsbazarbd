@extends('layouts.app')

@section('title', 'সিস্টেম সেটিংস - Admin')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-6">
    <div>
        <h1 class="text-2xl font-black text-slate-900">ওয়েবসাইট ও পেমেন্ট সেটিংস</h1>
        <p class="text-xs text-slate-500">হেল্পলাইন নম্বর, মার্চেন্ট বিকাশ/নগদ একাউন্ট ও ব্যাংকের তথ্য পরিবর্তন করুন</p>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-md space-y-6">
        @csrf

        <div class="space-y-4">
            <h2 class="text-base font-bold text-slate-900 pb-2 border-b border-slate-100">সাধারণ তথ্য ও কন্টাক্ট</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">ওয়েবসাইটের নাম</label>
                    <input type="text" name="site_name" value="{{ $settings['site_name'] ?? 'Reporter' }}" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-xs font-medium">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">ট্যাগলাইন</label>
                    <input type="text" name="site_tagline" value="{{ $settings['site_tagline'] ?? 'অনলাইন সংবাদপত্র বিজ্ঞাপন প্ল্যাটফর্ম' }}" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-xs font-medium">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">হেল্পলাইন ফোন নম্বর</label>
                    <input type="text" name="helpline_phone" value="{{ $settings['helpline_phone'] ?? '01854-820303' }}" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-xs font-bold text-emerald-700">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">কাস্টমার সাপোর্ট ইমেইল</label>
                    <input type="email" name="helpline_email" value="{{ $settings['helpline_email'] ?? 'contact@reporter.com.bd' }}" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-xs font-medium">
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">অফিসের ঠিকানা</label>
                <input type="text" name="office_address" value="{{ $settings['office_address'] ?? 'বাড়ি # ১২, রোড # ০৫, ধানমন্ডি, ঢাকা' }}" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-xs font-medium">
            </div>
        </div>

        <div class="space-y-4 pt-4 border-t border-slate-100">
            <h2 class="text-base font-bold text-slate-900 pb-2 border-b border-slate-100">মোবাইল ব্যাংকিং ও মার্চেন্ট নম্বর</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-pink-600 uppercase mb-1">বিকাশ (bKash) নম্বর</label>
                    <input type="text" name="bkash_merchant_number" value="{{ $settings['bkash_merchant_number'] ?? '01779-870454' }}" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-xs font-bold">
                </div>
                <div>
                    <label class="block text-xs font-bold text-orange-600 uppercase mb-1">নগদ (Nagad) নম্বর</label>
                    <input type="text" name="nagad_merchant_number" value="{{ $settings['nagad_merchant_number'] ?? '01854-820303' }}" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-xs font-bold">
                </div>
                <div>
                    <label class="block text-xs font-bold text-purple-600 uppercase mb-1">রকেট (Rocket) নম্বর</label>
                    <input type="text" name="rocket_number" value="{{ $settings['rocket_number'] ?? '01779-870454-8' }}" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-xs font-bold">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-sky-800 uppercase mb-1">ব্যাংক একাউন্ট বিবরণ</label>
                <textarea name="bank_info" rows="2" class="w-full bg-slate-50 border border-slate-300 rounded-xl p-3 text-xs leading-relaxed">{{ $settings['bank_info'] ?? '' }}</textarea>
            </div>
        </div>

        <div class="text-right pt-4 border-t border-slate-100">
            <button type="submit" class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold text-xs rounded-xl shadow-md transition-colors">
                সেটিংস সংরক্ষণ করুন
            </button>
        </div>
    </form>
</div>
@endsection
