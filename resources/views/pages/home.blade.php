@extends('layouts.app')

@section('title', 'Ads Bazar BD - সহজে জাতীয় পত্রিকায় বিজ্ঞাপন ও ডিজাইনার প্ল্যাটফর্ম')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-b from-emerald-900 via-slate-900 to-slate-900 text-white pt-16 pb-28 px-4 sm:px-6 lg:px-8 overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#10b981_1px,transparent_1px)] [background-size:16px_16px]"></div>
    
    <div class="relative max-w-7xl mx-auto text-center space-y-6">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 text-xs sm:text-sm font-medium backdrop-blur-xs">
            <span class="flex h-2 w-2 rounded-full bg-emerald-400 animate-ping"></span>
            বাংলাদেশের আধুনিক প্রোগ্রাম্যাটিক সংবাদপত্র বিজ্ঞাপন প্ল্যাটফর্ম
        </div>
        
        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight max-w-4xl mx-auto leading-tight sm:leading-tight">
            সহজে ঘরে বসেই <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-300">জাতীয় পত্রিকায়</span> বিজ্ঞাপন দিন
        </h1>
        
        <p class="text-slate-300 text-base sm:text-lg max-w-2xl mx-auto font-light leading-relaxed">
            কোনো এজেন্টের কাছে দৌড়াদৌড়ি না করে মাত্র ৫ মিনিটে প্রথম আলো, বাংলাদেশ প্রতিদিন, ডেইলি স্টারসহ সকল শীর্ষ দৈনিক পত্রিকায় বিজ্ঞাপন প্রকাশ করুন অথবা অভিজ্ঞ গ্রাফিক ডিজাইনার হায়ার করুন।
        </p>

        <!-- Search / Quick Ad Tracking Box -->
        <div class="max-w-xl mx-auto pt-4">
            <form action="{{ route('track') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-2 bg-white/10 backdrop-blur-md p-2 rounded-2xl border border-white/20 shadow-2xl">
                <div class="flex items-center gap-2 px-3 py-2 flex-1 w-full">
                    <i class="fa-solid fa-satellite-dish text-emerald-400"></i>
                    <input type="text" name="tracking_no" placeholder="বিজ্ঞাপনের ট্র্যাকিং নম্বর দিন (যেমন: CLS-202611-1001)" class="w-full bg-transparent text-white placeholder-slate-400 text-sm focus:outline-hidden" required>
                </div>
                <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-sm rounded-xl transition-all shadow-lg flex items-center justify-center gap-2 whitespace-nowrap">
                    <i class="fa-solid fa-magnifying-glass"></i> ট্র্যাক করুন
                </button>
            </form>
        </div>
    </div>
</section>

<!-- 3 Main Pillars / Service Cards (Overlapping Hero) -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 relative z-10">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Card 1: Classified Ad -->
        <div class="bg-white rounded-2xl p-7 shadow-xl border border-slate-100 flex flex-col justify-between hover:-translate-y-1 transition-all duration-300 group">
            <div class="space-y-4">
                <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl font-bold group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                    <i class="fa-solid fa-list-check"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-900">শ্রেণীভুক্ত বিজ্ঞাপন</h3>
                <p class="text-sm text-slate-600 leading-relaxed">
                    বাড়ি ভাড়া, জমি বিক্রয়, হারানো বিজ্ঞপ্তি, এফিডেভিট, পাত্র/পাত্রী চাই ইত্যাদি টেক্সট বিজ্ঞাপন খুব সহজে ওয়ার্ড ও লাইন হিসাব করে পত্রিকায় প্রকাশ করুন।
                </p>
                <ul class="text-xs text-slate-500 space-y-1.5 pt-2">
                    <li class="flex items-center gap-2"><i class="fa-solid fa-check text-emerald-500"></i> লাইভ ওয়ার্ড কাউন্টার ও স্বয়ংক্রিয় রেট হিসাব</li>
                    <li class="flex items-center gap-2"><i class="fa-solid fa-check text-emerald-500"></i> জিডি / এফিডেভিট ডকুমেন্ট আপলোড সুবিধা</li>
                </ul>
            </div>
            <div class="pt-6">
                <a href="{{ route('classified.index') }}" class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold shadow-md transition-all">
                    শ্রেণীভুক্ত বিজ্ঞাপন দিন <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>

        <!-- Card 2: Display Ad -->
        <div class="bg-white rounded-2xl p-7 shadow-xl border border-slate-100 flex flex-col justify-between hover:-translate-y-1 transition-all duration-300 group">
            <div class="space-y-4">
                <div class="w-14 h-14 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center text-2xl font-bold group-hover:bg-teal-600 group-hover:text-white transition-colors">
                    <i class="fa-solid fa-images"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-900">ডিসপ্লে বিজ্ঞাপন</h3>
                <p class="text-sm text-slate-600 leading-relaxed">
                    সংবাদপত্রের যেকোনো পাতায় (প্রথম পাতা, শেষ পাতা বা ব্যাক পেজ) কলাম-ইঞ্চি হিসাব করে ব্র্যান্ড, প্রতিষ্ঠান বা নিয়োগের রঙিন ব্যানার বিজ্ঞাপন বুকিং দিন।
                </p>
                <ul class="text-xs text-slate-500 space-y-1.5 pt-2">
                    <li class="flex items-center gap-2"><i class="fa-solid fa-check text-teal-500"></i> কলাম × ইঞ্চি ক্যালকুলেটর ও লাইভ সাইজ প্রিভিউ</li>
                    <li class="flex items-center gap-2"><i class="fa-solid fa-check text-teal-500"></i> রঙিন ও সাদা-কালো কাস্টম পেজ রেট</li>
                </ul>
            </div>
            <div class="pt-6">
                <a href="{{ route('display.index') }}" class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-teal-600 hover:bg-teal-700 text-white text-sm font-bold shadow-md transition-all">
                    ডিসপ্লে বিজ্ঞাপন দিন <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>

        <!-- Card 3: Hire Designer -->
        <div class="bg-white rounded-2xl p-7 shadow-xl border border-slate-100 flex flex-col justify-between hover:-translate-y-1 transition-all duration-300 group">
            <div class="space-y-4">
                <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-2xl font-bold group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                    <i class="fa-solid fa-pen-nib"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-900">ডিজাইনার নিয়োগ করুন</h3>
                <p class="text-sm text-slate-600 leading-relaxed">
                    বিজ্ঞাপনের ডিজাইন নেই? দেশের অভিজ্ঞ গ্রাফিক ডিজাইনারদের প্রোফাইল দেখে পছন্দমতো ডিজাইনার হায়ার করুন। এসক্রো পদ্ধতিতে আপনার টাকা ১০০% সুরক্ষিত।
                </p>
                <ul class="text-xs text-slate-500 space-y-1.5 pt-2">
                    <li class="flex items-center gap-2"><i class="fa-solid fa-check text-indigo-500"></i> ৩টি পর্যন্ত ডিজাইন সংশোধন (রিভিশন) সুবিধা</li>
                    <li class="flex items-center gap-2"><i class="fa-solid fa-check text-indigo-500"></i> ডিজাইন অনুমোদন না হওয়া পর্যন্ত পেমেন্ট সেফ</li>
                </ul>
            </div>
            <div class="pt-6">
                <a href="{{ route('designers.index') }}" class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold shadow-md transition-all">
                    ডিজাইনার খুঁজুন <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Newspaper Partners Showcase -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20">
    <div class="text-center max-w-2xl mx-auto space-y-3 mb-10">
        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">যেসব জাতীয় পত্রিকায় বিজ্ঞাপন দিতে পারবেন</h2>
        <p class="text-sm text-slate-600">দেশের শীর্ষস্থানীয় বাংলা ও ইংরেজি সংবাদপত্রে নিয়মিত প্রকাশের সুযোগ</p>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach($newspapers as $np)
            <div class="bg-white rounded-xl p-5 border border-slate-200/80 shadow-xs hover:border-emerald-500 hover:shadow-md transition-all flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <span class="px-2 py-0.5 rounded text-[11px] font-bold uppercase {{ $np->language === 'bangla' ? 'bg-emerald-50 text-emerald-700' : 'bg-blue-50 text-blue-700' }}">
                            {{ $np->language === 'bangla' ? 'বাংলা দৈনিক' : 'English Daily' }}
                        </span>
                        <span class="text-xs text-slate-400">মিনিমাম {{ $np->min_words }} শব্দ</span>
                    </div>
                    <h3 class="font-bold text-slate-900 text-base leading-snug mb-2">{{ $np->name }}</h3>
                    <div class="text-xs text-slate-500 space-y-1">
                        <div>শ্রেণীভুক্ত: <strong class="text-emerald-700">৳{{ number_format($np->classified_rate_per_word, 0) }}</strong> /শব্দ</div>
                        <div>ডিসপ্লে: <strong class="text-teal-700">৳{{ number_format($np->display_rate_col_inch, 0) }}</strong> /কলাম ইঞ্চি</div>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs font-semibold">
                    <a href="{{ route('classified.index') }}" class="text-emerald-600 hover:underline">শ্রেণীভুক্ত দিন &rarr;</a>
                    <a href="{{ route('display.index') }}" class="text-teal-600 hover:underline">ডিসপ্লে &rarr;</a>
                </div>
            </div>
        @endforeach
    </div>
</section>

<!-- How It Works (৩টি সহজ ধাপ) -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
    <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-3xl text-white p-8 sm:p-14 shadow-2xl relative overflow-hidden">
        <div class="text-center max-w-2xl mx-auto space-y-3 mb-12">
            <span class="text-emerald-400 font-bold uppercase tracking-wider text-xs">সহজ ও দ্রুত কার্যপ্রণালী</span>
            <h2 class="text-2xl sm:text-4xl font-extrabold tracking-tight">মাত্র ৩টি সহজ ধাপে বিজ্ঞাপন বুকিং</h2>
            <p class="text-slate-300 text-sm">ঘরে বসেই মোবাইল বা কম্পিউটার থেকে ৫ মিনিটে বিজ্ঞাপন প্রক্রিয়া সম্পন্ন করুন</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
            <!-- Step 1 -->
            <div class="bg-white/5 backdrop-blur-xs p-6 rounded-2xl border border-white/10 text-center space-y-4">
                <div class="w-14 h-14 rounded-full bg-emerald-500 text-slate-900 text-2xl font-black mx-auto flex items-center justify-center">
                    ১
                </div>
                <h3 class="text-lg font-bold text-white">পত্রিকা ও ধরণ নির্বাচন</h3>
                <p class="text-xs text-slate-300 leading-relaxed">
                    যে পত্রিকায় বিজ্ঞাপন দিতে চান সেটি নির্বাচন করুন। শ্রেণীভুক্ত টেক্সট বিজ্ঞাপন অথবা ডিসপ্লে বক্স বিজ্ঞাপনের ক্যাটাগরি ও তারিখ নির্ধারণ করুন।
                </p>
            </div>

            <!-- Step 2 -->
            <div class="bg-white/5 backdrop-blur-xs p-6 rounded-2xl border border-white/10 text-center space-y-4">
                <div class="w-14 h-14 rounded-full bg-emerald-500 text-slate-900 text-2xl font-black mx-auto flex items-center justify-center">
                    ২
                </div>
                <h3 class="text-lg font-bold text-white">বিজ্ঞাপনের তথ্য প্রদান</h3>
                <p class="text-xs text-slate-300 leading-relaxed">
                    আপনার বিজ্ঞাপনের শিরোনাম ও বিবরণ লিখুন। হারানো বিজ্ঞপ্তি বা সংশোধনের জন্য জিডি/এফিডেভিট কপি অথবা ডিসপ্লে আর্টওয়ার্ক ফাইল আপলোড করুন।
                </p>
            </div>

            <!-- Step 3 -->
            <div class="bg-white/5 backdrop-blur-xs p-6 rounded-2xl border border-white/10 text-center space-y-4">
                <div class="w-14 h-14 rounded-full bg-emerald-500 text-slate-900 text-2xl font-black mx-auto flex items-center justify-center">
                    ৩
                </div>
                <h3 class="text-lg font-bold text-white">পেমেন্ট ও প্রকাশনা</h3>
                <p class="text-xs text-slate-300 leading-relaxed">
                    বিকাশ, নগদ বা ব্যাংক ট্রান্সফারের মাধ্যমে স্বয়ংক্রিয়ভাবে হিসাবকৃত মূল্য পরিশোধ করুন। নির্দিষ্ট তারিখে পত্রিকায় আপনার বিজ্ঞাপন প্রকাশিত হবে।
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Popular Classified Categories -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4 mb-8">
        <div>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">বিজ্ঞাপনের জনপ্রিয় ক্যাটাগরি</h2>
            <p class="text-sm text-slate-600 mt-1">প্রয়োজনীয় বিভাগ নির্বাচন করে দ্রুত বিজ্ঞাপন প্রদান করুন</p>
        </div>
        <a href="{{ route('classified.index') }}" class="text-sm font-bold text-emerald-600 hover:text-emerald-700 flex items-center gap-1.5">
            সব ক্যাটাগরি দেখুন <i class="fa-solid fa-arrow-right text-xs"></i>
        </a>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
        @foreach($categories as $cat)
            <a href="{{ route('classified.index', ['category' => $cat->id]) }}" class="bg-white p-5 rounded-2xl border border-slate-200/80 text-center space-y-3 hover:border-emerald-500 hover:shadow-lg transition-all group">
                <div class="w-12 h-12 rounded-xl bg-slate-50 text-slate-700 group-hover:bg-emerald-50 group-hover:text-emerald-600 mx-auto flex items-center justify-center text-xl transition-colors">
                    @if(str_contains($cat->slug, 'rent') || str_contains($cat->slug, 'house'))
                        <i class="fa-solid fa-house"></i>
                    @elseif(str_contains($cat->slug, 'property') || str_contains($cat->slug, 'sale'))
                        <i class="fa-solid fa-building"></i>
                    @elseif(str_contains($cat->slug, 'lost'))
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    @elseif(str_contains($cat->slug, 'affidavit'))
                        <i class="fa-solid fa-file-contract"></i>
                    @elseif(str_contains($cat->slug, 'matrimonial'))
                        <i class="fa-solid fa-heart"></i>
                    @elseif(str_contains($cat->slug, 'job'))
                        <i class="fa-solid fa-briefcase"></i>
                    @elseif(str_contains($cat->slug, 'car'))
                        <i class="fa-solid fa-car"></i>
                    @else
                        <i class="fa-solid fa-bullhorn"></i>
                    @endif
                </div>
                <div class="font-bold text-slate-800 text-sm group-hover:text-emerald-600 transition-colors line-clamp-1">
                    {{ $cat->name }}
                </div>
                <div class="text-[11px] text-slate-400">বিজ্ঞাপন দিন &rarr;</div>
            </a>
        @endforeach
    </div>
</section>

<!-- Featured Designers Showcase -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4 mb-10">
        <div>
            <span class="text-xs uppercase tracking-wider font-bold text-indigo-600">দক্ষ ও অভিজ্ঞ ফ্রিল্যান্সার</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1">বিজ্ঞাপনের জন্য ডিজাইনার হায়ার করুন</h2>
            <p class="text-sm text-slate-600 mt-1">এসক্রো পদ্ধতিতে ১০০% নিরাপদ পেমেন্টে আপনার বিজ্ঞাপনটি নকশা করিয়ে নিন</p>
        </div>
        <a href="{{ route('designers.index') }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-700 flex items-center gap-1.5">
            সকল ডিজাইনার দেখুন <i class="fa-solid fa-arrow-right text-xs"></i>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($featuredDesigners as $profile)
            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs hover:shadow-xl transition-all flex flex-col justify-between">
                <div class="space-y-4">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-13 h-13 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-500 text-white flex items-center justify-center font-bold text-lg shadow-sm">
                                {{ mb_substr($profile->user->name, 0, 1) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 text-base flex items-center gap-1.5">
                                    {{ $profile->user->name }}
                                    <i class="fa-solid fa-circle-check text-emerald-500 text-xs" title="ভেরিফাইড ডিজাইনার"></i>
                                </h4>
                                <div class="text-xs text-slate-500">{{ $profile->tagline }}</div>
                            </div>
                        </div>
                    </div>

                    <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed">
                        {{ $profile->about }}
                    </p>

                    <div class="flex flex-wrap gap-1.5">
                        @foreach(explode(',', $profile->skills) as $skill)
                            <span class="px-2 py-0.5 bg-slate-100 text-slate-600 rounded text-[11px] font-medium">
                                {{ trim($skill) }}
                            </span>
                        @endforeach
                    </div>

                    <div class="grid grid-cols-3 gap-2 py-3 border-y border-slate-100 text-center text-xs">
                        <div>
                            <div class="text-slate-400">অভিজ্ঞতা</div>
                            <div class="font-bold text-slate-800">{{ $profile->experience_years }}+ বছর</div>
                        </div>
                        <div>
                            <div class="text-slate-400">রেটিং</div>
                            <div class="font-bold text-amber-500 flex items-center justify-center gap-1">
                                <i class="fa-solid fa-star text-[10px]"></i> {{ number_format($profile->rating, 1) }}
                            </div>
                        </div>
                        <div>
                            <div class="text-slate-400">শুরু মাত্র</div>
                            <div class="font-bold text-indigo-600">৳{{ number_format($profile->starting_rate, 0) }}</div>
                        </div>
                    </div>
                </div>

                <div class="pt-5 flex gap-2">
                    <a href="{{ route('designers.show', $profile->id) }}" class="flex-1 py-2.5 text-center text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">
                        প্রোফাইল দেখুন
                    </a>
                    <a href="{{ route('designers.hire', $profile->id) }}" class="flex-1 py-2.5 text-center text-xs font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl transition-colors shadow-xs">
                        হায়ার করুন
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</section>

<!-- Client Testimonials (Real Testimonials) -->
<section class="bg-slate-100 py-20 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto space-y-12">
        <div class="text-center max-w-2xl mx-auto space-y-2">
            <span class="text-xs uppercase tracking-wider font-bold text-emerald-600">গ্রাহকদের অভিজ্ঞতা</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">কেন মানুষ আমাদের উপর আস্থা রাখেন?</h2>
            <p class="text-sm text-slate-600">গ্রাহক ও কর্পোরেট পার্টনারদের প্রতিক্রিয়া</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Review 1 -->
            <div class="bg-white p-7 rounded-2xl shadow-xs border border-slate-200/80 space-y-4">
                <div class="text-amber-400 flex gap-1 text-sm">
                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                </div>
                <p class="text-sm text-slate-700 leading-relaxed italic">
                    "Dedicated and straight advice always. Really helpful in dealing with all the situation relating to the Advertisement. Professional, Honest and trustworthy."
                </p>
                <div class="pt-2 border-t border-slate-100">
                    <div class="font-bold text-slate-900 text-sm">Content Creator</div>
                    <div class="text-xs text-slate-500">AFR Technology</div>
                </div>
            </div>

            <!-- Review 2 -->
            <div class="bg-white p-7 rounded-2xl shadow-xs border border-slate-200/80 space-y-4">
                <div class="text-amber-400 flex gap-1 text-sm">
                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                </div>
                <p class="text-sm text-slate-700 leading-relaxed italic">
                    "Their service is very punctual and very easy process to give an ad to the newspaper through online service. I am very happy that I can submit my missing post without any hassle within one day!"
                </p>
                <div class="pt-2 border-t border-slate-100">
                    <div class="font-bold text-slate-900 text-sm">Program Officer</div>
                    <div class="text-xs text-slate-500">Bangladesh Institute of Labor Studies (BILS)</div>
                </div>
            </div>

            <!-- Review 3 -->
            <div class="bg-white p-7 rounded-2xl shadow-xs border border-slate-200/80 space-y-4">
                <div class="text-amber-400 flex gap-1 text-sm">
                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                </div>
                <p class="text-sm text-slate-700 leading-relaxed italic">
                    "Ads Bazar BD creates a concept to offline and online advertisement. It's really an excellent platform to maintain bridge communication between advertisers and publishers."
                </p>
                <div class="pt-2 border-t border-slate-100">
                    <div class="font-bold text-slate-900 text-sm">Manager (Digital Advertisement)</div>
                    <div class="text-xs text-slate-500">The Daily Samakal</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Banner -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="bg-gradient-to-r from-emerald-600 to-teal-600 rounded-3xl p-8 sm:p-12 text-white flex flex-col md:flex-row items-center justify-between gap-8 shadow-xl">
        <div class="space-y-3 max-w-xl text-center md:text-left">
            <h3 class="text-2xl sm:text-3xl font-extrabold">পত্রিকায় বিজ্ঞাপন প্রকাশ করতে চান?</h3>
            <p class="text-emerald-100 text-sm">আজই অনলাইনে আপনার পছন্দের পত্রিকায় বিজ্ঞাপন বুক করুন অথবা সহায়তার জন্য আমাদের হেল্পলাইনে কল করুন।</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
            <a href="{{ route('classified.index') }}" class="px-6 py-3.5 bg-white text-emerald-800 font-bold text-sm rounded-xl hover:bg-emerald-50 transition-all text-center shadow-md">
                বিজ্ঞাপন বুক করুন
            </a>
            <a href="tel:{{ preg_replace('/[^0-9]/', '', $siteSettings['helpline_phone'] ?? '01854820303') }}" class="px-6 py-3.5 bg-emerald-700/80 hover:bg-emerald-800 text-white font-bold text-sm rounded-xl transition-all text-center border border-emerald-400/30 flex items-center justify-center gap-2">
                <i class="fa-solid fa-phone"></i> {{ $siteSettings['helpline_phone'] ?? '01854-820303' }}
            </a>
        </div>
    </div>
</section>
@endsection
