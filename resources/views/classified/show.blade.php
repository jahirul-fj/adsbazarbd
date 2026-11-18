@extends('layouts.app')

@section('title', 'বিজ্ঞাপন কনফার্মেশন ও ইনভয়েস - ' . $ad->tracking_no)

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Success Badge Header -->
    <div class="text-center space-y-3 mb-8">
        <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-3xl mx-auto shadow-md">
            <i class="fa-solid fa-check"></i>
        </div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900">বিজ্ঞাপন সফলভাবে জমা হয়েছে!</h1>
        <p class="text-sm text-slate-600">আপনার বিজ্ঞাপন বুকিং সফল হয়েছে। নিচের ট্র্যাকিং নম্বরটি ভবিষ্যতে অনুসন্ধানের জন্য সংরক্ষণ করুন।</p>
    </div>

    <!-- Printable Invoice Card -->
    <div class="bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden" id="printableArea">
        <!-- Card Top Ribbon -->
        <div class="bg-slate-900 text-white p-6 sm:p-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <div class="text-xs uppercase tracking-wider text-emerald-400 font-bold mb-1">অফিসিয়াল ইনভয়েস ও রসিদ</div>
                <div class="text-xl sm:text-2xl font-black flex items-center gap-2">
                    {{ $ad->tracking_no }}
                    <button onclick="navigator.clipboard.writeText('{{ $ad->tracking_no }}'); alert('ট্র্যাকিং নম্বর কপি করা হয়েছে!');" class="text-xs text-slate-400 hover:text-white px-2 py-1 bg-slate-800 rounded-md">
                        <i class="fa-regular fa-copy"></i> কপি
                    </button>
                </div>
            </div>
            <div class="text-left sm:text-right">
                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase {{ $ad->status === 'published' ? 'bg-emerald-500 text-white' : ($ad->status === 'approved' ? 'bg-blue-500 text-white' : 'bg-amber-400 text-slate-950') }}">
                    {{ $ad->status === 'published' ? 'পত্রিকায় প্রকাশিত' : ($ad->status === 'approved' ? 'অনুমোদিত' : 'অপেক্ষমাণ (Pending)') }}
                </span>
                <div class="text-xs text-slate-400 mt-1.5">তারিখ: {{ $ad->created_at->format('d M, Y h:i A') }}</div>
            </div>
        </div>

        <!-- Ad Body Preview -->
        <div class="p-6 sm:p-8 space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pb-6 border-b border-slate-100 text-sm">
                <div>
                    <div class="text-xs text-slate-400 font-semibold">গ্রাহকের নাম ও যোগাযোগ</div>
                    <div class="font-bold text-slate-900 mt-0.5">{{ $ad->customer_name }}</div>
                    <div class="text-xs text-slate-500">{{ $ad->customer_phone }} | {{ $ad->customer_email }}</div>
                </div>
                <div>
                    <div class="text-xs text-slate-400 font-semibold">পত্রিকা ও প্রকাশের তারিখ</div>
                    <div class="font-bold text-emerald-700 mt-0.5">{{ $ad->newspaper->name }}</div>
                    <div class="text-xs text-slate-600 font-semibold">প্রকাশের তারিখ: {{ date('d F, Y', strtotime($ad->publish_date)) }}</div>
                </div>
            </div>

            <!-- Ad Content Section -->
            <div class="space-y-2">
                <div class="text-xs font-bold text-slate-400 uppercase tracking-wider">বিজ্ঞাপনের শিরোনাম ও টেক্সট</div>
                <div class="text-base font-bold text-slate-900">{{ $ad->title }}</div>
                <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl text-sm leading-relaxed text-slate-800 whitespace-pre-line">
                    {{ $ad->ad_body }}
                </div>
            </div>

            <!-- Billing Table -->
            <div class="border border-slate-200 rounded-2xl overflow-hidden">
                <table class="w-full text-left text-xs sm:text-sm">
                    <thead class="bg-slate-100 text-slate-700 font-bold border-b border-slate-200">
                        <tr>
                            <th class="p-3.5">বিবরণ</th>
                            <th class="p-3.5 text-center">শব্দ সংখ্যা</th>
                            <th class="p-3.5 text-right">রেট / শব্দ</th>
                            <th class="p-3.5 text-right">মোট টাকা</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr>
                            <td class="p-3.5 font-medium">
                                শ্রেণীভুক্ত বিজ্ঞাপন ({{ $ad->category->name }})<br>
                                <span class="text-xs text-slate-400">{{ $ad->newspaper->name }}</span>
                            </td>
                            <td class="p-3.5 text-center font-bold">{{ $ad->word_count }}</td>
                            <td class="p-3.5 text-right">৳{{ number_format($ad->newspaper->classified_rate_per_word, 2) }}</td>
                            <td class="p-3.5 text-right font-bold text-slate-900">৳{{ number_format($ad->total_amount, 2) }}</td>
                        </tr>
                        <tr class="bg-slate-50 font-bold text-slate-900">
                            <td colspan="3" class="p-3.5 text-right uppercase tracking-wider text-xs">সর্বমোট প্রদেয়:</td>
                            <td class="p-3.5 text-right text-base text-emerald-600">৳{{ number_format($ad->total_amount, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Payment Details Box -->
            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 text-xs">
                <div>
                    <span class="text-slate-500">পেমেন্ট মাধ্যম:</span> <strong class="uppercase text-slate-800">{{ $ad->payment_method }}</strong>
                    @if($ad->payment_trx_id)
                        | <span class="text-slate-500">TrxID:</span> <strong class="text-slate-800 font-mono">{{ $ad->payment_trx_id }}</strong>
                    @endif
                </div>
                <div>
                    <span class="px-2.5 py-1 rounded-full font-bold uppercase {{ $ad->payment_status === 'paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                        পেমেন্ট: {{ $ad->payment_status === 'paid' ? 'ভেরিফাইড (Paid)' : 'অপেক্ষমাণ (Pending)' }}
                    </span>
                </div>
            </div>

            <!-- If Published, Show Proof -->
            @if($ad->status === 'published' && $ad->published_proof_url)
                <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-xs space-y-1">
                    <div class="font-bold text-emerald-900 flex items-center gap-1.5">
                        <i class="fa-solid fa-newspaper text-emerald-600"></i> বিজ্ঞাপনটি পত্রিকায় প্রকাশিত হয়েছে!
                    </div>
                    <div class="text-slate-600">ই-পেপার কপি দেখার লিঙ্ক: 
                        <a href="{{ $ad->published_proof_url }}" target="_blank" class="text-emerald-700 underline font-semibold">{{ $ad->published_proof_url }}</a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Card Footer -->
        <div class="bg-slate-50 px-6 sm:px-8 py-4 border-t border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-3 text-xs text-slate-500">
            <div>যেকোনো তথ্যের জন্য কল করুন: <strong>01854-820303</strong></div>
            <div class="flex gap-2">
                <button type="button" onclick="window.print()" class="px-4 py-2 bg-slate-900 text-white font-bold rounded-xl hover:bg-slate-800 transition-colors">
                    <i class="fa-solid fa-print mr-1"></i> প্রিন্ট ইনভয়েস
                </button>
                <a href="{{ route('track', ['tracking_no' => $ad->tracking_no]) }}" class="px-4 py-2 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition-colors">
                    লাইভ ট্র্যাকিং
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
