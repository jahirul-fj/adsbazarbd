@extends('layouts.app')

@section('title', 'শ্রেণীভুক্ত বিজ্ঞাপন দিন - Ads Bazar BD')

@section('content')
<div class="bg-slate-900 text-white py-12 px-4 sm:px-6 lg:px-8 border-b border-slate-800">
    <div class="max-w-4xl mx-auto text-center space-y-3">
        <span class="px-3 py-1 bg-emerald-500/20 text-emerald-400 rounded-full text-xs font-semibold uppercase tracking-wider">সহজ অনলাইন বুকিং</span>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">শ্রেণীভুক্ত বিজ্ঞাপন (Classified Ad) বুকিং</h1>
        <p class="text-slate-400 text-sm max-w-xl mx-auto">
            নিচের ফরমটি পূরণ করে মাত্র ৫ মিনিটে আপনার কাঙ্ক্ষিত পত্রিকায় শ্রেণীভুক্ত বিজ্ঞাপন প্রকাশ করুন। লাইভ ওয়ার্ড কাউন্টার অনুযায়ী মোট খরচ স্বয়ংক্রিয়ভাবে হিসাব হবে।
        </p>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <form action="{{ route('classified.store') }}" method="POST" enctype="multipart/form-data" id="classifiedForm" class="space-y-8">
        @csrf

        <!-- Section 1: Newspaper & Category -->
        <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-xs border border-slate-200/80 space-y-6">
            <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2 pb-3 border-b border-slate-100">
                <span class="w-7 h-7 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs font-extrabold">১</span>
                পত্রিকা ও বিজ্ঞাপনের বিভাগ নির্বাচন
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Newspaper Select -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        সংবাদপত্র সিলেক্ট করুন <span class="text-rose-500">*</span>
                    </label>
                    <select name="newspaper_id" id="newspaper_id" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-emerald-500 focus:bg-white focus:outline-hidden transition-all" required onchange="calculatePrice()">
                        @foreach($newspapers as $np)
                            <option value="{{ $np->id }}" 
                                    data-rate="{{ $np->classified_rate_per_word }}" 
                                    data-min="{{ $np->min_words }}"
                                    {{ (old('newspaper_id', request('newspaper_id')) == $np->id || request('newspaper') == $np->slug) ? 'selected' : '' }}>
                                {{ $np->name }} (৳{{ number_format($np->classified_rate_per_word, 0) }}/শব্দ)
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Category Select -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        বিজ্ঞাপনের ক্যাটাগরি <span class="text-rose-500">*</span>
                    </label>
                    <select name="ad_category_id" id="ad_category_id" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-emerald-500 focus:bg-white focus:outline-hidden transition-all" required onchange="onCategoryChange()">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" 
                                    data-sample="{{ $cat->sample_text }}"
                                    data-doc="{{ $cat->requires_document ? '1' : '0' }}"
                                    {{ (old('ad_category_id') == $cat->id || request('category') == $cat->id) ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Publication Date -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        যে তারিখে বিজ্ঞাপন প্রকাশ করতে চান <span class="text-rose-500">*</span>
                    </label>
                    <input type="date" name="publish_date" id="publish_date" min="{{ date('Y-m-d') }}" value="{{ old('publish_date', date('Y-m-d', strtotime('+1 day'))) }}" class="w-full sm:w-1/2 bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-emerald-500 focus:bg-white focus:outline-hidden" required>
                    <p class="text-xs text-slate-400 mt-1">পরবর্তী দিনের পত্রিকায় প্রকাশের জন্য সাধারণত পূর্বের দিন বিকাল ৪টার মধ্যে আবেদন সম্পন্ন করতে হয়।</p>
                </div>
            </div>

            <!-- Sample Template Box -->
            <div id="sampleBox" class="bg-emerald-50/70 border border-emerald-200 rounded-xl p-4 text-xs space-y-2">
                <div class="flex items-center justify-between">
                    <span class="font-bold text-emerald-900 flex items-center gap-1.5">
                        <i class="fa-solid fa-lightbulb text-amber-500"></i> এই ক্যাটাগরির নমুনা বিজ্ঞাপন ফরম্যাট:
                    </span>
                    <button type="button" onclick="useSampleText()" class="text-xs font-bold text-emerald-700 hover:text-emerald-900 underline">
                        নমুনা টেক্সট ব্যবহার করুন
                    </button>
                </div>
                <div id="sampleTextContent" class="text-slate-700 italic bg-white p-3 rounded-lg border border-emerald-100"></div>
            </div>
        </div>

        <!-- Section 2: Ad Content & Live Price -->
        <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-xs border border-slate-200/80 space-y-6">
            <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2 pb-3 border-b border-slate-100">
                <span class="w-7 h-7 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs font-extrabold">২</span>
                বিজ্ঞাপনের শিরোনাম ও বিবরণ
            </h2>

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        বিজ্ঞাপনের শিরোনাম <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" placeholder="যেমন: ধানমন্ডিতে ৩ বেডের বাসা ভাড়া হবে / সার্টিফিকেট হারানো বিজ্ঞপ্তি" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-emerald-500 focus:bg-white focus:outline-hidden" required>
                </div>

                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">
                            বিজ্ঞাপনের সম্পূর্ণ বিবরণ (টেক্সট) <span class="text-rose-500">*</span>
                        </label>
                        <span class="text-xs text-slate-500 font-semibold" id="wordCountBadge">
                            শব্দ সংখ্যা: <strong class="text-emerald-600">০</strong>
                        </span>
                    </div>
                    <textarea name="ad_body" id="ad_body" rows="6" placeholder="আপনার বিজ্ঞাপনের পূর্ণাঙ্গ বিবরণ এখানে লিখুন। যোগাযোগ নম্বর ও সঠিক ঠিকানা দিতে ভুলবেন না..." class="w-full bg-slate-50 border border-slate-300 rounded-xl p-4 text-sm font-medium focus:ring-2 focus:ring-emerald-500 focus:bg-white focus:outline-hidden leading-relaxed" required oninput="calculatePrice()">{{ old('ad_body') }}</textarea>
                </div>

                <!-- Document Upload (Optional or required for GD / Affidavit) -->
                <div id="docUploadBox">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        প্রয়োজনীয় ডকুমেন্টস আপলোড (জিডি কপি / এফিডেভিট / চালান ইত্যাদি)
                    </label>
                    <input type="file" name="document_file" id="document_file" accept=".pdf,.jpg,.jpeg,.png" class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                    <p class="text-[11px] text-slate-400 mt-1">হারানো বিজ্ঞপ্তি বা সংশোধনের ক্ষেত্রে জিডি কপি বা এফিডেভিটের ছবি/পিডিএফ দিলে দ্রুত পত্রিকা কর্তৃক অনুমোদিত হয়।</p>
                </div>
            </div>

            <!-- Live Calculation Summary Card -->
            <div class="bg-gradient-to-br from-slate-900 to-slate-800 text-white rounded-2xl p-6 shadow-md flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="space-y-1 text-center sm:text-left">
                    <div class="text-xs text-slate-400 uppercase tracking-wider">আনুমানিক খরচ হিসাব</div>
                    <div class="text-sm font-medium text-slate-300">
                        মোট শব্দ: <span id="summaryWords" class="text-white font-bold">০</span> | রেট: <span id="summaryRate" class="text-white font-bold">৳০</span>/শব্দ
                    </div>
                    <div class="text-[11px] text-slate-400" id="summaryNote">নূন্যতম ২০ শব্দের মূল্য প্রযোজ্য</div>
                </div>
                <div class="text-center sm:text-right">
                    <div class="text-xs text-slate-400 uppercase tracking-wider">মোট প্রদেয় মূল্য</div>
                    <div class="text-3xl font-extrabold text-emerald-400" id="totalPriceDisplay">৳ ০.০০</div>
                </div>
            </div>
        </div>

        <!-- Section 3: Customer Details & Payment -->
        <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-xs border border-slate-200/80 space-y-6">
            <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2 pb-3 border-b border-slate-100">
                <span class="w-7 h-7 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs font-extrabold">৩</span>
                গ্রাহকের তথ্য ও পেমেন্ট বিবরণ
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        আপনার নাম <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="customer_name" value="{{ old('customer_name', auth()->user()?->name) }}" placeholder="সম্পূর্ণ নাম লিখুন" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-emerald-500 focus:bg-white focus:outline-hidden" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        মোবাইল নম্বর <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="customer_phone" value="{{ old('customer_phone', auth()->user()?->phone) }}" placeholder="017xxxxxxxx" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-emerald-500 focus:bg-white focus:outline-hidden" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        ইমেইল এড্রেস <span class="text-rose-500">*</span>
                    </label>
                    <input type="email" name="customer_email" value="{{ old('customer_email', auth()->user()?->email) }}" placeholder="name@example.com" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-emerald-500 focus:bg-white focus:outline-hidden" required>
                </div>
            </div>

            <!-- Payment Options -->
            <div class="space-y-4 pt-4 border-t border-slate-100">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                    পেমেন্ট মেথড নির্বাচন করুন <span class="text-rose-500">*</span>
                </label>
                <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
                    <label class="flex flex-col items-center justify-center p-3 rounded-xl border border-slate-200 cursor-pointer hover:border-emerald-500 has-checked:border-emerald-600 has-checked:bg-emerald-50/50 transition-all text-center">
                        <input type="radio" name="payment_method" value="bkash" class="sr-only" checked onchange="updatePaymentInstructions()">
                        <span class="font-extrabold text-sm text-pink-600">বিকাশ (bKash)</span>
                        <span class="text-[10px] text-slate-400 mt-0.5">মার্চেন্ট পেমেন্ট</span>
                    </label>
                    <label class="flex flex-col items-center justify-center p-3 rounded-xl border border-slate-200 cursor-pointer hover:border-emerald-500 has-checked:border-emerald-600 has-checked:bg-emerald-50/50 transition-all text-center">
                        <input type="radio" name="payment_method" value="nagad" class="sr-only" onchange="updatePaymentInstructions()">
                        <span class="font-extrabold text-sm text-orange-600">নগদ (Nagad)</span>
                        <span class="text-[10px] text-slate-400 mt-0.5">মার্চেন্ট / সেন্ড মানি</span>
                    </label>
                    <label class="flex flex-col items-center justify-center p-3 rounded-xl border border-slate-200 cursor-pointer hover:border-emerald-500 has-checked:border-emerald-600 has-checked:bg-emerald-50/50 transition-all text-center">
                        <input type="radio" name="payment_method" value="rocket" class="sr-only" onchange="updatePaymentInstructions()">
                        <span class="font-extrabold text-sm text-purple-600">রকেট (Rocket)</span>
                        <span class="text-[10px] text-slate-400 mt-0.5">ডিবিবিএল ওয়ালেট</span>
                    </label>
                    <label class="flex flex-col items-center justify-center p-3 rounded-xl border border-slate-200 cursor-pointer hover:border-emerald-500 has-checked:border-emerald-600 has-checked:bg-emerald-50/50 transition-all text-center">
                        <input type="radio" name="payment_method" value="bank" class="sr-only" onchange="updatePaymentInstructions()">
                        <span class="font-extrabold text-sm text-sky-700">ব্যাংক ট্রান্সফার</span>
                        <span class="text-[10px] text-slate-400 mt-0.5">সরাসরি একাউন্ট</span>
                    </label>
                    <label class="flex flex-col items-center justify-center p-3 rounded-xl border border-slate-200 cursor-pointer hover:border-emerald-500 has-checked:border-emerald-600 has-checked:bg-emerald-50/50 transition-all text-center col-span-2 sm:col-span-1">
                        <input type="radio" name="payment_method" value="cash_pickup" class="sr-only" onchange="updatePaymentInstructions()">
                        <span class="font-extrabold text-sm text-slate-800">ক্যাশ অন পিকআপ</span>
                        <span class="text-[10px] text-slate-400 mt-0.5">ঢাকা মেট্রো</span>
                    </label>
                </div>

                <!-- Payment Instruction Box -->
                <div id="paymentInstructions" class="p-4 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-700 space-y-2">
                    <!-- Updated via JS -->
                </div>

                <!-- Trx ID & Phone Inputs -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" id="trxFields">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            ট্রানজেকশন আইডি (Trx ID)
                        </label>
                        <input type="text" name="payment_trx_id" value="{{ old('payment_trx_id') }}" placeholder="যেমন: BK928371923" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-emerald-500 focus:bg-white focus:outline-hidden">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            যে নম্বর থেকে টাকা পাঠিয়েছেন
                        </label>
                        <input type="text" name="payment_sender_phone" value="{{ old('payment_sender_phone') }}" placeholder="01xxxxxxxxx" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-emerald-500 focus:bg-white focus:outline-hidden">
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="text-center pt-2">
            <button type="submit" class="w-full sm:w-auto px-10 py-4 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-extrabold text-base shadow-xl hover:shadow-2xl transition-all inline-flex items-center justify-center gap-2">
                <i class="fa-solid fa-paper-plane"></i> বিজ্ঞাপন জমা দিন ও কনফার্মেশন নিন
            </button>
            <p class="text-xs text-slate-400 mt-3">বিজ্ঞাপন জমা দেওয়ার সাথে সাথেই একটি ট্র্যাকিং নম্বর ও ইনভয়েস জেনারেট হবে।</p>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    function calculatePrice() {
        const newspaperSelect = document.getElementById('newspaper_id');
        const selectedOption = newspaperSelect.options[newspaperSelect.selectedIndex];
        const ratePerWord = parseFloat(selectedOption.getAttribute('data-rate')) || 15;
        const minWords = parseInt(selectedOption.getAttribute('data-min')) || 20;

        const text = document.getElementById('ad_body').value.trim();
        let wordCount = 0;
        if (text.length > 0) {
            wordCount = text.split(/\s+/).filter(w => w.length > 0).length;
        }

        const effectiveWords = Math.max(wordCount, minWords);
        const totalPrice = (effectiveWords * ratePerWord).toFixed(2);

        document.getElementById('wordCountBadge').innerHTML = `শব্দ সংখ্যা: <strong class="text-emerald-600">${wordCount}</strong>`;
        document.getElementById('summaryWords').innerText = wordCount > 0 ? wordCount : minWords;
        document.getElementById('summaryRate').innerText = `৳${ratePerWord.toFixed(0)}`;
        document.getElementById('totalPriceDisplay').innerText = `৳ ${Number(totalPrice).toLocaleString('en-US', {minimumFractionDigits: 2})}`;

        if (wordCount < minWords) {
            document.getElementById('summaryNote').innerText = `নূন্যতম ${minWords} শব্দের বিলিং প্রযোজ্য (বর্তমান শব্দ: ${wordCount})`;
        } else {
            document.getElementById('summaryNote').innerText = `${wordCount} শব্দের মোট রেট হিসাব করা হয়েছে`;
        }
    }

    function onCategoryChange() {
        const catSelect = document.getElementById('ad_category_id');
        const opt = catSelect.options[catSelect.selectedIndex];
        const sampleText = opt.getAttribute('data-sample');

        if (sampleText && sampleText.trim().length > 0) {
            document.getElementById('sampleBox').classList.remove('hidden');
            document.getElementById('sampleTextContent').innerText = sampleText;
        } else {
            document.getElementById('sampleBox').classList.add('hidden');
        }
    }

    function useSampleText() {
        const sample = document.getElementById('sampleTextContent').innerText;
        document.getElementById('ad_body').value = sample;
        calculatePrice();
    }

    function updatePaymentInstructions() {
        const checkedRadio = document.querySelector('input[name="payment_method"]:checked');
        if (!checkedRadio) return;
        const method = checkedRadio.value;
        const instBox = document.getElementById('paymentInstructions');
        const trxFields = document.getElementById('trxFields');

        // Update active class on labels
        document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
            const label = radio.closest('label');
            if (radio.checked) {
                label.classList.add('border-emerald-600', 'bg-emerald-50/70', 'ring-2', 'ring-emerald-500/20');
                label.classList.remove('border-slate-200');
            } else {
                label.classList.remove('border-emerald-600', 'bg-emerald-50/70', 'ring-2', 'ring-emerald-500/20');
                label.classList.add('border-slate-200');
            }
        });

        const bkashNum = {{ json_encode($siteSettings['bkash_merchant_number'] ?? '01779-870454') }};
        const nagadNum = {{ json_encode($siteSettings['nagad_merchant_number'] ?? '01854-820303') }};
        const rocketNum = {{ json_encode($siteSettings['rocket_number'] ?? '01779-870454-8') }};
        const bankInfo = {{ json_encode($siteSettings['bank_info'] ?? 'Dutch Bangla Bank Ltd, Account Name: Ads Bazar BD Ltd, Acc: 123.120.98765, Branch: Dhanmondi Branch') }};
        const cashNotice = {{ json_encode($siteSettings['cash_pickup_notice'] ?? 'শুধুমাত্র ঢাকা মেট্রোর জন্য প্রযোজ্য। আমাদের প্রতিনিধি আপনার ঠিকানায় গিয়ে বিজ্ঞাপনের কপি ও নগদ টাকা সংগ্রহ করবে।') }};

        if (method === 'bkash') {
            trxFields.classList.remove('hidden');
            instBox.innerHTML = `<strong>বিকাশ পেমেন্ট নিয়ম:</strong> আমাদের বিকাশ মার্চেন্ট নম্বর <strong>${bkashNum}</strong> এ পেমেন্ট করুন অথবা পার্সোনাল একাউন্টে সেন্ড মানি করুন। এরপর প্রাপ্ত ট্রানজেকশন আইডি (TrxID) নিচে ইনপুট দিন।`;
        } else if (method === 'nagad') {
            trxFields.classList.remove('hidden');
            instBox.innerHTML = `<strong>নগদ পেমেন্ট নিয়ম:</strong> আমাদের নগদ নম্বর <strong>${nagadNum}</strong> এ ক্যাশ আউট বা সেন্ড মানি করুন এবং TrxID নিচে লিখুন।`;
        } else if (method === 'rocket') {
            trxFields.classList.remove('hidden');
            instBox.innerHTML = `<strong>রকেট পেমেন্ট নিয়ম:</strong> রকেট ওয়ালেট <strong>${rocketNum}</strong> এ পেমেন্ট সম্পন্ন করে ট্রানজেকশন কোড লিখুন।`;
        } else if (method === 'bank') {
            trxFields.classList.remove('hidden');
            instBox.innerHTML = `<strong>ব্যাংক ট্রান্সফার:</strong> ${bankInfo}. ডিপোজিট স্লিপের রেফারেন্স বা ট্রানজেকশন নম্বর দিন।`;
        } else {
            trxFields.classList.add('hidden');
            instBox.innerHTML = `<strong>ক্যাশ অন পিকআপ:</strong> ${cashNotice}`;
        }
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function () {
        onCategoryChange();
        calculatePrice();
        updatePaymentInstructions();
    });
</script>
@endpush
