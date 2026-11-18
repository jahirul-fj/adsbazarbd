<?php

namespace Database\Seeders;

use App\Models\AdCategory;
use App\Models\ClassifiedAd;
use App\Models\DesignerProfile;
use App\Models\DesignOrder;
use App\Models\DesignOrderMessage;
use App\Models\DisplayAd;
use App\Models\Newspaper;
use App\Models\PaymentRecord;
use App\Models\SystemSetting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. System Settings
        $settings = [
            'site_name' => 'Reporter (প্রচারক - অনলাইন সংবাদপত্র বিজ্ঞাপন প্ল্যাটফর্ম)',
            'site_tagline' => 'ঘরে বসেই সহজে যেকোনো জাতীয় পত্রিকায় বিজ্ঞাপন দিন ও দক্ষ ডিজাইনার হায়ার করুন',
            'helpline_phone' => '01854-820303',
            'helpline_email' => 'contact@reporter.com.bd',
            'office_address' => 'বাড়ি # ১২, রোড # ০৫, ধানমন্ডি, ঢাকা-১২০৫, বাংলাদেশ',
            'bkash_merchant_number' => '01779-870454',
            'nagad_merchant_number' => '01854-820303',
            'rocket_number' => '01779-870454-8',
            'bank_info' => 'ডাচ বাংলা ব্যাংক লিমিটেড, একাউন্ট নাম: Reporter Ads Ltd, একাউন্ট নং: 123.120.98765, ব্র্যাঞ্চ: ধানমন্ডি শাখা',
            'cash_pickup_notice' => 'শুধুমাত্র ঢাকা মহানগরীর ভেতরের ঠিকানার জন্য ক্যাশ পিকআপ প্রযোজ্য।',
        ];

        foreach ($settings as $key => $val) {
            SystemSetting::set($key, $val);
        }

        // 2. Newspapers
        $newspapers = [
            [
                'name' => 'দৈনিক প্রথম আলো (Daily Prothom Alo)',
                'slug' => 'prothom-alo',
                'language' => 'bangla',
                'classified_rate_per_word' => 20.00,
                'display_rate_col_inch' => 2800.00,
                'front_page_multiplier' => 3.00,
                'back_page_multiplier' => 2.00,
                'inner_page_multiplier' => 1.00,
                'color_charge_percent' => 35,
                'min_words' => 20,
                'contact_email' => 'ads@prothomalo.com',
                'sort_order' => 1,
            ],
            [
                'name' => 'বাংলাদেশ প্রতিদিন (Bangladesh Pratidin)',
                'slug' => 'bangladesh-pratidin',
                'language' => 'bangla',
                'classified_rate_per_word' => 16.00,
                'display_rate_col_inch' => 2200.00,
                'front_page_multiplier' => 2.50,
                'back_page_multiplier' => 1.80,
                'inner_page_multiplier' => 1.00,
                'color_charge_percent' => 30,
                'min_words' => 20,
                'contact_email' => 'ads@bd-pratidin.com',
                'sort_order' => 2,
            ],
            [
                'name' => 'দ্য ডেইলি স্টার (The Daily Star)',
                'slug' => 'the-daily-star',
                'language' => 'english',
                'classified_rate_per_word' => 22.00,
                'display_rate_col_inch' => 2500.00,
                'front_page_multiplier' => 2.80,
                'back_page_multiplier' => 1.90,
                'inner_page_multiplier' => 1.00,
                'color_charge_percent' => 35,
                'min_words' => 20,
                'contact_email' => 'ads@thedailystar.net',
                'sort_order' => 3,
            ],
            [
                'name' => 'দৈনিক ইত্তেফাক (Daily Ittefaq)',
                'slug' => 'daily-ittefaq',
                'language' => 'bangla',
                'classified_rate_per_word' => 14.00,
                'display_rate_col_inch' => 1800.00,
                'front_page_multiplier' => 2.20,
                'back_page_multiplier' => 1.60,
                'inner_page_multiplier' => 1.00,
                'color_charge_percent' => 25,
                'min_words' => 20,
                'contact_email' => 'ads@ittefaq.com.bd',
                'sort_order' => 4,
            ],
            [
                'name' => 'দৈনিক সমকাল (Daily Samakal)',
                'slug' => 'daily-samakal',
                'language' => 'bangla',
                'classified_rate_per_word' => 15.00,
                'display_rate_col_inch' => 1900.00,
                'front_page_multiplier' => 2.40,
                'back_page_multiplier' => 1.70,
                'inner_page_multiplier' => 1.00,
                'color_charge_percent' => 30,
                'min_words' => 20,
                'contact_email' => 'ads@samakal.com',
                'sort_order' => 5,
            ],
            [
                'name' => 'দৈনিক কালের কণ্ঠ (Kaler Kantho)',
                'slug' => 'kaler-kantho',
                'language' => 'bangla',
                'classified_rate_per_word' => 14.00,
                'display_rate_col_inch' => 1800.00,
                'front_page_multiplier' => 2.20,
                'back_page_multiplier' => 1.60,
                'inner_page_multiplier' => 1.00,
                'color_charge_percent' => 25,
                'min_words' => 20,
                'contact_email' => 'ads@kalerkantho.com',
                'sort_order' => 6,
            ],
            [
                'name' => 'দৈনিক আমাদের সময় (Amader Shomoy)',
                'slug' => 'amader-shomoy',
                'language' => 'bangla',
                'classified_rate_per_word' => 12.00,
                'display_rate_col_inch' => 1500.00,
                'front_page_multiplier' => 2.00,
                'back_page_multiplier' => 1.50,
                'inner_page_multiplier' => 1.00,
                'color_charge_percent' => 25,
                'min_words' => 20,
                'contact_email' => 'ads@amadershomoy.com',
                'sort_order' => 7,
            ],
            [
                'name' => 'ঢাকা ট্রিবিউন (Dhaka Tribune)',
                'slug' => 'dhaka-tribune',
                'language' => 'english',
                'classified_rate_per_word' => 18.00,
                'display_rate_col_inch' => 2000.00,
                'front_page_multiplier' => 2.50,
                'back_page_multiplier' => 1.80,
                'inner_page_multiplier' => 1.00,
                'color_charge_percent' => 30,
                'min_words' => 20,
                'contact_email' => 'ads@dhakatribune.com',
                'sort_order' => 8,
            ],
        ];

        foreach ($newspapers as $np) {
            Newspaper::create($np);
        }

        // 3. Ad Categories
        $categories = [
            [
                'name' => 'বাড়ি ভাড়া / ফ্ল্যাট ভাড়া',
                'slug' => 'house-rent',
                'type' => 'all',
                'icon' => 'home',
                'sample_text' => 'পশ্চিম আগারগাঁও ৩ বেড, ২ বাথ, ড্রইং-ডাইনিং, ২য় তলা বাসা ভাড়া দেওয়া হবে। যোগাযোগঃ ০১৭xxxxxxxx',
                'requires_document' => false,
                'sort_order' => 1,
            ],
            [
                'name' => 'ফ্ল্যাট বিক্রয় / জমি বিক্রয়',
                'slug' => 'property-sale',
                'type' => 'all',
                'icon' => 'building',
                'sample_text' => 'বসুন্ধরা আবাসিক এলাকায় অত্যাধুনিক সুযোগ-সুবিধাসহ ১৮৫০ বর্গফুটের রেডি এপার্টমেন্ট বিক্রয় হবে। লিফট ও জেনারেটর সুবিধা সহ। যোগাযোগঃ ০১৮xxxxxxxx',
                'requires_document' => false,
                'sort_order' => 2,
            ],
            [
                'name' => 'হারানো বিজ্ঞপ্তি (GD আবশ্যক)',
                'slug' => 'lost-notice',
                'type' => 'classified',
                'icon' => 'alert-circle',
                'sample_text' => 'আমার এসএসসি সনদপত্র ও জাতীয় পরিচয়পত্র শাহবাগ এলাকায় হারিয়ে গিয়েছে। এ বিষয়ে শাহবাগ থানায় জিডি করা হয়েছে, জিডি নং: ১২৩৪, তারিখ: ১২/১১/২০২৬। যোগাযোগঃ ০১৭১xxxxxxx',
                'requires_document' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'এফিডেভিট / নাম ও বয়স সংশোধনী',
                'slug' => 'affidavit-correction',
                'type' => 'classified',
                'icon' => 'file-text',
                'sample_text' => 'আমি নিম্নস্বাক্ষরকারী মোহাম্মদ করিম, পিতা: আব্দুর রহিম, ঘোষণা করিতেছি যে আমার সকল শিক্ষা সনদে ভুলবশত নাম করিম মিয়া লিপিবদ্ধ হইয়াছে। বিজ্ঞ নোটারি পাবলিক এর এফিডেভিট নং-৫৬৭৮ মূলে আমি অদ্য হইতে মোহাম্মদ করিম নামে পরিচিত হইব।',
                'requires_document' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'পাত্র / পাত্রী চাই (ম্যাট্রিমোনিয়াল)',
                'slug' => 'matrimonial',
                'type' => 'classified',
                'icon' => 'heart',
                'sample_text' => 'ঢাকায় প্রতিষ্ঠিত সম্ভ্রান্ত মুসলিম পরিবারের জন্য ইঞ্জিনিয়ার/ডাক্তার পাত্রের জন্য সুশিক্ষিতা ধার্মিক পাত্রী আবশ্যক। যোগাযোগঃ ০১৫xxxxxxxx',
                'requires_document' => false,
                'sort_order' => 5,
            ],
            [
                'name' => 'নিয়োগ বিজ্ঞপ্তি / চাকরি',
                'slug' => 'job-vacancy',
                'type' => 'all',
                'icon' => 'briefcase',
                'sample_text' => 'একটি স্বনামধন্য আইটি প্রতিষ্ঠানের জন্য জরুরি ভিত্তিতে ২ জন সিনিয়র ওয়েব ডেভেলপার আবশ্যক। আকর্ষণীয় বেতন ও অন্যান্য সুযোগ-সুবিধা। সিভি পাঠান: hr@company.com',
                'requires_document' => false,
                'sort_order' => 6,
            ],
            [
                'name' => 'গাড়ি বিক্রয়',
                'slug' => 'car-sale',
                'type' => 'all',
                'icon' => 'truck',
                'sample_text' => 'টয়োটা করোলা এক্স করোলা ২০০৬ মডেল, সেলফ ড্রাইভেন, অল পেপার্স আপ টু ডেট, ইমার্জেন্সি বিক্রয় হইবে। সরাসরি মালিক: ০১৭১xxxxxxx',
                'requires_document' => false,
                'sort_order' => 7,
            ],
            [
                'name' => 'টিউটর চাই / পড়াতে চাই',
                'slug' => 'tuition',
                'type' => 'classified',
                'icon' => 'book-open',
                'sample_text' => 'ধানমন্ডি এলাকায় বাংলা মাধ্যম ৯ম শ্রেণির ছাত্রের জন্য বুয়েট/ঢাবির অভিজ্ঞ পুরুষ গৃহশিক্ষক প্রয়োজন। সপ্তাহে ৪ দিন। যোগাযোগঃ ০১৭xxxxxxxx',
                'requires_document' => false,
                'sort_order' => 8,
            ],
            [
                'name' => 'দরপত্র / আইনি নোটিশ / টেন্ডার',
                'slug' => 'tender-legal-notice',
                'type' => 'display',
                'icon' => 'shield',
                'sample_text' => 'জরুরি নিলাম বিজ্ঞপ্তি / আইনি নোটিশ সংক্রান্ত বিস্তারিত তথ্য।',
                'requires_document' => true,
                'sort_order' => 9,
            ],
        ];

        foreach ($categories as $cat) {
            AdCategory::create($cat);
        }

        // 4. Create Users (Admin, Clients, Designers)
        $admin = User::create([
            'name' => 'সিস্টেম অ্যাডমিন (Admin)',
            'email' => 'admin@reporter.test',
            'phone' => '01854820303',
            'role' => 'admin',
            'password' => Hash::make('password'),
            'status' => 'active',
        ]);

        $client = User::create([
            'name' => 'রফিকুল ইসলাম',
            'email' => 'client@reporter.test',
            'phone' => '01711223344',
            'role' => 'client',
            'password' => Hash::make('password'),
            'balance' => 5000.00,
            'status' => 'active',
        ]);

        $designerUser1 = User::create([
            'name' => 'তানভীর আহমেদ',
            'email' => 'tanvir@reporter.test',
            'phone' => '01911223344',
            'role' => 'designer',
            'password' => Hash::make('password'),
            'balance' => 8500.00,
            'status' => 'active',
            'bio' => '৮ বছরের অভিজ্ঞতা সম্পন্ন প্রি-প্রেস ও পত্রিকা বিজ্ঞাপন ডিজাইনার। প্রথম আলো ও ডেইলি স্টারের অ্যাড ফরম্যাট সম্পর্কে বিশদ জ্ঞান।',
        ]);

        DesignerProfile::create([
            'user_id' => $designerUser1->id,
            'tagline' => 'প্রফেশনাল নিউজপেপার ও ডিসপ্লে বিজ্ঞাপন বিশেষজ্ঞ',
            'about' => 'আমি বাংলাদেশের প্রধান প্রধান জাতীয় দৈনিকের জন্য ৫০০+ বিজ্ঞাপন সফলভাবে ডিজাইন করেছি। প্রি-প্রেস প্রিন্টিং টেকনোলজি এবং কালার সেপারেশনে পারদর্শী।',
            'experience_years' => 8,
            'starting_rate' => 600.00,
            'skills' => 'Newspaper Ads, Display Ads, Pre-press, Typography, Color Separation, Adobe Illustrator, Adobe Photoshop',
            'completed_orders' => 142,
            'rating' => 4.95,
            'total_reviews' => 98,
            'is_featured' => true,
            'is_available' => true,
            'portfolio' => [
                ['title' => 'আবাসিক প্রকল্পের ফুল পেজ রঙিন বিজ্ঞাপন', 'category' => 'Display Ad', 'image' => 'https://images.unsplash.com/photo-1542744094-3a31f272c490?w=600'],
                ['title' => 'ব্যাংক ও আর্থিক প্রতিষ্ঠানের এনুয়াল রিপোর্ট অ্যাড', 'category' => 'Corporate', 'image' => 'https://images.unsplash.com/photo-1557804506-669a67965ba0?w=600'],
                ['title' => 'বিশ্ববিদ্যালয় ভর্তি বিজ্ঞপ্তি কোয়ার্টার পেজ', 'category' => 'Education', 'image' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=600'],
            ],
        ]);

        $designerUser2 = User::create([
            'name' => 'নুসরাত জাহান রিয়া',
            'email' => 'nusrat@reporter.test',
            'phone' => '01811223344',
            'role' => 'designer',
            'password' => Hash::make('password'),
            'balance' => 4200.00,
            'status' => 'active',
            'bio' => 'ক্রিয়েটিভ আর্ট ডিরেক্টর ও গ্রাফিক ডিজাইনার। ব্র্যান্ডিং ও বিজ্ঞাপন প্রচারণায় বিশেষ দক্ষতা।',
        ]);

        DesignerProfile::create([
            'user_id' => $designerUser2->id,
            'tagline' => 'মডার্ন ও মিনিমালিস্ট অ্যাড ডিজাইন স্পেশালিস্ট',
            'about' => 'ডিজাইনে আধুনিকতা ও পরিষ্কার লেআউট পছন্দ করি। আপনার বিজ্ঞাপনকে পত্রিকার ভিড়েও সবার চোখে পড়ার মতো দৃষ্টিনন্দন করে তুলব।',
            'experience_years' => 5,
            'starting_rate' => 800.00,
            'skills' => 'Display Ads, Typography, Modern Layout, Luxury Branding, Poster, Social Media Cross-promotion',
            'completed_orders' => 86,
            'rating' => 4.90,
            'total_reviews' => 64,
            'is_featured' => true,
            'is_available' => true,
            'portfolio' => [
                ['title' => 'ফ্যাশন ব্র্যান্ড লঞ্চিং ব্যানার বিজ্ঞাপন', 'category' => 'Lifestyle', 'image' => 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=600'],
                ['title' => 'আইটি কোম্পানি রিক্রুটমেন্ট ক্যাম্পেইন অ্যাড', 'category' => 'Recruitment', 'image' => 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?w=600'],
            ],
        ]);

        $designerUser3 = User::create([
            'name' => 'আসিফ মাহমুদ',
            'email' => 'asif@reporter.test',
            'phone' => '01611223344',
            'role' => 'designer',
            'password' => Hash::make('password'),
            'balance' => 2100.00,
            'status' => 'active',
            'bio' => 'দ্রুত ডেলিভারি ও বাজেট-বান্ধব বিজ্ঞাপন ডিজাইনার। মাত্র ২ ঘণ্টার মধ্যে ড্রাফট সরবরাহ।',
        ]);

        DesignerProfile::create([
            'user_id' => $designerUser3->id,
            'tagline' => 'ফাস্ট ডেলিভারি নিউজপেপার নোটিশ ও আর্টওয়ার্ক',
            'about' => 'জরুরি বিজ্ঞাপন প্রকাশের জন্য দ্রুত এবং নির্ভুল ডিজাইন প্রয়োজন হলে আমি আছি। ৩টি ফ্রি রিভিশন নিশ্চিত।',
            'experience_years' => 4,
            'starting_rate' => 500.00,
            'skills' => 'Urgent Ads, Notice Design, Black & White Newspaper Specs, Raster to Vector',
            'completed_orders' => 54,
            'rating' => 4.82,
            'total_reviews' => 41,
            'is_featured' => false,
            'is_available' => true,
            'portfolio' => [
                ['title' => 'জরুরি নিলাম ও টেন্ডার নোটিশ ডিজাইন', 'category' => 'Notice', 'image' => 'https://images.unsplash.com/photo-1450133064473-71024230f91b?w=600'],
            ],
        ]);

        // 5. Sample Classified Ads
        $prothomAlo = Newspaper::where('slug', 'prothom-alo')->first();
        $bdPratidin = Newspaper::where('slug', 'bangladesh-pratidin')->first();
        $houseRentCat = AdCategory::where('slug', 'house-rent')->first();
        $lostCat = AdCategory::where('slug', 'lost-notice')->first();

        $cAd1 = ClassifiedAd::create([
            'tracking_no' => 'CLS-202611-1001',
            'user_id' => $client->id,
            'customer_name' => $client->name,
            'customer_email' => $client->email,
            'customer_phone' => $client->phone,
            'newspaper_id' => $prothomAlo->id,
            'ad_category_id' => $houseRentCat->id,
            'publish_date' => now()->addDays(2)->toDateString(),
            'title' => 'ধানমন্ডিতে ৩ বেডের আধুনিক ফ্ল্যাট বাসা ভাড়া হবে',
            'ad_body' => 'ধানমন্ডি ৮/এ লেকের কাছে ৩ বেড, ৩ বাথ, ড্রইং-ডাইনিং, লিফট, কার পার্কিং ও জেনারেটর সহ ৩য় তলায় মনোরম পরিবেশে ফ্ল্যাট বাসা ভাড়া দেওয়া হবে। যোগাযোগঃ ০১৭১১২২৩৩৪',
            'word_count' => 28,
            'total_amount' => 560.00,
            'payment_method' => 'bkash',
            'payment_trx_id' => 'BK928371923',
            'payment_sender_phone' => '01711223344',
            'payment_status' => 'paid',
            'status' => 'approved',
            'admin_notes' => 'পেমেন্ট ভেরিফাইড এবং পত্রিকায় প্রকাশের জন্য শিডিউল করা হয়েছে।',
        ]);

        PaymentRecord::create([
            'invoice_no' => 'INV-202611-1001',
            'user_id' => $client->id,
            'order_type' => 'classified_ad',
            'order_id' => $cAd1->id,
            'amount' => 560.00,
            'payment_method' => 'bkash',
            'trx_id' => 'BK928371923',
            'sender_phone' => '01711223344',
            'status' => 'approved',
            'verified_by' => $admin->id,
            'verified_at' => now(),
            'notes' => 'Auto-verified test transaction',
        ]);

        $cAd2 = ClassifiedAd::create([
            'tracking_no' => 'CLS-202611-1002',
            'user_id' => $client->id,
            'customer_name' => $client->name,
            'customer_email' => $client->email,
            'customer_phone' => $client->phone,
            'newspaper_id' => $bdPratidin->id,
            'ad_category_id' => $lostCat->id,
            'publish_date' => now()->addDays(1)->toDateString(),
            'title' => 'জাতীয় পরিচয়পত্র ও পাসপোর্ট হারানো বিজ্ঞপ্তি',
            'ad_body' => 'আমার মূল পাসপোর্ট নং BP1234567 এবং জাতীয় পরিচয়পত্র মতিঝিল এলাকায় হারিয়ে গিয়েছে। এই বিষয়ে মতিঝিল থানায় জিডি করা হয়েছে (জিডি নং: ৯৮৭, তারিখ: ১৫/১১/২০২৬)। যোগাযোগঃ ০১৮১১২২৩৩৪৪',
            'word_count' => 27,
            'total_amount' => 432.00,
            'payment_method' => 'nagad',
            'payment_trx_id' => 'NG812398471',
            'payment_sender_phone' => '01811223344',
            'payment_status' => 'paid',
            'status' => 'published',
            'published_proof_url' => 'https://epaper.bd-pratidin.com',
            'admin_notes' => 'বাংলাদেশ প্রতিদিন পত্রিকায় প্রকাশিত হয়েছে।',
        ]);

        // 6. Sample Display Ad
        $jobCat = AdCategory::where('slug', 'job-vacancy')->first();
        $dspAd = DisplayAd::create([
            'tracking_no' => 'DSP-202611-2001',
            'user_id' => $client->id,
            'customer_name' => 'বাংলা টেক সলিউশন লিমিটেড',
            'customer_email' => 'hr@banglatech.test',
            'customer_phone' => '01911223344',
            'newspaper_id' => $prothomAlo->id,
            'ad_category_id' => $jobCat->id,
            'publish_date' => now()->addDays(3)->toDateString(),
            'title' => 'সফটওয়্যার ইঞ্জিনিয়ার নিয়োগ বিজ্ঞপ্তি (৪ কলাম × ৫ ইঞ্চি)',
            'page_position' => 'inner_page',
            'color_type' => 'color',
            'columns' => 4,
            'height_inches' => 5.00,
            'total_col_inches' => 20.00,
            'rate_applied' => 2800.00,
            'needs_designer' => true,
            'total_amount' => 75600.00, // 20 col-inch * 2800 * 1.35 color
            'payment_method' => 'bank',
            'payment_trx_id' => 'DBBL-TRX-876129',
            'payment_sender_phone' => '01911223344',
            'payment_status' => 'paid',
            'status' => 'approved',
            'admin_notes' => 'বিজ্ঞাপনটি প্রস্তুত, ডিজাইনার তানভীর আর্টওয়ার্ক রিভিশন করছেন।',
        ]);

        // 7. Sample Design Order
        $designOrder = DesignOrder::create([
            'order_no' => 'DSN-202611-3001',
            'client_id' => $client->id,
            'designer_id' => $designerUser1->id,
            'title' => 'প্রথম আলোর জন্য ৪ কলাম × ৫ ইঞ্চি জব রিক্রুটমেন্ট অ্যাড ডিজাইন',
            'brief_description' => 'আমাদের টেক কোম্পানির নিয়োগ বিজ্ঞাপনের একটি দৃষ্টিনন্দন কালার ডিসপ্লে ডিজাইন লাগবে। লোগো ও টেক্সট সংযুক্ত করা হয়েছে। হাই-রেজ্যুলেশন প্রি-প্রেস প্রিন্টিং রেডি PDF ফাইল দরকার।',
            'ad_size_requirement' => '৪ কলাম × ৫ ইঞ্চি (Width: 6.2 inch, Height: 5 inch)',
            'budget' => 800.00,
            'revisions_remaining' => 2,
            'status' => 'draft_submitted',
            'escrow_funded' => true,
        ]);

        DesignOrderMessage::create([
            'design_order_id' => $designOrder->id,
            'sender_id' => $client->id,
            'message' => 'আসসালামু আলাইকুম তানভীর ভাই। কাজের ব্রিফ ও কোম্পানির ব্র্যান্ডিং কালার গাইডলাইন পাঠিয়েছি। প্রথম আলো অনুযায়ী স্পেসিফিকেশন মেইনটেইন করবেন প্লিজ।',
        ]);

        DesignOrderMessage::create([
            'design_order_id' => $designOrder->id,
            'sender_id' => $designerUser1->id,
            'message' => 'ওয়ালাইকুম আসসালাম। ধন্যবাদ রফিকুল সাহেব! ব্রিফ পেয়েছি। আজ সন্ধ্যার মধ্যেই ১ম ড্রাফট সাবমিট করছি।',
        ]);

        DesignOrderMessage::create([
            'design_order_id' => $designOrder->id,
            'sender_id' => $designerUser1->id,
            'message' => '১ম ড্রাফট প্রস্তুত করেছি। দয়া করে কালার স্কিম ও ফন্ট সাইজ চেক করে রিভিশন থাকলে জানান।',
            'attachment_file' => 'https://images.unsplash.com/photo-1542744094-3a31f272c490?w=1000',
            'is_draft_submission' => true,
        ]);
    }
}
