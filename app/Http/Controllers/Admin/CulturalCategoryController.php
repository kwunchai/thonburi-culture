<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CulturalCategory;
use Illuminate\Support\Str;

class CulturalCategoryController extends Controller
{
    //
    public function index()
    {
        $categories = CulturalCategory::withCount('culturalItems')
            ->orderBy('name')
            ->paginate(10);
        
        return view('admin.cultural-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.cultural-categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255'
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        CulturalCategory::create($validated);

        return redirect()->route('admin.cultural-categories.index')
            ->with('success', 'หมวดหมู่ถูกสร้างเรียบร้อยแล้ว');
    }

    public function edit(CulturalCategory $culturalCategory)
    {
        return view('admin.cultural-categories.edit', compact('culturalCategory'));
    }

    public function update(Request $request, CulturalCategory $culturalCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255'
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $culturalCategory->update($validated);

        return redirect()->route('admin.cultural-categories.index')
            ->with('success', 'หมวดหมู่ถูกอัปเดตเรียบร้อยแล้ว');
    }

    public function destroy(CulturalCategory $culturalCategory)
    {
        if ($culturalCategory->culturalItems()->count() > 0) {
            return redirect()->route('admin.cultural-categories.index')
                ->with('error', 'ไม่สามารถลบหมวดหมู่ที่มีข้อมูลวัฒนธรรมอยู่');
        }

        $culturalCategory->delete();

        return redirect()->route('admin.cultural-categories.index')
            ->with('success', 'หมวดหมู่ถูกลบเรียบร้อยแล้ว');
    }
}
