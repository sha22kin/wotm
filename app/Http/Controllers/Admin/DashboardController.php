<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Post;
use App\Models\Service;
use App\Models\Notice;
use App\Models\GalleryItem;
use App\Models\JoinSubmission;
use App\Models\ContactSubmission;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'pages' => Page::count(),
            'posts' => Post::count(),
            'services' => Service::count(),
            'notices' => Notice::count(),
            'gallery' => GalleryItem::count(),
            'joins' => JoinSubmission::count(),
            'joins_pending' => JoinSubmission::where('status', 'pending')->count(),
            'contacts' => ContactSubmission::count(),
            'contacts_unread' => ContactSubmission::where('is_read', false)->count(),
        ];

        $recentJoins = JoinSubmission::latest()->take(5)->get();
        $recentPosts = Post::latest()->take(5)->get();
        $recentContacts = ContactSubmission::latest()->take(5)->get();

        return view('admin.dashboard.index', compact('stats', 'recentJoins', 'recentPosts', 'recentContacts'));
    }
}
