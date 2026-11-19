@extends('layouts.designer')

@section('title', 'ডিজাইনার ড্যাশবোর্ড - Ads Bazar BD')
@section('page_title', 'ওভারভিউ ড্যাশবোর্ড')

@section('content')
<div class="space-y-8">
    <!-- Top Welcome Card -->
    <div class="bg-gradient-to-r from-teal-900 via-slate-900 to-slate-950 text-white rounded-3xl p-6 sm:p-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 shadow-xl border border-teal-500/20">
        <div class="space-y-1">
            <span class="text-xs font-semibold text-teal-400 uppercase tracking-wider">গ্রাফিক ডিজাইনার ওয়ার্কস্পেস</span>
            <h1 class="text-2xl sm:text-3xl font-black">স্বাগতম, {{ auth()->user()->name }}!</h1>
            <p class="text-xs text-slate-300">{{ $profile->tagline ?? 'প্রফেশনাল বিজ্ঞাপন ও ব্যানার ডিজাইনার' }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('designer.profile') }}" class="px-4 py-2.5 bg-teal-500 hover:bg-teal-400 text-slate-950 font-bold text-xs rounded-xl shadow-md transition-all flex items-center gap-1.5">
                <i class="fa-solid fa-user-pen"></i> প্রোফাইল এডিট
            </a>
            <a href="{{ route('designer.orders') }}" class="px-4 py-2.5 bg-white/10 hover:bg-white/20 text-white font-bold text-xs rounded-xl border border-white/20 transition-all flex items-center gap-1.5">
                <i class="fa-solid fa-layer-group"></i> সকল অর্ডার
            </a>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
            <div class="text-xs font-bold text-slate-400 uppercase tracking-wider">চলমান কাজ</div>
            <div class="text-3xl font-black text-slate-900 mt-1">{{ $activeOrdersCount }}</div>
            <div class="text-xs text-slate-500 mt-1">ক্লায়েন্টের অর্ডার ড্রাফট করুন</div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
            <div class="text-xs font-bold text-slate-400 uppercase tracking-wider">সম্পন্ন কাজ</div>
            <div class="text-3xl font-black text-emerald-600 mt-1">{{ $completedOrdersCount }}</div>
            <div class="text-xs text-slate-500 mt-1">সফলভাবে ডেলিভারি সম্পন্ন</div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex justify-between items-center">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">মোট ব্যালেন্স / আয়</span>
                    <span class="text-[10px] font-bold px-2 py-0.5 bg-teal-50 text-teal-700 rounded-full border border-teal-200">ফি: {{ $commissionPercent }}%</span>
                </div>
                <div class="text-3xl font-black text-teal-700 mt-1">৳{{ number_format(auth()->user()->balance, 2) }}</div>
                <div class="text-[11px] text-slate-500 mt-1">মিনিমাম উইথড্র: ৳{{ number_format($minWithdrawal) }}</div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100">
                <a href="{{ route('designer.withdrawals') }}" class="w-full inline-flex justify-center items-center gap-1.5 py-2 px-3 bg-teal-600 hover:bg-teal-700 text-white font-bold text-xs rounded-xl shadow-xs transition-colors">
                    <i class="fa-solid fa-money-bill-transfer"></i>
                    <span>উইথড্র রিকোয়েস্ট করুন</span>
                </a>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
            <div class="text-xs font-bold text-slate-400 uppercase tracking-wider">রেটিং ও ফিডব্যাক</div>
            <div class="text-3xl font-black text-amber-500 mt-1 flex items-center gap-1">
                <i class="fa-solid fa-star text-xl"></i> {{ number_format($profile->rating ?? 5.0, 1) }}
            </div>
            <div class="text-xs text-slate-500 mt-1">মোট {{ $profile->total_reviews ?? 0 }} টি রিভিউ</div>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex justify-between items-center">
            <h2 class="font-bold text-base text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-layer-group text-teal-600"></i> সাম্প্রতিক অ্যাসাইন করা অর্ডারসমূহ
            </h2>
            <a href="{{ route('designer.orders') }}" class="text-xs font-bold text-teal-600 hover:underline">সকল অর্ডার &rarr;</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm min-w-[700px]">
                <thead class="bg-slate-50 text-slate-500 uppercase text-[11px] font-bold">
                    <tr>
                        <th class="p-3.5">অর্ডার নং</th>
                        <th class="p-3.5">ক্লায়েন্টের নাম</th>
                        <th class="p-3.5">কাজের বিষয়</th>
                        <th class="p-3.5">সাইজ</th>
                        <th class="p-3.5">বাজেট</th>
                        <th class="p-3.5">স্ট্যাটাস</th>
                        <th class="p-3.5 text-right">অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentOrders as $order)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="p-3.5 font-mono font-bold text-slate-900">{{ $order->order_no }}</td>
                            <td class="p-3.5 font-bold text-slate-800">{{ $order->client->name }}</td>
                            <td class="p-3.5 font-medium max-w-xs truncate text-slate-700">{{ $order->title }}</td>
                            <td class="p-3.5 text-slate-600">{{ $order->ad_size_requirement }}</td>
                            <td class="p-3.5 font-bold text-emerald-700">৳{{ number_format($order->budget, 2) }}</td>
                            <td class="p-3.5">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $order->status === 'completed' ? 'bg-emerald-100 text-emerald-800' : 'bg-teal-100 text-teal-800' }}">
                                    {{ $order->status === 'draft_submitted' ? 'ড্রাফট পাঠানো হয়েছে' : ($order->status === 'completed' ? 'সম্পন্ন' : 'কাজ চলমান') }}
                                </span>
                            </td>
                            <td class="p-3.5 text-right">
                                <a href="{{ route('designer.order.show', $order->id) }}" class="px-3.5 py-1.5 bg-teal-600 hover:bg-teal-700 text-white font-bold text-xs rounded-lg shadow-xs transition-colors inline-flex items-center gap-1">
                                    <span>ওয়ার্কস্পেস</span>
                                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-xs text-slate-400">এখনো কোনো অর্ডার পাওয়া যায়নি।</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Withdrawals Section -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex justify-between items-center">
            <h2 class="font-bold text-base text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-clock-rotate-left text-teal-600"></i> সাম্প্রতিক টাকা উত্তোলনের আবেদনসমূহ
            </h2>
            <a href="{{ route('designer.withdrawals') }}" class="text-xs font-bold text-teal-600 hover:underline">উইথড্রয়াল হিস্ট্রি &rarr;</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm min-w-[700px]">
                <thead class="bg-slate-50 text-slate-500 uppercase text-[11px] font-bold">
                    <tr>
                        <th class="p-3.5">রিকোয়েস্ট নং</th>
                        <th class="p-3.5">মেথড ও নম্বর</th>
                        <th class="p-3.5">পরিমাণ</th>
                        <th class="p-3.5">স্ট্যাটাস</th>
                        <th class="p-3.5">ট্রানজেকশন আইডি</th>
                        <th class="p-3.5">তারিখ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentWithdrawals as $req)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="p-3.5 font-mono font-bold text-slate-900">{{ $req->request_no }}</td>
                            <td class="p-3.5">
                                <span class="font-bold text-slate-800 uppercase">{{ $req->payment_method }}</span>
                                <div class="text-[11px] text-slate-500 font-mono">{{ $req->account_number }}</div>
                            </td>
                            <td class="p-3.5 font-black text-slate-900">৳{{ number_format($req->amount, 2) }}</td>
                            <td class="p-3.5">
                                @if($req->status === 'approved')
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">অনুমোদিত (পেইড)</span>
                                @elseif($req->status === 'rejected')
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800">বাতিল (রিফান্ডেড)</span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">অপেক্ষমাণ (Pending)</span>
                                @endif
                            </td>
                            <td class="p-3.5 font-mono text-[11px] text-slate-600">{{ $req->trx_id ?? '---' }}</td>
                            <td class="p-3.5 text-slate-500 text-[11px]">{{ $req->created_at->format('d M, Y h:i A') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-xs text-slate-400">এখনো কোনো উইথড্রয়াল আবেদন করা হয়নি।</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
