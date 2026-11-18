@extends('layouts.app')

@section('title', 'গ্রাফিক ডিজাইনার ডিরেক্টরি - Ads Bazar BD')

@section('content')
<div class="bg-slate-900 text-white py-12 px-4 sm:px-6 lg:px-8 border-b border-slate-800">
    <div class="max-w-4xl mx-auto text-center space-y-3">
        <span class="px-3 py-1 bg-indigo-500/20 text-indigo-300 rounded-full text-xs font-semibold uppercase tracking-wider">এসক্রো সিকিউরড প্ল্যাটফর্ম</span>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">বিজ্ঞাপনের জন্য দক্ষ ডিজাইনার খুঁজুন</h1>
        <p class="text-slate-400 text-sm max-w-xl mx-auto">
            দেশের শীর্ষ সংবাদপত্রের স্পেসিফিকেশন জানা অভিজ্ঞ গ্রাফিক ডিজাইনারদের প্রোফাইল দেখুন এবং পছন্দের ডিজাইনার হায়ার করুন।
        </p>

        <!-- Search Bar -->
        <div class="max-w-lg mx-auto pt-4">
            <form action="{{ route('designers.index') }}" method="GET" class="flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="নাম বা স্কিল দিয়ে খুঁজুন (যেমন: Newspaper, Typography)..." class="flex-1 bg-white/10 border border-white/20 rounded-xl px-4 py-2.5 text-sm text-white placeholder-slate-400 focus:outline-hidden focus:ring-2 focus:ring-indigo-400">
                <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 font-bold text-xs rounded-xl transition-colors">
                    <i class="fa-solid fa-search"></i> খুঁজুন
                </button>
            </form>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($designers as $profile)
            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs hover:shadow-xl transition-all flex flex-col justify-between group">
                <div class="space-y-4">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-14 h-14 rounded-full bg-gradient-to-tr from-indigo-600 to-purple-600 text-white flex items-center justify-center font-bold text-xl shadow-md group-hover:scale-105 transition-transform">
                                {{ mb_substr($profile->user->name, 0, 1) }}
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-900 text-base flex items-center gap-1.5">
                                    {{ $profile->user->name }}
                                    <i class="fa-solid fa-circle-check text-emerald-500 text-xs" title="ভেরিফাইড ডিজাইনার"></i>
                                </h3>
                                <div class="text-xs text-slate-500 line-clamp-1">{{ $profile->tagline }}</div>
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
                                <i class="fa-solid fa-star text-[10px]"></i> {{ number_format($profile->rating, 1) }} ({{ $profile->total_reviews }})
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
                        পোর্টফোলিও
                    </a>
                    <a href="{{ route('designers.hire', $profile->id) }}" class="flex-1 py-2.5 text-center text-xs font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl transition-colors shadow-xs">
                        হায়ার করুন
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-16 bg-white rounded-2xl border border-slate-200">
                <i class="fa-solid fa-user-slash text-4xl text-slate-300 mb-3"></i>
                <div class="font-bold text-slate-700">কোনো ডিজাইনার পাওয়া যায়নি</div>
                <div class="text-xs text-slate-400 mt-1">অন্য কোনো কি-ওয়ার্ড দিয়ে সার্চ করুন</div>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $designers->links() }}
    </div>
</div>
@endsection
