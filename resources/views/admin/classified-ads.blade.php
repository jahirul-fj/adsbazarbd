@extends('layouts.admin')

@section('title', 'শ্রেণীভুক্ত বিজ্ঞাপন ম্যানেজমেন্ট - Admin')
@section('page_title', 'শ্রেণীভুক্ত বিজ্ঞাপন তালিকা ও প্রকাশনা')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-xl font-bold text-white">শ্রেণীভুক্ত বিজ্ঞাপন পরিচালনা</h1>
            <p class="text-xs text-slate-400">বিজ্ঞাপন অনুমোদন, স্ট্যাটাস পরিবর্তন এবং ই-পেপার প্রুফ লিংক সংযুক্ত করুন</p>
        </div>
        <div class="flex flex-wrap gap-2 text-xs font-bold">
            <a href="{{ route('admin.classified') }}" class="px-3 py-1.5 rounded-lg {{ !request('status') ? 'bg-indigo-600 text-white' : 'bg-slate-800 text-slate-300' }}">সব</a>
            <a href="{{ route('admin.classified', ['status' => 'pending']) }}" class="px-3 py-1.5 rounded-lg {{ request('status') === 'pending' ? 'bg-indigo-600 text-white' : 'bg-slate-800 text-slate-300' }}">পেন্ডিং</a>
            <a href="{{ route('admin.classified', ['status' => 'approved']) }}" class="px-3 py-1.5 rounded-lg {{ request('status') === 'approved' ? 'bg-indigo-600 text-white' : 'bg-slate-800 text-slate-300' }}">অনুমোদিত</a>
            <a href="{{ route('admin.classified', ['status' => 'published']) }}" class="px-3 py-1.5 rounded-lg {{ request('status') === 'published' ? 'bg-indigo-600 text-white' : 'bg-slate-800 text-slate-300' }}">প্রকাশিত</a>
        </div>
    </div>

    <!-- Search Form -->
    <div class="bg-slate-950 p-4 rounded-2xl border border-slate-800">
        <form action="{{ route('admin.classified') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="ট্র্যাকিং নম্বর, গ্রাহকের নাম বা মোবাইল দিয়ে সার্চ..." class="flex-1 bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-xs text-white placeholder-slate-500 focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
            <select name="newspaper_id" class="bg-slate-900 border border-slate-700 rounded-xl px-3 py-2.5 text-xs text-white">
                <option value="">সকল সংবাদপত্র</option>
                @foreach($newspapers as $np)
                    <option value="{{ $np->id }}" {{ request('newspaper_id') == $np->id ? 'selected' : '' }}>{{ $np->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs rounded-xl shadow-xs transition-colors">
                সার্চ
            </button>
        </form>
    </div>

    <!-- Cards for each Ad -->
    <div class="space-y-4">
        @forelse($ads as $ad)
            <div class="bg-slate-950 rounded-2xl border border-slate-800 p-6 shadow-md space-y-4">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 pb-3 border-b border-slate-800">
                    <div class="flex items-center gap-3 flex-wrap">
                        <span class="font-mono font-bold text-base text-white">{{ $ad->tracking_no }}</span>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $ad->status === 'published' ? 'bg-emerald-500/20 text-emerald-400' : ($ad->status === 'approved' ? 'bg-blue-500/20 text-blue-400' : 'bg-amber-500/20 text-amber-400') }}">
                            {{ $ad->status }}
                        </span>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $ad->payment_status === 'paid' ? 'bg-emerald-500/20 text-emerald-400' : 'bg-rose-500/20 text-rose-400' }}">
                            পেমেন্ট: {{ $ad->payment_status }}
                        </span>
                    </div>
                    <div class="text-xs text-slate-400">
                        দাখিল: {{ $ad->created_at->format('d/m/Y h:i A') }}
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
                    <div>
                        <span class="text-slate-400">বিজ্ঞাপনদাতা:</span>
                        <div class="font-bold text-white mt-0.5">{{ $ad->customer_name }}</div>
                        <div class="text-slate-400">{{ $ad->customer_phone }} | {{ $ad->customer_email }}</div>
                    </div>
                    <div>
                        <span class="text-slate-400">পত্রিকা ও তারিখ:</span>
                        <div class="font-bold text-emerald-400 mt-0.5">{{ $ad->newspaper->name }}</div>
                        <div class="text-slate-400">প্রকাশ: {{ date('d F, Y', strtotime($ad->publish_date)) }}</div>
                    </div>
                    <div>
                        <span class="text-slate-400">বিলিং ও পেমেন্ট:</span>
                        <div class="font-bold text-white mt-0.5">৳{{ number_format($ad->total_amount, 2) }} ({{ $ad->word_count }} শব্দ)</div>
                        <div class="text-slate-400 font-mono">{{ strtoupper($ad->payment_method) }}: {{ $ad->payment_trx_id ?? 'N/A' }}</div>
                    </div>
                </div>

                <!-- Text Body -->
                <div class="p-4 bg-slate-900 rounded-xl border border-slate-800 text-xs text-slate-300 space-y-1">
                    <div class="font-bold text-white text-sm">{{ $ad->title }}</div>
                    <div class="whitespace-pre-line text-slate-300 leading-relaxed">{{ $ad->ad_body }}</div>
                </div>

                @if($ad->document_file)
                    <div class="pt-1">
                        <a href="{{ asset('storage/' . $ad->document_file) }}" target="_blank" download class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-900 border border-slate-700 text-slate-300 hover:text-white text-xs font-bold rounded-lg transition-colors">
                            <i class="fa-solid fa-file-pdf text-rose-400"></i> সংযুক্ত জিডি/এফিডেভিট ফাইল দেখুন
                        </a>
                    </div>
                @endif

                <!-- Admin Action Form -->
                <form action="{{ route('admin.classified.status', $ad->id) }}" method="POST" class="pt-4 border-t border-slate-800 grid grid-cols-1 sm:grid-cols-4 gap-3 items-end">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">বিজ্ঞাপনের স্ট্যাটাস</label>
                        <select name="status" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3 py-2 text-xs font-bold text-white">
                            <option value="pending" {{ $ad->status === 'pending' ? 'selected' : '' }}>পেন্ডিং (Pending)</option>
                            <option value="approved" {{ $ad->status === 'approved' ? 'selected' : '' }}>অনুমোদিত (Approved)</option>
                            <option value="published" {{ $ad->status === 'published' ? 'selected' : '' }}>পত্রিকায় প্রকাশিত (Published)</option>
                            <option value="rejected" {{ $ad->status === 'rejected' ? 'selected' : '' }}>বাতিল (Rejected)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">পেমেন্ট ভেরিফিকেশন</label>
                        <select name="payment_status" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3 py-2 text-xs font-bold text-white">
                            <option value="pending_verification" {{ $ad->payment_status === 'pending_verification' ? 'selected' : '' }}>পেন্ডিং</option>
                            <option value="paid" {{ $ad->payment_status === 'paid' ? 'selected' : '' }}>পেইড (Paid / Verified)</option>
                            <option value="unpaid" {{ $ad->payment_status === 'unpaid' ? 'selected' : '' }}>আনপেইড</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">ই-পেপার কপি লিংক</label>
                        <input type="url" name="published_proof_url" value="{{ $ad->published_proof_url }}" placeholder="https://epaper.newspaper.com" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3 py-2 text-xs text-white">
                    </div>

                    <button type="submit" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs rounded-xl shadow-xs transition-colors">
                        আপডেট করুন
                    </button>
                </form>
            </div>
        @empty
            <div class="text-center py-12 bg-slate-950 rounded-2xl border border-slate-800 text-xs text-slate-500">
                কোনো বিজ্ঞাপন রেকর্ড মেলেনি।
            </div>
        @endforelse

        <div>
            {{ $ads->links() }}
        </div>
    </div>
</div>
@endsection
