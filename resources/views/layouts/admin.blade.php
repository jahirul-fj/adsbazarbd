<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'সিস্টেম অ্যাডমিন ড্যাশবোর্ড - Ads Bazar BD')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Tailwind CSS -->
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

    <!-- Mobile Backdrop Overlay -->
    <div id="sidebarBackdrop" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-900/50 z-30 hidden md:hidden transition-opacity"></div>

    <!-- Admin Sidebar (Light Modern & Fixed) -->
    <aside id="mainSidebar" class="fixed inset-y-0 left-0 w-64 h-screen bg-white border-r border-slate-200 flex flex-col z-40 shadow-xs -translate-x-full md:translate-x-0 transition-transform duration-200 ease-in-out">
        <!-- Sidebar Brand -->
        <div class="h-20 shrink-0 flex items-center justify-between px-6 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-600 to-indigo-700 flex items-center justify-center text-white text-lg font-black shadow-md">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <div>
                    <div class="font-extrabold text-lg text-slate-900 tracking-tight flex items-center gap-1.5">
                        Ads Bazar BD <span class="text-[10px] px-1.5 py-0.5 rounded bg-indigo-50 text-indigo-700 font-bold uppercase border border-indigo-200">ADMIN</span>
                    </div>
                    <div class="text-[10px] text-slate-500">সেন্ট্রাল কন্ট্রোল প্যানেল</div>
                </div>
            </div>
            <button onclick="toggleSidebar()" type="button" aria-label="ক্লোজ মেনু" class="md:hidden text-slate-400 hover:text-slate-600 p-1">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 px-4 py-6 space-y-1.5 text-xs font-semibold overflow-y-auto custom-sidebar-scroll">
            <div class="text-[10px] uppercase font-bold text-slate-400 px-3 pb-1 tracking-wider">মেনু ও অ্যানালিটিক্স</div>
            
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white font-bold shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-indigo-600' }}">
                <i class="fa-solid fa-gauge-high w-4 text-center"></i>
                <span>ওভারভিউ ড্যাশবোর্ড</span>
            </a>

            <div class="text-[10px] uppercase font-bold text-slate-400 px-3 pt-4 pb-1 tracking-wider">বিজ্ঞাপন ও বুকিং</div>

            <a href="{{ route('admin.classified') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.classified*') ? 'bg-indigo-600 text-white font-bold shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-indigo-600' }}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-list-check w-4 text-center"></i>
                    <span>শ্রেণীভুক্ত বিজ্ঞাপন</span>
                </div>
                @php $pCls = \App\Models\ClassifiedAd::where('status', 'pending')->count(); @endphp
                @if($pCls > 0)
                    <span class="px-2 py-0.5 rounded-full text-[10px] bg-amber-100 text-amber-800 border border-amber-200 font-bold">{{ $pCls }}</span>
                @endif
            </a>

            <a href="{{ route('admin.display') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.display*') ? 'bg-indigo-600 text-white font-bold shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-indigo-600' }}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-images w-4 text-center"></i>
                    <span>ডিসপ্লে বিজ্ঞাপন</span>
                </div>
                @php $pDsp = \App\Models\DisplayAd::where('status', 'pending')->count(); @endphp
                @if($pDsp > 0)
                    <span class="px-2 py-0.5 rounded-full text-[10px] bg-teal-100 text-teal-800 border border-teal-200 font-bold">{{ $pDsp }}</span>
                @endif
            </a>

            <a href="{{ route('admin.payments') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.payments*') ? 'bg-indigo-600 text-white font-bold shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-indigo-600' }}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-money-bill-transfer w-4 text-center"></i>
                    <span>পেমেন্ট ভেরিফিকেশন</span>
                </div>
                @php $pPay = \App\Models\PaymentRecord::where('status', 'pending')->count(); @endphp
                @if($pPay > 0)
                    <span class="px-2 py-0.5 rounded-full text-[10px] bg-emerald-100 text-emerald-800 border border-emerald-200 font-bold">{{ $pPay }}</span>
                @endif
            </a>

            <a href="{{ route('admin.withdrawals') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.withdrawals*') ? 'bg-indigo-600 text-white font-bold shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-indigo-600' }}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-wallet w-4 text-center"></i>
                    <span>উইথড্র রিকোয়েস্ট</span>
                </div>
                @php $pWth = \App\Models\WithdrawalRequest::where('status', 'pending')->count(); @endphp
                @if($pWth > 0)
                    <span class="px-2 py-0.5 rounded-full text-[10px] bg-rose-100 text-rose-800 border border-rose-200 font-bold">{{ $pWth }}</span>
                @endif
            </a>

            <div class="text-[10px] uppercase font-bold text-slate-400 px-3 pt-4 pb-1 tracking-wider">মার্কেটপ্লেস ও কনফিগারেশন</div>

            <a href="{{ route('admin.orders') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.orders*') ? 'bg-indigo-600 text-white font-bold shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-indigo-600' }}">
                <i class="fa-solid fa-handshake w-4 text-center"></i>
                <span>ডিজাইন এসক্রো অর্ডার</span>
            </a>

            <a href="{{ route('admin.newspapers') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.newspapers*') ? 'bg-indigo-600 text-white font-bold shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-indigo-600' }}">
                <i class="fa-solid fa-newspaper w-4 text-center"></i>
                <span>সংবাদপত্র ও রেট চার্ট</span>
            </a>

            <a href="{{ route('admin.categories') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.categories*') ? 'bg-indigo-600 text-white font-bold shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-indigo-600' }}">
                <i class="fa-solid fa-tags w-4 text-center"></i>
                <span>বিজ্ঞাপনের ক্যাটাগরি</span>
            </a>

            <a href="{{ route('admin.designers') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.designers*') ? 'bg-indigo-600 text-white font-bold shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-indigo-600' }}">
                <i class="fa-solid fa-paintbrush w-4 text-center"></i>
                <span>গ্রাফিক ডিজাইনার্স</span>
            </a>

            <a href="{{ route('admin.users') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.users*') ? 'bg-indigo-600 text-white font-bold shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-indigo-600' }}">
                <i class="fa-solid fa-users w-4 text-center"></i>
                <span>গ্রাহক ব্যবহারকারী</span>
            </a>

            <a href="{{ route('admin.settings') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.settings*') ? 'bg-indigo-600 text-white font-bold shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-indigo-600' }}">
                <i class="fa-solid fa-gear w-4 text-center"></i>
                <span>সিস্টেম সেটিংস</span>
            </a>

            <div class="text-[10px] uppercase font-bold text-slate-400 px-3 pt-4 pb-1 tracking-wider">অ্যাকাউন্ট ও নিরাপত্তা</div>

            <a href="{{ route('admin.profile') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.profile*') ? 'bg-indigo-600 text-white font-bold shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-indigo-600' }}">
                <i class="fa-solid fa-user-shield w-4 text-center"></i>
                <span>প্রোফাইল ও পাসওয়ার্ড</span>
            </a>
        </nav>

        <!-- Admin Profile Bottom (Pinned to bottom of sidebar) -->
        <div class="shrink-0 p-4 border-t border-slate-100 bg-slate-50/70 flex items-center justify-between">
            <a href="{{ route('admin.profile') }}" class="flex items-center gap-2.5 hover:opacity-80 transition-opacity">
                @if(auth()->user()->avatar_url)
                    <img src="{{ auth()->user()->avatar_url }}" alt="Avatar" class="w-8 h-8 rounded-full object-cover shadow-xs border border-slate-200">
                @else
                    <div class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold text-xs shadow-xs">
                        {{ mb_substr(auth()->user()->name, 0, 1) }}
                    </div>
                @endif
                <div class="truncate max-w-[120px]">
                    <div class="text-xs font-bold text-slate-900 truncate">{{ auth()->user()->name }}</div>
                    <div class="text-[10px] text-slate-400 font-medium">প্রোফাইল এডিট &rarr;</div>
                </div>
            </a>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" title="লগআউট" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors">
                    <i class="fa-solid fa-arrow-right-from-bracket text-xs"></i>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Shell (Light Background & Offset for Fixed Sidebar) -->
    <div class="flex-1 md:ml-64 flex flex-col min-w-0 bg-slate-50 min-h-screen">
        <!-- Top Navbar (Sticky Header) -->
        <header class="h-20 bg-white border-b border-slate-200 px-6 sm:px-8 flex justify-between items-center sticky top-0 z-20 shadow-2xs">
            <div class="flex items-center gap-3">
                <button onclick="toggleSidebar()" type="button" aria-label="মেনু খুলুন" class="md:hidden p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 mr-1 transition-colors">
                    <i class="fa-solid fa-bars text-sm"></i>
                </button>
                <span class="text-xs text-slate-400 font-medium hidden sm:inline">ড্যাশবোর্ড /</span>
                <span class="text-sm font-bold text-slate-900">@yield('page_title', 'অ্যাডমিন ওভারভিউ')</span>
            </div>

            <div class="flex items-center gap-4">
                <a href="{{ route('home') }}" target="_blank" class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-colors flex items-center gap-1.5 border border-slate-200/70">
                    <i class="fa-solid fa-arrow-up-right-from-square text-[11px] text-indigo-600"></i>
                    <span>ভিজিট ওয়েবসাইট</span>
                </a>
            </div>
        </header>

        <!-- Flash messages -->
        <div class="px-6 sm:px-8 pt-6">
            @if(session('success'))
                <div class="p-4 mb-4 text-emerald-800 bg-emerald-50 border border-emerald-200 rounded-xl flex items-center gap-3 text-xs font-medium">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 mb-4 text-rose-800 bg-rose-50 border border-rose-200 rounded-xl flex items-center gap-3 text-xs font-medium">
                    <i class="fa-solid fa-circle-exclamation text-rose-600 text-base"></i>
                    <div>{{ session('error') }}</div>
                </div>
            @endif
        </div>

        <!-- Page Body -->
        <main class="flex-1 p-6 sm:p-8">
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
            } else {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
            }
        }
    </script>
</body>
</html>
