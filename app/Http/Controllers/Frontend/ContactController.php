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
            $adminEmail = Setting::get('mail_admin_recipient', 'admin@wotm.org');
            if ($adminEmail) {
                Mail::raw("New Contact Inquiry Received:\n\nName: {$submission->name}\nContact: {$submission->contact}\nSubject: {$submission->subject}\nMessage: {$submission->message}", function ($message) use ($adminEmail) {
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
