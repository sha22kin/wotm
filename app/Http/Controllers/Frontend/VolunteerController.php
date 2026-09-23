<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\JoinSubmission;
use App\Models\Page;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class VolunteerController extends Controller
{
    public function index()
    {
        $page = Page::where('slug', 'volunteer')->first();
        $settings = Setting::getAllGrouped();
        return view('volunteer', compact('page', 'settings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'email' => 'nullable|email|max:100',
            'area_of_interest' => 'required|string|max:100',
            'education' => 'nullable|string|max:100',
            'district' => 'nullable|string|max:100',
            'message' => 'nullable|string',
            'facebook_link' => 'nullable|url|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('uploads/volunteers', 'public');
            $validated['photo_path'] = $path;
        }

        $submission = JoinSubmission::create($validated);

        // Send email notification to admin if mail configured
        try {
            $adminEmail = Setting::get('mail_admin_recipient', Setting::get('site_email', 'admin@wotm.org'));
            if ($adminEmail) {
                $settings = Setting::getAllGrouped();
                Mail::send('emails.volunteer', [
                    'submission' => $submission,
                    'settings' => $settings,
                    'subject' => 'New Volunteer Application - WOTM',
                    'badge' => '🤝 New Volunteer Application',
                    'badgeColor' => '#dcfce7',
                    'badgeTextColor' => '#166534',
                    'title' => 'New Volunteer Form Submission',
                    'subtitle' => 'A new volunteer has applied to join your team.',
                    'actionUrl' => url('/admin/joins'),
                    'actionText' => 'View Applications',
                ], function ($message) use ($adminEmail) {
                    $message->to($adminEmail)
                        ->subject('New Volunteer Application - WOTM');
                });
            }
        } catch (\Exception $e) {
            // Log or ignore mail sending failure gracefully
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => app()->getLocale() === 'en'
                    ? 'Thank you! Your volunteer application has been submitted successfully.'
                    : 'ধন্যবাদ! আপনার আবেদনটি সফলভাবে জমা হয়েছে। আমাদের সমন্বয়ক শীঘ্রই যোগাযোগ করবেন।'
            ]);
        }

        return back()->with('success', app()->getLocale() === 'en'
            ? 'Thank you! Your application has been submitted successfully.'
            : 'ধন্যবাদ! আপনার আবেদনটি সফলভাবে জমা হয়েছে।');
    }
}
