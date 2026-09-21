<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::getAllGrouped();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_title_en' => 'required|string|max:255',
            'site_title_bn' => 'required|string|max:255',
            'site_tagline_en' => 'nullable|string|max:255',
            'site_tagline_bn' => 'nullable|string|max:255',
            'site_description_en' => 'nullable|string',
            'site_description_bn' => 'nullable|string',
            'site_reg_no' => 'nullable|string|max:100',
            'site_phone' => 'nullable|string|max:50',
            'site_phone_secondary' => 'nullable|string|max:50',
            'site_email' => 'nullable|email|max:100',
            'site_address_en' => 'nullable|string',
            'site_address_bn' => 'nullable|string',
            'site_logo' => 'nullable|image|max:2048',
            'footer_logo' => 'nullable|image|max:2048',
            'site_favicon' => 'nullable|image|max:1024',
        ]);

        if ($request->hasFile('site_logo')) {
            $path = $request->file('site_logo')->store('uploads/settings', 'public');
            Setting::set('site_logo', 'storage/' . $path, 'general');
            unset($validated['site_logo']);
        }

        if ($request->hasFile('footer_logo')) {
            $path = $request->file('footer_logo')->store('uploads/settings', 'public');
            Setting::set('footer_logo', 'storage/' . $path, 'footer');
            unset($validated['footer_logo']);
        }

        if ($request->hasFile('site_favicon')) {
            $path = $request->file('site_favicon')->store('uploads/settings', 'public');
            Setting::set('site_favicon', 'storage/' . $path, 'general');
            unset($validated['site_favicon']);
        }

        foreach ($validated as $key => $value) {
            Setting::set($key, $value, 'general');
        }

        return back()->with('success', 'General settings updated successfully.');
    }
}
