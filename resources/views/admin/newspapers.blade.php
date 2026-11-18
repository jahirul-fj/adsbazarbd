@extends('layouts.admin')

@section('title', 'সংবাদপত্র ও রেট ম্যানেজমেন্ট - Admin')
@section('page_title', 'সংবাদপত্র তালিকা ও রেট চার্ট কনফিগারেশন')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-xl font-bold text-slate-900">সংবাদপত্র ও বিজ্ঞাপনের রেট চার্ট</h1>
            <p class="text-xs text-slate-500">প্রতি শব্দের মূল্য এবং পৃষ্ঠাভিত্তিক প্রতি কলাম-ইঞ্চির নির্দিষ্ট রেট কনফিগার করুন</p>
        </div>
        <div class="text-xs font-bold px-3 py-1.5 bg-indigo-50 text-indigo-700 rounded-xl border border-indigo-200">
            মোট সংবাদপত্র: {{ $newspapers->count() }} টি
        </div>
    </div>

    <!-- Add New Newspaper Accordion / Card -->
    <details class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-6 group">
        <summary class="font-bold text-sm text-slate-900 cursor-pointer flex justify-between items-center list-none">
            <span class="flex items-center gap-2 text-indigo-600">
                <i class="fa-solid fa-plus-circle"></i> নতুন সংবাদপত্র যুক্ত করুন
            </span>
            <i class="fa-solid fa-chevron-down text-xs text-slate-400 group-open:rotate-180 transition-transform"></i>
        </summary>
        <form action="{{ route('admin.newspapers.store') }}" method="POST" class="pt-6 mt-4 border-t border-slate-100 space-y-6">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">সংবাদপত্রের নাম <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" placeholder="যেমন: দৈনিক নয়া দিগন্ত" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 text-xs font-medium text-slate-900 focus:bg-white focus:ring-2 focus:ring-indigo-500" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">ভাষা <span class="text-rose-500">*</span></label>
                    <select name="language" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 text-xs font-medium text-slate-800 focus:bg-white">
                        <option value="bangla">বাংলা (Bangla)</option>
                        <option value="english">ইংরেজি (English)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">শ্রেণীভুক্ত রেট (প্রতি শব্দ ৳) <span class="text-rose-500">*</span></label>
                    <input type="number" step="0.5" name="classified_rate_per_word" value="15" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 text-xs font-bold text-emerald-700 focus:bg-white" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">নূন্যতম শব্দ সংখ্যা <span class="text-rose-500">*</span></label>
                    <input type="number" name="min_words" value="20" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 text-xs font-medium text-slate-900 focus:bg-white" required>
                </div>
            </div>

            <!-- Display Rates Sub-grid -->
            <div class="p-4 bg-slate-50/70 rounded-2xl border border-slate-200 space-y-3">
                <div class="text-xs font-bold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-table-cells text-indigo-600"></i> ডিসপ্লে বিজ্ঞাপনের পৃষ্ঠাভিত্তিক রেট চার্ট (টাকা / কলাম-ইঞ্চি)
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-7 gap-3 text-xs">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Inner B.W</label>
                        <input type="number" name="display_rates[inner_bw]" placeholder="e.g. 4000" class="w-full bg-white border border-slate-300 rounded-lg px-2.5 py-1.5 text-xs font-bold text-slate-900 focus:ring-1 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Inner Color</label>
                        <input type="number" name="display_rates[inner_color]" placeholder="e.g. 5000" class="w-full bg-white border border-slate-300 rounded-lg px-2.5 py-1.5 text-xs font-bold text-teal-700 focus:ring-1 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-rose-700 mb-1">FP Color (১ম পাতা)</label>
                        <input type="number" name="display_rates[fp_color]" placeholder="e.g. 16000" class="w-full bg-white border border-slate-300 rounded-lg px-2.5 py-1.5 text-xs font-bold text-rose-700 focus:ring-1 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-purple-700 mb-1">BP Color (শেষ পাতা)</label>
                        <input type="number" name="display_rates[bp_color]" placeholder="e.g. 14000" class="w-full bg-white border border-slate-300 rounded-lg px-2.5 py-1.5 text-xs font-bold text-purple-700 focus:ring-1 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Before BP (BW)</label>
                        <input type="number" name="display_rates[before_bp_bw]" placeholder="---" class="w-full bg-white border border-slate-300 rounded-lg px-2.5 py-1.5 text-xs font-bold text-slate-900">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-teal-700 mb-1">Before BP (Color)</label>
                        <input type="number" name="display_rates[before_bp_color]" placeholder="---" class="w-full bg-white border border-slate-300 rounded-lg px-2.5 py-1.5 text-xs font-bold text-teal-700">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Page-2 (BW)</label>
                        <input type="number" name="display_rates[page_2_bw]" placeholder="---" class="w-full bg-white border border-slate-300 rounded-lg px-2.5 py-1.5 text-xs font-bold text-slate-900">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-teal-700 mb-1">Page-2 (Color)</label>
                        <input type="number" name="display_rates[page_2_color]" placeholder="---" class="w-full bg-white border border-slate-300 rounded-lg px-2.5 py-1.5 text-xs font-bold text-teal-700">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Page-3 (BW)</label>
                        <input type="number" name="display_rates[page_3_bw]" placeholder="---" class="w-full bg-white border border-slate-300 rounded-lg px-2.5 py-1.5 text-xs font-bold text-slate-900">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-teal-700 mb-1">Page-3 (Color)</label>
                        <input type="number" name="display_rates[page_3_color]" placeholder="---" class="w-full bg-white border border-slate-300 rounded-lg px-2.5 py-1.5 text-xs font-bold text-teal-700">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Page-5 (BW)</label>
                        <input type="number" name="display_rates[page_5_bw]" placeholder="---" class="w-full bg-white border border-slate-300 rounded-lg px-2.5 py-1.5 text-xs font-bold text-slate-900">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-teal-700 mb-1">Page-5 (Color)</label>
                        <input type="number" name="display_rates[page_5_color]" placeholder="---" class="w-full bg-white border border-slate-300 rounded-lg px-2.5 py-1.5 text-xs font-bold text-teal-700">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Sports (BW)</label>
                        <input type="number" name="display_rates[sports_bw]" placeholder="---" class="w-full bg-white border border-slate-300 rounded-lg px-2.5 py-1.5 text-xs font-bold text-slate-900">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-teal-700 mb-1">Sports (Color)</label>
                        <input type="number" name="display_rates[sports_color]" placeholder="---" class="w-full bg-white border border-slate-300 rounded-lg px-2.5 py-1.5 text-xs font-bold text-teal-700">
                    </div>
                </div>
            </div>

            <div class="text-right">
                <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl shadow-md transition-all inline-flex items-center gap-1.5">
                    <i class="fa-solid fa-floppy-disk"></i> নতুন সংবাদপত্র সেভ করুন
                </button>
            </div>
        </form>
    </details>

    <!-- Existing Newspapers List -->
    <div class="space-y-6">
        @foreach($newspapers as $np)
            <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-xs space-y-5">
                <form action="{{ route('admin.newspapers.update', $np->id) }}" method="POST" class="space-y-5">
                    @csrf
                    <!-- Card Header -->
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 pb-3 border-b border-slate-100">
                        <div class="flex items-center gap-3">
                            <h3 class="font-extrabold text-base text-slate-900">{{ $np->name }}</h3>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $np->language === 'bangla' ? 'bg-emerald-100 text-emerald-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ $np->language === 'bangla' ? 'বাংলা' : 'English' }}
                            </span>
                        </div>
                        <label class="flex items-center gap-2 text-xs font-bold cursor-pointer text-slate-700">
                            <input type="checkbox" name="is_active" value="1" {{ $np->is_active ? 'checked' : '' }} class="w-4 h-4 text-emerald-600 rounded-sm border-slate-300">
                            <span>সক্রিয় (Active)</span>
                        </label>
                    </div>

                    <!-- Row 1: General & Classified -->
                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 text-xs">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 mb-1">সংবাদপত্রের নাম</label>
                            <input type="text" name="name" value="{{ $np->name }}" class="w-full bg-slate-50 border border-slate-300 text-slate-900 rounded-xl px-3 py-2 font-bold focus:bg-white" required>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 mb-1">শ্রেণীভুক্ত রেট (টাকা/শব্দ)</label>
                            <input type="number" step="0.5" name="classified_rate_per_word" value="{{ $np->classified_rate_per_word }}" class="w-full bg-slate-50 border border-slate-300 text-emerald-700 rounded-xl px-3 py-2 font-bold focus:bg-white" required>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 mb-1">নূন্যতম শব্দ</label>
                            <input type="number" name="min_words" value="{{ $np->min_words ?? 20 }}" class="w-full bg-slate-50 border border-slate-300 text-slate-800 rounded-xl px-3 py-2 font-bold focus:bg-white">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 mb-1">অ্যাকশন</label>
                            <button type="submit" class="w-full py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl shadow-xs transition-colors flex items-center justify-center gap-1.5">
                                <i class="fa-solid fa-check"></i> পরিবর্তন সেভ করুন
                            </button>
                        </div>
                    </div>

                    <!-- Row 2: Comprehensive Display Rate Chart Fields -->
                    @php
                        $rates = $np->display_rates ?? [];
                    @endphp
                    <div class="p-4 bg-slate-50/80 rounded-2xl border border-slate-200/90 space-y-2.5">
                        <div class="flex justify-between items-center">
                            <span class="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                                <i class="fa-solid fa-newspaper text-teal-600"></i> ডিসপ্লে বিজ্ঞাপনের পূর্ণাঙ্গ রেট তালিকা (প্রতি কলাম-ইঞ্চি ৳):
                            </span>
                            <span class="text-[10px] text-slate-500 font-medium">চার্ট অনুযায়ী খালি রাখতে চাইলে ফাঁকা রাখুন</span>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-7 gap-2.5 text-xs">
                            <!-- Inner BW -->
                            <div class="bg-white p-2 rounded-xl border border-slate-200 shadow-2xs">
                                <label class="block text-[10px] font-bold text-slate-500 mb-1">Inner B.W</label>
                                <input type="number" name="display_rates[inner_bw]" value="{{ $rates['inner_bw'] ?? '' }}" placeholder="---" class="w-full text-xs font-bold text-slate-900 border-0 p-0 focus:ring-0 bg-transparent">
                            </div>

                            <!-- Inner Color -->
                            <div class="bg-white p-2 rounded-xl border border-teal-200 shadow-2xs">
                                <label class="block text-[10px] font-bold text-teal-700 mb-1">Inner Color</label>
                                <input type="number" name="display_rates[inner_color]" value="{{ $rates['inner_color'] ?? '' }}" placeholder="---" class="w-full text-xs font-bold text-teal-700 border-0 p-0 focus:ring-0 bg-transparent">
                            </div>

                            <!-- FP Color -->
                            <div class="bg-white p-2 rounded-xl border border-rose-200 shadow-2xs">
                                <label class="block text-[10px] font-bold text-rose-700 mb-1">FP Color (১ম পাতা)</label>
                                <input type="number" name="display_rates[fp_color]" value="{{ $rates['fp_color'] ?? '' }}" placeholder="---" class="w-full text-xs font-bold text-rose-700 border-0 p-0 focus:ring-0 bg-transparent">
                            </div>

                            <!-- BP Color -->
                            <div class="bg-white p-2 rounded-xl border border-purple-200 shadow-2xs">
                                <label class="block text-[10px] font-bold text-purple-700 mb-1">BP Color (শেষ পাতা)</label>
                                <input type="number" name="display_rates[bp_color]" value="{{ $rates['bp_color'] ?? '' }}" placeholder="---" class="w-full text-xs font-bold text-purple-700 border-0 p-0 focus:ring-0 bg-transparent">
                            </div>

                            <!-- Before BP BW -->
                            <div class="bg-white p-2 rounded-xl border border-slate-200 shadow-2xs">
                                <label class="block text-[10px] font-bold text-slate-500 mb-1">Before BP (BW)</label>
                                <input type="number" name="display_rates[before_bp_bw]" value="{{ $rates['before_bp_bw'] ?? '' }}" placeholder="---" class="w-full text-xs font-bold text-slate-900 border-0 p-0 focus:ring-0 bg-transparent">
                            </div>

                            <!-- Before BP Color -->
                            <div class="bg-white p-2 rounded-xl border border-teal-200 shadow-2xs">
                                <label class="block text-[10px] font-bold text-teal-700 mb-1">Before BP (Color)</label>
                                <input type="number" name="display_rates[before_bp_color]" value="{{ $rates['before_bp_color'] ?? '' }}" placeholder="---" class="w-full text-xs font-bold text-teal-700 border-0 p-0 focus:ring-0 bg-transparent">
                            </div>

                            <!-- Page-2 BW -->
                            <div class="bg-white p-2 rounded-xl border border-slate-200 shadow-2xs">
                                <label class="block text-[10px] font-bold text-slate-500 mb-1">Page-2 (BW)</label>
                                <input type="number" name="display_rates[page_2_bw]" value="{{ $rates['page_2_bw'] ?? '' }}" placeholder="---" class="w-full text-xs font-bold text-slate-900 border-0 p-0 focus:ring-0 bg-transparent">
                            </div>

                            <!-- Page-2 Color -->
                            <div class="bg-white p-2 rounded-xl border border-teal-200 shadow-2xs">
                                <label class="block text-[10px] font-bold text-teal-700 mb-1">Page-2 (Color)</label>
                                <input type="number" name="display_rates[page_2_color]" value="{{ $rates['page_2_color'] ?? '' }}" placeholder="---" class="w-full text-xs font-bold text-teal-700 border-0 p-0 focus:ring-0 bg-transparent">
                            </div>

                            <!-- Page-3 BW -->
                            <div class="bg-white p-2 rounded-xl border border-slate-200 shadow-2xs">
                                <label class="block text-[10px] font-bold text-slate-500 mb-1">Page-3 (BW)</label>
                                <input type="number" name="display_rates[page_3_bw]" value="{{ $rates['page_3_bw'] ?? '' }}" placeholder="---" class="w-full text-xs font-bold text-slate-900 border-0 p-0 focus:ring-0 bg-transparent">
                            </div>

                            <!-- Page-3 Color -->
                            <div class="bg-white p-2 rounded-xl border border-teal-200 shadow-2xs">
                                <label class="block text-[10px] font-bold text-teal-700 mb-1">Page-3 (Color)</label>
                                <input type="number" name="display_rates[page_3_color]" value="{{ $rates['page_3_color'] ?? '' }}" placeholder="---" class="w-full text-xs font-bold text-teal-700 border-0 p-0 focus:ring-0 bg-transparent">
                            </div>

                            <!-- Page-5 BW -->
                            <div class="bg-white p-2 rounded-xl border border-slate-200 shadow-2xs">
                                <label class="block text-[10px] font-bold text-slate-500 mb-1">Page-5 (BW)</label>
                                <input type="number" name="display_rates[page_5_bw]" value="{{ $rates['page_5_bw'] ?? '' }}" placeholder="---" class="w-full text-xs font-bold text-slate-900 border-0 p-0 focus:ring-0 bg-transparent">
                            </div>

                            <!-- Page-5 Color -->
                            <div class="bg-white p-2 rounded-xl border border-teal-200 shadow-2xs">
                                <label class="block text-[10px] font-bold text-teal-700 mb-1">Page-5 (Color)</label>
                                <input type="number" name="display_rates[page_5_color]" value="{{ $rates['page_5_color'] ?? '' }}" placeholder="---" class="w-full text-xs font-bold text-teal-700 border-0 p-0 focus:ring-0 bg-transparent">
                            </div>

                            <!-- Sports BW -->
                            <div class="bg-white p-2 rounded-xl border border-slate-200 shadow-2xs">
                                <label class="block text-[10px] font-bold text-slate-500 mb-1">Sports (BW)</label>
                                <input type="number" name="display_rates[sports_bw]" value="{{ $rates['sports_bw'] ?? '' }}" placeholder="---" class="w-full text-xs font-bold text-slate-900 border-0 p-0 focus:ring-0 bg-transparent">
                            </div>

                            <!-- Sports Color -->
                            <div class="bg-white p-2 rounded-xl border border-teal-200 shadow-2xs">
                                <label class="block text-[10px] font-bold text-teal-700 mb-1">Sports (Color)</label>
                                <input type="number" name="display_rates[sports_color]" value="{{ $rates['sports_color'] ?? '' }}" placeholder="---" class="w-full text-xs font-bold text-teal-700 border-0 p-0 focus:ring-0 bg-transparent">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        @endforeach
    </div>
</div>
@endsection
