@extends('layouts.app')

@section('title', 'আমাদের সম্পর্কে - Reporter | Procharok')

@section('content')
<div class="bg-slate-900 text-white py-14 px-4 sm:px-6 lg:px-8 border-b border-slate-800">
    <div class="max-w-4xl mx-auto text-center space-y-3">
        <span class="px-3 py-1 bg-emerald-500/20 text-emerald-400 rounded-full text-xs font-semibold uppercase tracking-wider">আমাদের পরিচিতি</span>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">আমাদের সম্পর্কে বিস্তারিত</h1>
        <p class="text-slate-400 text-sm max-w-xl mx-auto">
            বাংলাদেশের সংবাদপত্র ও ডিজিটাল বিজ্ঞাপন মাধ্যমের আধুনিক রূপান্তর
        </p>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-14 space-y-12">
    <div class="bg-white p-8 sm:p-10 rounded-3xl border border-slate-200 shadow-xs space-y-6 text-slate-700 leading-relaxed text-sm">
        <h2 class="text-2xl font-extrabold text-slate-900">Reporter (প্রচারক) এর লক্ষ্য ও উদ্দেশ্য</h2>
        <p>
            <strong>Reporter</strong> একটি অনলাইন বেস প্রোগ্রাম্যাটিক অফলাইন সংবাদপত্র বিজ্ঞাপন প্ল্যাটফর্ম। এই প্ল্যাটফর্মের মাধ্যমে বাংলাদেশের সকল জাতীয় বাংলা ও ইংরেজি দৈনিক পত্রিকায় বিজ্ঞাপন সেবা অত্যন্ত দ্রুত ও স্বচ্ছ প্রক্রিয়ায় প্রদান করা হয়।
        </p>
        <p>
            প্রথাগত নিয়মে সংবাদপত্রে বিজ্ঞাপন দিতে গেলে বিভিন্ন বিজ্ঞাপনী সংস্থা বা এজেন্টের কাছে সশরীরে যেতে হতো, যা সময়সাপেক্ষ এবং খরচের দিক থেকেও অস্বচ্ছ। প্রচারক এই সমস্যা সমাধান করে এমন একটি অটোমেটেড ডাইনামিক প্ল্যাটফর্ম তৈরি করেছে যার মাধ্যমে যে কেউ নিজের স্মার্টফোন বা কম্পিউটার থেকে মাত্র ৫ মিনিটের মধ্যেই যেকোনো জাতীয় সংবাদপত্রে বিজ্ঞাপন বুকিং করতে পারেন।
        </p>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-4">
            <div class="p-6 bg-emerald-50 rounded-2xl border border-emerald-100 space-y-2">
                <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-bold text-lg">
                    <i class="fa-solid fa-bullseye"></i>
                </div>
                <h3 class="font-bold text-slate-900 text-base">আমাদের ভিশন</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    বিজ্ঞাপনদাতা এবং সংবাদপত্র প্রকাশকদের মধ্যে একটি স্বচ্ছ, নিরাপদ ও রিয়েল-টাইম ডিজিটাল সেতুবন্ধন তৈরি করা।
                </p>
            </div>

            <div class="p-6 bg-teal-50 rounded-2xl border border-teal-100 space-y-2">
                <div class="w-10 h-10 rounded-xl bg-teal-600 text-white flex items-center justify-center font-bold text-lg">
                    <i class="fa-solid fa-hand-holding-hand"></i>
                </div>
                <h3 class="font-bold text-slate-900 text-base">ডিজাইনার এমপাওয়ারমেন্ট</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    বাংলাদেশের প্রতিভাবান ফ্রিল্যান্স গ্রাফিক ডিজাইনারদের একটি সুরক্ষিত প্ল্যাটফর্ম দেওয়া, যেখানে এসক্রো পদ্ধতিতে তারা কাজের সঠিক পারিশ্রমিক পাবেন।
                </p>
            </div>
        </div>
    </div>

    <!-- Office & Contact Card -->
    <div class="bg-gradient-to-br from-slate-900 to-slate-800 text-white p-8 rounded-3xl shadow-xl flex flex-col md:flex-row justify-between items-center gap-6">
        <div class="space-y-2 text-center md:text-left">
            <h3 class="text-xl font-bold">সরাসরি আমাদের সাথে যোগাযোগ করুন</h3>
            <p class="text-xs text-slate-300">যেকোনো বিজ্ঞাপন সংক্রান্ত পরামর্শ ও কর্পোরেট সেবার জন্য আমরা প্রস্তুত আছি।</p>
            <div class="text-xs text-emerald-400 font-bold pt-2">
                <i class="fa-solid fa-location-dot mr-1"></i> বাড়ি # ১২, রোড # ০৫, ধানমন্ডি, ঢাকা-১২০৫, বাংলাদেশ
            </div>
        </div>
        <div class="flex gap-3">
            <a href="tel:01854820303" class="px-6 py-3 bg-emerald-500 hover:bg-emerald-600 text-slate-950 font-bold text-xs rounded-xl shadow-md transition-all">
                <i class="fa-solid fa-phone mr-1"></i> 01854-820303
            </a>
            <a href="{{ route('classified.index') }}" class="px-6 py-3 bg-white/10 hover:bg-white/20 text-white font-bold text-xs rounded-xl border border-white/20 transition-all">
                বিজ্ঞাপন দিন
            </a>
        </div>
    </div>
</div>
@endsection
