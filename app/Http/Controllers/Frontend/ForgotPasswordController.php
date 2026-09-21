<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /**
     * Show the form to request a password reset link.
     */
    public function showLinkRequestForm()
    {
        $settings = Setting::getAllGrouped();
        return view('forgot-password', compact('settings'));
    }

    /**
     * Send a reset link to the given user via email.
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => app()->getLocale() === 'en' ? 'Email address is required.' : 'ইমেইল ঠিকানা আবশ্যক।',
            'email.email' => app()->getLocale() === 'en' ? 'Please provide a valid email.' : 'সঠিক ইমেইল ঠিকানা দিন।',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            // Generic message to prevent account enumeration
            return back()->with('status', app()->getLocale() === 'en' 
                ? 'If that email address is registered, we have emailed your password reset link! Please check your inbox.' 
                : 'যদি এই ইমেইলটি নিবন্ধিত থাকে, তবে পাসওয়ার্ড রিসেট লিংক পাঠানো হয়েছে! দয়া করে আপনার ইনবক্স চেক করুন।');
        }

        // Generate token and record in password_reset_tokens
        $token = Str::random(64);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => Hash::make($token),
            'created_at' => Carbon::now(),
        ]);

        $resetUrl = route('password.reset', [
            'token' => $token,
            'email' => $request->email,
        ]);

        // Configure Mailer dynamically from settings
        $this->configureMailer();

        $siteName = Setting::get('site_title', 'WOTM');
        $fromAddress = Setting::get('mail_from_address', config('mail.from.address', 'no-reply@wotm.org'));
        $fromName = Setting::get('mail_from_name', config('mail.from.name', $siteName));

        try {
            Mail::send('emails.password-reset', [
                'user' => $user,
                'resetUrl' => $resetUrl,
                'siteName' => $siteName,
            ], function ($message) use ($user, $fromAddress, $fromName, $siteName) {
                $message->from($fromAddress, $fromName)
                    ->to($user->email, $user->name)
                    ->subject(app()->getLocale() === 'en' ? "Password Reset Request - {$siteName}" : "পাসওয়ার্ড রিসেট নির্দেশিকা - {$siteName}");
            });

            return back()->with('status', app()->getLocale() === 'en' 
                ? 'We have emailed your password reset link! Please check your inbox.' 
                : 'আপনার ইমেইলে পাসওয়ার্ড রিসেট লিংক পাঠানো হয়েছে! দয়া করে আপনার ইনবক্স চেক করুন।');
        } catch (\Throwable $e) {
            // Log error
            \Log::error('Password reset email error: ' . $e->getMessage());

            // If mail failed to send due to SMTP configuration, provide feedback
            return back()->with('status', app()->getLocale() === 'en'
                ? 'Password reset link generated. Please check your inbox or spam folder.'
                : 'পাসওয়ার্ড রিসেট লিংক প্রস্তুত করা হয়েছে। ইনবক্স অথবা স্প্যাম ফোল্ডার চেক করুন।');
        }
    }

    /**
     * Display the password reset view for the given token.
     */
    public function showResetForm(Request $request, $token)
    {
        $email = $request->query('email');
        $record = DB::table('password_reset_tokens')->where('email', $email)->first();

        if (!$record || Carbon::parse($record->created_at)->addMinutes(5)->isPast()) {
            if ($record) {
                DB::table('password_reset_tokens')->where('email', $email)->delete();
            }
            return redirect()->route('password.request')->withErrors([
                'email' => app()->getLocale() === 'en' 
                    ? 'Password reset link has expired (valid for 5 minutes). Please request a new one.' 
                    : 'পাসওয়ার্ড রিসেট লিংকের মেয়াদ (৫ মিনিট) শেষ হয়ে গেছে। অনুগ্রহ করে নতুন লিংকের জন্য আবার আবেদন করুন।',
            ]);
        }

        if (!Hash::check($token, $record->token)) {
            return redirect()->route('password.request')->withErrors([
                'email' => app()->getLocale() === 'en' ? 'Invalid reset token provided.' : 'অবৈধ অথবা ভুল রিসেট টোকেন।',
            ]);
        }

        // Calculate exact remaining seconds out of 300 seconds (5 minutes)
        $elapsedSeconds = Carbon::now()->diffInSeconds(Carbon::parse($record->created_at));
        $remainingSeconds = max(0, 300 - $elapsedSeconds);

        $settings = Setting::getAllGrouped();

        return view('reset-password', compact('token', 'email', 'settings', 'remainingSeconds'));
    }

    /**
     * Reset the given user's password.
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'password.required' => app()->getLocale() === 'en' ? 'New password is required.' : 'নতুন পাসওয়ার্ড দিন।',
            'password.min' => app()->getLocale() === 'en' ? 'Password must be at least 6 characters.' : 'পাসওয়ার্ড কমপক্ষে ৬ অক্ষরের হতে হবে।',
            'password.confirmed' => app()->getLocale() === 'en' ? 'Password confirmation does not match.' : 'পাসওয়ার্ড নিশ্চিতকরণ মিলছে না।',
        ]);

        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$record) {
            return back()->withErrors([
                'email' => app()->getLocale() === 'en' ? 'Invalid or expired password reset request.' : 'অবৈধ অথবা মেয়াদোত্তীর্ণ পাসওয়ার্ড রিসেট অনুরোধ।',
            ]);
        }

        // Check token expiration (valid for 5 minutes)
        if (Carbon::parse($record->created_at)->addMinutes(5)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return redirect()->route('password.request')->withErrors([
                'email' => app()->getLocale() === 'en' 
                    ? 'Password reset link has expired (valid for 5 minutes). Please request a new one.' 
                    : 'পাসওয়ার্ড রিসেট লিংকের মেয়াদ (৫ মিনিট) শেষ হয়ে গেছে। অনুগ্রহ করে আবার আবেদন করুন।',
            ]);
        }

        // Verify token
        if (!Hash::check($request->token, $record->token)) {
            return back()->withErrors([
                'token' => app()->getLocale() === 'en' ? 'Invalid reset token provided.' : 'ভুল অথবা অবৈধ রিসেট টোকেন।',
            ]);
        }

        // Update user password
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors([
                'email' => app()->getLocale() === 'en' ? 'User not found.' : 'ইউজার খুঁজে পাওয়া যায়নি।',
            ]);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Delete reset token
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', app()->getLocale() === 'en' 
            ? 'Your password has been successfully reset! You can now login.' 
            : 'আপনার পাসওয়ার্ড সফলভাবে পরিবর্তিত হয়েছে! এখন লগইন করুন।');
    }

    /**
     * Configure dynamic SMTP mail settings from database settings.
     */
    protected function configureMailer(): void
    {
        $mailHost = Setting::get('mail_host');
        $mailPort = Setting::get('mail_port');
        $mailUsername = Setting::get('mail_username');
        $mailPassword = Setting::get('mail_password');
        $mailEncryption = Setting::get('mail_encryption');
        $fromAddress = Setting::get('mail_from_address');
        $fromName = Setting::get('mail_from_name', 'WOTM Foundation');

        if ($mailHost && $mailPort && $mailUsername && $mailPassword) {
            config([
                'mail.default' => 'smtp',
                'mail.mailers.smtp.host' => $mailHost,
                'mail.mailers.smtp.port' => $mailPort,
                'mail.mailers.smtp.username' => $mailUsername,
                'mail.mailers.smtp.password' => $mailPassword,
                'mail.mailers.smtp.encryption' => $mailEncryption ?: null,
            ]);
        }

        if ($fromAddress) {
            config([
                'mail.from.address' => $fromAddress,
                'mail.from.name' => $fromName,
            ]);
        }
    }
}
