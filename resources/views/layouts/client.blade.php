<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'গ্রাহক ড্যাশবোর্ড - Ads Bazar BD')</title>

    <!-- Favicon & Touch Icons -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <meta name="theme-color" content="#059669">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Hind Siliguri', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Hind Siliguri', sans-serif; background-color: #f8fafc; }
        .custom-sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }
        .custom-sidebar-scroll::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-sidebar-scroll::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, 0.35);
            border-radius: 8px;
        }
        .custom-sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background: rgba(100, 116, 139, 0.6);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex">

    <!-- Mobile Backdrop Overlay (< lg) -->
    <div id="sidebarBackdrop" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-30 hidden lg:hidden transition-opacity duration-200"></div>

    <!-- Client Sidebar (Fixed on Desktop, Slide-over on Mobile & Tablet) -->
    <aside id="mainSidebar" class="fixed inset-y-0 left-0 w-64 h-screen bg-white border-r border-slate-200 flex flex-col z-40 shadow-xl lg:shadow-xs -translate-x-full lg:translate-x-0 transition-transform duration-200 ease-in-out">
        <div class="h-20 shrink-0 flex items-center justify-between px-6 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo-icon.svg') }}" alt="Ads Bazar BD" class="w-10 h-10 rounded-xl shadow-md object-contain shrink-0">
                <div>
                    <div class="font-extrabold text-lg text-slate-900 tracking-tight flex items-center gap-1.5">
                        Ads Bazar BD <span class="text-[10px] px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-800 font-bold uppercase">গ্রাহক</span>
                    </div>
                    <div class="text-[10px] text-slate-500 font-medium">বিজ্ঞাপনদাতা ড্যাশবোর্ড</div>
                </div>
            </div>
            <button onclick="toggleSidebar()" type="button" aria-label="ক্লোজ মেনু" class="lg:hidden text-slate-400 hover:text-slate-700 hover:bg-slate-100 p-1.5 rounded-lg transition-colors">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-1.5 text-xs font-semibold overflow-y-auto custom-sidebar-scroll">
            <div class="text-[10px] uppercase font-bold text-slate-400 px-3 pb-1 tracking-wider">আমার অ্যাকাউন্ট</div>

            <a href="{{ route('client.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('client.dashboard') ? 'bg-emerald-600 text-white font-bold shadow-md' : 'text-slate-700 hover:bg-slate-100' }}">
                <i class="fa-solid fa-gauge-high w-4 text-center"></i>
                <span>ড্যাশবোর্ড ওভারভিউ</span>
            </a>

            <a href="{{ route('client.classified') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('client.classified') ? 'bg-emerald-600 text-white font-bold shadow-md' : 'text-slate-700 hover:bg-slate-100' }}">
                <i class="fa-solid fa-list-check w-4 text-center"></i>
                <span>আমার শ্রেণীভুক্ত বিজ্ঞাপন</span>
            </a>

            <a href="{{ route('client.display') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('client.display') ? 'bg-emerald-600 text-white font-bold shadow-md' : 'text-slate-700 hover:bg-slate-100' }}">
                <i class="fa-solid fa-images w-4 text-center"></i>
                <span>আমার ডিসপ্লে বিজ্ঞাপন</span>
            </a>

            <a href="{{ route('client.orders') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('client.orders*') ? 'bg-emerald-600 text-white font-bold shadow-md' : 'text-slate-700 hover:bg-slate-100' }}">
                <i class="fa-solid fa-palette w-4 text-center"></i>
                <span>ডিজাইন অর্ডার ও এসক্রো</span>
            </a>

            <a href="{{ route('client.profile') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('client.profile*') ? 'bg-emerald-600 text-white font-bold shadow-md' : 'text-slate-700 hover:bg-slate-100' }}">
                <i class="fa-solid fa-user-gear w-4 text-center"></i>
                <span>প্রোফাইল ও পাসওয়ার্ড</span>
            </a>

            <div class="text-[10px] uppercase font-bold text-slate-400 px-3 pt-4 pb-1 tracking-wider">বিজ্ঞাপন বুকিং ও সেবা</div>

            <a href="{{ route('classified.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 transition-colors">
                <i class="fa-solid fa-plus-circle w-4 text-center text-emerald-600"></i>
                <span>+ শ্রেণীভুক্ত বিজ্ঞাপন দিন</span>
            </a>

            <a href="{{ route('display.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-slate-600 hover:bg-teal-50 hover:text-teal-700 transition-colors">
                <i class="fa-solid fa-plus-circle w-4 text-center text-teal-600"></i>
                <span>+ ডিসপ্লে বিজ্ঞাপন দিন</span>
            </a>

            <a href="{{ route('designers.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-slate-600 hover:bg-indigo-50 hover:text-indigo-700 transition-colors">
                <i class="fa-solid fa-paintbrush w-4 text-center text-indigo-600"></i>
                <span>ডিজাইনার নিয়োগ করুন</span>
            </a>

            <a href="{{ route('track') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-slate-600 hover:bg-slate-100 transition-colors">
                <i class="fa-solid fa-satellite-dish w-4 text-center text-slate-400"></i>
                <span>বিজ্ঞাপন লাইভ ট্র্যাকিং</span>
            </a>
        </nav>

        <div class="shrink-0 p-4 border-t border-slate-100 bg-slate-50 flex items-center justify-between">
            <a href="{{ route('client.profile') }}" class="flex items-center gap-2.5 hover:opacity-80 transition-opacity min-w-0">
                @if(auth()->user()->avatar_url)
                    <img src="{{ auth()->user()->avatar_url }}" alt="Avatar" class="w-8 h-8 rounded-full object-cover shadow-xs border border-slate-200 shrink-0">
                @else
                    <div class="w-8 h-8 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold text-xs shrink-0">
                        {{ mb_substr(auth()->user()->name, 0, 1) }}
                    </div>
                @endif
                <div class="truncate max-w-[120px]">
                    <div class="text-xs font-bold text-slate-900 truncate">{{ auth()->user()->name }}</div>
                    <div class="text-[10px] text-slate-400">প্রোফাইল এডিট &rarr;</div>
                </div>
            </a>
            <form action="{{ route('client.logout') }}" method="POST">
                @csrf
                <button type="submit" title="লগআউট" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors">
                    <i class="fa-solid fa-arrow-right-from-bracket text-xs"></i>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area (Offset by sidebar width on lg screens) -->
    <div class="flex-1 lg:ml-64 flex flex-col min-w-0 bg-slate-50 min-h-screen">
        <header class="h-20 bg-white border-b border-slate-200 px-4 sm:px-6 lg:px-8 flex justify-between items-center sticky top-0 z-20 shadow-2xs">
            <div class="flex items-center gap-2 sm:gap-3 min-w-0">
                <button onclick="toggleSidebar()" type="button" aria-label="মেনু খুলুন" class="lg:hidden p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors shrink-0">
                    <i class="fa-solid fa-bars text-sm"></i>
                </button>
                <div class="min-w-0">
                    <span class="text-xs text-slate-400 font-medium hidden sm:inline">গ্রাহক ড্যাশবোর্ড / </span>
                    <span class="text-xs sm:text-sm font-bold text-slate-900 truncate inline-block max-w-[140px] sm:max-w-xs md:max-w-md">@yield('page_title', 'ওভারভিউ')</span>
                </div>
            </div>

            <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                <a href="{{ route('home') }}" target="_blank" class="px-2.5 sm:px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-colors flex items-center gap-1.5 border border-slate-200/70 shadow-2xs">
                    <i class="fa-solid fa-arrow-up-right-from-square text-[11px] text-emerald-600"></i>
                    <span class="hidden sm:inline">মূল ওয়েবসাইট</span>
                </a>

                <form action="{{ route('client.logout') }}" method="POST" class="inline lg:hidden">
                    @csrf
                    <button type="submit" title="লগআউট" class="p-2 text-slate-500 hover:text-rose-600 hover:bg-rose-50 rounded-xl border border-slate-200 transition-colors">
                        <i class="fa-solid fa-arrow-right-from-bracket text-xs"></i>
                    </button>
                </form>
            </div>
        </header>

        <div class="px-4 sm:px-6 lg:px-8 pt-4 sm:pt-6">
            @if(session('success'))
                <div class="p-4 mb-4 text-emerald-800 bg-emerald-50 border border-emerald-200 rounded-xl flex items-center gap-3 text-xs font-medium shadow-2xs">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-base shrink-0"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 mb-4 text-rose-800 bg-rose-50 border border-rose-200 rounded-xl flex items-center gap-3 text-xs font-medium shadow-2xs">
                    <i class="fa-solid fa-circle-exclamation text-rose-600 text-base shrink-0"></i>
                    <div>{{ session('error') }}</div>
                </div>
            @endif
        </div>

        <main class="flex-1 p-4 sm:p-6 lg:p-8">
            @yield('content')
        </main>
    </div>

    <!-- Mobile Sidebar Toggle Script -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('mainSidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            } else {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
                document.body.style.overflow = '';
            }
        }

        // Close sidebar on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const sidebar = document.getElementById('mainSidebar');
                if (sidebar && !sidebar.classList.contains('-translate-x-full') && window.innerWidth < 1024) {
                    toggleSidebar();
                }
            }
        });
    </script>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('mainSidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
            }
        }
    </script>
</body>
</html>
