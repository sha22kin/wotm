<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostCategoryController extends Controller
{
    public function index()
    {
        $categories = PostCategory::withCount('posts')->orderBy('id', 'desc')->get();
        return view('admin.post_categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_bn' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:post_categories,slug',
        ]);

        $validated['slug'] = $validated['slug'] ? Str::slug($validated['slug']) : Str::slug($validated['name_en']);
        $validated['is_active'] = $request->has('is_active');

        PostCategory::create($validated);

        return redirect()->route('admin.post-categories.index')->with('success', 'Category created successfully.');
    }

    public function update(Request $request, PostCategory $postCategory)
    {
        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_bn' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:post_categories,slug,' . $postCategory->id,
        ]);

        $validated['slug'] = $validated['slug'] ? Str::slug($validated['slug']) : Str::slug($validated['name_en']);
        $validated['is_active'] = $request->has('is_active');

        $postCategory->update($validated);

        return redirect()->route('admin.post-categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(PostCategory $postCategory)
    {
        $postCategory->delete();
        return redirect()->route('admin.post-categories.index')->with('success', 'Category deleted successfully.');
    }
}
