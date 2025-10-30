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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class SlideshowController extends Controller
{
    /**
     * แสดงรายการ Slideshow
     */
    public function index()
    {
        // ดึงเฉพาะรายการที่ featured
        $featuredItems = CulturalItem::with(['category', 'community', 'creator'])
            ->where('is_featured', 1)
            ->orderBy('featured_order', 'asc')
            ->orderBy('publish_date', 'desc')
            ->get();
        
        // ดึงรายการทั้งหมดที่สามารถเพิ่มเป็น featured
        $availableItems = CulturalItem::with(['category', 'community'])
            ->where('is_featured', 0)
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
        Log::info('Toggle featured called for ID: ' . $id);
        
        // รับ action จาก request body
        $requestData = json_decode($request->getContent(), true);
        $action = $requestData['action'] ?? 'toggle';
        
        Log::info('Request action: ' . $action);
        
        try {
            DB::beginTransaction();
            
            $item = CulturalItem::findOrFail($id);
            
            Log::info('Current item featured status: ' . ($item->is_featured ? 'true' : 'false'));
            
            // เก็บค่าก่อนการเปลี่ยนแปลง
            $oldFeatured = $item->is_featured;
            
            // กำหนด featured status ตาม action
            if ($action === 'add') {
                $newFeatured = true;
            } elseif ($action === 'remove') {
                $newFeatured = false;
            } else {
                // toggle mode (เดิม)
                $newFeatured = !$item->is_featured;
            }
            
            Log::info('Action: ' . $action . ', Old featured: ' . ($oldFeatured ? 'true' : 'false') . ', New featured: ' . ($newFeatured ? 'true' : 'false'));
            
            // ตรวจสอบจำนวนเมื่อต้องการเพิ่ม
            if ($newFeatured && !$oldFeatured) {
                $featuredCount = CulturalItem::where('is_featured', true)->count();
                Log::info('Current featured count: ' . $featuredCount);
                if ($featuredCount >= 4) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => 'จำนวน Slideshow เต็มแล้ว (สูงสุด 4 รายการ)'
                    ], 400);
                }
            }
            
            // กำหนดค่าให้ model
            $item->is_featured = $newFeatured;
            
            Log::info('New featured status: ' . ($item->is_featured ? 'true' : 'false'));
            
            if ($item->is_featured) {
                // คำนวณ order ใหม่โดยหา max จาก items อื่นที่ featured อยู่แล้ว
                $maxOrder = CulturalItem::where('is_featured', true)
                    ->where('id', '!=', $item->id)
                    ->max('featured_order') ?? 0;
                $item->featured_order = $maxOrder + 1;
                Log::info('New featured order: ' . $item->featured_order);
            } else {
                $item->featured_order = null;
                Log::info('Removed featured order');
            }
            
            // บันทึกข้อมูลด้วย raw SQL เพื่อให้แน่ใจ
            $newFeaturedValue = $item->is_featured ? 1 : 0;
            $newOrderValue = $item->featured_order;
            
            $updated = DB::table('cultural_items')
                ->where('id', $id)
                ->update([
                    'is_featured' => $newFeaturedValue,
                    'featured_order' => $newOrderValue,
                    'updated_at' => now()
                ]);
                
            Log::info('Raw SQL update result: ' . $updated);
            
            if (!$updated) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'ไม่สามารถบันทึกข้อมูลได้ (SQL update failed)'
                ], 500);
            }
            
            // Commit transaction
            DB::commit();
            
            // ตรวจสอบข้อมูลหลังการบันทึก
            $item->refresh();
            Log::info('After refresh - featured status: ' . ($item->is_featured ? 'true' : 'false'));
            
            // ตรวจสอบในฐานข้อมูลอีกครั้ง
            $dbItem = CulturalItem::find($id);
            Log::info('Database check - featured status: ' . ($dbItem->is_featured ? 'true' : 'false'));
            
            $message = $item->is_featured ? 'เพิ่มเป็น Slideshow เรียบร้อยแล้ว' : 'ลบออกจาก Slideshow เรียบร้อยแล้ว';
            
            // เตรียมข้อมูลรายการสำหรับส่งกลับ
            $itemData = null;
            if (!$item->is_featured) {
                // หากยกเลิก featured ให้ส่งข้อมูลรายการกลับไปเพื่อแสดงในตาราง
                $itemData = [
                    'id' => $item->id,
                    'title' => $item->title,
                    'category_name' => $item->category->name ?? '',
                    'community_name' => $item->community->name ?? '',
                    'publish_date' => $item->publish_date->format('d/m/Y'),
                    'image' => $item->image ? true : false,
                    'image_url' => $item->image ? Storage::url($item->image) : null
                ];
            }
            
            return response()->json([
                'success' => true,
                'is_featured' => $item->is_featured,
                'old_featured' => $oldFeatured,
                'updated' => $updated,
                'message' => $message,
                'item_data' => $itemData,
                'debug' => [
                    'id' => $id,
                    'old_status' => $oldFeatured,
                    'new_status' => $item->is_featured,
                    'db_status' => $dbItem->is_featured,
                    'updated' => $updated,
                    'transaction' => 'committed'
                ]
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Toggle featured error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()
            ], 500);
        }
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