<?php

namespace App\Http\Controllers;

use App\Models\DesignerProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ==========================================
    // 1. ADMIN AUTHENTICATION
    // ==========================================

    public function showAdminLogin()
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();
            if ($user->isAdmin()) {
                $request->session()->regenerate();
                return redirect()->route('admin.dashboard')->with('success', 'অ্যাডমিন ড্যাশবোর্ডে স্বাগতম, ' . $user->name . '!');
            }

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return back()->with('error', 'অননুমোদিত প্রবেশ! এই লগইন পোর্টালটি শুধুমাত্র সিস্টেম অ্যাডমিনদের জন্য।')
                ->withErrors(['email' => 'অননুমোদিত প্রবেশ! এই লগইন পোর্টালটি শুধুমাত্র সিস্টেম অ্যাডমিনদের জন্য।'])->onlyInput('email');
        }

        return back()->with('error', 'প্রদত্ত অ্যাডমিন ইমেইল অথবা পাসওয়ার্ড সঠিক নয়।')
            ->withErrors(['email' => 'প্রদত্ত অ্যাডমিন ইমেইল অথবা পাসওয়ার্ড সঠিক নয়।'])->onlyInput('email');
    }

    public function adminLogout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login')->with('info', 'অ্যাডমিন প্যানেল থেকে সফলভাবে লগআউট হয়েছেন।');
    }

    // ==========================================
    // 2. CLIENT AUTHENTICATION
    // ==========================================

    public function showClientLogin()
    {
        if (Auth::check() && Auth::user()->isClient()) {
            return redirect()->route('client.dashboard');
        }
        return view('client.auth.login');
    }

    public function clientLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();
            if ($user->isClient()) {
                $request->session()->regenerate();
                return redirect()->route('client.dashboard')->with('success', 'স্বাগতম, ' . $user->name . '!');
            }

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return back()->with('error', 'এই লগইনটি শুধুমাত্র বিজ্ঞাপনদাতা গ্রাহকদের জন্য। ডিজাইনার বা অ্যাডমিনগণ তাদের নির্ধারিত পোর্টালে লগইন করুন।')
                ->withErrors(['email' => 'এই লগইনটি শুধুমাত্র বিজ্ঞাপনদাতা গ্রাহকদের জন্য। ডিজাইনার বা অ্যাডমিনগণ তাদের নির্ধারিত পোর্টালে লগইন করুন।'])->onlyInput('email');
        }

        return back()->with('error', 'প্রদত্ত ইমেইল অথবা পাসওয়ার্ড সঠিক নয়।')
            ->withErrors(['email' => 'প্রদত্ত ইমেইল অথবা পাসওয়ার্ড সঠিক নয়।'])->onlyInput('email');
    }

    public function showClientRegister()
    {
        if (Auth::check() && Auth::user()->isClient()) {
            return redirect()->route('client.dashboard');
        }
        return view('client.auth.register');
    }

    public function clientRegister(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'role' => 'client',
            'password' => Hash::make($validated['password']),
            'status' => 'active',
        ]);

        Auth::login($user);

        return redirect()->route('client.dashboard')->with('success', 'আপনার ক্লায়েন্ট অ্যাকাউন্টটি সফলভাবে তৈরি হয়েছে!');
    }

    public function clientLogout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('client.login')->with('info', 'আপনি সফলভাবে লগআউট করেছেন।');
    }

    // ==========================================
    // 3. DESIGNER AUTHENTICATION
    // ==========================================

    public function showDesignerLogin()
    {
        if (Auth::check() && Auth::user()->isDesigner()) {
            return redirect()->route('designer.dashboard');
        }
        return view('designer.auth.login');
    }

    public function designerLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();
            if ($user->isDesigner()) {
                $request->session()->regenerate();
                return redirect()->route('designer.dashboard')->with('success', 'ডিজাইনার ড্যাশবোর্ডে স্বাগতম, ' . $user->name . '!');
            }

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return back()->with('error', 'এই লগইনটি শুধুমাত্র গ্রাফিক ডিজাইনারদের জন্য।')
                ->withErrors(['email' => 'এই লগইনটি শুধুমাত্র গ্রাফিক ডিজাইনারদের জন্য।'])->onlyInput('email');
        }

        return back()->with('error', 'প্রদত্ত ইমেইল অথবা পাসওয়ার্ড সঠিক নয়।')
            ->withErrors(['email' => 'প্রদত্ত ইমেইল অথবা পাসওয়ার্ড সঠিক নয়।'])->onlyInput('email');
    }

    public function showDesignerRegister()
    {
        if (Auth::check() && Auth::user()->isDesigner()) {
            return redirect()->route('designer.dashboard');
        }
        return view('designer.auth.register');
    }

    public function designerRegister(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'tagline' => 'required|string|max:255',
            'experience_years' => 'required|integer|min:0',
            'starting_rate' => 'required|numeric|min:100',
            'skills' => 'required|string|max:500',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'role' => 'designer',
            'password' => Hash::make($validated['password']),
            'status' => 'active',
        ]);

        DesignerProfile::create([
            'user_id' => $user->id,
            'tagline' => $validated['tagline'],
            'about' => 'সংবাদপত্র বিজ্ঞাপন ও প্রকাশনা নকশা বিশেষজ্ঞ।',
            'experience_years' => $validated['experience_years'],
            'starting_rate' => $validated['starting_rate'],
            'skills' => $validated['skills'],
            'completed_orders' => 0,
            'rating' => 5.00,
            'total_reviews' => 0,
            'is_available' => true,
        ]);

        Auth::login($user);

        return redirect()->route('designer.dashboard')->with('success', 'আপনার ডিজাইনার অ্যাকাউন্টটি সফলভাবে তৈরি হয়েছে!');
    }

    public function designerLogout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('designer.login')->with('info', 'ডিজাইনার প্যানেল থেকে সফলভাবে লগআউট হয়েছেন।');
    }

    // ==========================================
    // 4. PORTAL SELECTOR / GENERIC REDIRECT
    // ==========================================

    public function logout(Request $request)
    {
        $role = Auth::user()?->role;
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($role === 'admin') {
            return redirect()->route('admin.login')->with('info', 'অ্যাডমিন প্যানেল থেকে সফলভাবে লগআউট হয়েছেন।');
        } elseif ($role === 'designer') {
            return redirect()->route('designer.login')->with('info', 'ডিজাইনার পোর্টাল থেকে সফলভাবে লগআউট হয়েছেন।');
        }

        return redirect()->route('home')->with('info', 'সফলভাবে লগআউট হয়েছেন।');
    }

    public function showPortalSelector()
    {
        return view('auth.portal-selector');
    }

    public function quickLogin($role)
    {
        $email = match ($role) {
            'admin' => 'admin@adsbazarbd.com',
            'designer' => 'tanvir@adsbazarbd.com',
            default => 'client@adsbazarbd.com',
        };

        $user = User::where('email', $email)->first();
        if ($user) {
            Auth::login($user);
            if ($user->isAdmin()) return redirect()->route('admin.dashboard');
            if ($user->isDesigner()) return redirect()->route('designer.dashboard');
            return redirect()->route('client.dashboard');
        }

        return redirect()->route('portal.select');
    }
}
