<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SocialController extends Controller
{
    public function index()
    {
        $settings = Setting::getAllGrouped();
        return view('admin.social.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'social_facebook' => 'nullable|string|max:255',
            'social_twitter' => 'nullable|string|max:255',
            'social_youtube' => 'nullable|string|max:255',
            'social_instagram' => 'nullable|string|max:255',
            'social_linkedin' => 'nullable|string|max:255',
            'whatsapp_number' => 'nullable|string|max:50',
        ]);

        foreach ($validated as $key => $value) {
            Setting::set($key, $value, 'social');
        }

        return back()->with('success', 'Social links updated successfully.');
    }
}
