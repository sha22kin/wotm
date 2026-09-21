<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\GalleryItem;
use App\Models\Notice;
use App\Models\Page;
use App\Models\Post;
use App\Models\Service;
use App\Models\Setting;

class HomeController extends Controller
{
    public function index()
    {
        $page = Page::where('slug', 'home')->first();
        $services = Service::active()->orderBy('order', 'asc')->latest()->take(6)->get();
        $featuredPost = Post::published()->featured()->orderByRaw('COALESCE(published_at, created_at) DESC')->first();
        if (!$featuredPost) {
            $featuredPost = Post::published()->orderByRaw('COALESCE(published_at, created_at) DESC')->first();
        }
        $posts = Post::published()->orderByRaw('COALESCE(published_at, created_at) DESC')->latest('id')->take(6)->get();
        $notices = Notice::active()->take(4)->get();
        $galleryImages = GalleryItem::with('galleryCategory')->active()->images()->take(6)->get();
        $settings = Setting::getAllGrouped();

        return view('home', compact('page', 'services', 'featuredPost', 'posts', 'notices', 'galleryImages', 'settings'));
    }
}
