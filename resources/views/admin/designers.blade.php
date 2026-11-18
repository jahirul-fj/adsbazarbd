@extends('layouts.admin')

@section('title', 'গ্রাফিক ডিজাইনার্স ম্যানেজমেন্ট - Admin')
@section('page_title', 'নিবন্ধিত ফ্রিল্যান্স ডিজাইনার্স ও পোর্টফোলিও')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-xl font-bold text-white">গ্রাফিক ডিজাইনার্স ম্যানেজমেন্ট</h1>
            <p class="text-xs text-slate-400">ডিজাইনারদের রেটিং, কাজের সংখ্যা, ফিচার্ড স্ট্যাটাস ও একাউন্ট পর্যবেক্ষণ</p>
        </div>
    </div>

    <div class="bg-slate-950 rounded-2xl border border-slate-800 shadow-xs overflow-hidden">
        <table class="w-full text-left text-xs">
            <thead class="bg-slate-900 text-slate-400 uppercase text-[10px] font-bold border-b border-slate-800">
                <tr>
                    <th class="p-4">ডিজাইনার</th>
                    <th class="p-4">ট্যাগলাইন</th>
                    <th class="p-4">অভিজ্ঞতা</th>
                    <th class="p-4">শুরুর রেট</th>
                    <th class="p-4">অর্ডার সম্পন্ন</th>
                    <th class="p-4">রেটিং</th>
                    <th class="p-4">ফিচার্ড?</th>
                    <th class="p-4 text-right">অ্যাকশন</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800/60">
                @forelse($designers as $des)
                    <tr class="hover:bg-slate-900/50 transition-colors">
                        <td class="p-4">
                            <div class="font-bold text-white">{{ $des->user->name }}</div>
                            <div class="text-[10px] text-slate-400">{{ $des->user->email }} | {{ $des->user->phone }}</div>
                        </td>
                        <td class="p-4 text-slate-300 max-w-xs truncate">{{ $des->tagline }}</td>
                        <td class="p-4 text-slate-300">{{ $des->experience_years }} বছর</td>
                        <td class="p-4 font-bold text-emerald-400">৳{{ number_format($des->starting_rate, 0) }}</td>
                        <td class="p-4 font-bold text-white">{{ $des->completed_orders }} টি</td>
                        <td class="p-4 text-amber-400 font-bold">
                            ★ {{ number_format($des->rating, 1) }} ({{ $des->total_reviews }})
                        </td>
                        <td class="p-4">
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $des->is_featured ? 'bg-indigo-500/20 text-indigo-300' : 'bg-slate-800 text-slate-400' }}">
                                {{ $des->is_featured ? 'Featured' : 'Regular' }}
                            </span>
                        </td>
                        <td class="p-4 text-right">
                            <form action="{{ route('admin.designers.featured', $des->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="px-3 py-1 rounded bg-slate-800 hover:bg-slate-700 text-white text-[11px] font-bold transition-colors">
                                    {{ $des->is_featured ? 'আন-ফিচার্ড করুন' : 'ফিচার্ড করুন' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="p-8 text-center text-xs text-slate-500">কোনো ডিজাইনার অ্যাকাউন্ট নেই।</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4 border-t border-slate-800">
            {{ $designers->links() }}
        </div>
    </div>
</div>
@endsection
