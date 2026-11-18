@extends('layouts.admin')

@section('title', 'সিস্টেম সেটিংস - Admin')
@section('page_title', 'সিস্টেম ও পেমেন্ট গেটওয়ে সেটিংস')

@section('content')
<div class="max-w-4xl space-y-6">
    <div>
        <h1 class="text-xl font-bold text-slate-900">ওয়েবসাইট ও পেমেন্ট সেটিংস</h1>
        <p class="text-xs text-slate-500">হেল্পলাইন নম্বর, মার্চেন্ট বিকাশ/নগদ একাউন্ট ও ব্যাংকের তথ্য পরিবর্তন করুন</p>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-200/80 shadow-xs space-y-6">
        @csrf

        <div class="space-y-4">
            <h2 class="text-sm font-bold text-slate-900 pb-2 border-b border-slate-100 flex items-center gap-2">
                <i class="fa-solid fa-gear text-indigo-600"></i> সাধারণ তথ্য ও যোগাযোগ
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5">ওয়েবসাইটের নাম</label>
                    <input type="text" name="site_name" value="{{ $settings['site_name'] ?? 'Ads Bazar BD' }}" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-xs text-slate-900 font-medium focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5">ট্যাগলাইন</label>
                    <input type="text" name="site_tagline" value="{{ $settings['site_tagline'] ?? 'অনলাইন সংবাদপত্র বিজ্ঞাপন প্ল্যাটফর্ম' }}" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-xs text-slate-900 font-medium focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5">হেল্পলাইন ফোন নম্বর</label>
                    <input type="text" name="helpline_phone" value="{{ $settings['helpline_phone'] ?? '01854-820303' }}" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-xs font-bold text-emerald-700 focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:outline-hidden">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5">কাস্টমার সাপোর্ট ইমেইল</label>
                    <input type="email" name="helpline_email" value="{{ $settings['helpline_email'] ?? 'contact@adsbazarbd.com' }}" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-xs text-slate-900 font-medium focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5">অফিসের ঠিকানা</label>
                <input type="text" name="office_address" value="{{ $settings['office_address'] ?? 'বাড়ি # ১২, রোড # ০৫, ধানমন্ডি, ঢাকা' }}" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-xs text-slate-900 font-medium focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
            </div>
        </div>

        <div class="space-y-4 pt-4 border-t border-slate-100">
            <h2 class="text-sm font-bold text-slate-900 pb-2 border-b border-slate-100 flex items-center gap-2">
                <i class="fa-solid fa-mobile-screen-button text-amber-500"></i> মোবাইল ব্যাংকিং ও মার্চেন্ট পেমেন্ট নম্বর
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-pink-600 uppercase mb-1.5">বিকাশ (bKash) নম্বর</label>
                    <input type="text" name="bkash_merchant_number" value="{{ $settings['bkash_merchant_number'] ?? '01779-870454' }}" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-xs font-bold text-pink-700 focus:bg-white focus:ring-2 focus:ring-pink-500 focus:outline-hidden">
                </div>
                <div>
                    <label class="block text-xs font-bold text-orange-600 uppercase mb-1.5">নগদ (Nagad) নম্বর</label>
                    <input type="text" name="nagad_merchant_number" value="{{ $settings['nagad_merchant_number'] ?? '01854-820303' }}" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-xs font-bold text-orange-700 focus:bg-white focus:ring-2 focus:ring-orange-500 focus:outline-hidden">
                </div>
                <div>
                    <label class="block text-xs font-bold text-purple-600 uppercase mb-1.5">রকেট (Rocket) নম্বর</label>
                    <input type="text" name="rocket_number" value="{{ $settings['rocket_number'] ?? '01779-870454-8' }}" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-xs font-bold text-purple-700 focus:bg-white focus:ring-2 focus:ring-purple-500 focus:outline-hidden">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-sky-700 uppercase mb-1.5">ব্যাংক একাউন্ট বিবরণ (রাউটিং ও একাউন্ট নম্বর)</label>
                <textarea name="bank_info" rows="3" class="w-full bg-slate-50 border border-slate-300 rounded-xl p-3 text-xs text-slate-900 leading-relaxed focus:bg-white focus:ring-2 focus:ring-sky-500 focus:outline-hidden">{{ $settings['bank_info'] ?? '' }}</textarea>
            </div>
        </div>

        <div class="space-y-4 pt-4 border-t border-slate-100">
            <h2 class="text-sm font-bold text-slate-900 pb-2 border-b border-slate-100 flex items-center gap-2">
                <i class="fa-solid fa-hand-holding-dollar text-emerald-600"></i> ডিজাইনার মার্কেটপ্লেস কমিশন ও উইথড্রয়াল পলিসি
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">প্ল্যাটফর্ম কমিশন রেট (%)</label>
                    <div class="relative">
                        <input type="number" step="0.5" min="0" max="90" name="designer_commission_percent" value="{{ $settings['designer_commission_percent'] ?? '15' }}" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-xs font-bold text-indigo-700 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:outline-hidden" required>
                        <span class="absolute right-4 top-2.5 text-xs text-slate-400 font-bold">%</span>
                    </div>
                    <p class="text-[11px] text-slate-400 mt-1">প্রতিটি ডিজাইন কাজ সম্পন্ন হলে মোট বাজেট থেকে এই পরিমাণ % প্ল্যাটফর্ম ফি কাটা হবে।</p>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">নূন্যতম উইথড্রয়াল সীমা (টাকা)</label>
                    <div class="relative">
                        <input type="number" step="50" min="50" name="min_withdrawal_amount" value="{{ $settings['min_withdrawal_amount'] ?? '500' }}" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-xs font-bold text-emerald-700 focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:outline-hidden" required>
                        <span class="absolute right-4 top-2.5 text-xs text-slate-400 font-bold">৳</span>
                    </div>
                    <p class="text-[11px] text-slate-400 mt-1">ডিজাইনারের অ্যাকাউন্টে কমপক্ষে এই পরিমাণ ব্যালেন্স থাকলে তবেই উইথড্র রিকোয়েস্ট পাঠাতে পারবে।</p>
                </div>
            </div>
        </div>

        <div class="text-right pt-4 border-t border-slate-100">
            <button type="submit" class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold text-xs rounded-xl shadow-xs transition-colors inline-flex items-center gap-2">
                <i class="fa-solid fa-floppy-disk"></i>
                সেটিংস সংরক্ষণ করুন
            </button>
        </div>
    </form>
</div>
@endsection
