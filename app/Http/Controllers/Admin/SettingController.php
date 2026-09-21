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
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg,bmp,avif|max:10240',
            'footer_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg,bmp,avif|max:10240',
            'site_favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg,ico|max:5120',
        ]);

        if ($request->hasFile('site_logo')) {
            $file = $request->file('site_logo');
            $ext = $file->getClientOriginalExtension() ?: 'png';
            $filename = 'logo_' . time() . '_' . uniqid() . '.' . $ext;
            $path = $file->storeAs('uploads/settings', $filename, 'public');
            Setting::set('site_logo', 'storage/' . $path, 'general');
            try {
                $destDir = public_path('storage/uploads/settings');
                if (!file_exists($destDir)) { @mkdir($destDir, 0755, true); }
                @copy(storage_path('app/public/' . $path), public_path('storage/' . $path));
            } catch (\Exception $e) {}
            unset($validated['site_logo']);
        }

        if ($request->hasFile('footer_logo')) {
            $file = $request->file('footer_logo');
            $ext = $file->getClientOriginalExtension() ?: 'png';
            $filename = 'footer_logo_' . time() . '_' . uniqid() . '.' . $ext;
            $path = $file->storeAs('uploads/settings', $filename, 'public');
            Setting::set('footer_logo', 'storage/' . $path, 'footer');
            try {
                $destDir = public_path('storage/uploads/settings');
                if (!file_exists($destDir)) { @mkdir($destDir, 0755, true); }
                @copy(storage_path('app/public/' . $path), public_path('storage/' . $path));
            } catch (\Exception $e) {}
            unset($validated['footer_logo']);
        }

        if ($request->hasFile('site_favicon')) {
            $file = $request->file('site_favicon');
            $ext = $file->getClientOriginalExtension() ?: 'png';
            $filename = 'favicon_' . time() . '_' . uniqid() . '.' . $ext;
            $path = $file->storeAs('uploads/settings', $filename, 'public');
            Setting::set('site_favicon', 'storage/' . $path, 'general');
            try {
                $destDir = public_path('storage/uploads/settings');
                if (!file_exists($destDir)) { @mkdir($destDir, 0755, true); }
                @copy(storage_path('app/public/' . $path), public_path('storage/' . $path));
            } catch (\Exception $e) {}
            unset($validated['site_favicon']);
        }

        foreach ($validated as $key => $value) {
            Setting::set($key, $value, 'general');
        }

        return back()->with('success', 'General settings updated successfully.');
    }
}
