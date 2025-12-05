<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Community;
use App\Models\CulturalItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

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
        if ($request->filled('search')) {
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
        
        // สถิติ
        $stats = [
            'total' => Community::count(),
            'with_location' => Community::whereNotNull('latitude')
                ->whereNotNull('longitude')->count(),
            'with_items' => Community::has('culturalItems')->count(),
            'total_items' => CulturalItem::count()
        ];
        
        return view('admin.communities.index', compact('communities', 'stats'));
    }

    /**
     * แสดงฟอร์มสร้างชุมชนใหม่
     */
    public function create()
    {
        // ดึงข้อมูลสำหรับแผนที่ (ถ้าต้องการ)
        $existingCommunities = Community::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->select('name', 'latitude', 'longitude')
            ->get();
            
        return view('admin.communities.create', compact('existingCommunities'));
    }

    /**
     * บันทึกข้อมูลชุมชนใหม่
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:communities,name',
            'description' => 'nullable|string|max:1000',
            'address' => 'nullable|string|max:500',
            'contact_name' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:50',
            'contact_email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'facebook' => 'nullable|string|max:255',
            'line_id' => 'nullable|string|max:100',
            'image' => 'nullable|image|max:4096',
            'gallery_images.*' => 'nullable|image|max:2048',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'established_year' => 'nullable|integer|min:1000|max:' . date('Y'),
            'population' => 'nullable|integer|min:0',
            'area_size' => 'nullable|numeric|min:0',
            'highlights' => 'nullable|string|max:1000',
            'working_hours' => 'nullable|string|max:255',
            'is_active' => 'boolean'
        ], [
            'name.required' => 'กรุณาระบุชื่อชุมชน',
            'name.unique' => 'ชื่อชุมชนนี้มีอยู่แล้ว',
            'image.max' => 'ขนาดรูปภาพต้องไม่เกิน 4MB',
            'gallery_images.*.max' => 'ขนาดรูปภาพในแกลเลอรี่ต้องไม่เกิน 2MB',
            'latitude.between' => 'ละติจูดต้องอยู่ระหว่าง -90 ถึง 90',
            'longitude.between' => 'ลองจิจูดต้องอยู่ระหว่าง -180 ถึง 180'
        ]);
        
        // จัดการ upload รูปภาพหลัก
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('communities', 'public');
        }
        
        // สร้างชุมชน
        $community = Community::create($validated);
        
        // จัดการ gallery images (ถ้ามี)
        if ($request->hasFile('gallery_images')) {
            $gallery = [];
            foreach ($request->file('gallery_images') as $image) {
                $path = $image->store('communities/gallery', 'public');
                $gallery[] = $path;
            }
            
            // บันทึกเป็น JSON ในฐานข้อมูล (ต้องเพิ่ม field gallery_images ใน migration)
            $community->update(['gallery_images' => json_encode($gallery)]);
        }
        
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
                  ->orderBy('publish_date', 'desc')
                  ->take(10);
        }]);
        
        // สถิติของชุมชน
        $stats = [
            'total_items' => $community->culturalItems()->count(),
            'published_items' => $community->culturalItems()->published()->count(),
            'featured_items' => $community->culturalItems()->where('is_featured', true)->count(),
            'categories' => $community->culturalItems()
                ->select('category_id', DB::raw('count(*) as total'))
                ->groupBy('category_id')
                ->with('category')
                ->get()
        ];
        
        // ชุมชนใกล้เคียง (ถ้ามีพิกัด)
        $nearbyCommunities = [];
        if ($community->latitude && $community->longitude) {
            $nearbyCommunities = Community::where('id', '!=', $community->id)
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->selectRaw("*, 
                    (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * 
                    cos(radians(longitude) - radians(?)) + sin(radians(?)) * 
                    sin(radians(latitude)))) AS distance", 
                    [$community->latitude, $community->longitude, $community->latitude])
                ->having('distance', '<', 5) // ในรัศมี 5 กม.
                ->orderBy('distance')
                ->take(5)
                ->get();
        }
        
        return view('admin.communities.show', compact('community', 'stats', 'nearbyCommunities'));
    }

    /**
     * แสดงฟอร์มแก้ไขข้อมูลชุมชน
     */
    public function edit(Community $community)
    {
        // Decode gallery images ถ้ามี
        if ($community->gallery_images) {
            $community->gallery_images = json_decode($community->gallery_images, true);
        }
        
        $existingCommunities = Community::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->where('id', '!=', $community->id)
            ->select('name', 'latitude', 'longitude')
            ->get();
            
        return view('admin.communities.edit', compact('community', 'existingCommunities'));
    }

    /**
     * อัปเดตข้อมูลชุมชน
     */
    public function update(Request $request, Community $community)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:communities,name,' . $community->id,
            'description' => 'nullable|string|max:1000',
            'address' => 'nullable|string|max:500',
            'contact_name' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:50',
            'contact_email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'facebook' => 'nullable|string|max:255',
            'line_id' => 'nullable|string|max:100',
            'image' => 'nullable|image|max:4096',
            'gallery_images.*' => 'nullable|image|max:2048',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'established_year' => 'nullable|integer|min:1000|max:' . date('Y'),
            'population' => 'nullable|integer|min:0',
            'area_size' => 'nullable|numeric|min:0',
            'highlights' => 'nullable|string|max:1000',
            'working_hours' => 'nullable|string|max:255',
            'is_active' => 'boolean'
        ]);
        
        // จัดการรูปภาพหลัก
        if ($request->hasFile('image')) {
            // ลบรูปเก่า
            if ($community->image) {
                Storage::disk('public')->delete($community->image);
            }
            $validated['image'] = $request->file('image')->store('communities', 'public');
        }
        
        // จัดการ gallery images
        if ($request->hasFile('gallery_images')) {
            // ลบรูปเก่าในแกลเลอรี่
            if ($community->gallery_images) {
                $oldGallery = json_decode($community->gallery_images, true);
                foreach ($oldGallery as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
            
            $gallery = [];
            foreach ($request->file('gallery_images') as $image) {
                $path = $image->store('communities/gallery', 'public');
                $gallery[] = $path;
            }
            $validated['gallery_images'] = json_encode($gallery);
        }
        
        // ลบรูปที่เลือกลบ (ถ้ามี)
        if ($request->has('delete_gallery_images')) {
            $currentGallery = json_decode($community->gallery_images, true) ?? [];
            $toDelete = $request->delete_gallery_images;
            
            foreach ($toDelete as $imagePath) {
                Storage::disk('public')->delete($imagePath);
                $currentGallery = array_diff($currentGallery, [$imagePath]);
            }
            
            $validated['gallery_images'] = json_encode(array_values($currentGallery));
        }
        
        $community->update($validated);
        
        return redirect()->route('admin.communities.show', $community)
            ->with('success', 'อัปเดตข้อมูลชุมชน "' . $community->name . '" เรียบร้อยแล้ว');
    }

    /**
     * ลบข้อมูลชุมชน
     */
    public function destroy(Community $community)
    {
        // ตรวจสอบว่ามีข้อมูลวัฒนธรรมที่เชื่อมโยงหรือไม่
        if ($community->culturalItems()->count() > 0) {
            return redirect()->route('admin.communities.index')
                ->with('error', 'ไม่สามารถลบชุมชน "' . $community->name . '" ได้ เนื่องจากมีข้อมูลวัฒนธรรมที่เชื่อมโยงอยู่ ' . $community->culturalItems()->count() . ' รายการ');
        }
        
        // ลบรูปภาพ
        if ($community->image) {
            Storage::disk('public')->delete($community->image);
        }
        
        // ลบรูปภาพในแกลเลอรี่
        if ($community->gallery_images) {
            $gallery = json_decode($community->gallery_images, true);
            foreach ($gallery as $image) {
                Storage::disk('public')->delete($image);
            }
        }
        
        $communityName = $community->name;
        $community->delete();
        
        return redirect()->route('admin.communities.index')
            ->with('success', 'ลบข้อมูลชุมชน "' . $communityName . '" เรียบร้อยแล้ว');
    }

    /**
     * ลบหลายรายการพร้อมกัน
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'community_ids' => 'required|array',
            'community_ids.*' => 'exists:communities,id'
        ]);
        
        $cannotDelete = [];
        $deleted = [];
        
        foreach ($request->community_ids as $id) {
            $community = Community::find($id);
            
            if ($community->culturalItems()->count() > 0) {
                $cannotDelete[] = $community->name;
            } else {
                // ลบรูปภาพ
                if ($community->image) {
                    Storage::disk('public')->delete($community->image);
                }
                if ($community->gallery_images) {
                    $gallery = json_decode($community->gallery_images, true);
                    foreach ($gallery as $image) {
                        Storage::disk('public')->delete($image);
                    }
                }
                
                $deleted[] = $community->name;
                $community->delete();
            }
        }
        
        $message = '';
        if (count($deleted) > 0) {
            $message .= 'ลบชุมชน ' . count($deleted) . ' รายการเรียบร้อย';
        }
        if (count($cannotDelete) > 0) {
            $message .= ' (ไม่สามารถลบ: ' . implode(', ', $cannotDelete) . ' เนื่องจากมีข้อมูลเชื่อมโยง)';
        }
        
        return redirect()->route('admin.communities.index')
            ->with(count($deleted) > 0 ? 'success' : 'warning', $message);
    }

    /**
     * Export ข้อมูลชุมชนเป็น CSV
     */
    public function export(Request $request)
    {
        $format = $request->get('export', 'excel');
        
        $query = Community::withCount(['culturalItems' => function($q) {
            $q->published();
        }]);
        
        // ใช้ filter เดียวกับ index
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }
        
        $communities = $query->orderBy('name')->get();
        
        return $this->exportToExcel($communities);
    }
    
    private function exportToExcel($communities)
    {
        try {
            $filename = 'communities-' . date('Y-m-d') . '.csv';
            
            $headers = [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0',
                'Pragma' => 'public',
            ];

            $callback = function() use ($communities) {
                $file = fopen('php://output', 'w');
                
                // Add BOM for UTF-8
                fwrite($file, "\xEF\xBB\xBF");
                
                // Headers
                fputcsv($file, [
                    'ID',
                    'ชื่อชุมชน',
                    'คำอธิบาย',
                    'ที่อยู่',
                    'ผู้ติดต่อ',
                    'โทรศัพท์',
                    'อีเมล',
                    'จำนวนข้อมูลวัฒนธรรม',
                    'ละติจูด',
                    'ลองจิจูด',
                    'วันที่สร้าง'
                ]);
                
                foreach ($communities as $community) {
                    fputcsv($file, [
                        $community->id,
                        $community->name,
                        strip_tags($community->description),
                        $community->address,
                        $community->contact_name,
                        $community->contact_phone,
                        $community->contact_email,
                        $community->cultural_items_count,
                        $community->latitude,
                        $community->longitude,
                        $community->created_at->format('d/m/Y H:i:s')
                    ]);
                }
                
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
            
        } catch (\Exception $e) {
            Log::error('Community export failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'เกิดข้อผิดพลาดในการส่งออกข้อมูล: ' . $e->getMessage());
        }
    }

    /**
     * Toggle Active Status (AJAX)
     */
    public function toggleActive(Request $request, Community $community)
    {
        $community->is_active = !$community->is_active;
        $community->save();
        
        return response()->json([
            'success' => true,
            'is_active' => $community->is_active,
            'message' => $community->is_active ? 
                'เปิดใช้งานชุมชน "' . $community->name . '" แล้ว' : 
                'ปิดใช้งานชุมชน "' . $community->name . '" แล้ว'
        ]);
    }

    /**
     * อัปเดตพิกัดบนแผนที่ (AJAX)
     */
    public function updateLocation(Request $request, Community $community)
    {
        $validated = $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180'
        ]);
        
        $community->update($validated);
        
        return response()->json([
            'success' => true,
            'message' => 'อัปเดตพิกัดของชุมชน "' . $community->name . '" เรียบร้อยแล้ว'
        ]);
    }
}