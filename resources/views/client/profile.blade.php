@extends('layouts.client')

@section('title', 'আমার প্রোফাইল ও নিরাপত্তা - Ads Bazar BD')
@section('page_title', 'প্রোফাইল সেটিংস ও পাসওয়ার্ড')

@section('content')
<div class="max-w-4xl space-y-8">
    <!-- Top Client Banner -->
    <div class="bg-gradient-to-r from-emerald-900 via-slate-900 to-teal-950 text-white rounded-3xl p-6 sm:p-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 shadow-xl border border-emerald-500/20">
        <div class="flex items-center gap-5">
            <div class="relative">
                @if($user->avatar_url)
                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-20 h-20 rounded-2xl object-cover border-2 border-emerald-400 shadow-md">
                @else
                    <div class="w-20 h-20 rounded-2xl bg-emerald-600 border-2 border-emerald-400/50 flex items-center justify-center text-white text-3xl font-black shadow-md">
                        {{ mb_substr($user->name, 0, 1) }}
                    </div>
                @endif
                <span class="absolute -bottom-1 -right-1 w-5 h-5 bg-emerald-400 border-2 border-slate-900 rounded-full" title="ভেরিফাইড অ্যাকাউন্ট"></span>
            </div>
            <div class="space-y-1">
                <div class="flex items-center gap-2">
                    <h1 class="text-2xl font-black">{{ $user->name }}</h1>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-400/30 uppercase">বিজ্ঞাপনদাতা</span>
                </div>
                <div class="text-xs text-slate-300 flex items-center gap-3">
                    <span><i class="fa-solid fa-envelope text-emerald-400 mr-1"></i> {{ $user->email }}</span>
                    <span><i class="fa-solid fa-phone text-emerald-400 mr-1"></i> {{ $user->phone }}</span>
                </div>
                <div class="text-[11px] text-slate-400">
                    মেম্বারশিপ: {{ $user->created_at->format('d M, Y') }} ({{ $user->created_at->diffForHumans() }})
                </div>
            </div>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('classified.index') }}" class="px-3.5 py-2 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs transition-colors flex items-center gap-1.5 shadow-md">
                <i class="fa-solid fa-plus-circle"></i> নতুন বিজ্ঞাপন দিন
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left: General Profile Form (2 Columns) -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-xs space-y-6">
                <div class="pb-4 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h2 class="font-extrabold text-base text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-user-pen text-emerald-600"></i> ব্যক্তিগত তথ্য ও ছবি
                        </h2>
                        <p class="text-xs text-slate-500 mt-0.5">আপনার প্রোফাইল নাম, ফোন এবং যোগাযোগের ঠিকানা আপডেট করুন।</p>
                    </div>
                </div>

                <form action="{{ route('client.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf

                    <!-- Avatar Upload -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">প্রোফাইল ছবি</label>
                        <div class="flex items-center gap-4">
                            @if($user->avatar_url)
                                <img src="{{ $user->avatar_url }}" alt="Preview" class="w-14 h-14 rounded-2xl object-cover border border-slate-200 shadow-xs">
                            @else
                                <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-700 font-bold flex items-center justify-center border border-emerald-100 text-xl">
                                    {{ mb_substr($user->name, 0, 1) }}
                                </div>
                            @endif
                            <div class="flex-1">
                                <input type="file" name="avatar" accept="image/png, image/jpeg, image/jpg, image/webp" class="block w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer">
                                <p class="text-[11px] text-slate-400 mt-1">PNG, JPG বা WEBP (সর্বোচ্চ ২MB)</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">আপনার নাম <span class="text-rose-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-xs font-medium focus:ring-2 focus:ring-emerald-500 focus:outline-hidden" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">ফোন নম্বর <span class="text-rose-500">*</span></label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-xs font-medium focus:ring-2 focus:ring-emerald-500 focus:outline-hidden" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">ইমেইল ঠিকানা <span class="text-rose-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-xs font-medium focus:ring-2 focus:ring-emerald-500 focus:outline-hidden" required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">কোম্পানির নাম / যোগাযোগের ঠিকানা</label>
                        <textarea name="bio" rows="3" placeholder="যেমন: ধানমন্ডি, ঢাকা অথবা প্রতিষ্ঠানের পূর্ণ ঠিকানা..." class="w-full bg-slate-50 border border-slate-300 rounded-xl p-3 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-hidden leading-relaxed">{{ old('bio', $user->bio) }}</textarea>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-md transition-all inline-flex items-center gap-2">
                            <i class="fa-solid fa-floppy-disk"></i>
                            <span>প্রোফাইল তথ্য সেভ করুন</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right: Change Password Card & Summary -->
        <div class="space-y-6">
            <!-- Password Change Card -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs space-y-5">
                <div class="pb-3 border-b border-slate-100">
                    <h2 class="font-extrabold text-sm text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-lock text-rose-500"></i> পাসওয়ার্ড পরিবর্তন
                    </h2>
                    <p class="text-[11px] text-slate-500 mt-0.5">নিয়মিত পাসওয়ার্ড আপডেট করে আপনার অ্যাকাউন্ট সুরক্ষিত রাখুন।</p>
                </div>

                <form action="{{ route('client.password.update') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">বর্তমান পাসওয়ার্ড <span class="text-rose-500">*</span></label>
                        <input type="password" name="current_password" placeholder="••••••••" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-xs font-medium focus:ring-2 focus:ring-emerald-500 focus:outline-hidden" required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">নতুন পাসওয়ার্ড <span class="text-rose-500">*</span></label>
                        <input type="password" name="password" placeholder="কমপক্ষে ৬ অক্ষর" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-xs font-medium focus:ring-2 focus:ring-emerald-500 focus:outline-hidden" required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">নতুন পাসওয়ার্ড নিশ্চিত করুন <span class="text-rose-500">*</span></label>
                        <input type="password" name="password_confirmation" placeholder="পুনরায় নতুন পাসওয়ার্ড লিখুন" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-xs font-medium focus:ring-2 focus:ring-emerald-500 focus:outline-hidden" required>
                    </div>

                    <button type="submit" class="w-full py-3 bg-slate-900 hover:bg-slate-800 text-white font-extrabold text-xs rounded-xl shadow-md transition-colors flex items-center justify-center gap-2">
                        <i class="fa-solid fa-key text-amber-400"></i>
                        <span>পাসওয়ার্ড আপডেট করুন</span>
                    </button>
                </form>
            </div>

            <!-- Activity Quick Facts -->
            <div class="bg-slate-50 rounded-3xl p-5 border border-slate-200 space-y-3 text-xs">
                <div class="font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-chart-pie text-emerald-600"></i> অ্যাকাউন্ট অ্যাক্টিভিটি
                </div>
                <div class="space-y-2 text-slate-600 text-[11px]">
                    <div class="flex justify-between py-1 border-b border-slate-200/60">
                        <span>শ্রেণীভুক্ত বিজ্ঞাপন:</span>
                        <span class="font-bold text-slate-900">{{ $totalClassified }} টি</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-slate-200/60">
                        <span>ডিসপ্লে বিজ্ঞাপন:</span>
                        <span class="font-bold text-slate-900">{{ $totalDisplay }} টি</span>
                    </div>
                    <div class="flex justify-between py-1">
                        <span>ডিজাইন এসক্রো অর্ডার:</span>
                        <span class="font-bold text-indigo-700">{{ $totalOrders }} টি</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
