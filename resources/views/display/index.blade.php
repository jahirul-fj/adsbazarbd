@extends('layouts.app')

@section('title', 'ডিসপ্লে বিজ্ঞাপন দিন - Ads Bazar BD')

@section('content')
<div class="bg-slate-900 text-white py-12 px-4 sm:px-6 lg:px-8 border-b border-slate-800">
    <div class="max-w-4xl mx-auto text-center space-y-3">
        <span class="px-3 py-1 bg-teal-500/20 text-teal-300 rounded-full text-xs font-semibold uppercase tracking-wider">বক্স ও ব্যানার বিজ্ঞাপন</span>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">ডিসপ্লে বিজ্ঞাপন (Display Ads) বুকিং</h1>
        <p class="text-slate-400 text-sm max-w-xl mx-auto">
            কলাম-ইঞ্চি হিসাব করে সংবাদপত্রের যেকোনো পাতায় আকর্ষণীয় রঙিন বা সাদা-কালো বিজ্ঞাপন প্রকাশ করুন। লাইভ ক্যালকুলেটরে তাৎক্ষণিক খরচ জানুন।
        </p>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <form action="{{ route('display.store') }}" method="POST" enctype="multipart/form-data" id="displayForm" class="space-y-8">
        @csrf

        <!-- Section 1: Newspaper & Placement -->
        <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-xs border border-slate-200/80 space-y-6">
            <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2 pb-3 border-b border-slate-100">
                <span class="w-7 h-7 rounded-full bg-teal-100 text-teal-700 flex items-center justify-center text-xs font-extrabold">১</span>
                সংবাদপত্র ও পৃষ্ঠার অবস্থান নির্বাচন
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Newspaper Select -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        সংবাদপত্র সিলেক্ট করুন <span class="text-rose-500">*</span>
                    </label>
                    <select name="newspaper_id" id="newspaper_id" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-teal-500 focus:bg-white focus:outline-hidden transition-all" required onchange="calculateDisplayPrice()">
                        @foreach($newspapers as $np)
                            <option value="{{ $np->id }}" 
                                    data-rates="{{ json_encode($np->display_rates ?? []) }}"
                                    data-base="{{ $np->display_rate_col_inch }}" 
                                    data-front="{{ $np->front_page_multiplier }}"
                                    data-back="{{ $np->back_page_multiplier }}"
                                    data-inner="{{ $np->inner_page_multiplier }}"
                                    data-color="{{ $np->color_charge_percent }}"
                                    {{ (old('newspaper_id', request('newspaper_id')) == $np->id || request('newspaper') == $np->slug) ? 'selected' : '' }}>
                                {{ $np->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Page Position -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        পৃষ্ঠার অবস্থান (Page Position) <span class="text-rose-500">*</span>
                    </label>
                    <select name="page_position" id="page_position" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-teal-500 focus:bg-white focus:outline-hidden transition-all" required onchange="calculateDisplayPrice()">
                        <option value="inner" selected>ভেতরের সাধারণ পাতা (Inner Page)</option>
                        <option value="fp">১ম পাতা (Front Page - FP Color)</option>
                        <option value="bp">শেষ পাতা (Back Page - BP Color)</option>
                        <option value="before_bp">শেষ পাতার আগের পাতা (Before Back Page)</option>
                        <option value="page_2">২য় পৃষ্ঠা (Page-2)</option>
                        <option value="page_3">৩য় পৃষ্ঠা (Page-3)</option>
                        <option value="page_5">৫ম পৃষ্ঠা (Page-5)</option>
                        <option value="sports">খেলাধুলার পৃষ্ঠা (Sports Page)</option>
                    </select>
                </div>

                <!-- Color Type -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        রং নির্বাচন (Color Type) <span class="text-rose-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="flex items-center gap-2 p-3 rounded-xl border border-slate-200 cursor-pointer has-checked:border-teal-500 has-checked:bg-teal-50/40 text-xs font-bold">
                            <input type="radio" name="color_type" value="color" checked onchange="calculateDisplayPrice()">
                            <span>রঙিন (Multi-Color)</span>
                        </label>
                        <label class="flex items-center gap-2 p-3 rounded-xl border border-slate-200 cursor-pointer has-checked:border-teal-500 has-checked:bg-teal-50/40 text-xs font-bold">
                            <input type="radio" name="color_type" value="black_white" onchange="calculateDisplayPrice()">
                            <span>সাদা-কালো (Black & White)</span>
                        </label>
                    </div>
                </div>

                <!-- Publication Date -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        প্রকাশের কাঙ্ক্ষিত তারিখ <span class="text-rose-500">*</span>
                    </label>
                    <input type="date" name="publish_date" id="publish_date" min="{{ date('Y-m-d') }}" value="{{ old('publish_date', date('Y-m-d', strtotime('+2 days'))) }}" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-teal-500 focus:bg-white focus:outline-hidden" required>
                </div>
            </div>
        </div>

        <!-- Section 2: Dimensions & Visual Live Size -->
        <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-xs border border-slate-200/80 space-y-6">
            <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2 pb-3 border-b border-slate-100">
                <span class="w-7 h-7 rounded-full bg-teal-100 text-teal-700 flex items-center justify-center text-xs font-extrabold">২</span>
                বিজ্ঞাপনের আকার (কলাম × ইঞ্চি) নির্ধারণ
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                <div class="space-y-4">
                    <!-- Columns Input -->
                    <div>
                        <div class="flex justify-between items-center mb-1.5">
                            <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">কলাম সংখ্যা (Columns)</label>
                            <span class="text-xs font-extrabold text-teal-600" id="colValDisplay">২ কলাম</span>
                        </div>
                        <input type="range" name="columns" id="columns" min="1" max="8" value="2" class="w-full accent-teal-600" oninput="calculateDisplayPrice()">
                        <div class="flex justify-between text-[10px] text-slate-400 mt-1">
                            <span>১ কলাম (1.5")</span>
                            <span>২</span>
                            <span>৪ (হাফ)</span>
                            <span>৮ কলাম (ফুল উইডথ)</span>
                        </div>
                    </div>

                    <!-- Height in Inches -->
                    <div>
                        <div class="flex justify-between items-center mb-1.5">
                            <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">উচ্চতা / ইঞ্চি (Height)</label>
                            <span class="text-xs font-extrabold text-teal-600" id="heightValDisplay">৪ ইঞ্চি</span>
                        </div>
                        <input type="range" name="height_inches" id="height_inches" min="1" max="21" step="0.5" value="4" class="w-full accent-teal-600" oninput="calculateDisplayPrice()">
                        <div class="flex justify-between text-[10px] text-slate-400 mt-1">
                            <span>১ ইঞ্চি</span>
                            <span>৫"</span>
                            <span>১০" (হাফ পেজ)</span>
                            <span>২১" (ফুল পেজ)</span>
                        </div>
                    </div>

                    <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl text-xs space-y-1 text-slate-600">
                        <div>মোট কলাম ইঞ্চি: <strong id="totalColInchesText" class="text-slate-900 font-extrabold text-sm">৮ কলাম ইঞ্চি</strong></div>
                        <div class="text-[11px] text-slate-500">হিসাব: কলাম সংখ্যা × উচ্চতা (ইঞ্চি) = মোট কলাম ইঞ্চি</div>
                    </div>
                </div>

                <!-- Visual Dimension Diagram -->
                <div class="bg-slate-100 border-2 border-dashed border-slate-300 rounded-2xl p-6 flex flex-col items-center justify-center text-center min-h-[220px]">
                    <div class="text-[11px] text-slate-400 mb-2 uppercase tracking-wider font-semibold">সংবাদপত্রের পাতার আনুমানিক সাইজ স্কেলিং</div>
                    <div id="visualBox" class="bg-gradient-to-tr from-teal-500 to-emerald-400 text-white rounded-lg shadow-lg flex items-center justify-center font-bold text-xs p-2 transition-all duration-200 min-w-[120px] min-h-[60px]">
                        <span id="visualBoxText">২ কলাম × ৪ ইঞ্চি</span>
                    </div>
                    <div class="text-[11px] text-slate-500 mt-3" id="visualDimensionHint">
                        প্রস্থ: প্রায় ৩.০ ইঞ্চি | উচ্চতা: ৪.০ ইঞ্চি
                    </div>
                </div>
            </div>

            <!-- Ad Title & Artwork Upload -->
            <div class="space-y-4 pt-4 border-t border-slate-100">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        বিজ্ঞাপনের নাম / শিরোনাম <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="title" value="{{ old('title') }}" placeholder="যেমন: নতুন পণ্য উদ্বোধন / জব রিক্রুটমেন্ট ব্যানার" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-teal-500 focus:bg-white focus:outline-hidden" required>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        রেডিমেড আর্টওয়ার্ক ফাইল আপলোড (PDF, JPG, PNG, EPS, AI)
                    </label>
                    <input type="file" name="artwork_file" accept=".pdf,.jpg,.jpeg,.png,.eps,.ai,.psd" class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
                    <p class="text-[11px] text-slate-400 mt-1">হাই রেজ্যুলেশন প্রিন্ট কোয়ালিটি (300 DPI) ফাইল প্রদান করুন।</p>
                </div>

                <!-- Need Designer Checkbox -->
                <div class="p-4 bg-indigo-50/70 border border-indigo-200 rounded-xl flex items-start gap-3">
                    <input type="checkbox" name="needs_designer" id="needs_designer" value="1" class="mt-1 w-4 h-4 text-indigo-600 rounded-md border-slate-300 focus:ring-indigo-500">
                    <div>
                        <label for="needs_designer" class="font-bold text-xs text-indigo-900 cursor-pointer">
                            আমার কোনো প্রস্তুত করা ডিজাইন নেই, প্রচারকের ডিজাইনার হায়ার করতে চাই
                        </label>
                        <p class="text-[11px] text-indigo-700 mt-0.5">
                            টিক দিলে বিজ্ঞাপন বুকিংয়ের পর আমাদের অভিজ্ঞ ডিজাইনার টিম আপনার পছন্দ অনুযায়ী ডিজাইন তৈরি করে দিবে।
                        </p>
                    </div>
                </div>
            </div>

            <!-- Total Price Calculation Bar -->
            <div class="bg-gradient-to-br from-slate-900 to-slate-800 text-white rounded-2xl p-6 shadow-md flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="space-y-1 text-center sm:text-left">
                    <div class="text-xs text-slate-400 uppercase tracking-wider">ডিসপ্লে বিজ্ঞাপনের মূল্য হিসাব</div>
                    <div class="text-sm font-medium text-slate-300">
                        কলাম ইঞ্চি: <span id="summaryColInches" class="text-white font-bold">৮</span> | কার্যকর রেট: <span id="summaryAppliedRate" class="text-white font-bold">৳০</span>/কলাম-ইঞ্চি
                    </div>
                </div>
                <div class="text-center sm:text-right">
                    <div class="text-xs text-slate-400 uppercase tracking-wider">সর্বমোট প্রদেয় মূল্য</div>
                    <div class="text-3xl font-extrabold text-teal-400" id="displayTotalPrice">৳ ০.০০</div>
                </div>
            </div>
        </div>

        <!-- Section 3: Customer Details & Payment -->
        <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-xs border border-slate-200/80 space-y-6">
            <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2 pb-3 border-b border-slate-100">
                <span class="w-7 h-7 rounded-full bg-teal-100 text-teal-700 flex items-center justify-center text-xs font-extrabold">৩</span>
                যোগাযোগের তথ্য ও পেমেন্ট
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">নাম / প্রতিষ্ঠানের নাম <span class="text-rose-500">*</span></label>
                    <input type="text" name="customer_name" value="{{ old('customer_name', auth()->user()?->name) }}" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-teal-500 focus:bg-white focus:outline-hidden" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">মোবাইল নম্বর <span class="text-rose-500">*</span></label>
                    <input type="text" name="customer_phone" value="{{ old('customer_phone', auth()->user()?->phone) }}" placeholder="01xxxxxxxxx" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-teal-500 focus:bg-white focus:outline-hidden" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">ইমেইল <span class="text-rose-500">*</span></label>
                    <input type="email" name="customer_email" value="{{ old('customer_email', auth()->user()?->email) }}" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-teal-500 focus:bg-white focus:outline-hidden" required>
                </div>
            </div>

            <div class="space-y-4 pt-4 border-t border-slate-100">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">পেমেন্ট মেথড <span class="text-rose-500">*</span></label>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <label class="flex flex-col items-center justify-center p-3 rounded-xl border border-slate-200 cursor-pointer hover:border-teal-500 has-checked:border-teal-600 has-checked:bg-teal-50/50 transition-all text-center">
                        <input type="radio" name="payment_method" value="bank" class="sr-only" checked>
                        <span class="font-extrabold text-sm text-sky-800">ব্যাংক ট্রান্সফার</span>
                        <span class="text-[10px] text-slate-400 mt-0.5">কর্পোরেট একাউন্ট</span>
                    </label>
                    <label class="flex flex-col items-center justify-center p-3 rounded-xl border border-slate-200 cursor-pointer hover:border-teal-500 has-checked:border-teal-600 has-checked:bg-teal-50/50 transition-all text-center">
                        <input type="radio" name="payment_method" value="bkash" class="sr-only">
                        <span class="font-extrabold text-sm text-pink-600">বিকাশ (bKash)</span>
                        <span class="text-[10px] text-slate-400 mt-0.5">মার্চেন্ট পে</span>
                    </label>
                    <label class="flex flex-col items-center justify-center p-3 rounded-xl border border-slate-200 cursor-pointer hover:border-teal-500 has-checked:border-teal-600 has-checked:bg-teal-50/50 transition-all text-center">
                        <input type="radio" name="payment_method" value="nagad" class="sr-only">
                        <span class="font-extrabold text-sm text-orange-600">নগদ (Nagad)</span>
                        <span class="text-[10px] text-slate-400 mt-0.5">মার্চেন্ট পে</span>
                    </label>
                    <label class="flex flex-col items-center justify-center p-3 rounded-xl border border-slate-200 cursor-pointer hover:border-teal-500 has-checked:border-teal-600 has-checked:bg-teal-50/50 transition-all text-center">
                        <input type="radio" name="payment_method" value="cash_pickup" class="sr-only">
                        <span class="font-extrabold text-sm text-slate-800">ক্যাশ অন পিকআপ</span>
                        <span class="text-[10px] text-slate-400 mt-0.5">ঢাকা মহানগর</span>
                    </label>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">ট্রানজেকশন আইডি / স্লিপ নম্বর</label>
                        <input type="text" name="payment_trx_id" placeholder="ব্যাংক রেফারেন্স বা TrxID" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-teal-500 focus:bg-white focus:outline-hidden">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">প্রেরক ফোন নম্বর</label>
                        <input type="text" name="payment_sender_phone" placeholder="01xxxxxxxxx" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-teal-500 focus:bg-white focus:outline-hidden">
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center pt-2">
            <button type="submit" class="w-full sm:w-auto px-10 py-4 rounded-2xl bg-gradient-to-r from-teal-600 to-emerald-600 hover:from-teal-700 hover:to-emerald-700 text-white font-extrabold text-base shadow-xl hover:shadow-2xl transition-all inline-flex items-center justify-center gap-2">
                <i class="fa-solid fa-paper-plane"></i> ডিসপ্লে বিজ্ঞাপন সাবমিট করুন
            </button>
            <p class="text-xs text-slate-400 mt-3">ফর্ম সাবমিট করলে আমাদের কাস্টমার সার্ভিস থেকে যোগাযোগ করে কনফার্ম করা হবে।</p>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    function calculateDisplayPrice() {
        const npSelect = document.getElementById('newspaper_id');
        const opt = npSelect.options[npSelect.selectedIndex];
        let rates = {};
        try {
            rates = JSON.parse(opt.getAttribute('data-rates') || '{}');
        } catch(e) { rates = {}; }

        const baseRate = parseFloat(opt.getAttribute('data-base')) || 2000;
        const pagePos = document.getElementById('page_position').value;
        const colorRadio = document.querySelector('input[name="color_type"]:checked');
        const colorType = colorRadio ? colorRadio.value : 'color';
        const colorKey = (colorType === 'color') ? 'color' : 'bw';

        const columns = parseInt(document.getElementById('columns').value) || 2;
        const height = parseFloat(document.getElementById('height_inches').value) || 4;

        let appliedRate = 0;
        const targetKey = `${pagePos}_${colorKey}`;

        if (rates && rates[targetKey] && parseFloat(rates[targetKey]) > 0) {
            appliedRate = parseFloat(rates[targetKey]);
        } else if (rates && colorKey === 'bw' && rates[`${pagePos}_color`]) {
            appliedRate = Math.round(parseFloat(rates[`${pagePos}_color`]) * 0.75);
        } else if (rates && colorKey === 'color' && rates[`${pagePos}_bw`]) {
            appliedRate = Math.round(parseFloat(rates[`${pagePos}_bw`]) * 1.35);
        } else if (rates && rates[`inner_${colorKey}`]) {
            appliedRate = parseFloat(rates[`inner_${colorKey}`]);
        } else {
            // fallback
            let mult = 1.0;
            if (pagePos === 'fp' || pagePos === 'front_page') mult = parseFloat(opt.getAttribute('data-front')) || 2.5;
            if (pagePos === 'bp' || pagePos === 'back_page') mult = parseFloat(opt.getAttribute('data-back')) || 1.8;
            appliedRate = baseRate * mult;
            if (colorType === 'color') {
                appliedRate *= 1.35;
            }
        }

        const totalColInches = (columns * height).toFixed(2);
        const totalPrice = (totalColInches * appliedRate).toFixed(2);

        // Update displays
        document.getElementById('colValDisplay').innerText = `${columns} কলাম`;
        document.getElementById('heightValDisplay').innerText = `${height} ইঞ্চি`;
        document.getElementById('totalColInchesText').innerText = `${totalColInches} কলাম ইঞ্চি`;
        document.getElementById('summaryColInches').innerText = totalColInches;
        document.getElementById('summaryAppliedRate').innerText = `৳${Math.round(appliedRate).toLocaleString()}`;
        document.getElementById('displayTotalPrice').innerText = `৳ ${Number(totalPrice).toLocaleString('en-US', {minimumFractionDigits: 2})}`;

        // Visual box scale
        const visualBox = document.getElementById('visualBox');
        visualBox.style.width = `${Math.min(columns * 35 + 80, 260)}px`;
        visualBox.style.height = `${Math.min(height * 7 + 40, 160)}px`;
        document.getElementById('visualBoxText').innerText = `${columns} কলাম × ${height}"`;
        document.getElementById('visualDimensionHint').innerText = `প্রস্থ: প্রায় ${(columns * 1.5).toFixed(1)} ইঞ্চি | উচ্চতা: ${height.toFixed(1)} ইঞ্চি`;
    }

    document.addEventListener('DOMContentLoaded', calculateDisplayPrice);
</script>
@endpush
