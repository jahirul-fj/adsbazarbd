@extends('layouts.app')

@section('title', 'ডিজাইনার প্রোফাইল এডিট - Designer Panel')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-md space-y-6">
        <div class="pb-4 border-b border-slate-100">
            <h1 class="text-2xl font-black text-slate-900">ডিজাইনার প্রোফাইল এডিট</h1>
            <p class="text-xs text-slate-500 mt-1">আপনার স্কিল, কাজের দর ও পরিচিতি আপডেট রাখুন যাতে ক্লায়েন্ট সহজে হায়ার করতে পারে।</p>
        </div>

        <form action="{{ route('designer.profile.update') }}" method="POST" class="space-y-5">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">আপনার নাম <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-teal-500 focus:outline-hidden" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">ফোন নম্বর <span class="text-rose-500">*</span></label>
                    <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-teal-500 focus:outline-hidden" required>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">ট্যাগলাইন (পেশাগত পরিচয়) <span class="text-rose-500">*</span></label>
                <input type="text" name="tagline" value="{{ old('tagline', $profile->tagline) }}" placeholder="যেমন: পেশাদার নিউজপেপার ও কমার্শিয়াল গ্রাফিক ডিজাইনার" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-teal-500 focus:outline-hidden" required>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">আপনার সম্পর্কে (Bio) <span class="text-rose-500">*</span></label>
                <textarea name="about" rows="4" placeholder="আপনার অভিজ্ঞতা, কাজের ধরন ও ক্লায়েন্ট সন্তুষ্টির ব্যাপারে বিস্তারিত লিখুন..." class="w-full bg-slate-50 border border-slate-300 rounded-xl p-4 text-sm focus:ring-2 focus:ring-teal-500 focus:outline-hidden leading-relaxed" required>{{ old('about', $profile->about) }}</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">অভিজ্ঞতা (বছর) <span class="text-rose-500">*</span></label>
                    <input type="number" name="experience_years" value="{{ old('experience_years', $profile->experience_years) }}" min="0" max="40" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-teal-500 focus:outline-hidden" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">শুরু মাত্র / ন্যূনতম রেট (৳) <span class="text-rose-500">*</span></label>
                    <input type="number" name="starting_rate" value="{{ old('starting_rate', $profile->starting_rate) }}" min="100" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-teal-500 focus:outline-hidden" required>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">দক্ষতা ও টুলস (কমা দিয়ে লিখুন) <span class="text-rose-500">*</span></label>
                <input type="text" name="skills" value="{{ old('skills', $profile->skills) }}" placeholder="Newspaper Ads, Adobe Illustrator, Photoshop, Pre-press, Typography" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-teal-500 focus:outline-hidden" required>
            </div>

            <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 flex items-center gap-3">
                <input type="checkbox" name="is_available" id="is_available" value="1" {{ $profile->is_available ? 'checked' : '' }} class="w-4 h-4 text-teal-600 rounded-sm border-slate-300">
                <label for="is_available" class="text-xs font-bold text-slate-700 cursor-pointer">
                    আমি নতুন কাজের জন্য উন্মুক্ত আছি (Available for hire)
                </label>
            </div>

            <button type="submit" class="w-full py-3.5 bg-teal-600 hover:bg-teal-700 text-white font-extrabold text-sm rounded-xl shadow-md transition-colors">
                প্রোফাইল সেভ করুন
            </button>
        </form>
    </div>
</div>
@endsection
