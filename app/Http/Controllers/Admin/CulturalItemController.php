<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\CulturalItem;
use App\Models\CulturalCategory;
use App\Models\Community;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CulturalItemController extends Controller
{
    public function index()
    {
        $items = CulturalItem::with(['category', 'community', 'creator'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        // สถิติสำหรับการ์ด
        $stats = [
            'total_items' => CulturalItem::count(),
            'published_items' => CulturalItem::where('is_published', true)->count(),
            'featured_items' => CulturalItem::where('is_featured', true)->count(),
            'draft_items' => CulturalItem::where('is_published', false)->count(),
            'communities_with_items' => CulturalItem::distinct('community_id')->count(),
            'categories_used' => CulturalItem::distinct('category_id')->count(),
        ];
        
        return view('admin.cultural-items.index', compact('items', 'stats'));
    }

    public function create()
    {
        $categories = CulturalCategory::orderBy('name')->get();
        $communities = Community::orderBy('name')->get();
        
        return view('admin.cultural-items.create', compact('categories', 'communities'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:cultural_categories,id',
            'community_id' => 'required|exists:communities,id',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'publish_date' => 'required|date',
            'is_published' => 'nullable',
            'is_featured' => 'nullable',
            'featured_order' => 'nullable|integer'
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('cultural-items', 'public');
        }

        //$validated['created_by'] = auth()->id();
        $validated['created_by'] = Auth::id(); 
        $validated['is_published'] = $request->has('is_published') ? true : false;
        $validated['is_featured'] = $request->has('is_featured') ? true : false;

        CulturalItem::create($validated);

        return redirect()->route('admin.cultural-items.index')
            ->with('success', 'ข้อมูลวัฒนธรรมถูกสร้างเรียบร้อยแล้ว');
    }

    public function edit(CulturalItem $culturalItem)
    {
        $categories = CulturalCategory::orderBy('name')->get();
        $communities = Community::orderBy('name')->get();
        
        return view('admin.cultural-items.edit', compact('culturalItem', 'categories', 'communities'));
    }

    public function update(Request $request, CulturalItem $culturalItem)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:cultural_categories,id',
            'community_id' => 'required|exists:communities,id',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'publish_date' => 'required|date',
            'is_published' => 'nullable',
            'is_featured' => 'nullable',
            'featured_order' => 'nullable|integer'
        ]);

        if ($request->hasFile('image')) {
            if ($culturalItem->image) {
                Storage::disk('public')->delete($culturalItem->image);
            }
            $validated['image'] = $request->file('image')->store('cultural-items', 'public');
        }

        $validated['is_published'] = $request->has('is_published') ? true : false;
        $validated['is_featured'] = $request->has('is_featured') ? true : false;

        $culturalItem->update($validated);

        return redirect()->route('admin.cultural-items.index')
            ->with('success', 'ข้อมูลวัฒนธรรมถูกอัปเดตเรียบร้อยแล้ว');
    }

    public function destroy(CulturalItem $culturalItem)
    {
        if ($culturalItem->image) {
            Storage::disk('public')->delete($culturalItem->image);
        }
        
        $culturalItem->delete();

        return redirect()->route('admin.cultural-items.index')
            ->with('success', 'ข้อมูลวัฒนธรรมถูกลบเรียบร้อยแล้ว');
    }
}