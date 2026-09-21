<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class FooterController extends Controller
{
    public function index()
    {
        $settings = Setting::getAllGrouped();
        return view('admin.footer.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'footer_logo' => 'nullable|image|max:2048',
            'footer_about_en' => 'nullable|string',
            'footer_about_bn' => 'nullable|string',
            'footer_copyright_en' => 'nullable|string',
            'footer_copyright_bn' => 'nullable|string',
        ]);

        if ($request->hasFile('footer_logo')) {
            $path = $request->file('footer_logo')->store('uploads/settings', 'public');
            Setting::set('footer_logo', 'storage/' . $path, 'footer');
            unset($validated['footer_logo']);
        }

        foreach ($validated as $key => $value) {
            Setting::set($key, $value, 'footer');
        }

        return back()->with('success', 'Footer settings updated successfully.');
    }
}
