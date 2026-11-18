<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureClient
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('client.login')->with('error', 'আপনার ড্যাশবোর্ডে প্রবেশ করতে লগইন করুন।');
        }

        if (auth()->user()->role !== 'client') {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('client.login')->with('error', 'এই ড্যাশবোর্ডটি শুধুমাত্র ক্লায়েন্ট গ্রাহকদের জন্য।');
        }

        return $next($request);
    }
}
