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
            return redirect()->route('login')->with('error', 'ডিজাইনার ড্যাশবোর্ডে প্রবেশ করতে লগইন করুন।');
        }

        if (auth()->user()->role !== 'designer' && auth()->user()->role !== 'admin') {
            abort(403, 'শুধুমাত্র ডিজাইনারদের জন্য এই ড্যাশবোর্ড নির্ধারিত।');
        }

        return $next($request);
    }
}
