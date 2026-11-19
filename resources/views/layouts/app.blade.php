<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Ads Bazar BD - অনলাইন সংবাদপত্র বিজ্ঞাপন ও ডিজাইনার প্ল্যাটফর্ম')</title>

    <!-- Favicon & Touch Icons -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <meta name="theme-color" content="#059669">

    <!-- Google Fonts (Hind Siliguri for beautiful Bengali typography) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Tailwind CSS (via CDN for instant zero-config styling + custom utilities) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Hind Siliguri', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                            900: '#14532d',
                        },
                        navy: {
                            800: '#1e293b',
                            900: '#0f172a',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Hind Siliguri', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
        }
    </style>
    @stack('styles')
</head>
<body class="flex flex-col min-h-screen bg-slate-50 text-slate-800">

    @php
        $sitePhone = $siteSettings['helpline_phone'] ?? '01854-820303';
        $siteEmail = $siteSettings['helpline_email'] ?? 'contact@adsbazarbd.com';
        $siteAddress = $siteSettings['office_address'] ?? 'বাড়ি # ১২, রোড # ০৫, ধানমন্ডি, ঢাকা';
        $cleanPhone = preg_replace('/[^0-9]/', '', $sitePhone);
        $waPhone = str_starts_with($cleanPhone, '88') ? $cleanPhone : (str_starts_with($cleanPhone, '0') ? '88' . $cleanPhone : '880' . $cleanPhone);
    @endphp

    <!-- Top Announcement & Support Bar -->
    <div class="bg-slate-900 text-slate-300 text-xs sm:text-sm py-2 px-4 border-b border-slate-800">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-2">
            <div class="flex items-center gap-3 sm:gap-4 flex-wrap justify-center sm:justify-start">
                <span>
                    <i class="fa-solid fa-phone text-emerald-400 mr-1.5"></i> হেল্পলাইন: 
                    <a href="tel:{{ $cleanPhone }}" class="font-bold text-white hover:text-emerald-400 transition-colors">{{ $sitePhone }}</a>
                </span>
                <span class="hidden md:inline text-slate-600">|</span>
                <span class="hidden md:inline">
                    <i class="fa-solid fa-envelope text-emerald-400 mr-1.5"></i>
                    <a href="mailto:{{ $siteEmail }}" class="hover:text-emerald-400 transition-colors">{{ $siteEmail }}</a>
                </span>
                <span class="hidden lg:inline text-slate-600">|</span>
                <span class="hidden lg:inline"><i class="fa-solid fa-shield-halved text-emerald-400 mr-1.5"></i> এসক্রো পদ্ধতিতে ১০০% নিরাপদ ডিজাইন সার্ভিস</span>
            </div>
            <div class="flex items-center gap-3 text-xs">
                <a href="{{ route('track') }}" class="hover:text-emerald-400 transition-colors flex items-center gap-1">
                    <i class="fa-solid fa-satellite-dish text-emerald-400"></i> বিজ্ঞাপন ট্র্যাকিং
                </a>
                <span class="text-slate-600">|</span>
                <a href="{{ route('pricing') }}" class="hover:text-emerald-400 transition-colors">
                    <i class="fa-solid fa-tags text-emerald-400 mr-1"></i> রেট চার্ট
                </a>
            </div>
        </div>
    </div>

    <!-- Main Navigation Header -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Brand / Logo -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5 sm:gap-3 group">
                        <img src="{{ asset('images/logo-icon.svg') }}" alt="Ads Bazar BD" class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl shadow-md group-hover:scale-105 transition-transform object-contain shrink-0">
                        <div>
                            <div class="font-extrabold text-xl sm:text-2xl tracking-tight text-slate-900 leading-tight">
                                Ads Bazar BD
                            </div>
                            <div class="text-[10px] sm:text-[11px] text-slate-500 font-medium line-clamp-1">সহজে সংবাদপত্রে বিজ্ঞাপন ও ডিজাইনার প্ল্যাটফর্ম</div>
                        </div>
                    </a>
                </div>

                <!-- Desktop Nav Links -->
                <nav class="hidden lg:flex items-center gap-6 text-[15px] font-medium text-slate-700">
                    <a href="{{ route('home') }}" class="hover:text-emerald-600 transition-colors {{ request()->routeIs('home') ? 'text-emerald-600 font-semibold' : '' }}">
                        হোম
                    </a>
                    <a href="{{ route('classified.index') }}" class="hover:text-emerald-600 transition-colors {{ request()->routeIs('classified.*') ? 'text-emerald-600 font-semibold' : '' }}">
                        শ্রেণীভুক্ত বিজ্ঞাপন
                    </a>
                    <a href="{{ route('display.index') }}" class="hover:text-emerald-600 transition-colors {{ request()->routeIs('display.*') ? 'text-emerald-600 font-semibold' : '' }}">
                        ডিসপ্লে বিজ্ঞাপন
                    </a>
                    <a href="{{ route('designers.index') }}" class="hover:text-emerald-600 transition-colors {{ request()->routeIs('designers.*') ? 'text-emerald-600 font-semibold' : '' }}">
                        ডিজাইনার খুঁজুন
                    </a>
                    <a href="{{ route('pricing') }}" class="hover:text-emerald-600 transition-colors {{ request()->routeIs('pricing') ? 'text-emerald-600 font-semibold' : '' }}">
                        মূল্য তালিকা
                    </a>
                    <a href="{{ route('faq') }}" class="hover:text-emerald-600 transition-colors {{ request()->routeIs('faq') ? 'text-emerald-600 font-semibold' : '' }}">
                        প্রশ্নোত্তর
                    </a>
                    <a href="{{ route('about') }}" class="hover:text-emerald-600 transition-colors {{ request()->routeIs('about') ? 'text-emerald-600 font-semibold' : '' }}">
                        আমাদের সম্পর্কে
                    </a>
                </nav>

                <!-- Auth Buttons / User Profile (Desktop) -->
                <div class="hidden lg:flex items-center gap-3">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-3.5 py-2 text-sm font-semibold rounded-lg bg-indigo-50 text-indigo-700 hover:bg-indigo-100 transition-all border border-indigo-200">
                                <i class="fa-solid fa-gauge-high"></i> অ্যাডমিন প্যানেল
                            </a>
                        @elseif(auth()->user()->isDesigner())
                            <a href="{{ route('designer.dashboard') }}" class="inline-flex items-center gap-2 px-3.5 py-2 text-sm font-semibold rounded-lg bg-teal-50 text-teal-700 hover:bg-teal-100 transition-all border border-teal-200">
                                <i class="fa-solid fa-paintbrush"></i> ডিজাইনার ড্যাশবোর্ড
                            </a>
                        @else
                            <a href="{{ route('client.dashboard') }}" class="inline-flex items-center gap-2 px-3.5 py-2 text-sm font-semibold rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-100 transition-all border border-emerald-200">
                                <i class="fa-solid fa-user"></i> আমার অ্যাকাউন্ট
                            </a>
                        @endif

                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" title="লগআউট" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors">
                                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-xs transition-colors">
                            <i class="fa-solid fa-arrow-right-to-bracket text-xs"></i>
                            <span>লগইন</span>
                        </a>
                    @endauth
                </div>

                <!-- Mobile Action Area (< lg) -->
                <div class="flex lg:hidden items-center gap-2">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold rounded-lg bg-indigo-50 text-indigo-700 border border-indigo-200">
                                <i class="fa-solid fa-gauge-high"></i>
                                <span class="hidden sm:inline">অ্যাডমিন</span>
                            </a>
                        @elseif(auth()->user()->isDesigner())
                            <a href="{{ route('designer.dashboard') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold rounded-lg bg-teal-50 text-teal-700 border border-teal-200">
                                <i class="fa-solid fa-paintbrush"></i>
                                <span class="hidden sm:inline">ডিজাইনার</span>
                            </a>
                        @else
                            <a href="{{ route('client.dashboard') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-200">
                                <i class="fa-solid fa-user"></i>
                                <span class="hidden sm:inline">অ্যাকাউন্ট</span>
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg shadow-xs transition-colors">
                            <i class="fa-solid fa-arrow-right-to-bracket text-[10px]"></i>
                            <span>লগইন</span>
                        </a>
                    @endauth

                    <!-- Mobile Menu Toggle Button -->
                    <button type="button" onclick="togglePublicMobileMenu()" aria-label="মেনু টগল করুন" class="p-2 text-slate-700 hover:text-slate-900 hover:bg-slate-100 rounded-lg border border-slate-200 transition-colors">
                        <i id="mobileMenuIcon" class="fa-solid fa-bars text-lg"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Drawer (Animated Dropdown) -->
        <div id="mobile-menu" class="hidden lg:hidden border-t border-slate-200 bg-white/95 backdrop-blur-md px-4 py-4 space-y-3 shadow-xl transition-all">
            <div class="grid grid-cols-2 gap-2 pb-3 border-b border-slate-100 text-xs">
                <a href="{{ route('classified.index') }}" class="flex items-center gap-2 p-2.5 rounded-xl bg-emerald-50 text-emerald-700 font-bold hover:bg-emerald-100 transition-colors">
                    <i class="fa-solid fa-list-check text-emerald-600"></i>
                    <span>শ্রেণীভুক্ত বিজ্ঞাপন</span>
                </a>
                <a href="{{ route('display.index') }}" class="flex items-center gap-2 p-2.5 rounded-xl bg-teal-50 text-teal-700 font-bold hover:bg-teal-100 transition-colors">
                    <i class="fa-solid fa-images text-teal-600"></i>
                    <span>ডিসপ্লে বিজ্ঞাপন</span>
                </a>
            </div>

            <nav class="space-y-1 text-sm font-semibold text-slate-700">
                <a href="{{ route('home') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('home') ? 'bg-emerald-50 text-emerald-700 font-bold' : 'hover:bg-slate-100' }}">
                    <i class="fa-solid fa-house w-4 text-center text-slate-400"></i>
                    <span>হোম</span>
                </a>
                <a href="{{ route('designers.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('designers.*') ? 'bg-emerald-50 text-emerald-700 font-bold' : 'hover:bg-slate-100' }}">
                    <i class="fa-solid fa-paintbrush w-4 text-center text-slate-400"></i>
                    <span>ডিজাইনার খুঁজুন</span>
                </a>
                <a href="{{ route('pricing') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('pricing') ? 'bg-emerald-50 text-emerald-700 font-bold' : 'hover:bg-slate-100' }}">
                    <i class="fa-solid fa-tags w-4 text-center text-slate-400"></i>
                    <span>বিজ্ঞাপনের মূল্য তালিকা</span>
                </a>
                <a href="{{ route('track') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('track') ? 'bg-emerald-50 text-emerald-700 font-bold' : 'hover:bg-slate-100' }}">
                    <i class="fa-solid fa-satellite-dish w-4 text-center text-slate-400"></i>
                    <span>বিজ্ঞাপন ট্র্যাকিং</span>
                </a>
                <a href="{{ route('faq') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('faq') ? 'bg-emerald-50 text-emerald-700 font-bold' : 'hover:bg-slate-100' }}">
                    <i class="fa-solid fa-circle-question w-4 text-center text-slate-400"></i>
                    <span>প্রশ্নোত্তর (FAQ)</span>
                </a>
                <a href="{{ route('about') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('about') ? 'bg-emerald-50 text-emerald-700 font-bold' : 'hover:bg-slate-100' }}">
                    <i class="fa-solid fa-circle-info w-4 text-center text-slate-400"></i>
                    <span>আমাদের সম্পর্কে</span>
                </a>
            </nav>

            <div class="pt-3 border-t border-slate-100 flex flex-col gap-2">
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="w-full text-center py-2.5 rounded-xl bg-indigo-600 text-white font-bold text-sm shadow-xs">অ্যাডমিন ড্যাশবোর্ড</a>
                    @elseif(auth()->user()->isDesigner())
                        <a href="{{ route('designer.dashboard') }}" class="w-full text-center py-2.5 rounded-xl bg-teal-600 text-white font-bold text-sm shadow-xs">ডিজাইনার ড্যাশবোর্ড</a>
                    @else
                        <a href="{{ route('client.dashboard') }}" class="w-full text-center py-2.5 rounded-xl bg-emerald-600 text-white font-bold text-sm shadow-xs">আমার অ্যাকাউন্ট</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-center py-2 text-rose-600 hover:bg-rose-50 rounded-xl font-bold text-sm transition-colors">লগআউট</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="w-full inline-flex items-center justify-center gap-2 py-3 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-bold text-sm transition-all shadow-sm">
                        <i class="fa-solid fa-arrow-right-to-bracket text-xs"></i>
                        <span>লগইন করুন</span>
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Global Flash Alerts (Only rendered when active alerts exist) -->
    @if(session('success') || session('error') || session('info') || $errors->any())
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 w-full">
            @if(session('success'))
                <div class="p-4 text-emerald-800 bg-emerald-50 border border-emerald-200 rounded-xl flex items-start gap-3 shadow-xs">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-lg mt-0.5"></i>
                    <div class="flex-1 text-sm font-medium leading-relaxed">{{ session('success') }}</div>
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 text-rose-800 bg-rose-50 border border-rose-200 rounded-xl flex items-start gap-3 shadow-xs">
                    <i class="fa-solid fa-circle-exclamation text-rose-600 text-lg mt-0.5"></i>
                    <div class="flex-1 text-sm font-medium leading-relaxed">{{ session('error') }}</div>
                </div>
            @endif

            @if(session('info'))
                <div class="p-4 text-sky-800 bg-sky-50 border border-sky-200 rounded-xl flex items-start gap-3 shadow-xs">
                    <i class="fa-solid fa-circle-info text-sky-600 text-lg mt-0.5"></i>
                    <div class="flex-1 text-sm font-medium leading-relaxed">{{ session('info') }}</div>
                </div>
            @endif

            @if ($errors->any())
                <div class="p-4 text-rose-800 bg-rose-50 border border-rose-200 rounded-xl flex items-start gap-3 shadow-xs">
                    <i class="fa-solid fa-triangle-exclamation text-rose-600 text-lg mt-0.5"></i>
                    <div class="flex-1 text-sm">
                        <div class="font-bold mb-1">অনুগ্রহ করে নিচের ভুলগুলো সংশোধন করুন:</div>
                        <ul class="list-disc list-inside space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    @endif

    <!-- Main Page Content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-950 text-slate-300 mt-16 pt-12 sm:pt-16 pb-24 sm:pb-12 border-t border-slate-800/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10 sm:space-y-12">
            
            <!-- Top Section: Brand & Trust Highlights -->
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 pb-8 border-b border-slate-800/70">
                <div class="space-y-3 max-w-xl">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo-icon.svg') }}" alt="Ads Bazar BD" class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl shadow-md object-contain shrink-0">
                        <div>
                            <div class="font-black text-2xl text-white tracking-tight flex items-center gap-2">
                                Ads Bazar BD
                                <span class="text-[10px] px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-400 font-bold border border-emerald-500/30">অফিসিয়াল</span>
                            </div>
                            <div class="text-[11px] text-slate-400 font-medium">সহজে জাতীয় সংবাদপত্রে বিজ্ঞাপন ও ডিজাইনার প্ল্যাটফর্ম</div>
                        </div>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-400 leading-relaxed">
                        এজেন্টের কাছে দৌড়াদৌড়ি ছাড়াই ঘরে বসে দেশের শীর্ষ সকল বাংলা ও ইংরেজি পত্রিকায় সহজে বিজ্ঞাপন দিন অথবা দক্ষ গ্রাফিক ডিজাইনার হায়ার করুন।
                    </p>
                </div>

                <!-- Trust Highlights -->
                <div class="flex flex-wrap items-center gap-2.5 sm:gap-3 text-xs w-full lg:w-auto">
                    <div class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-3.5 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-emerald-400 shadow-2xs font-semibold">
                        <i class="fa-solid fa-shield-halved text-sm"></i>
                        <span>১০০% এসক্রো সুরক্ষিত</span>
                    </div>
                    <div class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-3.5 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-teal-400 shadow-2xs font-semibold">
                        <i class="fa-solid fa-certificate text-sm"></i>
                        <span>ভেরিফাইড রেট চার্ট</span>
                    </div>
                    <div class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-3.5 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-indigo-400 shadow-2xs font-semibold">
                        <i class="fa-solid fa-headset text-sm"></i>
                        <span>সার্বক্ষণিক হেল্পলাইন</span>
                    </div>
                </div>
            </div>

            <!-- Middle Grid: 2-Cols on Mobile (Quick Links), Contact Card on Right -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 sm:gap-8 lg:gap-10">
                
                <!-- Col 1: বিজ্ঞাপন সেবা (Mobile Col 1) -->
                <div class="space-y-3">
                    <h4 class="text-white font-bold text-sm tracking-wide flex items-center gap-2 border-b border-slate-800/80 pb-2.5">
                        <i class="fa-solid fa-rectangle-ad text-emerald-400 text-xs"></i>
                        <span>বিজ্ঞাপন সেবা</span>
                    </h4>
                    <ul class="space-y-2 text-xs sm:text-sm text-slate-400">
                        <li><a href="{{ route('classified.index') }}" class="hover:text-emerald-400 transition-colors block py-1">শ্রেণীভুক্ত বিজ্ঞাপন</a></li>
                        <li><a href="{{ route('display.index') }}" class="hover:text-emerald-400 transition-colors block py-1">ডিসপ্লে বিজ্ঞাপন</a></li>
                        <li><a href="{{ route('designers.index') }}" class="hover:text-emerald-400 transition-colors block py-1">ডিজাইনার নিয়োগ</a></li>
                        <li><a href="{{ route('pricing') }}" class="hover:text-emerald-400 transition-colors block py-1">মূল্য তালিকা</a></li>
                        <li><a href="{{ route('track') }}" class="hover:text-emerald-400 transition-colors block py-1">বিজ্ঞাপন ট্র্যাকিং</a></li>
                    </ul>
                </div>

                <!-- Col 2: জনপ্রিয় সংবাদপত্র (Mobile Col 2) -->
                <div class="space-y-3">
                    <h4 class="text-white font-bold text-sm tracking-wide flex items-center gap-2 border-b border-slate-800/80 pb-2.5">
                        <i class="fa-solid fa-newspaper text-teal-400 text-xs"></i>
                        <span>শীর্ষ পত্রিকা</span>
                    </h4>
                    <ul class="space-y-2 text-xs sm:text-sm text-slate-400">
                        <li><span class="block py-1 hover:text-slate-200 transition-colors">প্রথম আলো</span></li>
                        <li><span class="block py-1 hover:text-slate-200 transition-colors">বাংলাদেশ প্রতিদিন</span></li>
                        <li><span class="block py-1 hover:text-slate-200 transition-colors">দ্য ডেইলি স্টার</span></li>
                        <li><span class="block py-1 hover:text-slate-200 transition-colors">দৈনিক সমকাল</span></li>
                        <li><span class="block py-1 hover:text-slate-200 transition-colors">দৈনিক ইত্তেফাক</span></li>
                    </ul>
                </div>

                <!-- Col 3: যোগাযোগ ও সরাসরি সহায়তা (Spans 2 cols on mobile) -->
                <div class="col-span-2 md:col-span-1 lg:col-span-2 space-y-3">
                    <h4 class="text-white font-bold text-sm tracking-wide flex items-center gap-2 border-b border-slate-800/80 pb-2.5">
                        <i class="fa-solid fa-headset text-indigo-400 text-xs"></i>
                        <span>যোগাযোগ ও সহায়তা</span>
                    </h4>

                    <!-- Contact Card Container -->
                    <div class="bg-slate-900/90 border border-slate-800 rounded-2xl p-4 sm:p-5 space-y-3.5 shadow-xs">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <!-- Direct Call Button -->
                            <a href="tel:{{ $cleanPhone }}" class="flex items-center gap-3 p-3 rounded-xl bg-slate-800/80 hover:bg-emerald-950/40 border border-slate-700/60 hover:border-emerald-500/50 transition-all group">
                                <div class="w-9 h-9 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                                    <i class="fa-solid fa-phone text-sm"></i>
                                </div>
                                <div class="min-w-0">
                                    <div class="text-[10px] text-slate-400 font-medium">জরুরি হেল্পলাইন</div>
                                    <div class="text-sm font-bold text-white group-hover:text-emerald-400 transition-colors">{{ $sitePhone }}</div>
                                </div>
                            </a>

                            <!-- WhatsApp Direct Chat Button -->
                            <a href="https://wa.me/{{ $waPhone }}" target="_blank" class="flex items-center gap-3 p-3 rounded-xl bg-slate-800/80 hover:bg-emerald-950/40 border border-slate-700/60 hover:border-emerald-500/50 transition-all group">
                                <div class="w-9 h-9 rounded-lg bg-emerald-500 text-white flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                                    <i class="fa-brands fa-whatsapp text-lg"></i>
                                </div>
                                <div class="min-w-0">
                                    <div class="text-[10px] text-slate-400 font-medium">সরাসরি চ্যাট</div>
                                    <div class="text-sm font-bold text-white group-hover:text-emerald-400 transition-colors">হোয়াটসঅ্যাপ সাপোর্ট</div>
                                </div>
                            </a>
                        </div>

                        <!-- Email & Office address -->
                        <div class="pt-2 border-t border-slate-800/80 flex flex-col sm:flex-row justify-between gap-2 text-xs text-slate-400">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-envelope text-emerald-400 shrink-0"></i>
                                <a href="mailto:{{ $siteEmail }}" class="hover:text-emerald-400 transition-colors">{{ $siteEmail }}</a>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-location-dot text-emerald-400 shrink-0"></i>
                                <span>{{ $siteAddress }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Partners Modern Strip -->
            <div class="bg-slate-900/60 border border-slate-800/80 rounded-2xl p-4 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs">
                <div class="flex items-center gap-2 text-slate-400 font-semibold">
                    <i class="fa-solid fa-lock text-emerald-400 text-xs"></i>
                    <span>নিরাপদ পেমেন্ট পার্টনার:</span>
                </div>
                <div class="flex flex-wrap items-center justify-center gap-2">
                    <span class="px-3 py-1 rounded-lg bg-slate-800 text-pink-400 font-bold border border-slate-700/60 text-[11px] inline-flex items-center gap-1.5">
                        <i class="fa-solid fa-mobile-screen-button"></i> বিকাশ (bKash)
                    </span>
                    <span class="px-3 py-1 rounded-lg bg-slate-800 text-orange-400 font-bold border border-slate-700/60 text-[11px] inline-flex items-center gap-1.5">
                        <i class="fa-solid fa-bolt"></i> নগদ (Nagad)
                    </span>
                    <span class="px-3 py-1 rounded-lg bg-slate-800 text-purple-400 font-bold border border-slate-700/60 text-[11px] inline-flex items-center gap-1.5">
                        <i class="fa-solid fa-rocket"></i> রকেট (Rocket)
                    </span>
                    <span class="px-3 py-1 rounded-lg bg-slate-800 text-sky-400 font-bold border border-slate-700/60 text-[11px] inline-flex items-center gap-1.5">
                        <i class="fa-solid fa-building-columns"></i> ব্যাংক ট্রান্সফার
                    </span>
                </div>
            </div>

            <!-- Bottom Legal Bar & Socials -->
            <div class="pt-4 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-slate-500 border-t border-slate-800/80">
                <div class="text-center md:text-left flex flex-col sm:flex-row items-center gap-1.5 sm:gap-3">
                    <div>
                        &copy; {{ date('Y') }} <strong class="text-slate-300">{{ $siteSettings['site_name'] ?? 'Ads Bazar BD Ltd.' }}</strong> সর্বস্বত্ব সংরক্ষিত।
                    </div>
                    <span class="hidden sm:inline text-slate-700">•</span>
                    <div class="text-slate-400 text-[11px] sm:text-xs">
                        Developed with <i class="fa-solid fa-heart text-rose-500 text-[10px]"></i> by 
                        <a href="https://extremecoder.net" target="_blank" rel="noopener noreferrer" class="text-emerald-400 hover:text-emerald-300 font-bold hover:underline transition-colors inline-flex items-center gap-1">
                            <span>Extremecoder.net</span>
                            <i class="fa-solid fa-arrow-up-right-from-square text-[9px] opacity-70"></i>
                        </a>
                    </div>
                </div>

                <!-- Social Media Badges -->
                <div class="flex items-center gap-2.5">
                    <a href="https://wa.me/{{ $waPhone }}" target="_blank" aria-label="WhatsApp" class="w-8 h-8 rounded-full bg-slate-800/80 hover:bg-emerald-600 hover:text-white text-slate-400 flex items-center justify-center transition-all shadow-xs">
                        <i class="fa-brands fa-whatsapp text-xs"></i>
                    </a>
                    <a href="#" aria-label="Facebook" class="w-8 h-8 rounded-full bg-slate-800/80 hover:bg-blue-600 hover:text-white text-slate-400 flex items-center justify-center transition-all shadow-xs">
                        <i class="fa-brands fa-facebook-f text-xs"></i>
                    </a>
                    <a href="#" aria-label="YouTube" class="w-8 h-8 rounded-full bg-slate-800/80 hover:bg-rose-600 hover:text-white text-slate-400 flex items-center justify-center transition-all shadow-xs">
                        <i class="fa-brands fa-youtube text-xs"></i>
                    </a>
                    <a href="#" aria-label="LinkedIn" class="w-8 h-8 rounded-full bg-slate-800/80 hover:bg-sky-600 hover:text-white text-slate-400 flex items-center justify-center transition-all shadow-xs">
                        <i class="fa-brands fa-linkedin-in text-xs"></i>
                    </a>
                </div>

                <!-- Quick Legal Links -->
                <div class="flex flex-wrap justify-center gap-4 text-slate-400">
                    <a href="{{ route('about') }}" class="hover:text-emerald-400 transition-colors">আমাদের সম্পর্কে</a>
                    <a href="{{ route('faq') }}" class="hover:text-emerald-400 transition-colors">শর্তাবলী</a>
                    <a href="{{ route('faq') }}" class="hover:text-emerald-400 transition-colors">গোপনীয়তা নীতি</a>
                </div>
            </div>

        </div>
    </footer>

    <!-- Floating Quick WhatsApp Button on Mobile/Desktop -->
    <a href="https://wa.me/{{ $waPhone }}" target="_blank" title="সরাসরি হোয়াটসঅ্যাপে যোগাযোগ করুন" class="fixed bottom-5 right-5 z-40 w-12 h-12 sm:w-14 sm:h-14 bg-emerald-500 hover:bg-emerald-600 active:scale-95 text-white rounded-full shadow-2xl flex items-center justify-center text-2xl sm:text-3xl transition-transform hover:scale-105">
        <i class="fa-brands fa-whatsapp"></i>
    </a>

    <!-- Mobile Menu Toggle Handler Script -->
    <script>
        function togglePublicMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            const icon = document.getElementById('mobileMenuIcon');
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                if (icon) {
                    icon.classList.remove('fa-bars');
                    icon.classList.add('fa-xmark');
                }
            } else {
                menu.classList.add('hidden');
                if (icon) {
                    icon.classList.remove('fa-xmark');
                    icon.classList.add('fa-bars');
                }
            }
        }

        // Close mobile menu on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const menu = document.getElementById('mobile-menu');
                if (menu && !menu.classList.contains('hidden')) {
                    togglePublicMobileMenu();
                }
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
