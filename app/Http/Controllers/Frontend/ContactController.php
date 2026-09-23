<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use App\Models\Page;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        $page = Page::where('slug', 'contact')->first();
        $settings = Setting::getAllGrouped();
        return view('contact', compact('page', 'settings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact' => 'required|string|max:100',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $submission = ContactSubmission::create($validated);

        // Send email notification to admin if mail configured
        try {
            $adminEmail = Setting::get('mail_admin_recipient', Setting::get('site_email', 'admin@wotm.org'));
            if ($adminEmail) {
                $settings = Setting::getAllGrouped();
                Mail::send('emails.contact', [
                    'submission' => $submission,
                    'settings' => $settings,
                    'subject' => 'New Contact Inquiry - WOTM',
                    'badge' => '📩 New Contact Message',
                    'badgeColor' => '#dbeafe',
                    'badgeTextColor' => '#1e40af',
                    'title' => 'New Contact Form Submission',
                    'subtitle' => 'Someone has sent a message through the website contact form.',
                    'actionUrl' => url('/admin/contacts'),
                    'actionText' => 'View in Admin Panel',
                ], function ($message) use ($adminEmail) {
                    $message->to($adminEmail)
                        ->subject('New Contact Inquiry - WOTM');
                });
            }
        } catch (\Exception $e) {
            // Log or ignore mail sending failure gracefully
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => app()->getLocale() === 'en'
                    ? 'Thank you! Your message has been sent successfully.'
                    : 'ধন্যবাদ! আপনার বার্তা সফলভাবে পাঠানো হয়েছে।'
            ]);
        }

        return back()->with('success', app()->getLocale() === 'en'
            ? 'Thank you! Your message has been sent successfully.'
            : 'ধন্যবাদ! আপনার বার্তা সফলভাবে পাঠানো হয়েছে।');
    }
}
