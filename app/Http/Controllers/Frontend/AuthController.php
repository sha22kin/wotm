<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('user.profile');
        }

        $settings = Setting::getAllGrouped();
        return view('login', compact('settings'));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ], [
            'email.required' => app()->getLocale() === 'en' ? 'Email or mobile number is required.' : 'ইমেইল অথবা মোবাইল নম্বর আবশ্যক।',
            'password.required' => app()->getLocale() === 'en' ? 'Password is required.' : 'পাসওয়ার্ড আবশ্যক।',
        ]);

        $loginInput = trim($credentials['email']);
        $field = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        if ($field === 'email') {
            $loginInput = strtolower($loginInput);
        }

        if (Auth::attempt([$field => $loginInput, 'password' => $credentials['password']], $request->has('remember'))) {
            $request->session()->regenerate();

            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard')->with('success', app()->getLocale() === 'en' ? 'Welcome to Admin Dashboard!' : 'অ্যাডমিন ড্যাশবোর্ডে স্বাগতম!');
            }

            return redirect()->route('user.profile')->with('success', app()->getLocale() === 'en' ? 'Welcome to your profile dashboard!' : 'আপনার প্রোফাইল ড্যাশবোর্ডে স্বাগতম!');
        }

        // Generic error message to prevent account enumeration
        return back()->withErrors([
            'email' => app()->getLocale() === 'en' 
                ? 'Email or password is incorrect. Please try again.' 
                : 'ইমেইল অথবা পাসওয়ার্ড ভুল। দয়া করে আবার চেষ্টা করুন।',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('user.profile');
        }

        $settings = Setting::getAllGrouped();
        return view('register', compact('settings'));
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email', new \App\Rules\NotDisposableEmail],
            'phone' => 'nullable|string|max:20|unique:users,phone',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'email.unique' => app()->getLocale() === 'en' ? 'This email address is already registered.' : 'এই ইমেইলটি ইতিমধ্যে ব্যবহৃত হয়েছে।',
            'phone.unique' => app()->getLocale() === 'en' ? 'This phone number is already registered.' : 'এই মোবাইল নম্বরটি ইতিমধ্যে ব্যবহৃত হয়েছে।',
            'password.confirmed' => app()->getLocale() === 'en' ? 'Password confirmation does not match.' : 'পাসওয়ার্ড নিশ্চিতকরণ মিলছে না।',
            'password.min' => app()->getLocale() === 'en' ? 'Password must be at least 6 characters.' : 'পাসওয়ার্ড কমপক্ষে ৬ অক্ষরের হতে হবে।',
        ]);

        // Input Sanitization
        $cleanName = strip_tags(trim($validated['name']));
        $cleanEmail = strtolower(trim($validated['email']));
        $cleanPhone = !empty($validated['phone']) ? strip_tags(trim($validated['phone'])) : null;

        $user = User::create([
            'name' => $cleanName,
            'email' => $cleanEmail,
            'phone' => $cleanPhone,
            'password' => Hash::make($validated['password']),
            'role' => 'member',
            'is_admin' => false,
            'status' => 'active',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('user.profile')->with('success', app()->getLocale() === 'en' ? 'Account created successfully! Welcome to your dashboard.' : 'আপনার অ্যাকাউন্ট সফলভাবে তৈরি হয়েছে! ড্যাশবোর্ডে স্বাগতম।');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', app()->getLocale() === 'en' ? 'Logged out successfully.' : 'সফলভাবে লগআউট হয়েছেন।');
    }
}
