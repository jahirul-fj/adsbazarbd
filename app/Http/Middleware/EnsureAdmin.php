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
            return redirect()->route('login')->with('error', 'অ্যাডমিন প্যানেলে প্রবেশ করতে অনুগ্রহ করে লগইন করুন।');
        }

        if (auth()->user()->role !== 'admin') {
            abort(403, 'আপনার এই পেইজে প্রবেশ করার অনুমতি নেই।');
        }

        return $next($request);
    }
}
