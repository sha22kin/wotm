<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Page;
use App\Models\Setting;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $page = Page::where('slug', 'activities')->first();
        $query = Service::active();

        if ($request->filled('cat')) {
            $query->where('category', $request->cat);
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sq) use ($q) {
                $sq->where('title_en', 'like', "%{$q}%")
                    ->orWhere('title_bn', 'like', "%{$q}%")
                    ->orWhere('short_description_en', 'like', "%{$q}%")
                    ->orWhere('short_description_bn', 'like', "%{$q}%");
            });
        }

        $services = $query->paginate(9)->withQueryString();
        $settings = Setting::getAllGrouped();

        return view('activities', compact('page', 'services', 'settings'));
    }

    public function show($slug)
    {
        $service = Service::where('slug', $slug)->firstOrFail();
        $relatedServices = Service::active()->where('id', '!=', $service->id)->take(4)->get();
        $settings = Setting::getAllGrouped();

        return view('activity-details', compact('service', 'relatedServices', 'settings'));
    }
}
