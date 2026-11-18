@extends('layouts.admin')

@section('title', 'বিজ্ঞাপনের ক্যাটাগরি ও স্যাম্পল - Admin')
@section('page_title', 'বিজ্ঞাপন ক্যাটাগরি ও নমুনা টেমপ্লেট')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-xl font-bold text-white">বিজ্ঞাপনের ক্যাটাগরি ও নমুনা ফরম্যাট</h1>
            <p class="text-xs text-slate-400">ব্যবহারকারীদের সুবিধার্থে বিভিন্ন বিভাগ ও স্যাম্পল টেক্সট কনফিগার করুন</p>
        </div>
    </div>

    <!-- Create New Category -->
    <details class="bg-slate-950 rounded-2xl border border-slate-800 shadow-xs p-6 group">
        <summary class="font-bold text-sm text-slate-200 cursor-pointer flex justify-between items-center list-none">
            <span class="flex items-center gap-2 text-indigo-400">
                <i class="fa-solid fa-plus-circle"></i> নতুন ক্যাটাগরি তৈরি করুন
            </span>
            <i class="fa-solid fa-chevron-down text-xs text-slate-400 group-open:rotate-180 transition-transform"></i>
        </summary>
        <form action="{{ route('admin.categories.store') }}" method="POST" class="pt-6 mt-4 border-t border-slate-800 space-y-4">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-1">ক্যাটাগরির নাম</label>
                    <input type="text" name="name" placeholder="যেমন: ব্যবসা বিক্রয় / ফ্র্যাঞ্চাইজ" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3 py-2 text-xs font-medium text-white" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-1">বিজ্ঞাপনের প্রযোজ্য ধরন</label>
                    <select name="type" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3 py-2 text-xs font-medium text-white">
                        <option value="all">শ্রেণীভুক্ত ও ডিসপ্লে উভয়ই</option>
                        <option value="classified">শুধুমাত্র শ্রেণীভুক্ত (Classified)</option>
                        <option value="display">শুধুমাত্র ডিসপ্লে (Display)</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase mb-1">নমুনা টেক্সট (Sample Text Template)</label>
                <textarea name="sample_text" rows="2" placeholder="ব্যবহারকারীর সুবিধার জন্য নমুনা বাক্য লিখুন..." class="w-full bg-slate-900 border border-slate-700 rounded-xl p-3 text-xs text-white"></textarea>
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center gap-2 text-xs font-bold cursor-pointer text-slate-300">
                    <input type="checkbox" name="requires_document" value="1" class="w-4 h-4 bg-slate-900 border-slate-700 text-rose-600 rounded-sm">
                    <span>ডকুমেন্ট আপলোড বাধ্যতামূলক (যেমন: জিডি কপি / এফিডেভিট)</span>
                </label>
                <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs rounded-xl shadow-xs transition-colors">
                    সেভ করুন
                </button>
            </div>
        </form>
    </details>

    <!-- Categories Table -->
    <div class="bg-slate-950 rounded-2xl border border-slate-800 shadow-xs overflow-hidden">
        <table class="w-full text-left text-xs">
            <thead class="bg-slate-900 text-slate-400 uppercase text-[10px] font-bold border-b border-slate-800">
                <tr>
                    <th class="p-4">ক্যাটাগরি</th>
                    <th class="p-4">টাইপ</th>
                    <th class="p-4">ডকুমেন্ট প্রয়োজন?</th>
                    <th class="p-4">নমুনা টেক্সট</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800/60">
                @foreach($categories as $cat)
                    <tr class="hover:bg-slate-900/50 transition-colors">
                        <td class="p-4 font-bold text-white">{{ $cat->name }}</td>
                        <td class="p-4">
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-slate-800 text-slate-300">
                                {{ $cat->type }}
                            </span>
                        </td>
                        <td class="p-4">
                            @if($cat->requires_document)
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-rose-500/20 text-rose-300">
                                    জিডি কপি আবশ্যক
                                </span>
                            @else
                                <span class="text-slate-500 text-xs">প্রয়োজন নেই</span>
                            @endif
                        </td>
                        <td class="p-4 text-xs text-slate-400 italic max-w-md truncate">
                            {{ $cat->sample_text ?? '-' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
