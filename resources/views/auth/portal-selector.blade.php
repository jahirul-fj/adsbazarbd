@extends('layouts.app')

@section('title', 'লগইন পোর্টাল নির্বাচন করুন - Ads Bazar BD')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 space-y-10">
    <div class="text-center space-y-3">
        <span class="px-3 py-1 bg-slate-200 text-slate-700 rounded-full text-xs font-bold uppercase tracking-wider">
            লগইন পোর্টাল গেটওয়ে
        </span>
        <h1 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">আপনার নির্ধারিত পোর্টাল নির্বাচন করুন</h1>
        <p class="text-slate-500 text-sm max-w-lg mx-auto">
            নিরাপত্তা ও আলাদা ড্যাশবোর্ড ব্যবস্থাপনার সুবিধার্থে প্রত্যেক রোল-এর জন্য আলাদা লগইন ব্যবস্থা রয়েছে।
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-2xl mx-auto">
        <!-- Portal 1: Client -->
        <div class="relative overflow-hidden bg-white rounded-3xl p-7 sm:p-8 border border-slate-200/90 shadow-md hover:shadow-xl hover:border-emerald-500 hover:-translate-y-1 transition-all duration-300 flex flex-col items-center text-center group">
            <!-- Ambient corner glow -->
            <div class="absolute -top-12 -right-12 w-32 h-32 bg-emerald-100/60 rounded-full blur-2xl group-hover:bg-emerald-200/70 transition-colors pointer-events-none"></div>

            <div class="space-y-3.5 flex flex-col items-center w-full relative z-10">
                <!-- Icon Badge -->
                <div class="w-16 h-16 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-600 flex items-center justify-center text-2xl shadow-2xs group-hover:scale-105 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300">
                    <i class="fa-solid fa-user-check"></i>
                </div>

                <!-- Title -->
                <h3 class="text-2xl font-black text-slate-900 tracking-tight group-hover:text-emerald-700 transition-colors">
                    গ্রাহক পোর্টাল
                </h3>

                <!-- Description -->
                <p class="text-xs sm:text-sm text-slate-500 leading-relaxed max-w-xs mx-auto">
                    সংবাদপত্রে আপনার বুকিং করা বিজ্ঞাপন, ইনভয়েস ডাউনলোড এবং ডিজাইনারদের সাথে কাজ সমন্বয়ের জন্য।
                </p>
            </div>

            <!-- Buttons -->
            <div class="pt-5 space-y-2 w-full relative z-10">
                <a href="{{ route('client.login') }}" class="w-full inline-flex items-center justify-center gap-2 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-extrabold text-sm rounded-xl shadow-sm hover:shadow-md transition-all">
                    <span>গ্রাহক লগইন</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
                <a href="{{ route('client.register') }}" class="w-full inline-flex items-center justify-center gap-1.5 py-2 bg-slate-50 hover:bg-emerald-50 text-slate-600 hover:text-emerald-700 text-xs font-bold rounded-lg transition-all border border-slate-100">
                    <i class="fa-solid fa-user-plus text-[11px]"></i>
                    <span>নতুন অ্যাকাউন্ট খুলুন</span>
                </a>
            </div>
        </div>

        <!-- Portal 2: Designer -->
        <div class="relative overflow-hidden bg-white rounded-3xl p-7 sm:p-8 border border-slate-200/90 shadow-md hover:shadow-xl hover:border-teal-500 hover:-translate-y-1 transition-all duration-300 flex flex-col items-center text-center group">
            <!-- Ambient corner glow -->
            <div class="absolute -top-12 -right-12 w-32 h-32 bg-teal-100/60 rounded-full blur-2xl group-hover:bg-teal-200/70 transition-colors pointer-events-none"></div>

            <div class="space-y-3.5 flex flex-col items-center w-full relative z-10">
                <!-- Icon Badge -->
                <div class="w-16 h-16 rounded-2xl bg-teal-50 border border-teal-100 text-teal-600 flex items-center justify-center text-2xl shadow-2xs group-hover:scale-105 group-hover:bg-teal-600 group-hover:text-white transition-all duration-300">
                    <i class="fa-solid fa-paintbrush"></i>
                </div>

                <!-- Title -->
                <h3 class="text-2xl font-black text-slate-900 tracking-tight group-hover:text-teal-700 transition-colors">
                    ডিজাইনার পোর্টাল
                </h3>

                <!-- Description -->
                <p class="text-xs sm:text-sm text-slate-500 leading-relaxed max-w-xs mx-auto">
                    বিজ্ঞাপনের ডিজাইন অর্ডার রিসিভ, ড্রাফট সাবমিশন, এসক্রো ব্যালেন্স ও পোর্টফোলিও পরিচালনার জন্য।
                </p>
            </div>

            <!-- Buttons -->
            <div class="pt-5 space-y-2 w-full relative z-10">
                <a href="{{ route('designer.login') }}" class="w-full inline-flex items-center justify-center gap-2 py-3 bg-gradient-to-r from-teal-600 to-emerald-600 hover:from-teal-700 hover:to-emerald-700 text-white font-extrabold text-sm rounded-xl shadow-sm hover:shadow-md transition-all">
                    <span>ডিজাইনার লগইন</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
                <a href="{{ route('designer.register') }}" class="w-full inline-flex items-center justify-center gap-1.5 py-2 bg-slate-50 hover:bg-teal-50 text-slate-600 hover:text-teal-700 text-xs font-bold rounded-lg transition-all border border-slate-100">
                    <i class="fa-solid fa-palette text-[11px]"></i>
                    <span>ডিজাইনার হিসেবে সাইনআপ</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
