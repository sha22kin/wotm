<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Setting;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $featuredPost = Post::published()->featured()->latest('published_at')->first();
        if (!$featuredPost) {
            $featuredPost = Post::published()->latest('published_at')->first();
        }

        $query = Post::published()->latest('published_at');

        if ($featuredPost) {
            $query->where('id', '!=', $featuredPost->id);
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

        return view('projects', compact('featuredPost', 'posts', 'settings'));
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        $relatedPosts = Post::published()->where('id', '!=', $post->id)->take(4)->get();
        $settings = Setting::getAllGrouped();

        return view('project-details', compact('post', 'relatedPosts', 'settings'));
    }
}
