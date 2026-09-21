<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Page;
use App\Models\Setting;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $page = Page::where('slug', 'blog')->first();
        $categories = PostCategory::where('is_active', true)->withCount('posts')->get();

        $isFiltering = $request->filled('category') || $request->filled('search') || $request->get('page', 1) > 1;

        $featuredPost = null;
        if (!$isFiltering) {
            $featuredPost = Post::published()->featured()->orderByRaw('COALESCE(published_at, created_at) DESC')->first();
            if (!$featuredPost) {
                $featuredPost = Post::published()->orderByRaw('COALESCE(published_at, created_at) DESC')->first();
            }
        }

        $query = Post::published()->orderByRaw('COALESCE(published_at, created_at) DESC')->latest('id');

        if ($featuredPost) {
            $query->where('id', '!=', $featuredPost->id);
        }

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title_en', 'like', "%{$search}%")
                    ->orWhere('title_bn', 'like', "%{$search}%");
            });
        }

        $posts = $query->paginate(9)->withQueryString();
        $settings = Setting::getAllGrouped();

        return view('blog', compact('page', 'categories', 'featuredPost', 'posts', 'settings'));
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)->published()->firstOrFail();
        $relatedPosts = Post::published()->where('id', '!=', $post->id)->take(3)->get();
        $categories = PostCategory::where('is_active', true)->withCount('posts')->get();
        $settings = Setting::getAllGrouped();

        return view('blog-details', compact('post', 'relatedPosts', 'categories', 'settings'));
    }
}
