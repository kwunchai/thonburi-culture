<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\CulturalItem;
use App\Models\CulturalCategory;
use App\Models\Community;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class SlideshowController extends Controller
{
    /**
     * แสดงรายการ Slideshow
     */
    public function index()
    {
        // ดึงเฉพาะรายการที่ featured
        $featuredItems = CulturalItem::with(['category', 'community', 'creator'])
            ->featured()
            ->get();
        
        // ดึงรายการทั้งหมดที่สามารถเพิ่มเป็น featured
        $availableItems = CulturalItem::with(['category', 'community'])
            ->where('is_featured', false)
            ->published()
            ->orderBy('publish_date', 'desc')
            ->get();
        
        return view('admin.slideshow.index', compact('featuredItems', 'availableItems'));
    }

    /**
     * หน้าสร้าง Slideshow ใหม่
     */
    public function create()
    {
        $categories = CulturalCategory::orderBy('name')->get();
        $communities = Community::orderBy('name')->get();
        
        // นับจำนวน featured items ปัจจุบัน
        $featuredCount = CulturalItem::where('is_featured', true)->count();
        
        return view('admin.slideshow.create', compact('categories', 'communities', 'featuredCount'));
    }

    /**
     * บันทึก Slideshow ใหม่
     */
    public function store(Request $request)
    {
        // ตรวจสอบจำนวน featured items (จำกัดไว้ที่ 4)
        $featuredCount = CulturalItem::where('is_featured', true)->count();
        if ($featuredCount >= 4 && $request->is_featured) {
            return back()->with('error', 'จำนวน Slideshow เต็มแล้ว (สูงสุด 4 รายการ) กรุณาลบรายการเก่าก่อน');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:cultural_categories,id',
            'community_id' => 'required|exists:communities,id',
            'description' => 'required|string',
            'image' => 'required|image|max:4096', // ขนาดใหญ่ขึ้นสำหรับ slideshow
            'publish_date' => 'required|date',
            'is_published' => 'nullable',
            'is_featured' => 'nullable',
            'featured_order' => 'nullable|integer|min:1|max:4'
        ]);

        // Upload รูปภาพ
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('slideshow', 'public');
        }

        //$validated['created_by'] = auth()->id();
        $validated['created_by'] = Auth::id(); 
        $validated['is_published'] = $request->has('is_published') ? true : false;
        $validated['is_featured'] = $request->has('is_featured') ? true : false;
        
        // กำหนด featured_order อัตโนมัติถ้าไม่ได้ระบุ
        if ($validated['is_featured'] && !$request->featured_order) {
            $validated['featured_order'] = CulturalItem::where('is_featured', true)->max('featured_order') + 1;
        }

        CulturalItem::create($validated);

        return redirect()->route('admin.slideshow.index')
            ->with('success', 'สร้าง Slideshow เรียบร้อยแล้ว');
    }

    /**
     * แก้ไข Slideshow
     */
    public function edit($id)
    {
        $item = CulturalItem::findOrFail($id);
        $categories = CulturalCategory::orderBy('name')->get();
        $communities = Community::orderBy('name')->get();
        $featuredCount = CulturalItem::where('is_featured', true)->count();
        
        return view('admin.slideshow.edit', compact('item', 'categories', 'communities', 'featuredCount'));
    }

    /**
     * อัปเดต Slideshow
     */
    public function update(Request $request, $id)
    {
        $item = CulturalItem::findOrFail($id);
        
        // ตรวจสอบจำนวน featured items
        $featuredCount = CulturalItem::where('is_featured', true)
            ->where('id', '!=', $id)
            ->count();
            
        if ($featuredCount >= 4 && $request->is_featured && !$item->is_featured) {
            return back()->with('error', 'จำนวน Slideshow เต็มแล้ว (สูงสุด 4 รายการ)');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:cultural_categories,id',
            'community_id' => 'required|exists:communities,id',
            'description' => 'required|string',
            'image' => 'nullable|image|max:4096',
            'publish_date' => 'required|date',
            'is_published' => 'nullable',
            'is_featured' => 'nullable',
            'featured_order' => 'nullable|integer|min:1|max:4'
        ]);

        // Upload รูปภาพใหม่ถ้ามี
        if ($request->hasFile('image')) {
            // ลบรูปเก่า
            if ($item->image) {
                Storage::disk('public')->delete($item->image);
            }
            $validated['image'] = $request->file('image')->store('slideshow', 'public');
        }

        $validated['is_published'] = $request->has('is_published') ? true : false;
        $validated['is_featured'] = $request->has('is_featured') ? true : false;
        
        // ถ้าเปลี่ยนจาก featured เป็นไม่ featured ให้ clear order
        if (!$validated['is_featured']) {
            $validated['featured_order'] = null;
        } elseif ($validated['is_featured'] && !$request->featured_order) {
            $validated['featured_order'] = $item->featured_order ?: CulturalItem::where('is_featured', true)->max('featured_order') + 1;
        }

        $item->update($validated);

        return redirect()->route('admin.slideshow.index')
            ->with('success', 'อัปเดต Slideshow เรียบร้อยแล้ว');
    }

    /**
     * ลบ Slideshow
     */
    public function destroy($id)
    {
        $item = CulturalItem::findOrFail($id);
        
        // ลบรูปภาพ
        if ($item->image) {
            Storage::disk('public')->delete($item->image);
        }
        
        // ปรับลำดับ featured_order ของรายการที่เหลือ
        if ($item->is_featured && $item->featured_order) {
            CulturalItem::where('is_featured', true)
                ->where('featured_order', '>', $item->featured_order)
                ->decrement('featured_order');
        }
        
        $item->delete();

        return redirect()->route('admin.slideshow.index')
            ->with('success', 'ลบ Slideshow เรียบร้อยแล้ว');
    }

    /**
     * Toggle Featured Status (AJAX)
     */
    public function toggleFeatured(Request $request, $id)
    {
        $item = CulturalItem::findOrFail($id);
        
        // ตรวจสอบจำนวน
        if (!$item->is_featured) {
            $featuredCount = CulturalItem::where('is_featured', true)->count();
            if ($featuredCount >= 4) {
                return response()->json([
                    'success' => false,
                    'message' => 'จำนวน Slideshow เต็มแล้ว (สูงสุด 4 รายการ)'
                ], 400);
            }
        }
        
        $item->is_featured = !$item->is_featured;
        
        if ($item->is_featured) {
            // คำนวณ order ใหม่โดยหา max จาก items อื่นที่ featured อยู่แล้ว
            $maxOrder = CulturalItem::where('is_featured', true)
                ->where('id', '!=', $item->id)
                ->max('featured_order') ?? 0;
            $item->featured_order = $maxOrder + 1;
        } else {
            $item->featured_order = null;
        }
        
        $item->save();
        
        return response()->json([
            'success' => true,
            'is_featured' => $item->is_featured,
            'message' => $item->is_featured ? 'เพิ่มเป็น Slideshow เรียบร้อยแล้ว' : 'ลบออกจาก Slideshow เรียบร้อยแล้ว'
        ]);
    }

    /**
     * อัปเดตลำดับ Slideshow (AJAX)
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:cultural_items,id',
            'items.*.order' => 'required|integer|min:1'
        ]);
        
        DB::beginTransaction();
        try {
            foreach ($request->items as $item) {
                CulturalItem::where('id', $item['id'])
                    ->update(['featured_order' => $item['order']]);
            }
            DB::commit();
            
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}