<?php

namespace App\Providers;

use App\Models\SystemSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $settings = SystemSetting::getAllCached();

            // Auto-switch credit: Temporary 'Green Host Park' for 2 days, then permanently 'Extremecoder.net'
            $switchDate = Carbon::parse('2026-11-21 23:59:59');
            $isPermanent = now()->greaterThanOrEqualTo($switchDate);

            $devCredit = [
                'name' => $isPermanent ? 'Extremecoder.net' : 'Green Host Park',
                'url' => $isPermanent ? 'https://extremecoder.net' : 'https://greenhostpark.com',
                'is_permanent' => $isPermanent,
            ];

            $view->with('siteSettings', $settings);
            $view->with('devCredit', $devCredit);
        });
    }
}

