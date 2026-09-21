<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Setting;

class PageController extends Controller
{
    public function about()
    {
        $page = Page::where('slug', 'about-us')->first();
        $settings = Setting::getAllGrouped();
        return view('about', compact('page', 'settings'));
    }
}
