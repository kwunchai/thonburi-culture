<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Community;
use Illuminate\Support\Facades\Storage;
use App\Models\CulturalItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\CulturalCategory;


class CommunityController extends Controller
{
    /**
     * แสดงรายการชุมชนทั้งหมด
     */
    public function index(Request $request)
    {
        $query = Community::withCount(['culturalItems' => function($q) {
            $q->published();
        }]);

        // ค้นหา
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        // เรียงลำดับ
        $sortBy = $request->get('sort', 'name');
        $sortOrder = $request->get('order', 'asc');
        
        switch($sortBy) {
            case 'items_count':
                $query->orderBy('cultural_items_count', $sortOrder);
                break;
            case 'created_at':
                $query->orderBy('created_at', $sortOrder);
                break;
            default:
                $query->orderBy('name', $sortOrder);
        }


        $communities = $query->paginate(10)->appends($request->all());
        
        return view('admin.communities.index', compact('communities'));
    }


    /**
     * แสดงฟอร์มสร้างชุมชนใหม่
     */
    public function create()
    {
        return view('admin.communities.create');
    }

    /**
     * บันทึกข้อมูลชุมชนใหม่
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:communities,name',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|max:2048|mimes:jpg,jpeg,png,gif',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'address' => 'nullable|string|max:500',
            'contact_phone' => 'nullable|string|max:50',
            'contact_email' => 'nullable|email|max:100',
            'website' => 'nullable|url|max:255',
            'facebook' => 'nullable|string|max:255',
            'line_id' => 'nullable|string|max:100',
            'opening_hours' => 'nullable|string|max:255',
            'is_active' => 'boolean'
        ]);

        // Upload รูปภาพ
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('communities', 'public');
        }

        // ตั้งค่า default
        $validated['is_active'] = $request->has('is_active') ? true : false;

        // สร้าง slug จากชื่อ (สำหรับ URL friendly)
        $validated['slug'] = Str::slug($validated['name']);

        // ตรวจสอบ slug ซ้ำ
        $originalSlug = $validated['slug'];
        $count = 1;
        while (Community::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $count;
            $count++;
        }


        $community = Community::create($validated);

        return redirect()->route('admin.communities.index')
            ->with('success', 'เพิ่มข้อมูลชุมชน "' . $community->name . '" เรียบร้อยแล้ว');
    }

    /**
     * แสดงรายละเอียดชุมชน
     */
    public function show(Community $community)
    {
        // โหลดข้อมูลที่เกี่ยวข้อง
        $community->load(['culturalItems' => function($query) {
            $query->with(['category', 'creator'])
                  ->latest()
                  ->take(10);
        }]);
        
        // สถิติ
        $stats = [
            'total_items' => $community->culturalItems()->count(),
            'published_items' => $community->culturalItems()->published()->count(),
            'categories' => $community->culturalItems()
                ->join('cultural_categories', 'cultural_items.category_id', '=', 'cultural_categories.id')
                ->select('cultural_categories.name', DB::raw('count(*) as count'))
                ->groupBy('cultural_categories.name')
                ->pluck('count', 'name')
        ];
        
        return view('admin.communities.show', compact('community', 'stats'));
    }

    /**
     * แสดงฟอร์มแก้ไขชุมชน
     */
    public function edit(Community $community)
    {
        return view('admin.communities.edit', compact('community'));
    }

    /**
     * อัปเดตข้อมูลชุมชน
     */
    public function update(Request $request, Community $community)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:communities,name,' . $community->id,
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|max:2048|mimes:jpg,jpeg,png,gif',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'address' => 'nullable|string|max:500',
            'contact_phone' => 'nullable|string|max:50',
            'contact_email' => 'nullable|email|max:100',
            'website' => 'nullable|url|max:255',
            'facebook' => 'nullable|string|max:255',
            'line_id' => 'nullable|string|max:100',
            'opening_hours' => 'nullable|string|max:255',
            'is_active' => 'boolean'
        ]);

        // Upload รูปภาพใหม่
        if ($request->hasFile('image')) {
            // ลบรูปเก่า
            if ($community->image) {
                Storage::disk('public')->delete($community->image);
            }
            $validated['image'] = $request->file('image')->store('communities', 'public');
        }

        // ตั้งค่า is_active
        $validated['is_active'] = $request->has('is_active') ? true : false;

        // อัปเดต slug ถ้าเปลี่ยนชื่อ
        if ($community->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']);
            
            // ตรวจสอบ slug ซ้ำ
            $originalSlug = $validated['slug'];
            $count = 1;
            while (Community::where('slug', $validated['slug'])->where('id', '!=', $community->id)->exists()) {
                $validated['slug'] = $originalSlug . '-' . $count;
                $count++;
            }
        }

        $community->update($validated);

        return redirect()->route('admin.communities.index')
            ->with('success', 'อัปเดตข้อมูลชุมชน "' . $community->name . '" เรียบร้อยแล้ว');
    }

    /**
     * ลบข้อมูลชุมชน
     */
    public function destroy(Community $community)
    {
        // ตรวจสอบว่ามีข้อมูลวัฒนธรรมในชุมชนนี้หรือไม่
        if ($community->culturalItems()->count() > 0) {
            return redirect()->route('admin.communities.index')
                ->with('error', 'ไม่สามารถลบชุมชน "' . $community->name . '" ได้ เนื่องจากมีข้อมูลวัฒนธรรม ' . $community->culturalItems()->count() . ' รายการ');
        }

        // ลบรูปภาพ
        if ($community->image) {
            Storage::disk('public')->delete($community->image);
        }
        
        $communityName = $community->name;
        $community->delete();

        return redirect()->route('admin.communities.index')
            ->with('success', 'ลบชุมชน "' . $communityName . '" เรียบร้อยแล้ว');
    }
}
