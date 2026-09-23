<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\NewMuslim;
use App\Models\Page;
use App\Models\Setting;

class NewMuslimController extends Controller
{
    public function index()
    {
        $page = Page::where('slug', 'new-muslims')->first();
        $newMuslims = NewMuslim::latest()->get();
        $settings = Setting::getAllGrouped();
        
        return view('new-muslims', compact('page', 'newMuslims', 'settings'));
    }
}
