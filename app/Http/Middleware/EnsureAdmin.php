<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('admin.login')->with('error', 'অ্যাডমিন প্যানেলে প্রবেশ করতে অনুগ্রহ করে অ্যাডমিন একাউন্টে লগইন করুন।');
        }

        if (auth()->user()->role !== 'admin') {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('admin.login')->with('error', 'অননুমোদিত প্রবেশ! এই পোর্টালটি শুধুমাত্র সিস্টেম অ্যাডমিনদের জন্য।');
        }

        return $next($request);
    }
}
