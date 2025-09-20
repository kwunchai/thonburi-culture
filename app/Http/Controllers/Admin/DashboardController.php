<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CulturalItem;
use App\Models\CulturalCategory;
use App\Models\Community;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_items' => CulturalItem::count(),
            'total_categories' => CulturalCategory::count(),
            'total_communities' => Community::count(),
            'total_users' => User::count(),
            'featured_items' => CulturalItem::where('is_featured', true)->count(),
            'published_items' => CulturalItem::where('is_published', true)->count(),
            'recent_items' => CulturalItem::with(['category', 'community'])
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get()
        ];

        return view('admin.dashboard', compact('stats'));
    }
}