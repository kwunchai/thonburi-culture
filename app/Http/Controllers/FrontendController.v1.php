<?php

namespace App\Http\Controllers;

use App\Models\CulturalItem;
use App\Models\CulturalCategory;
use App\Models\Community;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function home()
    {
        $categories = CulturalCategory::all();
        $latestItems = CulturalItem::with(['category', 'community'])
            ->published()
            ->orderBy('publish_date', 'desc')
            ->take(4)
            ->get();
        $communities = Community::all();

        return view('frontend.home', compact('categories', 'latestItems', 'communities'));
    }

    public function category($slug)
    {
        $category = CulturalCategory::where('slug', $slug)->firstOrFail();
        $items = $category->culturalItems()
            ->published()
            ->with(['community'])
            ->orderBy('publish_date', 'desc')
            ->paginate(12);

        return view('frontend.category', compact('category', 'items'));
    }

    public function show($id)
    {
        $item = CulturalItem::with(['category', 'community', 'creator'])
            ->published()
            ->findOrFail($id);
        
        $relatedItems = CulturalItem::where('category_id', $item->category_id)
            ->where('id', '!=', $id)
            ->published()
            ->take(4)
            ->get();

        return view('frontend.show', compact('item', 'relatedItems'));
    }
}