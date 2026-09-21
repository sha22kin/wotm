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
        $services = Service::active()->take(6)->get();
        $featuredPost = Post::published()->featured()->latest('published_at')->first();
        if (!$featuredPost) {
            $featuredPost = Post::published()->latest('published_at')->first();
        }
        $posts = Post::published()->latest('published_at')->take(6)->get();
        $notices = Notice::active()->take(4)->get();
        $galleryImages = GalleryItem::with('galleryCategory')->active()->images()->take(6)->get();
        $settings = Setting::getAllGrouped();

        return view('home', compact('page', 'services', 'featuredPost', 'posts', 'notices', 'galleryImages', 'settings'));
    }
}
