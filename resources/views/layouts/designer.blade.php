<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ডিজাইনার ড্যাশবোর্ড - Ads Bazar BD')</title>

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
    </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex">

    <!-- Designer Sidebar -->
    <aside class="w-64 bg-slate-900 text-white flex flex-col shrink-0 min-h-screen border-r border-slate-800">
        <div class="h-20 flex items-center gap-3 px-6 border-b border-slate-800">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-teal-500 to-emerald-400 flex items-center justify-center text-slate-950 text-lg font-black shadow-md">
                <i class="fa-solid fa-paintbrush"></i>
            </div>
            <div>
                <div class="font-extrabold text-lg text-white tracking-tight flex items-center gap-1.5">
                    Ads Bazar BD <span class="text-[10px] px-1.5 py-0.5 rounded bg-teal-500/20 text-teal-400 font-bold uppercase">CREATIVE</span>
                </div>
                <div class="text-[10px] text-slate-400">ডিজাইনার পোর্টাল</div>
            </div>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-1.5 text-xs font-semibold overflow-y-auto">
            <div class="text-[10px] uppercase font-bold text-slate-400 px-3 pb-1 tracking-wider">ওয়ার্কস্পেস</div>

            <a href="{{ route('designer.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('designer.dashboard') ? 'bg-teal-600 text-white font-bold shadow-md' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-gauge-high w-4 text-center"></i>
                <span>ওভারভিউ ড্যাশবোর্ড</span>
            </a>

            <a href="{{ route('designer.orders') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('designer.orders*') ? 'bg-teal-600 text-white font-bold shadow-md' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-layer-group w-4 text-center"></i>
                <span>অ্যাসাইন করা অর্ডারসমূহ</span>
            </a>

            <div class="text-[10px] uppercase font-bold text-slate-400 px-3 pt-4 pb-1 tracking-wider">প্রোফাইল ও সেটিংস</div>

            <a href="{{ route('designer.profile') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('designer.profile') ? 'bg-teal-600 text-white font-bold shadow-md' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-user-pen w-4 text-center"></i>
                <span>প্রোফাইল ও স্কিল এডিট</span>
            </a>

            @if(auth()->user()->designerProfile)
                <a href="{{ route('designers.show', auth()->user()->designerProfile->id) }}" target="_blank" class="flex items-center gap-3 px-3 py-2 rounded-xl text-slate-400 hover:bg-slate-800 hover:text-teal-400 transition-colors">
                    <i class="fa-solid fa-eye w-4 text-center"></i>
                    <span>পাবলিক প্রোফাইল দেখুন</span>
                </a>
            @endif
        </nav>

        <div class="p-4 border-t border-slate-800 bg-slate-950 flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-full bg-teal-500 text-slate-950 flex items-center justify-center font-bold text-xs">
                    {{ mb_substr(auth()->user()->name, 0, 1) }}
                </div>
                <div class="truncate max-w-[120px]">
                    <div class="text-xs font-bold text-white truncate">{{ auth()->user()->name }}</div>
                    <div class="text-[10px] text-teal-400 font-bold">৳{{ number_format(auth()->user()->balance, 0) }} ব্যালেন্স</div>
                </div>
            </div>
            <form action="{{ route('designer.logout') }}" method="POST">
                @csrf
                <button type="submit" title="লগআউট" class="p-2 text-slate-400 hover:text-rose-400 transition-colors">
                    <i class="fa-solid fa-arrow-right-from-bracket text-xs"></i>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 bg-slate-50 overflow-y-auto">
        <header class="h-20 bg-white border-b border-slate-200 px-6 sm:px-8 flex justify-between items-center sticky top-0 z-30">
            <div class="flex items-center gap-3">
                <span class="text-xs text-slate-400 font-medium">ডিজাইনার প্যানেল /</span>
                <span class="text-sm font-bold text-slate-900">@yield('page_title', 'ওভারভিউ')</span>
            </div>

            <div class="flex items-center gap-4">
                <div class="hidden sm:flex items-center gap-2 px-3 py-1.5 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-lg text-xs font-bold">
                    <i class="fa-solid fa-shield-halved text-emerald-600"></i> এসক্রো প্রটেকশন অন
                </div>
                <a href="{{ route('home') }}" target="_blank" class="px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-colors flex items-center gap-1.5">
                    <i class="fa-solid fa-arrow-up-right-from-square text-[11px] text-teal-600"></i>
                    <span>পোর্টাল</span>
                </a>
            </div>
        </header>

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

        <main class="flex-1 p-6 sm:p-8">
            @yield('content')
        </main>
    </div>

</body>
</html>
