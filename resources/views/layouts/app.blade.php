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

    <!-- Top Announcement & Support Bar -->
    <div class="bg-slate-900 text-slate-300 text-xs sm:text-sm py-2 px-4 border-b border-slate-800">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-2">
            <div class="flex items-center gap-4 flex-wrap justify-center sm:justify-start">
                <span><i class="fa-solid fa-phone text-emerald-400 mr-1.5"></i> হেল্পলাইন: <strong>01854-820303</strong></span>
                <span class="hidden md:inline text-slate-600">|</span>
                <span class="hidden md:inline"><i class="fa-solid fa-envelope text-emerald-400 mr-1.5"></i> contact@adsbazarbd.com</span>
                <span class="hidden lg:inline text-slate-600">|</span>
                <span class="hidden lg:inline"><i class="fa-solid fa-shield-halved text-emerald-400 mr-1.5"></i> এসক্রো পদ্ধতিতে ১০০% নিরাপদ ডিজাইন সার্ভিস</span>
            </div>
            <div class="flex items-center gap-3">
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
                    <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                        <img src="{{ asset('images/logo-icon.svg') }}" alt="Ads Bazar BD" class="w-11 h-11 rounded-xl shadow-md group-hover:scale-105 transition-transform object-contain">
                        <div>
                            <div class="font-extrabold text-2xl tracking-tight text-slate-900 flex items-center gap-2">
                                <span>Ads Bazar BD</span>
                                <span class="text-xs px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 font-semibold uppercase tracking-wider">অ্যাডস বাজার</span>
                            </div>
                            <div class="text-[11px] text-slate-500 font-medium">সহজে সংবাদপত্রে বিজ্ঞাপন ও ডিজাইনার প্ল্যাটফর্ম</div>
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

                <!-- Auth Buttons / User Profile -->
                <div class="hidden sm:flex items-center gap-3">
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
                        <a href="{{ route('login') }}" class="text-sm font-medium text-slate-700 hover:text-emerald-600 px-3 py-2">
                            লগইন
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg shadow-xs transition-colors">
                            <i class="fa-solid fa-user-plus text-xs"></i> সাইনআপ
                        </a>
                    @endauth
                </div>

                <!-- Mobile Menu Toggle Button -->
                <button type="button" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" class="lg:hidden p-2 text-slate-600 hover:text-slate-900 rounded-lg border border-slate-200">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu Drawer -->
        <div id="mobile-menu" class="hidden lg:hidden border-t border-slate-200 bg-white px-4 py-3 space-y-2 text-sm">
            <a href="{{ route('home') }}" class="block py-2 text-slate-700 font-medium">হোম</a>
            <a href="{{ route('classified.index') }}" class="block py-2 text-emerald-600 font-medium">শ্রেণীভুক্ত বিজ্ঞাপন দিন</a>
            <a href="{{ route('display.index') }}" class="block py-2 text-emerald-600 font-medium">ডিসপ্লে বিজ্ঞাপন দিন</a>
            <a href="{{ route('designers.index') }}" class="block py-2 text-slate-700 font-medium">ডিজাইনার খুঁজুন</a>
            <a href="{{ route('pricing') }}" class="block py-2 text-slate-700 font-medium">মূল্য তালিকা</a>
            <a href="{{ route('track') }}" class="block py-2 text-slate-700 font-medium">বিজ্ঞাপন ট্র্যাকিং</a>
            <a href="{{ route('faq') }}" class="block py-2 text-slate-700 font-medium">প্রশ্নোত্তর (FAQ)</a>
            <a href="{{ route('about') }}" class="block py-2 text-slate-700 font-medium">আমাদের সম্পর্কে</a>
            <div class="pt-3 border-t border-slate-100 flex flex-col gap-2">
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="w-full text-center py-2 rounded-lg bg-indigo-50 text-indigo-700 font-medium">অ্যাডমিন ড্যাশবোর্ড</a>
                    @elseif(auth()->user()->isDesigner())
                        <a href="{{ route('designer.dashboard') }}" class="w-full text-center py-2 rounded-lg bg-teal-50 text-teal-700 font-medium">ডিজাইনার ড্যাশবোর্ড</a>
                    @else
                        <a href="{{ route('client.dashboard') }}" class="w-full text-center py-2 rounded-lg bg-emerald-50 text-emerald-700 font-medium">আমার অ্যাকাউন্ট</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-center py-2 text-rose-600 font-medium">লগআউট</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="w-full text-center py-2 rounded-lg border border-slate-300 text-slate-700 font-medium">লগইন</a>
                    <a href="{{ route('register') }}" class="w-full text-center py-2 rounded-lg bg-emerald-600 text-white font-medium">নতুন অ্যাকাউন্ট খুলুন</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Global Flash Alerts -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
        @if(session('success'))
            <div class="p-4 mb-4 text-emerald-800 bg-emerald-50 border border-emerald-200 rounded-xl flex items-start gap-3 shadow-xs">
                <i class="fa-solid fa-circle-check text-emerald-600 text-lg mt-0.5"></i>
                <div class="flex-1 text-sm font-medium leading-relaxed">{{ session('success') }}</div>
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 mb-4 text-rose-800 bg-rose-50 border border-rose-200 rounded-xl flex items-start gap-3 shadow-xs">
                <i class="fa-solid fa-circle-exclamation text-rose-600 text-lg mt-0.5"></i>
                <div class="flex-1 text-sm font-medium leading-relaxed">{{ session('error') }}</div>
            </div>
        @endif

        @if(session('info'))
            <div class="p-4 mb-4 text-sky-800 bg-sky-50 border border-sky-200 rounded-xl flex items-start gap-3 shadow-xs">
                <i class="fa-solid fa-circle-info text-sky-600 text-lg mt-0.5"></i>
                <div class="flex-1 text-sm font-medium leading-relaxed">{{ session('info') }}</div>
            </div>
        @endif

        @if ($errors->any())
            <div class="p-4 mb-4 text-rose-800 bg-rose-50 border border-rose-200 rounded-xl flex items-start gap-3 shadow-xs">
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

    <!-- Main Page Content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-300 mt-16 pt-16 pb-12 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 pb-12 border-b border-slate-800">
                <!-- Col 1: Brand Info -->
                <div class="lg:col-span-2 space-y-4">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo-icon.svg') }}" alt="Ads Bazar BD" class="w-11 h-11 rounded-xl shadow-md object-contain">
                        <div class="font-extrabold text-2xl text-white tracking-tight flex items-center gap-2">
                            <span>Ads Bazar BD</span>
                            <span class="text-xs px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-400 font-normal">অ্যাডস বাজার বিডি</span>
                        </div>
                    </div>
                    <p class="text-sm text-slate-400 leading-relaxed pr-6">
                        Ads Bazar BD হলো বাংলাদেশের শীর্ষস্থানীয় অনলাইন সংবাদপত্রে বিজ্ঞাপন প্রকাশনা ও গ্রাফিক ডিজাইনার প্ল্যাটফর্ম। এজেন্ট খোঁজার ঝামেলা ছাড়াই ঘরে বসে দেশের শীর্ষ সকল বাংলা ও ইংরেজি পত্রিকায় সহজে বিজ্ঞাপন বুকিং দিন।
                    </p>
                    <div class="flex items-center gap-3 pt-2 text-slate-400">
                        <span class="text-xs uppercase tracking-wider text-slate-500 font-semibold">পেমেন্ট পার্টনার:</span>
                        <span class="px-2 py-1 bg-slate-800 text-pink-400 rounded text-xs font-bold">বিকাশ (bKash)</span>
                        <span class="px-2 py-1 bg-slate-800 text-orange-400 rounded text-xs font-bold">নগদ (Nagad)</span>
                        <span class="px-2 py-1 bg-slate-800 text-purple-400 rounded text-xs font-bold">রকেট (Rocket)</span>
                        <span class="px-2 py-1 bg-slate-800 text-sky-400 rounded text-xs font-bold">ব্যাংক ট্রান্সফার</span>
                    </div>
                </div>

                <!-- Col 2: Services -->
                <div>
                    <h4 class="text-white font-bold text-base mb-4">বিজ্ঞাপন সেবা</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('classified.index') }}" class="hover:text-emerald-400 transition-colors">শ্রেণীভুক্ত বিজ্ঞাপন (Classified)</a></li>
                        <li><a href="{{ route('display.index') }}" class="hover:text-emerald-400 transition-colors">ডিসপ্লে বিজ্ঞাপন (Display Ads)</a></li>
                        <li><a href="{{ route('designers.index') }}" class="hover:text-emerald-400 transition-colors">গ্রাফিক ডিজাইনার হায়ার</a></li>
                        <li><a href="{{ route('pricing') }}" class="hover:text-emerald-400 transition-colors">বিজ্ঞাপনের মূল্য তালিকা</a></li>
                        <li><a href="{{ route('track') }}" class="hover:text-emerald-400 transition-colors">বিজ্ঞাপনের লাইভ স্ট্যাটাস</a></li>
                    </ul>
                </div>

                <!-- Col 3: Newspapers -->
                <div>
                    <h4 class="text-white font-bold text-base mb-4">জনপ্রিয় সংবাদপত্র</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><span class="text-slate-400">দৈনিক প্রথম আলো</span></li>
                        <li><span class="text-slate-400">বাংলাদেশ প্রতিদিন</span></li>
                        <li><span class="text-slate-400">দ্য ডেইলি স্টার</span></li>
                        <li><span class="text-slate-400">দৈনিক সমকাল</span></li>
                        <li><span class="text-slate-400">দৈনিক ইত্তেফাক</span></li>
                        <li><span class="text-slate-400">কালের কণ্ঠ ও অন্যান্য</span></li>
                    </ul>
                </div>

                <!-- Col 4: Contact & Office -->
                <div>
                    <h4 class="text-white font-bold text-base mb-4">যোগাযোগ ও সহায়তা</h4>
                    <ul class="space-y-3 text-sm text-slate-400">
                        <li class="flex items-start gap-2.5">
                            <i class="fa-solid fa-phone text-emerald-400 mt-1"></i>
                            <div>
                                <div class="font-bold text-white">01854-820303</div>
                                <div class="text-xs text-slate-500">সকাল ৯টা - রাত ১০টা</div>
                            </div>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-envelope text-emerald-400"></i>
                            <span>contact@adsbazarbd.com</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <i class="fa-solid fa-location-dot text-emerald-400 mt-1"></i>
                            <span>বাড়ি # ১২, রোড # ০৫, ধানমন্ডি, ঢাকা-১২০৫</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Legal Bar -->
            <div class="pt-8 flex flex-col sm:flex-row justify-between items-center gap-4 text-xs text-slate-500">
                <div>
                    &copy; {{ date('Y') }} Ads Bazar BD Ltd. সর্বস্বত্ব সংরক্ষিত।
                </div>
                <div class="flex gap-6">
                    <a href="{{ route('about') }}" class="hover:text-slate-400">আমাদের সম্পর্কে</a>
                    <a href="{{ route('faq') }}" class="hover:text-slate-400">শর্তাবলী ও নিয়মাবলী</a>
                    <a href="{{ route('faq') }}" class="hover:text-slate-400">গোপনীয়তা নীতি</a>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
