@extends('layouts.app')

@section('title', 'পত্রিকার বিজ্ঞাপনের মূল্য তালিকা (Display & Classified Ad Rates) - Ads Bazar BD')

@section('content')
<!-- Hero Header -->
<div class="bg-gradient-to-r from-slate-950 via-slate-900 to-indigo-950 text-white py-12 px-4 sm:px-6 lg:px-8 border-b border-slate-800">
    <div class="max-w-5xl mx-auto text-center space-y-3">
        <span class="px-3 py-1 bg-emerald-500/20 text-emerald-400 rounded-full text-xs font-semibold uppercase tracking-wider border border-emerald-500/30">
            ১০০% স্বচ্ছ অফিশিয়াল রেট কার্ড
        </span>
        <h1 class="text-3xl sm:text-4xl font-black tracking-tight">জাতীয় ও আঞ্চলিক পত্রিকার বিজ্ঞাপনের মূল্য তালিকা</h1>
        <p class="text-slate-300 text-xs sm:text-sm max-w-2xl mx-auto leading-relaxed">
            দেশের শীর্ষ সকল দৈনিক পত্রিকার পৃষ্ঠাভিত্তিক প্রতি কলাম-ইঞ্চির নির্দিষ্ট রেট চার্ট ও শ্রেণীভুক্ত বিজ্ঞাপনের সরকারি অনুমোদিত মূল্য তালিকা।
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-6">
    <!-- Controls: Tabs & Search Filter -->
    <div class="bg-white rounded-3xl p-5 sm:p-6 border border-slate-200 shadow-xs flex flex-col md:flex-row justify-between items-stretch md:items-center gap-4">
        <!-- Tabs -->
        <div class="flex items-center gap-2 p-1 bg-slate-100 rounded-2xl shrink-0">
            <button onclick="switchTab('display')" id="tabBtnDisplay" class="px-4 py-2.5 rounded-xl font-bold text-xs transition-all bg-teal-600 text-white shadow-xs">
                <i class="fa-solid fa-table-cells mr-1.5"></i> ডিসপ্লে বিজ্ঞাপন মূল্য তালিকা
            </button>
            <button onclick="switchTab('classified')" id="tabBtnClassified" class="px-4 py-2.5 rounded-xl font-bold text-xs transition-all text-slate-600 hover:text-slate-900">
                <i class="fa-solid fa-list-check mr-1.5"></i> শ্রেণীভুক্ত বিজ্ঞাপন রেট
            </button>
        </div>

        <!-- Search Bar -->
        <div class="relative flex-1 max-w-md">
            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
            <input type="text" id="newspaperSearch" onkeyup="filterNewspapers()" placeholder="পত্রিকার নাম দিয়ে অনুসন্ধান করুন (যেমন: Prothom Alo, Daily Star)..." class="w-full pl-9 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs font-medium focus:bg-white focus:ring-2 focus:ring-teal-500 focus:outline-hidden">
        </div>
    </div>

    <!-- TAB 1: Display Ads Rate Chart (Comprehensive Image Equivalent Table) -->
    <div id="displayRateSection" class="bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="text-lg font-black text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-newspaper text-teal-600"></i> পত্রিকার বিজ্ঞাপনের মূল্য তালিকা (Display Ad Rates)
                </h2>
                <p class="text-xs text-slate-500 mt-0.5">সবগুলো মূল্য <strong>প্রতি কলাম-ইঞ্চি (টাকা)</strong> হিসেবে প্রযোজ্য। কলামের গড় মাপ ১.৫ ইঞ্চি।</p>
            </div>
            <div class="text-xs text-slate-400">
                মোট ২৪টি জাতীয় ও আঞ্চলিক সংবাদপত্র
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-center text-xs border-collapse" id="displayRatesTable">
                <!-- Grouped Header -->
                <thead class="bg-slate-100 text-slate-800 font-extrabold uppercase text-[11px] border-b border-slate-200">
                    <tr class="divide-x divide-slate-200">
                        <th rowspan="2" class="p-3 text-left min-w-[170px] sticky left-0 bg-slate-100 z-10 shadow-r">Paper Name</th>
                        <th rowspan="2" class="p-3 bg-slate-50 min-w-[90px]">Inner B.W</th>
                        <th rowspan="2" class="p-3 bg-teal-50/60 text-teal-900 min-w-[95px]">Inner Color</th>
                        <th rowspan="2" class="p-3 bg-rose-50 text-rose-800 min-w-[95px]">FP Color</th>
                        <th rowspan="2" class="p-3 bg-purple-50 text-purple-800 min-w-[95px]">BP Color</th>
                        <th colspan="2" class="p-2 bg-slate-50 border-b border-slate-200">Before BP</th>
                        <th colspan="2" class="p-2 bg-slate-100 border-b border-slate-200">Page-2</th>
                        <th colspan="2" class="p-2 bg-slate-50 border-b border-slate-200">Page-3</th>
                        <th colspan="2" class="p-2 bg-slate-100 border-b border-slate-200">Page-5</th>
                        <th colspan="2" class="p-2 bg-slate-50 border-b border-slate-200">Sports Page</th>
                        <th rowspan="2" class="p-3 min-w-[90px]">অ্যাকশন</th>
                    </tr>
                    <tr class="divide-x divide-slate-200 text-[10px] bg-slate-50">
                        <!-- Before BP -->
                        <th class="p-2 min-w-[65px] text-slate-600">BW</th>
                        <th class="p-2 min-w-[70px] text-teal-700">Color</th>
                        <!-- Page-2 -->
                        <th class="p-2 min-w-[65px] text-slate-600">BW</th>
                        <th class="p-2 min-w-[70px] text-teal-700">Color</th>
                        <!-- Page-3 -->
                        <th class="p-2 min-w-[65px] text-slate-600">BW</th>
                        <th class="p-2 min-w-[70px] text-teal-700">Color</th>
                        <!-- Page-5 -->
                        <th class="p-2 min-w-[65px] text-slate-600">BW</th>
                        <th class="p-2 min-w-[70px] text-teal-700">Color</th>
                        <!-- Sports -->
                        <th class="p-2 min-w-[65px] text-slate-600">BW</th>
                        <th class="p-2 min-w-[70px] text-teal-700">Color</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-mono text-[11px]" id="displayTableBody">
                    @foreach($newspapers as $np)
                        @php $r = $np->display_rates ?? []; @endphp
                        <tr class="hover:bg-teal-50/30 transition-colors divide-x divide-slate-100 newspaper-row" data-name="{{ strtolower($np->name) }}">
                            <!-- Paper Name -->
                            <td class="p-3 text-left font-sans font-bold text-slate-900 sticky left-0 bg-white shadow-r">
                                <div>{{ $np->name }}</div>
                                <span class="px-1.5 py-0.2 rounded text-[9px] uppercase font-bold {{ $np->language === 'bangla' ? 'bg-emerald-50 text-emerald-700' : 'bg-blue-50 text-blue-700' }}">
                                    {{ $np->language }}
                                </span>
                            </td>

                            <!-- Inner BW -->
                            <td class="p-2.5 font-bold text-slate-800">
                                {{ isset($r['inner_bw']) && $r['inner_bw'] ? number_format($r['inner_bw']) : '---' }}
                            </td>

                            <!-- Inner Color -->
                            <td class="p-2.5 font-bold text-teal-700 bg-teal-50/20">
                                {{ isset($r['inner_color']) && $r['inner_color'] ? number_format($r['inner_color']) : '---' }}
                            </td>

                            <!-- FP Color -->
                            <td class="p-2.5 font-extrabold text-rose-700 bg-rose-50/20">
                                {{ isset($r['fp_color']) && $r['fp_color'] ? number_format($r['fp_color']) : '---' }}
                            </td>

                            <!-- BP Color -->
                            <td class="p-2.5 font-extrabold text-purple-700 bg-purple-50/20">
                                {{ isset($r['bp_color']) && $r['bp_color'] ? number_format($r['bp_color']) : '---' }}
                            </td>

                            <!-- Before BP (BW | Color) -->
                            <td class="p-2.5 text-slate-700">
                                {{ isset($r['before_bp_bw']) && $r['before_bp_bw'] ? number_format($r['before_bp_bw']) : '' }}
                            </td>
                            <td class="p-2.5 font-bold text-teal-700">
                                {{ isset($r['before_bp_color']) && $r['before_bp_color'] ? number_format($r['before_bp_color']) : '' }}
                            </td>

                            <!-- Page-2 (BW | Color) -->
                            <td class="p-2.5 text-slate-700">
                                {{ isset($r['page_2_bw']) && $r['page_2_bw'] ? number_format($r['page_2_bw']) : '' }}
                            </td>
                            <td class="p-2.5 font-bold text-teal-700">
                                {{ isset($r['page_2_color']) && $r['page_2_color'] ? number_format($r['page_2_color']) : '' }}
                            </td>

                            <!-- Page-3 (BW | Color) -->
                            <td class="p-2.5 text-slate-700">
                                {{ isset($r['page_3_bw']) && $r['page_3_bw'] ? number_format($r['page_3_bw']) : '' }}
                            </td>
                            <td class="p-2.5 font-bold text-teal-700">
                                {{ isset($r['page_3_color']) && $r['page_3_color'] ? number_format($r['page_3_color']) : '' }}
                            </td>

                            <!-- Page-5 (BW | Color) -->
                            <td class="p-2.5 text-slate-700">
                                {{ isset($r['page_5_bw']) && $r['page_5_bw'] ? number_format($r['page_5_bw']) : '' }}
                            </td>
                            <td class="p-2.5 font-bold text-teal-700">
                                {{ isset($r['page_5_color']) && $r['page_5_color'] ? number_format($r['page_5_color']) : '' }}
                            </td>

                            <!-- Sports (BW | Color) -->
                            <td class="p-2.5 text-slate-700">
                                {{ isset($r['sports_bw']) && $r['sports_bw'] ? number_format($r['sports_bw']) : '' }}
                            </td>
                            <td class="p-2.5 font-bold text-teal-700">
                                {{ isset($r['sports_color']) && $r['sports_color'] ? number_format($r['sports_color']) : '' }}
                            </td>

                            <!-- Action -->
                            <td class="p-2.5 font-sans">
                                <a href="{{ route('display.index', ['newspaper_id' => $np->id]) }}" class="px-3 py-1.5 bg-teal-600 hover:bg-teal-700 text-white rounded-lg text-xs font-bold shadow-xs transition-colors whitespace-nowrap">
                                    বুক করুন &rarr;
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- TAB 2: Classified Ads Rate Table (Hidden by default) -->
    <div id="classifiedRateSection" class="hidden bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center">
            <div>
                <h2 class="text-lg font-black text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-list-check text-emerald-600"></i> শ্রেণীভুক্ত বিজ্ঞাপন মূল্য তালিকা (Classified Ad Rates)
                </h2>
                <p class="text-xs text-slate-500 mt-0.5">বাড়ি ভাড়া, পাত্র-পাত্রী, নিয়োগ, হারানো বিজ্ঞপ্তি ইত্যাদির জন্য প্রতি শব্দ রেট।</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm min-w-[700px]">
                <thead class="bg-slate-50 text-slate-700 font-bold border-b border-slate-200 uppercase text-[11px] tracking-wider">
                    <tr>
                        <th class="p-4">সংবাদপত্রের নাম</th>
                        <th class="p-4">ভাষা</th>
                        <th class="p-4 text-center">প্রতি শব্দের রেট</th>
                        <th class="p-4 text-center">নূন্যতম শব্দ</th>
                        <th class="p-4 text-center">২০ শব্দের প্রাথমিক বাজেট</th>
                        <th class="p-4 text-center">বুকিং</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @foreach($newspapers as $np)
                        <tr class="hover:bg-slate-50/70 transition-colors newspaper-row" data-name="{{ strtolower($np->name) }}">
                            <td class="p-4 font-bold text-slate-900">{{ $np->name }}</td>
                            <td class="p-4">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $np->language === 'bangla' ? 'bg-emerald-50 text-emerald-700' : 'bg-blue-50 text-blue-700' }}">
                                    {{ $np->language === 'bangla' ? 'বাংলা' : 'English' }}
                                </span>
                            </td>
                            <td class="p-4 text-center font-bold text-emerald-700">৳{{ number_format($np->classified_rate_per_word, 2) }}</td>
                            <td class="p-4 text-center text-slate-600">{{ $np->min_words ?? 20 }} টি শব্দ</td>
                            <td class="p-4 text-center font-bold text-slate-900">৳{{ number_format(($np->classified_rate_per_word * ($np->min_words ?? 20)), 2) }}</td>
                            <td class="p-4 text-center">
                                <a href="{{ route('classified.index', ['newspaper_id' => $np->id]) }}" class="px-3.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold transition-colors">
                                    বিজ্ঞাপন দিন
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function switchTab(type) {
        const displaySec = document.getElementById('displayRateSection');
        const classSec = document.getElementById('classifiedRateSection');
        const btnDisplay = document.getElementById('tabBtnDisplay');
        const btnClass = document.getElementById('tabBtnClassified');

        if (type === 'display') {
            displaySec.classList.remove('hidden');
            classSec.classList.add('hidden');
            btnDisplay.className = 'px-4 py-2.5 rounded-xl font-bold text-xs transition-all bg-teal-600 text-white shadow-xs';
            btnClass.className = 'px-4 py-2.5 rounded-xl font-bold text-xs transition-all text-slate-600 hover:text-slate-900';
        } else {
            displaySec.classList.add('hidden');
            classSec.classList.remove('hidden');
            btnClass.className = 'px-4 py-2.5 rounded-xl font-bold text-xs transition-all bg-emerald-600 text-white shadow-xs';
            btnDisplay.className = 'px-4 py-2.5 rounded-xl font-bold text-xs transition-all text-slate-600 hover:text-slate-900';
        }
    }

    function filterNewspapers() {
        const query = document.getElementById('newspaperSearch').value.toLowerCase().trim();
        const rows = document.querySelectorAll('.newspaper-row');
        rows.forEach(row => {
            const name = row.getAttribute('data-name') || '';
            if (!query || name.includes(query)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
</script>
@endsection
