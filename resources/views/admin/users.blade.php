@extends('layouts.admin')

@section('title', 'গ্রাহক অ্যাকাউন্টস - Admin')
@section('page_title', 'নিবন্ধিত ক্লায়েন্ট ও বিজ্ঞাপনদাতা তালিকা')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-xl font-bold text-white">গ্রাহক অ্যাকাউন্টসমূহ</h1>
        <p class="text-xs text-slate-400">নিবন্ধিত বিজ্ঞাপনদাতাদের যোগাযোগ তথ্য ও সর্বমোট বিজ্ঞাপনের হিসাব</p>
    </div>

    <div class="bg-slate-950 rounded-2xl border border-slate-800 shadow-xs overflow-hidden">
        <table class="w-full text-left text-xs">
            <thead class="bg-slate-900 text-slate-400 uppercase text-[10px] font-bold border-b border-slate-800">
                <tr>
                    <th class="p-4">গ্রাহকের নাম</th>
                    <th class="p-4">ইমেইল</th>
                    <th class="p-4">মোবাইল নম্বর</th>
                    <th class="p-4">শ্রেণীভুক্ত বিজ্ঞাপন</th>
                    <th class="p-4">ডিসপ্লে বিজ্ঞাপন</th>
                    <th class="p-4">স্ট্যাটাস</th>
                    <th class="p-4 text-right">যোগদানের তারিখ</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800/60">
                @forelse($users as $u)
                    <tr class="hover:bg-slate-900/50 transition-colors">
                        <td class="p-4 font-bold text-white">{{ $u->name }}</td>
                        <td class="p-4 text-slate-300">{{ $u->email }}</td>
                        <td class="p-4 text-slate-300 font-mono">{{ $u->phone }}</td>
                        <td class="p-4 font-bold text-emerald-400">{{ $u->classified_ads_count }} টি</td>
                        <td class="p-4 font-bold text-teal-400">{{ $u->display_ads_count }} টি</td>
                        <td class="p-4">
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-emerald-500/20 text-emerald-400">
                                {{ $u->status }}
                            </span>
                        </td>
                        <td class="p-4 text-right text-slate-400">{{ $u->created_at->format('d/m/Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-8 text-center text-xs text-slate-500">কোনো গ্রাহক অ্যাকাউন্ট নেই।</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4 border-t border-slate-800">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
