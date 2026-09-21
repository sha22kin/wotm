<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use App\Models\Page;
use App\Models\Setting;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function index(Request $request)
    {
        $page = Page::where('slug', 'notice')->first();
        $query = Notice::active();

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sq) use ($q) {
                $sq->where('title_en', 'like', "%{$q}%")
                    ->orWhere('title_bn', 'like', "%{$q}%")
                    ->orWhere('notice_number', 'like', "%{$q}%");
            });
        }

        $notices = $query->paginate(10)->withQueryString();
        $settings = Setting::getAllGrouped();

        return view('notice', compact('page', 'notices', 'settings'));
    }
}
