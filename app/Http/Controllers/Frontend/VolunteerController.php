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
        ]);

        $submission = JoinSubmission::create($validated);

        // Send email notification to admin if mail configured
        try {
            $adminEmail = Setting::get('mail_admin_recipient', 'admin@wotm.org');
            if ($adminEmail) {
                Mail::raw("New Volunteer / Join Application Received:\n\nName: {$submission->full_name}\nPhone: {$submission->phone}\nEmail: {$submission->email}\nArea: {$submission->area_of_interest}\nDistrict: {$submission->district}\nMessage: {$submission->message}", function ($message) use ($adminEmail) {
                    $message->to($adminEmail)
                        ->subject('New Volunteer Submission - WOTM');
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
