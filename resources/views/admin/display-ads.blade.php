@extends('layouts.admin')

@section('title', 'ডিসপ্লে বিজ্ঞাপন ম্যানেজমেন্ট - Admin')
@section('page_title', 'ডিসপ্লে বিজ্ঞাপন ও আর্টওয়ার্ক ম্যানেজমেন্ট')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-xl font-bold text-slate-900">ডিসপ্লে বিজ্ঞাপন পরিচালনা</h1>
            <p class="text-xs text-slate-500">ব্যানার ও বক্স বিজ্ঞাপনের অনুমোদন, আর্টওয়ার্ক ফাইল চেক ও প্রকাশনা স্ট্যাটাস</p>
        </div>
        <div class="flex flex-wrap gap-2 text-xs font-bold">
            <a href="{{ route('admin.display') }}" class="px-3.5 py-1.5 rounded-lg {{ !request('status') ? 'bg-indigo-600 text-white' : 'bg-white border border-slate-200 text-slate-700 hover:bg-slate-50' }}">সব</a>
            <a href="{{ route('admin.display', ['status' => 'pending']) }}" class="px-3.5 py-1.5 rounded-lg {{ request('status') === 'pending' ? 'bg-indigo-600 text-white' : 'bg-white border border-slate-200 text-slate-700 hover:bg-slate-50' }}">পেন্ডিং</a>
            <a href="{{ route('admin.display', ['status' => 'approved']) }}" class="px-3.5 py-1.5 rounded-lg {{ request('status') === 'approved' ? 'bg-indigo-600 text-white' : 'bg-white border border-slate-200 text-slate-700 hover:bg-slate-50' }}">অনুমোদিত</a>
            <a href="{{ route('admin.display', ['status' => 'published']) }}" class="px-3.5 py-1.5 rounded-lg {{ request('status') === 'published' ? 'bg-indigo-600 text-white' : 'bg-white border border-slate-200 text-slate-700 hover:bg-slate-50' }}">প্রকাশিত</a>
        </div>
    </div>

    <!-- Search Form -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-xs">
        <form action="{{ route('admin.display') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="ট্র্যাকিং নম্বর, নাম বা মোবাইল দিয়ে সার্চ..." class="flex-1 bg-slate-50 border border-slate-300 rounded-xl px-4 py-2.5 text-xs text-slate-900 placeholder-slate-400 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
            <select name="newspaper_id" class="bg-slate-50 border border-slate-300 rounded-xl px-3 py-2.5 text-xs text-slate-800 focus:bg-white">
                <option value="">সকল সংবাদপত্র</option>
                @foreach($newspapers as $np)
                    <option value="{{ $np->id }}" {{ request('newspaper_id') == $np->id ? 'selected' : '' }}>{{ $np->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl shadow-xs transition-colors">
                সার্চ
            </button>
        </form>
    </div>

    <!-- Cards for each Display Ad -->
    <div class="space-y-4">
        @forelse($ads as $ad)
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs space-y-4">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 pb-3 border-b border-slate-100">
                    <div class="flex items-center gap-3 flex-wrap">
                        <span class="font-mono font-bold text-base text-slate-900">{{ $ad->tracking_no }}</span>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $ad->status === 'published' ? 'bg-emerald-100 text-emerald-800' : ($ad->status === 'approved' ? 'bg-blue-100 text-blue-800' : 'bg-amber-100 text-amber-800') }}">
                            {{ $ad->status }}
                        </span>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $ad->payment_status === 'paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                            পেমেন্ট: {{ $ad->payment_status }}
                        </span>
                    </div>
                    <div class="text-xs text-slate-400">
                        তারিখ: {{ $ad->created_at->format('d/m/Y h:i A') }}
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 text-xs">
                    <div>
                        <span class="text-slate-400">বিজ্ঞাপনদাতা:</span>
                        <div class="font-bold text-slate-900 mt-0.5">{{ $ad->customer_name }}</div>
                        <div class="text-slate-500">{{ $ad->customer_phone }} | {{ $ad->customer_email }}</div>
                    </div>
                    <div>
                        <span class="text-slate-400">সংবাদপত্র:</span>
                        <div class="font-bold text-teal-700 mt-0.5">{{ $ad->newspaper->name }}</div>
                        <div class="text-slate-500">প্রকাশ: {{ date('d F, Y', strtotime($ad->publish_date)) }}</div>
                    </div>
                    <div>
                        <span class="text-slate-400">সাইজ ও অবস্থান:</span>
                        <div class="font-bold text-slate-900 mt-0.5">{{ $ad->columns }} কলাম × {{ $ad->height_inches }}" ({{ $ad->total_col_inches }} CI)</div>
                        <div class="text-slate-500 uppercase">{{ str_replace('_', ' ', $ad->page_position) }} | {{ $ad->color_type }}</div>
                    </div>
                    <div>
                        <span class="text-slate-400">মোট বিলিং:</span>
                        <div class="font-bold text-emerald-700 text-sm mt-0.5">৳{{ number_format($ad->total_amount, 2) }}</div>
                        <div class="text-slate-600 font-mono">{{ strtoupper($ad->payment_method) }}: {{ $ad->payment_trx_id ?? 'N/A' }}</div>
                    </div>
                </div>

                @if($ad->artwork_file)
                    <div class="pt-2 flex items-center gap-3">
                        <a href="{{ asset('storage/' . $ad->artwork_file) }}" target="_blank" download class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-50 border border-slate-300 text-slate-700 hover:bg-slate-100 text-xs font-bold rounded-lg transition-colors">
                            <i class="fa-solid fa-file-image text-teal-600"></i> আর্টওয়ার্ক ফাইল ডাউনলোড
                        </a>
                    </div>
                @endif

                <!-- Admin Action Form -->
                <form action="{{ route('admin.display.status', $ad->id) }}" method="POST" class="pt-4 border-t border-slate-100 grid grid-cols-1 sm:grid-cols-4 gap-3 items-end">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">স্ট্যাটাস</label>
                        <select name="status" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 text-xs font-bold text-slate-800 focus:bg-white">
                            <option value="pending" {{ $ad->status === 'pending' ? 'selected' : '' }}>পেন্ডিং</option>
                            <option value="in_review" {{ $ad->status === 'in_review' ? 'selected' : '' }}>রিভিউধীন</option>
                            <option value="approved" {{ $ad->status === 'approved' ? 'selected' : '' }}>অনুমোদিত (Approved)</option>
                            <option value="published" {{ $ad->status === 'published' ? 'selected' : '' }}>প্রকাশিত (Published)</option>
                            <option value="rejected" {{ $ad->status === 'rejected' ? 'selected' : '' }}>বাতিল</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">পেমেন্ট ভেরিফিকেশন</label>
                        <select name="payment_status" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 text-xs font-bold text-slate-800 focus:bg-white">
                            <option value="pending_verification" {{ $ad->payment_status === 'pending_verification' ? 'selected' : '' }}>পেন্ডিং</option>
                            <option value="paid" {{ $ad->payment_status === 'paid' ? 'selected' : '' }}>পেইড (Paid / Verified)</option>
                            <option value="unpaid" {{ $ad->payment_status === 'unpaid' ? 'selected' : '' }}>আনপেইড</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">ই-পেপার কপি লিংক</label>
                        <input type="url" name="published_proof_url" value="{{ $ad->published_proof_url }}" placeholder="https://epaper.newspaper.com" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 text-xs text-slate-900 focus:bg-white">
                    </div>

                    <button type="submit" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl transition-colors">
                        আপডেট করুন
                    </button>
                </form>
            </div>
        @empty
            <div class="text-center py-12 bg-white rounded-2xl border border-slate-200 text-xs text-slate-400">
                কোনো ডিসপ্লে বিজ্ঞাপন নেই।
            </div>
        @endforelse

        @if($ads->hasPages())
            <div>
                {{ $ads->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
