@extends('layouts.designer')

@section('title', 'ডিজাইনার প্রোফাইল ও নিরাপত্তা - Ads Bazar BD')
@section('page_title', 'প্রোফাইল, স্কিল ও পাসওয়ার্ড')

@section('content')
<div class="max-w-4xl space-y-8">
    <!-- Top Designer Banner -->
    <div class="bg-gradient-to-r from-teal-950 via-slate-900 to-slate-950 text-white rounded-3xl p-6 sm:p-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 shadow-xl border border-teal-500/20">
        <div class="flex items-center gap-5">
            <div class="relative">
                @if(auth()->user()->avatar_url)
                    <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="w-20 h-20 rounded-2xl object-cover border-2 border-teal-400 shadow-md">
                @else
                    <div class="w-20 h-20 rounded-2xl bg-teal-600 border-2 border-teal-400/50 flex items-center justify-center text-slate-950 text-3xl font-black shadow-md">
                        {{ mb_substr(auth()->user()->name, 0, 1) }}
                    </div>
                @endif
                <span class="absolute -bottom-1 -right-1 w-5 h-5 {{ $profile->is_available ? 'bg-teal-400' : 'bg-slate-500' }} border-2 border-slate-900 rounded-full" title="{{ $profile->is_available ? 'অ্যাভেইলেবল' : 'ব্যস্ত' }}"></span>
            </div>
            <div class="space-y-1">
                <div class="flex items-center gap-2">
                    <h1 class="text-2xl font-black">{{ auth()->user()->name }}</h1>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-teal-500/20 text-teal-300 border border-teal-400/30 uppercase">ভেরিফাইড ডিজাইনার</span>
                </div>
                <p class="text-xs text-slate-300">{{ $profile->tagline ?? 'প্রফেশনাল বিজ্ঞাপন ও ব্যানার ডিজাইনার' }}</p>
                <div class="text-[11px] text-slate-400 flex items-center gap-3">
                    <span><i class="fa-solid fa-envelope text-teal-400 mr-1"></i> {{ auth()->user()->email }}</span>
                    <span><i class="fa-solid fa-phone text-teal-400 mr-1"></i> {{ auth()->user()->phone }}</span>
                </div>
            </div>
        </div>
        <div class="flex gap-2">
            @if(auth()->user()->designerProfile)
                <a href="{{ route('designers.show', auth()->user()->designerProfile->id) }}" target="_blank" class="px-4 py-2.5 bg-teal-500 hover:bg-teal-400 text-slate-950 font-bold text-xs rounded-xl shadow-md transition-all flex items-center gap-1.5">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i> পাবলিক পোর্টফোলিও
                </a>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left: Designer Profile Form (2 Columns) -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-xs space-y-6">
                <div class="pb-4 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h2 class="font-extrabold text-base text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-user-pen text-teal-600"></i> প্রোফাইল, স্কিল ও দর সেটিংস
                        </h2>
                        <p class="text-xs text-slate-500 mt-0.5">আপনার স্কিল, রেট ও বায়ো আপডেট রাখুন যাতে ক্লায়েন্ট আপনাকে সহজে হায়ার করতে পারে।</p>
                    </div>
                </div>

                <form action="{{ route('designer.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf

                    <!-- Avatar Upload -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">প্রোফাইল ছবি (Avatar)</label>
                        <div class="flex items-center gap-4">
                            @if(auth()->user()->avatar_url)
                                <img src="{{ auth()->user()->avatar_url }}" alt="Preview" class="w-14 h-14 rounded-2xl object-cover border border-slate-200 shadow-xs">
                            @else
                                <div class="w-14 h-14 rounded-2xl bg-teal-50 text-teal-700 font-bold flex items-center justify-center border border-teal-100 text-xl">
                                    {{ mb_substr(auth()->user()->name, 0, 1) }}
                                </div>
                            @endif
                            <div class="flex-1">
                                <input type="file" name="avatar" accept="image/png, image/jpeg, image/jpg, image/webp" class="block w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 cursor-pointer">
                                <p class="text-[11px] text-slate-400 mt-1">PNG, JPG বা WEBP (সর্বোচ্চ ২MB)</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">আপনার নাম <span class="text-rose-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-xs font-medium focus:ring-2 focus:ring-teal-500 focus:outline-hidden" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">ফোন নম্বর <span class="text-rose-500">*</span></label>
                            <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-xs font-medium focus:ring-2 focus:ring-teal-500 focus:outline-hidden" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">ইমেইল ঠিকানা <span class="text-rose-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-xs font-medium focus:ring-2 focus:ring-teal-500 focus:outline-hidden" required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">পেশাগত ট্যাগলাইন <span class="text-rose-500">*</span></label>
                        <input type="text" name="tagline" value="{{ old('tagline', $profile->tagline) }}" placeholder="যেমন: পেশাদার সংবাদপত্র বিজ্ঞাপন ও সোশ্যাল মিডিয়া ব্যানার ডিজাইনার" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-xs font-medium focus:ring-2 focus:ring-teal-500 focus:outline-hidden" required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">আপনার সম্পর্কে বিস্তারিত (Bio) <span class="text-rose-500">*</span></label>
                        <textarea name="about" rows="4" placeholder="আপনার অভিজ্ঞতা, কাজের ধরন ও ক্লায়েন্ট সন্তুষ্টির ব্যাপারে বিস্তারিত লিখুন..." class="w-full bg-slate-50 border border-slate-300 rounded-xl p-3 text-xs focus:ring-2 focus:ring-teal-500 focus:outline-hidden leading-relaxed" required>{{ old('about', $profile->about) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">অভিজ্ঞতা (বছর) <span class="text-rose-500">*</span></label>
                            <input type="number" name="experience_years" value="{{ old('experience_years', $profile->experience_years) }}" min="0" max="40" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-xs font-medium focus:ring-2 focus:ring-teal-500 focus:outline-hidden" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">ন্যূনতম রেট / শুরুর দর (৳) <span class="text-rose-500">*</span></label>
                            <input type="number" name="starting_rate" value="{{ old('starting_rate', $profile->starting_rate) }}" min="100" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-xs font-medium focus:ring-2 focus:ring-teal-500 focus:outline-hidden" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">দক্ষতা ও টুলস (কমা দিয়ে লিখুন) <span class="text-rose-500">*</span></label>
                        <input type="text" name="skills" value="{{ old('skills', $profile->skills) }}" placeholder="Newspaper Ads, Adobe Illustrator, Photoshop, Pre-press, Typography" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-xs font-medium focus:ring-2 focus:ring-teal-500 focus:outline-hidden" required>
                    </div>

                    <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 flex items-center gap-3">
                        <input type="checkbox" name="is_available" id="is_available" value="1" {{ $profile->is_available ? 'checked' : '' }} class="w-4 h-4 text-teal-600 rounded-sm border-slate-300">
                        <label for="is_available" class="text-xs font-bold text-slate-700 cursor-pointer">
                            আমি নতুন কাজের জন্য উন্মুক্ত আছি (Available for hire)
                        </label>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="px-6 py-3 bg-teal-600 hover:bg-teal-700 text-white font-extrabold text-xs rounded-xl shadow-md transition-all inline-flex items-center gap-2">
                            <i class="fa-solid fa-floppy-disk"></i>
                            <span>প্রোফাইল সেভ করুন</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right: Change Password Card & Stats -->
        <div class="space-y-6">
            <!-- Password Change Card -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs space-y-5">
                <div class="pb-3 border-b border-slate-100">
                    <h2 class="font-extrabold text-sm text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-lock text-rose-500"></i> পাসওয়ার্ড পরিবর্তন
                    </h2>
                    <p class="text-[11px] text-slate-500 mt-0.5">নিয়মিত পাসওয়ার্ড আপডেট করে আপনার ডিজাইনার অ্যাকাউন্ট নিরাপদ রাখুন।</p>
                </div>

                <form action="{{ route('designer.password.update') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">বর্তমান পাসওয়ার্ড <span class="text-rose-500">*</span></label>
                        <input type="password" name="current_password" placeholder="••••••••" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-xs font-medium focus:ring-2 focus:ring-teal-500 focus:outline-hidden" required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">নতুন পাসওয়ার্ড <span class="text-rose-500">*</span></label>
                        <input type="password" name="password" placeholder="কমপক্ষে ৬ অক্ষর" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-xs font-medium focus:ring-2 focus:ring-teal-500 focus:outline-hidden" required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">নতুন পাসওয়ার্ড নিশ্চিত করুন <span class="text-rose-500">*</span></label>
                        <input type="password" name="password_confirmation" placeholder="পুনরায় নতুন পাসওয়ার্ড লিখুন" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-xs font-medium focus:ring-2 focus:ring-teal-500 focus:outline-hidden" required>
                    </div>

                    <button type="submit" class="w-full py-3 bg-slate-900 hover:bg-slate-800 text-white font-extrabold text-xs rounded-xl shadow-md transition-colors flex items-center justify-center gap-2">
                        <i class="fa-solid fa-key text-amber-400"></i>
                        <span>পাসওয়ার্ড আপডেট করুন</span>
                    </button>
                </form>
            </div>

            <!-- Performance Card -->
            <div class="bg-slate-50 rounded-3xl p-5 border border-slate-200 space-y-3 text-xs">
                <div class="font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-award text-teal-600"></i> পারফরম্যান্স সারসংক্ষেপ
                </div>
                <div class="space-y-2 text-slate-600 text-[11px]">
                    <div class="flex justify-between py-1 border-b border-slate-200/60">
                        <span>মোট ব্যালেন্স:</span>
                        <span class="font-bold text-teal-700">৳{{ number_format(auth()->user()->balance, 2) }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-slate-200/60">
                        <span>ক্লায়েন্ট রেটিং:</span>
                        <span class="font-bold text-amber-500">★ {{ number_format($profile->rating ?? 5.0, 1) }} ({{ $profile->total_reviews ?? 0 }})</span>
                    </div>
                    <div class="flex justify-between py-1">
                        <span>সম্পন্ন কাজ:</span>
                        <span class="font-bold text-slate-900">{{ $profile->completed_orders ?? 0 }} টি</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
