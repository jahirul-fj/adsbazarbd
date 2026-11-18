@extends('layouts.app')

@section('title', $profile->user->name . ' - ডিজাইনার প্রোফাইল ও পোর্টফোলিও')

@section('content')
<div class="bg-slate-900 text-white py-12 px-4 sm:px-6 lg:px-8 border-b border-slate-800">
    <div class="max-w-5xl mx-auto flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="flex flex-col sm:flex-row items-center gap-5 text-center sm:text-left">
            <div class="w-20 h-20 rounded-2xl bg-gradient-to-tr from-indigo-500 to-purple-600 text-white flex items-center justify-center font-black text-3xl shadow-xl">
                {{ mb_substr($profile->user->name, 0, 1) }}
            </div>
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold flex items-center justify-center sm:justify-start gap-2">
                    {{ $profile->user->name }}
                    <i class="fa-solid fa-circle-check text-emerald-400 text-base" title="ভেরিফাইড ডিজাইনার"></i>
                </h1>
                <p class="text-indigo-200 text-sm mt-1 font-medium">{{ $profile->tagline }}</p>
                <div class="flex items-center gap-3 mt-2 text-xs text-slate-300 justify-center sm:justify-start">
                    <span class="flex items-center gap-1 text-amber-400 font-bold"><i class="fa-solid fa-star"></i> {{ number_format($profile->rating, 1) }} ({{ $profile->total_reviews }} রিভিউ)</span>
                    <span>•</span>
                    <span>{{ $profile->completed_orders }} টি সফল অর্ডার সম্পন্ন</span>
                    <span>•</span>
                    <span>{{ $profile->experience_years }}+ বছর অভিজ্ঞতা</span>
                </div>
            </div>
        </div>

        <a href="{{ route('designers.hire', $profile->id) }}" class="px-8 py-3.5 bg-emerald-500 hover:bg-emerald-600 text-slate-950 font-extrabold text-sm rounded-xl shadow-lg transition-all flex items-center gap-2">
            <i class="fa-solid fa-handshake"></i> হায়ার করুন (৳{{ number_format($profile->starting_rate, 0) }} থেকে)
        </a>
    </div>
</div>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-10">
    <!-- Bio & Skills Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="md:col-span-2 space-y-6 bg-white p-7 rounded-2xl border border-slate-200 shadow-xs">
            <h2 class="text-lg font-bold text-slate-900 pb-2 border-b border-slate-100">আমার সম্পর্কে</h2>
            <p class="text-sm text-slate-700 leading-relaxed whitespace-pre-line">
                {{ $profile->about }}
            </p>

            <h3 class="text-sm font-bold text-slate-900 pt-2">দক্ষতা ও টুলস (Skills):</h3>
            <div class="flex flex-wrap gap-2">
                @foreach(explode(',', $profile->skills) as $skill)
                    <span class="px-3 py-1 bg-indigo-50 text-indigo-700 rounded-lg text-xs font-semibold border border-indigo-100">
                        {{ trim($skill) }}
                    </span>
                @endforeach
            </div>
        </div>

        <!-- Escrow Protection Box -->
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 text-white p-6 rounded-2xl shadow-md space-y-4">
            <div class="w-10 h-10 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-lg font-bold">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
            <h3 class="text-base font-bold text-white">এসক্রো গ্যারান্টি</h3>
            <p class="text-xs text-slate-300 leading-relaxed">
                আপনার প্রদত্ত পেমেন্ট Ads Bazar BD প্ল্যাটফর্মে নিরাপদ থাকে। ডিজাইনার ফাইল ডেলিভারি করার পর আপনি চূড়ান্ত অনুমোদন দিলে তবেই ডিজাইনার অর্থ পাবে।
            </p>
            <ul class="text-xs text-emerald-300 space-y-1.5 pt-2">
                <li><i class="fa-solid fa-check mr-1.5"></i> ৩টি রিভিশন সুবিধা নিশ্চিত</li>
                <li><i class="fa-solid fa-check mr-1.5"></i> হাই রেজ্যুলেশন প্রিন্ট রেডি PDF</li>
                <li><i class="fa-solid fa-check mr-1.5"></i> ২৪ ঘণ্টার মধ্যে দ্রুত ডেলিভারি</li>
            </ul>
        </div>
    </div>

    <!-- Portfolio Gallery -->
    <div class="space-y-6">
        <h2 class="text-xl font-bold text-slate-900">পূর্বের কাজের নমুনা ও পোর্টফোলিও</h2>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @if(!empty($profile->portfolio) && is_array($profile->portfolio))
                @foreach($profile->portfolio as $item)
                    <div class="bg-white rounded-2xl overflow-hidden border border-slate-200 shadow-xs hover:shadow-lg transition-all group">
                        <div class="h-48 overflow-hidden bg-slate-100 relative">
                            <img src="{{ $item['image'] ?? 'https://images.unsplash.com/photo-1542744094-3a31f272c490?w=600' }}" alt="{{ $item['title'] ?? 'Portfolio' }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @if(isset($item['category']))
                                <span class="absolute top-3 left-3 px-2 py-1 bg-slate-900/80 backdrop-blur-xs text-white text-[10px] font-bold rounded-md uppercase">
                                    {{ $item['category'] }}
                                </span>
                            @endif
                        </div>
                        <div class="p-4">
                            <h4 class="font-bold text-sm text-slate-800 leading-snug">{{ $item['title'] ?? 'নিউজপেপার অ্যাড ডিজাইন' }}</h4>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-span-3 p-8 text-center bg-white rounded-2xl border border-slate-200 text-slate-500 text-xs">
                    পোর্টফোলিও ফাইল শীঘ্রই যুক্ত হবে।
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
