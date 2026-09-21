<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SeoController extends Controller
{
    public function index()
    {
        $settings = Setting::getAllGrouped();
        return view('admin.seo.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'seo_meta_title' => 'nullable|string|max:255',
            'seo_meta_description' => 'nullable|string',
            'seo_meta_keywords' => 'nullable|string',
            'seo_og_image' => 'nullable|image|max:2048',
            'google_analytics_id' => 'nullable|string|max:50',
        ]);

        if ($request->hasFile('seo_og_image')) {
            $path = $request->file('seo_og_image')->store('uploads/seo', 'public');
            Setting::set('seo_og_image', 'storage/' . $path, 'seo');
            unset($validated['seo_og_image']);
        }

        foreach ($validated as $key => $value) {
            Setting::set($key, $value, 'seo');
        }

        return back()->with('success', 'SEO settings updated successfully.');
    }
}
