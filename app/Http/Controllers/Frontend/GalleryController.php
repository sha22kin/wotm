<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\GalleryCategory;
use App\Models\GalleryItem;
use App\Models\Page;
use App\Models\Setting;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $page = Page::where('slug', 'gallery')->first();
        $categories = GalleryCategory::where('is_active', true)->orderBy('order', 'asc')->get();
        $images = GalleryItem::with('galleryCategory')->active()->images()->get();
        $videos = GalleryItem::with('galleryCategory')->active()->videos()->get();
        $settings = Setting::getAllGrouped();

        return view('gallery', compact('page', 'categories', 'images', 'videos', 'settings'));
    }
}
