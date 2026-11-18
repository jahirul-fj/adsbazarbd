<?php

namespace App\Http\Controllers;

use App\Models\AdCategory;
use App\Models\ClassifiedAd;
use App\Models\DesignerProfile;
use App\Models\DisplayAd;
use App\Models\Newspaper;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $newspapers = Newspaper::where('is_active', true)->orderBy('sort_order')->get();
        $categories = AdCategory::where('is_active', true)->orderBy('sort_order')->get();
        $featuredDesigners = DesignerProfile::with('user')
            ->where('is_featured', true)
            ->where('is_available', true)
            ->take(6)
            ->get();

        $stats = [
            'total_ads' => ClassifiedAd::count() + DisplayAd::count() + 1250,
            'newspapers_count' => $newspapers->count(),
            'designers_count' => DesignerProfile::count() + 15,
            'satisfaction_rate' => '99.4%',
        ];

        return view('pages.home', compact('newspapers', 'categories', 'featuredDesigners', 'stats'));
    }

    public function about()
    {
        return view('pages.about');
    }

    public function faq()
    {
        return view('pages.faq');
    }

    public function pricing()
    {
        $newspapers = Newspaper::where('is_active', true)->orderBy('sort_order')->get();
        return view('pages.pricing', compact('newspapers'));
    }

    public function track(Request $request)
    {
        $trackingNo = trim($request->input('tracking_no'));
        $ad = null;
        $adType = null;

        if ($trackingNo) {
            if (str_starts_with(strtoupper($trackingNo), 'DSP')) {
                $ad = DisplayAd::with(['newspaper', 'category'])->where('tracking_no', $trackingNo)->first();
                $adType = 'display';
            } else {
                $ad = ClassifiedAd::with(['newspaper', 'category'])->where('tracking_no', $trackingNo)->first();
                $adType = 'classified';
            }
        }

        return view('pages.track', compact('trackingNo', 'ad', 'adType'));
    }

    public function contact()
    {
        return view('pages.contact');
    }
}
