@extends('layouts.app')

@section('title', 'লগইন পোর্টাল নির্বাচন করুন - Reporter')

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

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Portal 1: Client -->
        <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm hover:shadow-xl hover:border-emerald-500 transition-all duration-300 flex flex-col justify-between group">
            <div class="space-y-4">
                <div class="w-16 h-16 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-3xl group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                    <i class="fa-solid fa-user-check"></i>
                </div>
                <div>
                    <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-wider">বিজ্ঞাপনদাতা</span>
                    <h3 class="text-xl font-black text-slate-900 mt-0.5">গ্রাহক পোর্টাল</h3>
                </div>
                <p class="text-xs text-slate-600 leading-relaxed">
                    সংবাদপত্রে আপনার বুকিং করা বিজ্ঞাপন, ইনভয়েস ডাউনলোড এবং ডিজাইনারদের সাথে কাজ সমন্বয়ের জন্য।
                </p>
            </div>
            <div class="pt-6 space-y-2">
                <a href="{{ route('client.login') }}" class="w-full inline-flex items-center justify-center gap-2 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition-colors">
                    গ্রাহক লগইন <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
                <a href="{{ route('client.register') }}" class="w-full inline-flex items-center justify-center py-2 bg-slate-50 hover:bg-slate-100 text-slate-600 text-xs font-semibold rounded-xl transition-colors">
                    নতুন অ্যাকাউন্ট খুলুন
                </a>
            </div>
        </div>

        <!-- Portal 2: Designer -->
        <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm hover:shadow-xl hover:border-teal-500 transition-all duration-300 flex flex-col justify-between group">
            <div class="space-y-4">
                <div class="w-16 h-16 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center text-3xl group-hover:bg-teal-600 group-hover:text-white transition-colors">
                    <i class="fa-solid fa-paintbrush"></i>
                </div>
                <div>
                    <span class="text-[10px] font-bold text-teal-600 uppercase tracking-wider">ফ্রিল্যান্সার</span>
                    <h3 class="text-xl font-black text-slate-900 mt-0.5">ডিজাইনার পোর্টাল</h3>
                </div>
                <p class="text-xs text-slate-600 leading-relaxed">
                    বিজ্ঞাপনের ডিজাইন অর্ডার রিসিভ, ড্রাফট সাবমিশন, এসক্রো ব্যালেন্স ও পোর্টফোলিও পরিচালনার জন্য।
                </p>
            </div>
            <div class="pt-6 space-y-2">
                <a href="{{ route('designer.login') }}" class="w-full inline-flex items-center justify-center gap-2 py-3 bg-teal-600 hover:bg-teal-700 text-white font-bold text-xs rounded-xl shadow-xs transition-colors">
                    ডিজাইনার লগইন <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
                <a href="{{ route('designer.register') }}" class="w-full inline-flex items-center justify-center py-2 bg-slate-50 hover:bg-slate-100 text-slate-600 text-xs font-semibold rounded-xl transition-colors">
                    ডিজাইনার হিসেবে সাইনআপ
                </a>
            </div>
        </div>

        <!-- Portal 3: Admin -->
        <div class="bg-slate-900 text-white rounded-3xl p-8 border border-slate-800 shadow-xl hover:shadow-2xl hover:border-indigo-500 transition-all duration-300 flex flex-col justify-between group">
            <div class="space-y-4">
                <div class="w-16 h-16 rounded-2xl bg-indigo-600/30 text-indigo-400 flex items-center justify-center text-3xl group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <div>
                    <span class="text-[10px] font-bold text-indigo-400 uppercase tracking-wider">সিস্টেম কন্ট্রোল</span>
                    <h3 class="text-xl font-black text-white mt-0.5">অ্যাডমিন পোর্টাল</h3>
                </div>
                <p class="text-xs text-slate-400 leading-relaxed">
                    বিজ্ঞাপনের অনুমোদন, পেমেন্ট ভেরিফিকেশন, সংবাদপত্রের রেট আপডেট ও সিস্টেম সেটিংস ব্যবস্থাপনার জন্য।
                </p>
            </div>
            <div class="pt-6 space-y-2">
                <a href="{{ route('admin.login') }}" class="w-full inline-flex items-center justify-center gap-2 py-3 bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs rounded-xl shadow-lg transition-colors">
                    অ্যাডমিন সিকিউর লগইন <i class="fa-solid fa-lock text-[10px]"></i>
                </a>
                <div class="text-[11px] text-center text-slate-500 py-1 font-semibold">
                    অননুমোদিত প্রবেশ নিষেধ
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
