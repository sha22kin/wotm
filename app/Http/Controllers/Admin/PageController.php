<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::orderBy('id', 'asc')->get();
        return view('admin.pages.index', compact('pages'));
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title_en' => 'required|string|max:255',
            'title_bn' => 'required|string|max:255',
            'subtitle_en' => 'nullable|string|max:255',
            'subtitle_bn' => 'nullable|string|max:255',
            'content_en' => 'nullable|string',
            'content_bn' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'canonical_url' => 'nullable|string|max:255',
            'featured_image' => 'nullable|image|max:2048',
            'og_image' => 'nullable|image|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('uploads/pages', 'public');
            $validated['featured_image'] = 'storage/' . $path;
        }

        if ($request->hasFile('og_image')) {
            $path = $request->file('og_image')->store('uploads/pages', 'public');
            $validated['og_image'] = 'storage/' . $path;
        }

        $validated['is_active'] = $request->has('is_active');

        $page->update($validated);

        return redirect()->route('admin.pages.index')->with('success', 'Page updated successfully.');
    }
}
