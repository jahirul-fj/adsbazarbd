<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureDesigner
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('designer.login')->with('error', 'ডিজাইনার ড্যাশবোর্ডে প্রবেশ করতে ডিজাইনার একাউন্টে লগইন করুন।');
        }

        if (auth()->user()->role !== 'designer') {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('designer.login')->with('error', 'এই পোর্টালটি শুধুমাত্র নিবন্ধিত গ্রাফিক ডিজাইনারদের জন্য।');
        }

        return $next($request);
    }
}
