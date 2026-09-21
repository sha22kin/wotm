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

        $featuredPost = Post::published()->featured()->latest('published_at')->first();
        if (!$featuredPost) {
            $featuredPost = Post::published()->latest('published_at')->first();
        }

        $query = Post::published()->latest('published_at');

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
