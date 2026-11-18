<?php

namespace App\Http\Controllers;

use App\Models\DesignerProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return $this->redirectBasedOnRole(Auth::user());
        }

        return back()->withErrors([
            'email' => 'প্রদত্ত ইমেইল অথবা পাসওয়ার্ড সঠিক নয়।',
        ])->onlyInput('email');
    }

    public function quickLogin($role)
    {
        $email = match ($role) {
            'admin' => 'admin@reporter.test',
            'designer' => 'tanvir@reporter.test',
            default => 'client@reporter.test',
        };

        $user = User::where('email', $email)->first();
        if ($user) {
            Auth::login($user);
            return $this->redirectBasedOnRole($user)->with('success', 'স্বাগতম, ' . $user->name . '! আপনি লগইন করেছেন।');
        }

        return redirect()->route('login')->with('error', 'ব্যবহারকারী পাওয়া যায়নি।');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'role' => 'required|in:client,designer',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'role' => $validated['role'],
            'password' => Hash::make($validated['password']),
            'status' => 'active',
        ]);

        // If designer, create profile
        if ($user->role === 'designer') {
            DesignerProfile::create([
                'user_id' => $user->id,
                'tagline' => 'প্রফেশনাল গ্রাফিক ডিজাইনার',
                'about' => 'সংবাদপত্র বিজ্ঞাপন ও প্রকাশনা নকশা বিশেষজ্ঞ।',
                'experience_years' => 2,
                'starting_rate' => 500.00,
                'skills' => 'Newspaper Ads, Adobe Illustrator, Photoshop',
                'completed_orders' => 0,
                'rating' => 5.00,
                'total_reviews' => 0,
                'is_available' => true,
            ]);
        }

        Auth::login($user);

        return $this->redirectBasedOnRole($user)->with('success', 'আপনার অ্যাকাউন্টটি সফলভাবে তৈরি হয়েছে!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('info', 'আপনি সফলভাবে লগআউট করেছেন।');
    }

    protected function redirectBasedOnRole(User $user)
    {
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isDesigner()) {
            return redirect()->route('designer.dashboard');
        }
        return redirect()->route('client.dashboard');
    }
}
