<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailSettingController extends Controller
{
    public function index()
    {
        $settings = Setting::getAllGrouped();
        return view('admin.mail.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'mail_host' => 'required|string|max:255',
            'mail_port' => 'required|numeric',
            'mail_username' => 'nullable|string|max:255',
            'mail_password' => 'nullable|string|max:255',
            'mail_encryption' => 'nullable|string|max:20',
            'mail_from_address' => 'required|email|max:255',
            'mail_from_name' => 'required|string|max:255',
            'mail_admin_recipient' => 'nullable|email|max:255',
        ]);

        foreach ($validated as $key => $value) {
            Setting::set($key, $value, 'mail');
        }

        return back()->with('success', 'Mailing settings updated successfully.');
    }

    public function sendTestMail(Request $request)
    {
        $request->validate([
            'test_email' => 'required|email',
        ]);

        try {
            Mail::raw('This is a test notification from WOTM CMS admin panel. Your mail settings are configured properly.', function ($message) use ($request) {
                $message->to($request->test_email)
                    ->subject('WOTM CMS - SMTP Test Mail');
            });
            return back()->with('success', 'Test email sent successfully to ' . $request->test_email);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send test email: ' . $e->getMessage());
        }
    }
}
