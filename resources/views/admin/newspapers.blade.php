@extends('layouts.admin')

@section('title', 'সংবাদপত্র ও রেট ম্যানেজমেন্ট - Admin')
@section('page_title', 'সংবাদপত্র তালিকা ও রেট চার্ট কনফিগারেশন')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-xl font-bold text-slate-900">সংবাদপত্র ও বিজ্ঞাপনের রেট চার্ট</h1>
            <p class="text-xs text-slate-500">প্রতি শব্দের মূল্য, প্রতি কলাম-ইঞ্চির রেট ও মাল্টিপ্লায়ার পরিবর্তন করুন</p>
        </div>
    </div>

    <!-- Add New Newspaper Accordion / Card -->
    <details class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 group">
        <summary class="font-bold text-sm text-slate-900 cursor-pointer flex justify-between items-center list-none">
            <span class="flex items-center gap-2 text-indigo-600">
                <i class="fa-solid fa-plus-circle"></i> নতুন সংবাদপত্র যুক্ত করুন
            </span>
            <i class="fa-solid fa-chevron-down text-xs text-slate-400 group-open:rotate-180 transition-transform"></i>
        </summary>
        <form action="{{ route('admin.newspapers.store') }}" method="POST" class="pt-6 mt-4 border-t border-slate-100 grid grid-cols-1 sm:grid-cols-3 gap-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">সংবাদপত্রের নাম</label>
                <input type="text" name="name" placeholder="যেমন: দৈনিক নয়া দিগন্ত" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 text-xs font-medium text-slate-900 focus:bg-white focus:ring-2 focus:ring-indigo-500" required>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">ভাষা</label>
                <select name="language" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 text-xs font-medium text-slate-800 focus:bg-white">
                    <option value="bangla">বাংলা (Bangla)</option>
                    <option value="english">ইংরেজি (English)</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">শ্রেণীভুক্ত রেট (প্রতি শব্দ ৳)</label>
                <input type="number" step="0.5" name="classified_rate_per_word" value="15" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 text-xs font-medium text-slate-900 focus:bg-white" required>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">ডিসপ্লে বেস রেট (প্রতি কলাম ইঞ্চি ৳)</label>
                <input type="number" step="50" name="display_rate_col_inch" value="1500" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 text-xs font-medium text-slate-900 focus:bg-white" required>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">প্রথম পাতা গুণক</label>
                <input type="number" step="0.1" name="front_page_multiplier" value="2.5" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 text-xs font-medium text-slate-900 focus:bg-white" required>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">ব্যাক পেজ গুণক</label>
                <input type="number" step="0.1" name="back_page_multiplier" value="1.8" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 text-xs font-medium text-slate-900 focus:bg-white" required>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">রঙিন অতিরিক্ত চার্জ (%)</label>
                <input type="number" name="color_charge_percent" value="30" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 text-xs font-medium text-slate-900 focus:bg-white" required>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">নূন্যতম শব্দ সংখ্যা</label>
                <input type="number" name="min_words" value="20" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 text-xs font-medium text-slate-900 focus:bg-white" required>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl shadow-xs transition-colors">
                    সেভ করুন
                </button>
            </div>
        </form>
    </details>

    <!-- Existing Newspapers List -->
    <div class="space-y-4">
        @foreach($newspapers as $np)
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs space-y-4">
                <form action="{{ route('admin.newspapers.update', $np->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 pb-3 border-b border-slate-100">
                        <div class="flex items-center gap-3">
                            <h3 class="font-extrabold text-base text-slate-900">{{ $np->name }}</h3>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $np->language === 'bangla' ? 'bg-emerald-100 text-emerald-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ $np->language }}
                            </span>
                        </div>
                        <label class="flex items-center gap-2 text-xs font-bold cursor-pointer text-slate-700">
                            <input type="checkbox" name="is_active" value="1" {{ $np->is_active ? 'checked' : '' }} class="w-4 h-4 text-emerald-600 rounded-sm border-slate-300">
                            <span>সক্রিয় (Active)</span>
                        </label>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-6 gap-3 text-xs">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">নাম</label>
                            <input type="text" name="name" value="{{ $np->name }}" class="w-full bg-slate-50 border border-slate-300 text-slate-900 rounded-lg px-2.5 py-1.5 font-bold focus:bg-white" required>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">শ্রেণীভুক্ত (টাকা/শব্দ)</label>
                            <input type="number" step="0.5" name="classified_rate_per_word" value="{{ $np->classified_rate_per_word }}" class="w-full bg-slate-50 border border-slate-300 text-emerald-700 rounded-lg px-2.5 py-1.5 font-bold focus:bg-white" required>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">ডিসপ্লে (টাকা/কলাম ইঞ্চি)</label>
                            <input type="number" step="50" name="display_rate_col_inch" value="{{ $np->display_rate_col_inch }}" class="w-full bg-slate-50 border border-slate-300 text-teal-700 rounded-lg px-2.5 py-1.5 font-bold focus:bg-white" required>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">১ম পাতা গুণক</label>
                            <input type="number" step="0.1" name="front_page_multiplier" value="{{ $np->front_page_multiplier }}" class="w-full bg-slate-50 border border-slate-300 text-slate-800 rounded-lg px-2.5 py-1.5 focus:bg-white" required>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">ব্যাক পেজ গুণক</label>
                            <input type="number" step="0.1" name="back_page_multiplier" value="{{ $np->back_page_multiplier }}" class="w-full bg-slate-50 border border-slate-300 text-slate-800 rounded-lg px-2.5 py-1.5 focus:bg-white" required>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">রঙিন চার্জ (%)</label>
                            <input type="number" name="color_charge_percent" value="{{ $np->color_charge_percent }}" class="w-full bg-slate-50 border border-slate-300 text-slate-800 rounded-lg px-2.5 py-1.5 focus:bg-white" required>
                        </div>
                    </div>

                    <div class="text-right">
                        <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl shadow-xs transition-colors">
                            পরিবর্তন সেভ করুন
                        </button>
                    </div>
                </form>
            </div>
        @endforeach
    </div>
</div>
@endsection
