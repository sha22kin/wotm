<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Setting;
use App\Models\BoardMember;

class PageController extends Controller
{
    public function about()
    {
        $page = Page::where('slug', 'about-us')->first();
        $settings = Setting::getAllGrouped();
        return view('about', compact('page', 'settings'));
    }

    public function chairmansMessage()
    {
        $page = Page::where('slug', 'chairmans-message')->first();
        $settings = Setting::getAllGrouped();
        $chairman = BoardMember::active()->chairman()->first();
        return view('chairmans-message', compact('page', 'settings', 'chairman'));
    }

    public function introductionBackground()
    {
        $page = Page::where('slug', 'introduction-background')->first();
        $settings = Setting::getAllGrouped();
        return view('introduction-background', compact('page', 'settings'));
    }

    public function visionMission()
    {
        $page = Page::where('slug', 'vision-mission')->first();
        $settings = Setting::getAllGrouped();
        return view('vision-mission', compact('page', 'settings'));
    }

    public function boardOfDirectors()
    {
        $page = Page::where('slug', 'board-of-directors')->first();
        $settings = Setting::getAllGrouped();
        $chairman = BoardMember::active()->chairman()->first();
        $teamMembers = BoardMember::active()->where('type', '!=', 'chairman')->orderBy('order')->get();
        $directors = BoardMember::active()->directors()->get();
        $advisors = BoardMember::active()->advisors()->get();

        return view('board-of-directors', compact('page', 'settings', 'chairman', 'teamMembers', 'directors', 'advisors'));
    }

    public function show($slug)
    {
        $page = Page::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $settings = Setting::getAllGrouped();

        if ($slug === 'board-of-directors') {
            $chairman = BoardMember::active()->chairman()->first();
            $teamMembers = BoardMember::active()->where('type', '!=', 'chairman')->orderBy('order')->get();
            $directors = BoardMember::active()->directors()->get();
            $advisors = BoardMember::active()->advisors()->get();
            return view('board-of-directors', compact('page', 'settings', 'chairman', 'teamMembers', 'directors', 'advisors'));
        }

        if ($slug === 'chairmans-message') {
            $chairman = BoardMember::active()->chairman()->first();
            return view('chairmans-message', compact('page', 'settings', 'chairman'));
        }

        $customViews = [
            'introduction-background' => 'introduction-background',
            'vision-mission' => 'vision-mission',
        ];

        if (isset($customViews[$slug]) && view()->exists($customViews[$slug])) {
            return view($customViews[$slug], compact('page', 'settings'));
        }

        return view('page', compact('page', 'settings'));
    }
}
