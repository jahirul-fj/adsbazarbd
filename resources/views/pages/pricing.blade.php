@extends('layouts.app')

@section('title', 'বিজ্ঞাপনের মূল্য তালিকা (Newspaper Ad Rates) - Reporter')

@section('content')
<div class="bg-slate-900 text-white py-12 px-4 sm:px-6 lg:px-8 border-b border-slate-800">
    <div class="max-w-4xl mx-auto text-center space-y-3">
        <span class="px-3 py-1 bg-emerald-500/20 text-emerald-400 rounded-full text-xs font-semibold uppercase tracking-wider">১০০% স্বচ্ছ রেট তালিকা</span>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">জাতীয় সংবাদপত্রের বিজ্ঞাপনের মূল্য তালিকা</h1>
        <p class="text-slate-400 text-sm max-w-xl mx-auto">
            দেশের শীর্ষ সকল বাংলা ও ইংরেজি সংবাদপত্রের শ্রেণীভুক্ত ও ডিসপ্লে বিজ্ঞাপনের অফিসিয়াল রেট চার্ট। কোনো লুকায়িত চার্জ নেই।
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden">
        <div class="p-6 sm:p-8 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="text-xl font-bold text-slate-900">সকল দৈনিক পত্রিকার বিজ্ঞাপনের তুলনামূলক রেট</h2>
                <p class="text-xs text-slate-500 mt-1">কলামের গড় মাপ: প্রস্থ ১.৫ ইঞ্চি, পাতার পূর্ণ উচ্চতা ২১ ইঞ্চি</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('classified.index') }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition-colors">
                    শ্রেণীভুক্ত দিন
                </a>
                <a href="{{ route('display.index') }}" class="px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white font-bold text-xs rounded-xl shadow-xs transition-colors">
                    ডিসপ্লে দিন
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead class="bg-slate-50 text-slate-700 font-bold border-b border-slate-200 uppercase text-[11px] tracking-wider">
                    <tr>
                        <th class="p-4">সংবাদপত্রের নাম</th>
                        <th class="p-4">ভাষা</th>
                        <th class="p-4 text-center">শ্রেণীভুক্ত (প্রতি শব্দ)</th>
                        <th class="p-4 text-center">ডিসপ্লে (প্রতি কলাম-ইঞ্চি)</th>
                        <th class="p-4 text-center">প্রথম পাতা রেট</th>
                        <th class="p-4 text-center">ব্যাক পেজ রেট</th>
                        <th class="p-4 text-center">রঙিন সারচার্জ</th>
                        <th class="p-4 text-center">অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @foreach($newspapers as $np)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="p-4 font-bold text-slate-900">
                                {{ $np->name }}
                            </td>
                            <td class="p-4">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $np->language === 'bangla' ? 'bg-emerald-50 text-emerald-700' : 'bg-blue-50 text-blue-700' }}">
                                    {{ $np->language === 'bangla' ? 'বাংলা' : 'English' }}
                                </span>
                            </td>
                            <td class="p-4 text-center font-bold text-emerald-700">
                                ৳{{ number_format($np->classified_rate_per_word, 2) }}
                            </td>
                            <td class="p-4 text-center font-bold text-teal-700">
                                ৳{{ number_format($np->display_rate_col_inch, 2) }}
                            </td>
                            <td class="p-4 text-center text-slate-600 font-bold">
                                {{ $np->front_page_multiplier }}x
                            </td>
                            <td class="p-4 text-center text-slate-600 font-bold">
                                {{ $np->back_page_multiplier }}x
                            </td>
                            <td class="p-4 text-center text-slate-600">
                                +{{ $np->color_charge_percent }}%
                            </td>
                            <td class="p-4 text-center">
                                <a href="{{ route('classified.index') }}" class="inline-block px-3 py-1 bg-slate-900 text-white rounded-lg text-xs font-bold hover:bg-emerald-600 transition-colors">
                                    বুক করুন
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
