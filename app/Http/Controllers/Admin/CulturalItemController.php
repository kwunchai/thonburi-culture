<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\CulturalItem;
use App\Models\CulturalCategory;
use App\Models\Community;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class CulturalItemController extends Controller
{
    public function index(Request $request)
    {
        $query = CulturalItem::with(['category', 'community', 'creator']);

        // ค้นหาตามชื่อ
        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // กรองตามหมวดหมู่
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // กรองตามสถานะ
        if ($request->has('status') && $request->status != '') {
            switch ($request->status) {
                case 'published':
                    $query->where('is_published', true);
                    break;
                case 'draft':
                    $query->where('is_published', false);
                    break;
                case 'featured':
                    $query->where('is_featured', true);
                    break;
            }
        }

        // กรองตามชุมชน
        if ($request->has('community') && $request->community != '') {
            $query->where('community_id', $request->community);
        }

        // เรียงลำดับ
        $order = $request->get('order', 'desc');
        switch ($order) {
            case 'asc':
                $query->orderBy('created_at', 'asc');
                break;
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $items = $query->paginate(15);
        $items->appends($request->query());
        
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
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
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
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
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

    /**
     * Toggle featured status
     */
    public function toggleFeatured(Request $request, CulturalItem $culturalItem)
    {
        try {
            $culturalItem->update([
                'is_featured' => $request->is_featured
            ]);

            return response()->json([
                'success' => true,
                'message' => 'อัปเดตสถานะเรียบร้อยแล้ว',
                'is_featured' => $culturalItem->is_featured
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk actions for multiple items
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:publish,unpublish,feature,unfeature,delete',
            'ids' => 'required|array',
            'ids.*' => 'exists:cultural_items,id'
        ]);

        $ids = $request->ids;
        $action = $request->action;
        $successCount = 0;

        try {
            switch ($action) {
                case 'publish':
                    $successCount = CulturalItem::whereIn('id', $ids)
                        ->update(['is_published' => true]);
                    break;

                case 'unpublish':
                    $successCount = CulturalItem::whereIn('id', $ids)
                        ->update(['is_published' => false]);
                    break;

                case 'feature':
                    $successCount = CulturalItem::whereIn('id', $ids)
                        ->update(['is_featured' => true]);
                    break;

                case 'unfeature':
                    $successCount = CulturalItem::whereIn('id', $ids)
                        ->update(['is_featured' => false]);
                    break;

                case 'delete':
                    // Delete images first
                    $items = CulturalItem::whereIn('id', $ids)->get();
                    foreach ($items as $item) {
                        if ($item->image && Storage::exists($item->image)) {
                            Storage::delete($item->image);
                        }
                    }
                    $successCount = CulturalItem::whereIn('id', $ids)->delete();
                    break;
            }

            return response()->json([
                'success' => true,
                'message' => "ดำเนินการเรียบร้อยแล้ว จำนวน {$successCount} รายการ"
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export data to Excel/PDF
     */
    public function export(Request $request)
    {
        $format = $request->get('export', 'excel');
        
        $query = CulturalItem::with(['category', 'community', 'creator']);
        
        // Apply same filters as index
        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }
        if ($request->has('status') && $request->status != '') {
            switch ($request->status) {
                case 'published':
                    $query->where('is_published', true);
                    break;
                case 'draft':
                    $query->where('is_published', false);
                    break;
                case 'featured':
                    $query->where('is_featured', true);
                    break;
            }
        }
        if ($request->has('community') && $request->community != '') {
            $query->where('community_id', $request->community);
        }

        $items = $query->get();

        if ($format === 'pdf') {
            return $this->exportToPdf($items);
        }
        
        return $this->exportToExcel($items);
    }

    private function exportToExcel($items)
    {
        try {
            $filename = 'cultural-items-' . date('Y-m-d') . '.csv';
            
            $headers = [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0',
                'Pragma' => 'public',
            ];

            $callback = function() use ($items) {
                $file = fopen('php://output', 'w');
                
                // Add BOM for UTF-8
                fwrite($file, "\xEF\xBB\xBF");
                
                // Headers
                fputcsv($file, [
                    'ID',
                    'ชื่อข้อมูลวัฒนธรรม',
                    'หมวดหมู่',
                    'ชุมชน',
                    'คำอธิบาย',
                    'สถานะการเผยแพร่',
                    'ข้อมูลเด่น',
                    'วันที่เผยแพร่',
                    'ผู้สร้าง',
                    'วันที่สร้าง'
                ]);
                
                foreach ($items as $item) {
                    fputcsv($file, [
                        $item->id,
                        $item->title,
                        $item->category->name ?? '',
                        $item->community->name ?? '',
                        strip_tags($item->description),
                        $item->is_published ? 'เผยแพร่' : 'ฉบับร่าง',
                        $item->is_featured ? 'ใช่' : 'ไม่ใช่',
                        $item->publish_date ? $item->publish_date->format('d/m/Y') : '',
                        $item->creator->name ?? '',
                        $item->created_at->format('d/m/Y H:i:s')
                    ]);
                }
                
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
            
        } catch (\Exception $e) {
            Log::error('Export failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'เกิดข้อผิดพลาดในการส่งออกข้อมูล: ' . $e->getMessage());
        }
    }

    private function exportToPdf($items)
    {
        // This would require a PDF library like TCPDF or similar
        // For now, return a simple response
        return response()->json([
            'message' => 'PDF export will be implemented in future version'
        ]);
    }
}