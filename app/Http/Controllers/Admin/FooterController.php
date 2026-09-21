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
            'footer_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg,bmp,avif|max:10240',
            'footer_about_en' => 'nullable|string',
            'footer_about_bn' => 'nullable|string',
            'footer_copyright_en' => 'nullable|string',
            'footer_copyright_bn' => 'nullable|string',
        ]);

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

        foreach ($validated as $key => $value) {
            Setting::set($key, $value, 'footer');
        }

        return back()->with('success', 'Footer settings updated successfully.');
    }
}
