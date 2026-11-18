@extends('layouts.app')

@section('title', 'সচরাচর জিজ্ঞাসা (FAQ) - Reporter | Procharok')

@section('content')
<div class="bg-slate-900 text-white py-12 px-4 sm:px-6 lg:px-8 border-b border-slate-800">
    <div class="max-w-4xl mx-auto text-center space-y-3">
        <span class="px-3 py-1 bg-emerald-500/20 text-emerald-400 rounded-full text-xs font-semibold uppercase tracking-wider">সহায়তা ও নির্দেশিকা</span>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">সাধারণ প্রশ্নোত্তর (FAQ)</h1>
        <p class="text-slate-400 text-sm max-w-xl mx-auto">
            সংবাদপত্রে বিজ্ঞাপন প্রকাশনা, পরিমাপ, ডিজাইনার নিয়োগ এবং পেমেন্ট সংক্রান্ত যেকোনো তথ্যের জন্য নিচের উত্তরগুলো দেখুন।
        </p>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-10">
    <!-- Client Section -->
    <div class="space-y-4">
        <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2 border-b border-slate-200 pb-3">
            <i class="fa-solid fa-circle-question text-emerald-600"></i> বিজ্ঞাপনদাতাদের জন্য সাধারণ জিজ্ঞাসা (Client FAQ)
        </h2>

        <div class="space-y-3">
            <details class="group bg-white p-5 rounded-2xl border border-slate-200 shadow-xs" open>
                <summary class="font-bold text-sm text-slate-800 cursor-pointer flex justify-between items-center list-none">
                    <span>১. Reporter / প্রচারক প্ল্যাটফর্ম কী এবং এটি কীভাবে কাজ করে?</span>
                    <i class="fa-solid fa-chevron-down text-xs text-slate-400 group-open:rotate-180 transition-transform"></i>
                </summary>
                <p class="text-xs text-slate-600 mt-3 leading-relaxed">
                    Reporter একটি অনলাইন-বেসড প্রোগ্রাম্যাটিক অফলাইন সংবাদপত্র বিজ্ঞাপন প্ল্যাটফর্ম। প্রথাগত এজেন্টদের খোঁজার ঝামেলা ছাড়াই ঘরে বসে দেশের শীর্ষ সকল বাংলা ও ইংরেজি পত্রিকায় সহজে বিজ্ঞাপন প্রকাশ এবং পেশাদার গ্রাফিক ডিজাইনার দিয়ে বিজ্ঞাপন প্রস্তুত করার সুবিধা দিয়ে থাকে।
                </p>
            </details>

            <details class="group bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
                <summary class="font-bold text-sm text-slate-800 cursor-pointer flex justify-between items-center list-none">
                    <span>২. প্রচলিত মাধ্যমের বদলে আমাদের মাধ্যমে কেন বিজ্ঞাপন দিবেন?</span>
                    <i class="fa-solid fa-chevron-down text-xs text-slate-400 group-open:rotate-180 transition-transform"></i>
                </summary>
                <div class="text-xs text-slate-600 mt-3 leading-relaxed space-y-1.5">
                    <div>• এজেন্ট খোঁজার ঝামেলা ছাড়া মাত্র ৫ মিনিটে আবেদন সম্পন্ন হয়।</div>
                    <div>• রিয়েল-টাইম রেট, প্রকাশের তারিখ এবং স্বচ্ছ হিসাব পাওয়া যায়।</div>
                    <div>• অভিজ্ঞ গ্রাফিক ডিজাইনার দ্বারা দৃষ্টিনন্দন বিজ্ঞাপন তৈরির সুবিধা।</div>
                    <div>• বিজ্ঞাপন প্রকাশের পর অনলাইনে E-Paper প্রুফ কপি ও রসিদ প্রদান করা হয়।</div>
                </div>
            </details>

            <details class="group bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
                <summary class="font-bold text-sm text-slate-800 cursor-pointer flex justify-between items-center list-none">
                    <span>৩. বিজ্ঞাপনে কী কী অন্তর্ভুক্ত করা উচিত?</span>
                    <i class="fa-solid fa-chevron-down text-xs text-slate-400 group-open:rotate-180 transition-transform"></i>
                </summary>
                <p class="text-xs text-slate-600 mt-3 leading-relaxed">
                    সর্বোচ্চ রেসপন্স পাওয়ার জন্য বিজ্ঞাপনের বিস্তারিত তথ্য ও যোগাযোগের স্পষ্ট ঠিকানা/মোবাইল নম্বর প্রদান করুন। হারানো বিজ্ঞপ্তি বা সংশোধনের ক্ষেত্রে সংশ্লিষ্ট থানার জিডি নম্বর ও এফিডেভিটের কপি প্রদান করা আবশ্যক।
                </p>
            </details>

            <details class="group bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
                <summary class="font-bold text-sm text-slate-800 cursor-pointer flex justify-between items-center list-none">
                    <span>৪. পত্রিকার কলাম ও পৃষ্ঠার গড় পরিমাপ কী রূপ?</span>
                    <i class="fa-solid fa-chevron-down text-xs text-slate-400 group-open:rotate-180 transition-transform"></i>
                </summary>
                <div class="text-xs text-slate-600 mt-3 leading-relaxed space-y-1">
                    <div>• কলামের প্রস্থ: সাধারণত ১.৫ ইঞ্চি (পত্রিকাভেদে পরিবর্তনশীল)।</div>
                    <div>• পুরো পৃষ্ঠার উচ্চতা: ২১ ইঞ্চি।</div>
                    <div>• একটি পূর্ণাঙ্গ পাতার আকার: ১৬৮ কলাম-ইঞ্চি (৮ কলাম × ২১ ইঞ্চি)।</div>
                </div>
            </details>

            <details class="group bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
                <summary class="font-bold text-sm text-slate-800 cursor-pointer flex justify-between items-center list-none">
                    <span>৫. মূল্য পরিশোধের অপশনগুলো কী কী?</span>
                    <i class="fa-solid fa-chevron-down text-xs text-slate-400 group-open:rotate-180 transition-transform"></i>
                </summary>
                <p class="text-xs text-slate-600 mt-3 leading-relaxed">
                    আমাদের সব ধরনের পেমেন্ট সুবিধা রয়েছে: বিকাশ (bKash), নগদ (Nagad), রকেট (Rocket), সরাসরি ব্যাংক ট্রান্সফার এবং ঢাকা মহানগরীর ভেতরে ক্যাশ অন পিকআপ সুবিধা।
                </p>
            </details>
        </div>
    </div>

    <!-- Designer Section -->
    <div class="space-y-4">
        <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2 border-b border-slate-200 pb-3">
            <i class="fa-solid fa-palette text-indigo-600"></i> ডিজাইনার ও এসক্রো সংক্রান্ত জিজ্ঞাসা (Designer FAQ)
        </h2>

        <div class="space-y-3">
            <details class="group bg-white p-5 rounded-2xl border border-slate-200 shadow-xs" open>
                <summary class="font-bold text-sm text-slate-800 cursor-pointer flex justify-between items-center list-none">
                    <span>১. ডিজাইন তৈরির জন্য এসক্রো (ESCROW) পদ্ধতি কীভাবে কাজ করে?</span>
                    <i class="fa-solid fa-chevron-down text-xs text-slate-400 group-open:rotate-180 transition-transform"></i>
                </summary>
                <p class="text-xs text-slate-600 mt-3 leading-relaxed">
                    নিরাপত্তাজনিত কারণে ক্লায়েন্ট অর্ডার করার সময় অর্থ প্রদান করে এবং আমরা প্ল্যাটফর্মে এই অর্থ সুরক্ষিত রাখি। ডিজাইনার ক্রিয়েটিভ আর্টওয়ার্ক সম্পন্ন করে ড্রাফট জমা দিলে ক্লায়েন্ট তা চেক করেন (সর্বোচ্চ ৩টি রিভিশন সুযোগ থাকে)। ক্লায়েন্ট সন্তুষ্ট হয়ে ফাইনাল অনুমোদন দিলে ডিজাইনারকে অর্থ প্রদান করা হয়। ফলে ক্লায়েন্ট এবং ডিজাইনার উভয়ের শতভাগ নিরাপত্তা নিশ্চিত হয়।
                </p>
            </details>

            <details class="group bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
                <summary class="font-bold text-sm text-slate-800 cursor-pointer flex justify-between items-center list-none">
                    <span>২. একজন ফ্রিল্যান্স গ্রাফিক ডিজাইনার কীভাবে কাজ শুরু করবেন?</span>
                    <i class="fa-solid fa-chevron-down text-xs text-slate-400 group-open:rotate-180 transition-transform"></i>
                </summary>
                <p class="text-xs text-slate-600 mt-3 leading-relaxed">
                    'ডিজাইনার সাইনআপ' লিংকে গিয়ে নিজের প্রোফাইল তৈরি করুন। আপনার পূর্বের কাজের নমুনা ও পোর্টফোলিও আপলোড করুন। প্রোফাইল সক্রিয় হলে ক্লায়েন্টরা সরাসরি অর্ডার প্রদান করতে পারবে।
                </p>
            </details>
        </div>
    </div>
</div>
@endsection
