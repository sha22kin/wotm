<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GalleryCategoryController extends Controller
{
    public function index()
    {
        $categories = GalleryCategory::withCount(['items', 'images', 'videos'])
            ->orderBy('order', 'asc')
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.gallery_categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_bn' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:gallery_categories,slug',
            'order' => 'nullable|integer',
        ]);

        $validated['slug'] = $validated['slug'] ? Str::slug($validated['slug']) : Str::slug($validated['name_en']);
        $validated['order'] = $validated['order'] ?? 0;
        $validated['is_active'] = $request->has('is_active');

        GalleryCategory::create($validated);

        return redirect()->route('admin.gallery-categories.index')->with('success', 'Media category created successfully.');
    }

    public function update(Request $request, GalleryCategory $galleryCategory)
    {
        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_bn' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:gallery_categories,slug,' . $galleryCategory->id,
            'order' => 'nullable|integer',
        ]);

        $validated['slug'] = $validated['slug'] ? Str::slug($validated['slug']) : Str::slug($validated['name_en']);
        $validated['order'] = $validated['order'] ?? 0;
        $validated['is_active'] = $request->has('is_active');

        $galleryCategory->update($validated);

        return redirect()->route('admin.gallery-categories.index')->with('success', 'Media category updated successfully.');
    }

    public function destroy(GalleryCategory $galleryCategory)
    {
        $galleryCategory->delete();
        return redirect()->route('admin.gallery-categories.index')->with('success', 'Media category deleted successfully.');
    }
}
