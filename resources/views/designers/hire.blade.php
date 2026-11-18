@extends('layouts.app')

@section('title', $profile->user->name . ' কে হায়ার করুন')

@section('content')
<div class="bg-slate-900 text-white py-12 px-4 sm:px-6 lg:px-8 border-b border-slate-800">
    <div class="max-w-3xl mx-auto text-center space-y-2">
        <span class="px-3 py-1 bg-emerald-500/20 text-emerald-400 rounded-full text-xs font-semibold uppercase tracking-wider">এসক্রো প্রটেকশন</span>
        <h1 class="text-3xl font-extrabold">{{ $profile->user->name }} কে হায়ার করুন</h1>
        <p class="text-slate-400 text-xs">আপনার বিজ্ঞাপনের ব্রিফ ও সাইজ প্রদান করুন। কাজ সম্পন্ন হলে পেমেন্ট রিলিজ হবে।</p>
    </div>
</div>

<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <form action="{{ route('designers.storeOrder', $profile->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6 bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-md">
        @csrf

        <div class="space-y-4">
            <h2 class="text-base font-bold text-slate-900 pb-2 border-b border-slate-100">প্রজেক্ট ব্রিফ ও বিবরণ</h2>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    কাজের শিরোনাম <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="title" value="{{ old('title') }}" placeholder="যেমন: প্রথম আলোর জন্য ৪ কলাম × ৫ ইঞ্চি জব রিক্রুটমেন্ট ব্যানার" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-emerald-500 focus:bg-white focus:outline-hidden" required>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    বিজ্ঞাপনের আকার / সাইজ স্পেসিফিকেশন <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="ad_size_requirement" value="{{ old('ad_size_requirement') }}" placeholder="যেমন: ৪ কলাম × ৬ ইঞ্চি (কালার) অথবা হাফ পেজ" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-emerald-500 focus:bg-white focus:outline-hidden" required>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    বিস্তারিত কেস স্টাডি / ডিজাইনের ব্রিফ <span class="text-rose-500">*</span>
                </label>
                <textarea name="brief_description" rows="5" placeholder="বিজ্ঞাপনের টেক্সট, কোম্পানির লোগো নির্দেশিকা, পছন্দসই রঙ এবং যোগাযোগের তথ্য বিস্তারিত লিখুন..." class="w-full bg-slate-50 border border-slate-300 rounded-xl p-4 text-sm font-medium focus:ring-2 focus:ring-emerald-500 focus:bg-white focus:outline-hidden leading-relaxed" required>{{ old('brief_description') }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    লোগো / রেফারেন্স ফাইল বা টেক্সট ডকুমেন্ট সংযুক্ত করুন
                </label>
                <input type="file" name="attachment_file" accept=".pdf,.jpg,.jpeg,.png,.zip,.doc,.docx" class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    বাজেট (ন্যূনতম ৳{{ number_format($profile->starting_rate, 0) }}) <span class="text-rose-500">*</span>
                </label>
                <input type="number" name="budget" min="{{ $profile->starting_rate }}" value="{{ old('budget', $profile->starting_rate) }}" class="w-full sm:w-1/2 bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm font-bold text-emerald-700 focus:ring-2 focus:ring-emerald-500 focus:bg-white focus:outline-hidden" required>
            </div>
        </div>

        <!-- Escrow Payment Selection -->
        <div class="space-y-4 pt-4 border-t border-slate-100">
            <h2 class="text-base font-bold text-slate-900 pb-1">নিরাপদ এসক্রো পেমেন্ট</h2>
            <p class="text-xs text-slate-500">আপনার টাকা প্রচারক প্ল্যাটফর্মে গচ্ছিত থাকবে। ডিজাইনার ৩টি রিভিশন দিবে এবং আপনার অনুমোদনের পর টাকা ডিজাইনারের ব্যালেন্সে যোগ হবে।</p>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                <label class="flex flex-col items-center justify-center p-3 rounded-xl border border-slate-200 cursor-pointer has-checked:border-emerald-600 has-checked:bg-emerald-50/50 text-center">
                    <input type="radio" name="payment_method" value="bkash" class="sr-only" checked>
                    <span class="font-extrabold text-sm text-pink-600">বিকাশ (bKash)</span>
                </label>
                <label class="flex flex-col items-center justify-center p-3 rounded-xl border border-slate-200 cursor-pointer has-checked:border-emerald-600 has-checked:bg-emerald-50/50 text-center">
                    <input type="radio" name="payment_method" value="nagad" class="sr-only">
                    <span class="font-extrabold text-sm text-orange-600">নগদ (Nagad)</span>
                </label>
                <label class="flex flex-col items-center justify-center p-3 rounded-xl border border-slate-200 cursor-pointer has-checked:border-emerald-600 has-checked:bg-emerald-50/50 text-center">
                    <input type="radio" name="payment_method" value="rocket" class="sr-only">
                    <span class="font-extrabold text-sm text-purple-600">রকেট (Rocket)</span>
                </label>
                <label class="flex flex-col items-center justify-center p-3 rounded-xl border border-slate-200 cursor-pointer has-checked:border-emerald-600 has-checked:bg-emerald-50/50 text-center">
                    <input type="radio" name="payment_method" value="bank" class="sr-only">
                    <span class="font-extrabold text-sm text-sky-700">ব্যাংক ট্রান্সফার</span>
                </label>
            </div>

            <div class="p-3 bg-emerald-50 rounded-xl border border-emerald-200 text-xs text-emerald-900">
                আমাদের বিকাশ নম্বর <strong>01779-870454</strong> অথবা নগদ <strong>01854-820303</strong> এ পেমেন্ট করে নিচের বক্সে ট্রানজেকশন আইডি প্রদান করুন।
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Trx ID / ট্রানজেকশন আইডি <span class="text-rose-500">*</span></label>
                    <input type="text" name="trx_id" value="{{ old('trx_id') }}" placeholder="যেমন: BK928371923" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-emerald-500 focus:bg-white focus:outline-hidden" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">প্রেরক ফোন নম্বর <span class="text-rose-500">*</span></label>
                    <input type="text" name="sender_phone" value="{{ old('sender_phone', auth()->user()?->phone) }}" placeholder="01xxxxxxxxx" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-emerald-500 focus:bg-white focus:outline-hidden" required>
                </div>
            </div>
        </div>

        <div class="pt-4 text-center">
            <button type="submit" class="w-full sm:w-auto px-10 py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-base rounded-2xl shadow-lg transition-all inline-flex items-center justify-center gap-2">
                <i class="fa-solid fa-lock"></i> অর্ডার নিশ্চিত করুন ও এসক্রো ফান্ড জমা দিন
            </button>
        </div>
    </form>
</div>
@endsection
