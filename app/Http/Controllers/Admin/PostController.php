<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with('category')->latest();

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title_en', 'like', "%{$search}%")
                    ->orWhere('title_bn', 'like', "%{$search}%");
            });
        }

        $posts = $query->paginate(10)->withQueryString();
        $categories = PostCategory::all();

        return view('admin.posts.index', compact('posts', 'categories'));
    }

    public function create()
    {
        $categories = PostCategory::all();
        return view('admin.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_en' => 'required|string|max:255',
            'title_bn' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:posts,slug',
            'category_id' => 'nullable|exists:post_categories,id',
            'excerpt_en' => 'nullable|string',
            'excerpt_bn' => 'nullable|string',
            'content_en' => 'nullable|string',
            'content_bn' => 'nullable|string',
            'author_name' => 'nullable|string|max:100',
            'status' => 'required|in:draft,published',
            'is_featured' => 'nullable|boolean',
            'published_at' => 'nullable|date',
            'featured_image' => 'nullable|image|max:3072',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
        ]);

        $validated['slug'] = $validated['slug'] ? Str::slug($validated['slug']) : Str::slug($validated['title_en']);
        $validated['is_featured'] = $request->has('is_featured');
        $validated['author_name'] = $validated['author_name'] ?: 'WOTM';

        if (!$validated['published_at'] && $validated['status'] === 'published') {
            $validated['published_at'] = now();
        }

        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('uploads/posts', 'public');
            $validated['featured_image'] = 'storage/' . $path;
        }

        Post::create($validated);

        return redirect()->route('admin.posts.index')->with('success', 'Post created successfully.');
    }

    public function edit(Post $post)
    {
        $categories = PostCategory::all();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title_en' => 'required|string|max:255',
            'title_bn' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:posts,slug,' . $post->id,
            'category_id' => 'nullable|exists:post_categories,id',
            'excerpt_en' => 'nullable|string',
            'excerpt_bn' => 'nullable|string',
            'content_en' => 'nullable|string',
            'content_bn' => 'nullable|string',
            'author_name' => 'nullable|string|max:100',
            'status' => 'required|in:draft,published',
            'is_featured' => 'nullable|boolean',
            'published_at' => 'nullable|date',
            'featured_image' => 'nullable|image|max:3072',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
        ]);

        $validated['slug'] = $validated['slug'] ? Str::slug($validated['slug']) : Str::slug($validated['title_en']);
        $validated['is_featured'] = $request->has('is_featured');

        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('uploads/posts', 'public');
            $validated['featured_image'] = 'storage/' . $path;
        }

        $post->update($validated);

        return redirect()->route('admin.posts.index')->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'Post deleted successfully.');
    }
}
