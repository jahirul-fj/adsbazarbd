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
            <div>
                <h2 class="text-base font-bold text-slate-900 pb-1 flex items-center gap-2">
                    <i class="fa-solid fa-shield-halved text-emerald-600"></i> নিরাপদ এসক্রো পেমেন্ট
                </h2>
                <p class="text-xs text-slate-500">আপনার টাকা Ads Bazar BD প্ল্যাটফর্মে সুরক্ষিত এসক্রোতে গচ্ছিত থাকবে। ডিজাইনার ৩টি রিভিশন সম্পন্ন করে আপনার চূড়ান্ত অনুমোদন পাওয়ার পরই ডিজাইনারের একাউন্টে টাকা যোগ হবে।</p>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3" id="hirePaymentGrid">
                <label id="hire_card_bkash" onclick="selectHirePayment('bkash')" class="hire-gateway-card flex flex-col items-center justify-center p-3.5 rounded-2xl border-2 border-emerald-600 bg-emerald-50/80 ring-2 ring-emerald-500/20 cursor-pointer transition-all text-center select-none shadow-xs">
                    <input type="radio" name="payment_method" id="pay_bkash" value="bkash" class="sr-only" checked onchange="selectHirePayment('bkash')">
                    <span class="font-extrabold text-sm text-pink-600">বিকাশ (bKash)</span>
                    <span class="text-[10px] text-slate-400 mt-0.5">মার্চেন্ট পেমেন্ট</span>
                </label>
                <label id="hire_card_nagad" onclick="selectHirePayment('nagad')" class="hire-gateway-card flex flex-col items-center justify-center p-3.5 rounded-2xl border border-slate-200 bg-white hover:border-slate-300 cursor-pointer transition-all text-center select-none shadow-xs">
                    <input type="radio" name="payment_method" id="pay_nagad" value="nagad" class="sr-only" onchange="selectHirePayment('nagad')">
                    <span class="font-extrabold text-sm text-orange-600">নগদ (Nagad)</span>
                    <span class="text-[10px] text-slate-400 mt-0.5">মার্চেন্ট / সেন্ড মানি</span>
                </label>
                <label id="hire_card_rocket" onclick="selectHirePayment('rocket')" class="hire-gateway-card flex flex-col items-center justify-center p-3.5 rounded-2xl border border-slate-200 bg-white hover:border-slate-300 cursor-pointer transition-all text-center select-none shadow-xs">
                    <input type="radio" name="payment_method" id="pay_rocket" value="rocket" class="sr-only" onchange="selectHirePayment('rocket')">
                    <span class="font-extrabold text-sm text-purple-600">রকেট (Rocket)</span>
                    <span class="text-[10px] text-slate-400 mt-0.5">ডিবিবিএল ওয়ালেট</span>
                </label>
                <label id="hire_card_bank" onclick="selectHirePayment('bank')" class="hire-gateway-card flex flex-col items-center justify-center p-3.5 rounded-2xl border border-slate-200 bg-white hover:border-slate-300 cursor-pointer transition-all text-center select-none shadow-xs">
                    <input type="radio" name="payment_method" id="pay_bank" value="bank" class="sr-only" onchange="selectHirePayment('bank')">
                    <span class="font-extrabold text-sm text-sky-700">ব্যাংক ট্রান্সফার</span>
                    <span class="text-[10px] text-slate-400 mt-0.5">সরাসরি একাউন্ট</span>
                </label>
            </div>

            <!-- Dynamic Payment Instructions Box -->
            <div id="hireInstructionsBox" class="p-4 bg-emerald-50/80 rounded-2xl border border-emerald-200 text-xs text-emerald-950 leading-relaxed space-y-1">
                <!-- Injected via JS -->
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label id="trxLabel" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Trx ID / ট্রানজেকশন আইডি <span class="text-rose-500">*</span></label>
                    <input type="text" name="trx_id" id="trxInput" value="{{ old('trx_id') }}" placeholder="যেমন: BK928371923" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-emerald-500 focus:bg-white focus:outline-hidden" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">প্রেরক / যোগাযোগ ফোন নম্বর <span class="text-rose-500">*</span></label>
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

@push('scripts')
<script>
    function selectHirePayment(method) {
        // Set radio checked
        const radio = document.getElementById('pay_' + method);
        if (radio) radio.checked = true;

        const methods = ['bkash', 'nagad', 'rocket', 'bank'];
        methods.forEach(m => {
            const card = document.getElementById('hire_card_' + m);
            if (!card) return;
            if (m === method) {
                card.className = 'hire-gateway-card flex flex-col items-center justify-center p-3.5 rounded-2xl border-2 border-emerald-600 bg-emerald-50/80 ring-2 ring-emerald-500/20 cursor-pointer transition-all text-center select-none shadow-xs';
            } else {
                card.className = 'hire-gateway-card flex flex-col items-center justify-center p-3.5 rounded-2xl border border-slate-200 bg-white hover:border-slate-300 cursor-pointer transition-all text-center select-none shadow-xs';
            }
        });

        const instBox = document.getElementById('hireInstructionsBox');
        const trxLabel = document.getElementById('trxLabel');
        const trxInput = document.getElementById('trxInput');

        const bkashNum = {{ json_encode($siteSettings['bkash_merchant_number'] ?? '01779-870454') }};
        const nagadNum = {{ json_encode($siteSettings['nagad_merchant_number'] ?? '01854-820303') }};
        const rocketNum = {{ json_encode($siteSettings['rocket_number'] ?? '01779-870454-8') }};
        const bankInfo = {{ json_encode($siteSettings['bank_info'] ?? 'Dutch Bangla Bank Ltd, Account Name: Ads Bazar BD Ltd, Acc: 123.120.98765, Branch: Dhanmondi Branch') }};

        if (method === 'bkash') {
            instBox.innerHTML = `<div><strong>বিকাশ পেমেন্ট নিয়ম:</strong> আমাদের বিকাশ মার্চেন্ট নম্বর <strong>${bkashNum}</strong> এ পেমেন্ট করুন অথবা সেন্ড মানি করুন। এরপর প্রাপ্ত ট্রানজেকশন আইডি (TrxID) নিচে ইনপুট দিন।</div>`;
            trxLabel.innerHTML = 'বিকাশ Trx ID (ট্রানজেকশন আইডি) <span class="text-rose-500">*</span>';
            trxInput.placeholder = 'যেমন: BK928371923';
        } else if (method === 'nagad') {
            instBox.innerHTML = `<div><strong>নগদ পেমেন্ট নিয়ম:</strong> আমাদের নগদ নম্বর <strong>${nagadNum}</strong> এ ক্যাশ আউট বা সেন্ড মানি করুন এবং প্রাপ্ত TrxID নিচে লিখুন।</div>`;
            trxLabel.innerHTML = 'নগদ Trx ID (ট্রানজেকশন আইডি) <span class="text-rose-500">*</span>';
            trxInput.placeholder = 'যেমন: 73GF9281';
        } else if (method === 'rocket') {
            instBox.innerHTML = `<div><strong>রকেট পেমেন্ট নিয়ম:</strong> রকেট ওয়ালেট <strong>${rocketNum}</strong> এ পেমেন্ট সম্পন্ন করে প্রাপ্ত ট্রানজেকশন আইডি লিখুন।</div>`;
            trxLabel.innerHTML = 'রকেট ট্রানজেকশন আইডি <span class="text-rose-500">*</span>';
            trxInput.placeholder = 'যেমন: RC8291038';
        } else if (method === 'bank') {
            instBox.innerHTML = `<div><strong>ব্যাংক একাউন্ট বিবরণ:</strong> ${bankInfo}. ব্যাংকে টাকা জমা দিয়ে প্রাপ্ত ডিপোজিট স্লিপ নম্বর বা রেফারেন্স নিচে দিন।</div>`;
            trxLabel.innerHTML = 'ব্যাংক স্লিপ নং / রেফারেন্স আইডি <span class="text-rose-500">*</span>';
            trxInput.placeholder = 'যেমন: DEP-202611-987';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const checked = document.querySelector('input[name="payment_method"]:checked');
        selectHirePayment(checked ? checked.value : 'bkash');
    });
</script>
@endpush
