<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'সিস্টেম অ্যাডমিন ড্যাশবোর্ড - Reporter Ads')</title>

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
        body { font-family: 'Hind Siliguri', sans-serif; background-color: #0f172a; }
    </style>
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen flex">

    <!-- Admin Sidebar -->
    <aside class="w-64 bg-slate-950 border-r border-slate-800 flex flex-col shrink-0 min-h-screen">
        <!-- Sidebar Brand -->
        <div class="h-20 flex items-center gap-3 px-6 border-b border-slate-800/80">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-500 to-indigo-700 flex items-center justify-center text-white text-lg font-black shadow-md">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
            <div>
                <div class="font-extrabold text-lg text-white tracking-tight flex items-center gap-1.5">
                    Reporter <span class="text-[10px] px-1.5 py-0.5 rounded bg-indigo-500/20 text-indigo-400 font-bold uppercase">ADMIN</span>
                </div>
                <div class="text-[10px] text-slate-400">সেন্ট্রাল কন্ট্রোল প্যানেল</div>
            </div>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 px-4 py-6 space-y-1.5 text-xs font-semibold overflow-y-auto">
            <div class="text-[10px] uppercase font-bold text-slate-400 px-3 pb-1 tracking-wider">মেনু ও অ্যানালিটিক্স</div>
            
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white font-bold shadow-md' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white' }}">
                <i class="fa-solid fa-gauge-high w-4 text-center"></i>
                <span>ওভারভিউ ড্যাশবোর্ড</span>
            </a>

            <div class="text-[10px] uppercase font-bold text-slate-400 px-3 pt-4 pb-1 tracking-wider">বিজ্ঞাপন ও বুকিং</div>

            <a href="{{ route('admin.classified') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.classified*') ? 'bg-indigo-600 text-white font-bold shadow-md' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white' }}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-list-check w-4 text-center"></i>
                    <span>শ্রেণীভুক্ত বিজ্ঞাপন</span>
                </div>
                @php $pCls = \App\Models\ClassifiedAd::where('status', 'pending')->count(); @endphp
                @if($pCls > 0)
                    <span class="px-2 py-0.5 rounded-full text-[10px] bg-amber-400 text-slate-950 font-black">{{ $pCls }}</span>
                @endif
            </a>

            <a href="{{ route('admin.display') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.display*') ? 'bg-indigo-600 text-white font-bold shadow-md' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white' }}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-images w-4 text-center"></i>
                    <span>ডিসপ্লে বিজ্ঞাপন</span>
                </div>
                @php $pDsp = \App\Models\DisplayAd::where('status', 'pending')->count(); @endphp
                @if($pDsp > 0)
                    <span class="px-2 py-0.5 rounded-full text-[10px] bg-teal-400 text-slate-950 font-black">{{ $pDsp }}</span>
                @endif
            </a>

            <a href="{{ route('admin.payments') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.payments*') ? 'bg-indigo-600 text-white font-bold shadow-md' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white' }}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-money-bill-transfer w-4 text-center"></i>
                    <span>পেমেন্ট ভেরিফিকেশন</span>
                </div>
                @php $pPay = \App\Models\PaymentRecord::where('status', 'pending')->count(); @endphp
                @if($pPay > 0)
                    <span class="px-2 py-0.5 rounded-full text-[10px] bg-emerald-400 text-slate-950 font-black">{{ $pPay }}</span>
                @endif
            </a>

            <div class="text-[10px] uppercase font-bold text-slate-400 px-3 pt-4 pb-1 tracking-wider">মার্কেটপ্লেস ও কনফিগারেশন</div>

            <a href="{{ route('admin.orders') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.orders*') ? 'bg-indigo-600 text-white font-bold shadow-md' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white' }}">
                <i class="fa-solid fa-handshake w-4 text-center"></i>
                <span>ডিজাইন এসক্রো অর্ডার</span>
            </a>

            <a href="{{ route('admin.newspapers') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.newspapers*') ? 'bg-indigo-600 text-white font-bold shadow-md' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white' }}">
                <i class="fa-solid fa-newspaper w-4 text-center"></i>
                <span>সংবাদপত্র ও রেট চার্ট</span>
            </a>

            <a href="{{ route('admin.categories') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.categories*') ? 'bg-indigo-600 text-white font-bold shadow-md' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white' }}">
                <i class="fa-solid fa-tags w-4 text-center"></i>
                <span>বিজ্ঞাপনের ক্যাটাগরি</span>
            </a>

            <a href="{{ route('admin.designers') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.designers*') ? 'bg-indigo-600 text-white font-bold shadow-md' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white' }}">
                <i class="fa-solid fa-paintbrush w-4 text-center"></i>
                <span>গ্রাফিক ডিজাইনার্স</span>
            </a>

            <a href="{{ route('admin.users') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.users*') ? 'bg-indigo-600 text-white font-bold shadow-md' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white' }}">
                <i class="fa-solid fa-users w-4 text-center"></i>
                <span>গ্রাহক ব্যবহারকারী</span>
            </a>

            <a href="{{ route('admin.settings') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.settings*') ? 'bg-indigo-600 text-white font-bold shadow-md' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white' }}">
                <i class="fa-solid fa-gear w-4 text-center"></i>
                <span>সিস্টেম সেটিংস</span>
            </a>
        </nav>

        <!-- Admin Profile Bottom -->
        <div class="p-4 border-t border-slate-800/80 bg-slate-950/60 flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold text-xs">
                    {{ mb_substr(auth()->user()->name, 0, 1) }}
                </div>
                <div class="truncate max-w-[120px]">
                    <div class="text-xs font-bold text-white truncate">{{ auth()->user()->name }}</div>
                    <div class="text-[10px] text-slate-400">Super Admin</div>
                </div>
            </div>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" title="লগআউট" class="p-2 text-slate-400 hover:text-rose-400 transition-colors">
                    <i class="fa-solid fa-arrow-right-from-bracket text-xs"></i>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Shell -->
    <div class="flex-1 flex flex-col min-w-0 bg-slate-900 overflow-y-auto">
        <!-- Top Navbar -->
        <header class="h-20 bg-slate-950/70 backdrop-blur-md border-b border-slate-800 px-6 sm:px-8 flex justify-between items-center sticky top-0 z-30">
            <div class="flex items-center gap-3">
                <span class="text-xs text-slate-400 font-medium">ড্যাশবোর্ড /</span>
                <span class="text-sm font-bold text-white">@yield('page_title', 'অ্যাডমিন ওভারভিউ')</span>
            </div>

            <div class="flex items-center gap-4">
                <a href="{{ route('home') }}" target="_blank" class="px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-bold transition-colors flex items-center gap-1.5">
                    <i class="fa-solid fa-arrow-up-right-from-square text-[11px] text-emerald-400"></i>
                    <span>ভিজিট ওয়েবসাইট</span>
                </a>
            </div>
        </header>

        <!-- Flash messages -->
        <div class="px-6 sm:px-8 pt-6">
            @if(session('success'))
                <div class="p-4 mb-4 text-emerald-300 bg-emerald-950/60 border border-emerald-800 rounded-xl flex items-center gap-3 text-xs font-medium">
                    <i class="fa-solid fa-circle-check text-emerald-400 text-base"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 mb-4 text-rose-300 bg-rose-950/60 border border-rose-800 rounded-xl flex items-center gap-3 text-xs font-medium">
                    <i class="fa-solid fa-circle-exclamation text-rose-400 text-base"></i>
                    <div>{{ session('error') }}</div>
                </div>
            @endif
        </div>

        <!-- Page Body -->
        <main class="flex-1 p-6 sm:p-8">
            @yield('content')
        </main>
    </div>

</body>
</html>
