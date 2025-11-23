<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\ActivityCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ActivityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // ใช้ check แบบง่ายก่อน เพื่อ debug
        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            if (!$user) {
                abort(403, 'Please login first');
            }
            
            if (!$user->hasRole(['admin', 'editor', 'ip_manager'])) {
                abort(403, 'Insufficient permissions. Your role: ' . $user->role);
            }
            
            return $next($request);
        });
    }

    /**
     * แสดงรายการกิจกรรมทั้งหมด
     */
    public function index()
    {
        $activities = Activity::with(['creator', 'category'])
            ->latest('created_at') // เรียงตามวันที่เพิ่มกิจกรรมล่าสุด
            ->paginate(15);        return view('admin.activities.index', compact('activities'));
    }

    /**
     * แสดงฟอร์มสร้างกิจกรรมใหม่
     */
    public function create()
    {
        $categories = ActivityCategory::active()->ordered()->get();
        return view('admin.activities.create', compact('categories'));
    }

    /**
     * บันทึกกิจกรรมใหม่
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'nullable|exists:activity_categories,id',
            'activity_date' => 'nullable|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'location' => 'nullable|string|max:255',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        $data['created_by'] = Auth::id();
        $data['is_active'] = $request->has('is_active');

        // จัดการวันที่และเวลา
        if ($request->activity_date && $request->start_time) {
            $data['start_time'] = $request->activity_date . ' ' . $request->start_time;
        }
        if ($request->activity_date && $request->end_time) {
            $data['end_time'] = $request->activity_date . ' ' . $request->end_time;
        }

        // อัพโลดรูปภาพหลัก
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $data['image'] = $image->storeAs('activities', $filename, 'public');
        }

        // อัพโลดรูปภาพเพิ่มเติม
        $additionalImages = [];
        if ($request->hasFile('additional_images')) {
            foreach ($request->file('additional_images') as $index => $image) {
                $filename = time() . '_' . $index . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('activities', $filename, 'public');
                $additionalImages[] = $imagePath;
            }
        }
        $data['images'] = $additionalImages;

        Activity::create($data);

        return redirect()->route('admin.activities.index')
                        ->with('success', 'เพิ่มกิจกรรมสำเร็จ');
    }

    /**
     * แสดงรายละเอียดกิจกรรม
     */
    public function show(Activity $activity)
    {
        return view('admin.activities.show', compact('activity'));
    }

    /**
     * แสดงฟอร์มแก้ไขกิจกรรม
     */
    public function edit(Activity $activity)
    {
        $categories = ActivityCategory::active()->ordered()->get();
        return view('admin.activities.edit', compact('activity', 'categories'));
    }

    /**
     * อัพเดทกิจกรรม
     */
    public function update(Request $request, Activity $activity)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'nullable|exists:activity_categories,id',
            'activity_date' => 'nullable|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'location' => 'nullable|string|max:255',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        // จัดการวันที่และเวลา
        if ($request->activity_date && $request->start_time) {
            $data['start_time'] = $request->activity_date . ' ' . $request->start_time;
        }
        if ($request->activity_date && $request->end_time) {
            $data['end_time'] = $request->activity_date . ' ' . $request->end_time;
        }

        // อัพโลดรูปภาพหลักใหม่
        if ($request->hasFile('image')) {
            // ลบรูปเก่า
            if ($activity->image && Storage::disk('public')->exists($activity->image)) {
                Storage::disk('public')->delete($activity->image);
            }

            $image = $request->file('image');
            $filename = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $data['image'] = $image->storeAs('activities', $filename, 'public');
        }

        // จัดการรูปภาพเพิ่มเติม
        $existingImages = [];
        if ($request->has('existing_images')) {
            // เก็บรูปภาพเก่าที่ยังต้องการ (ที่ไม่ถูกลบ)
            $existingImages = array_values($request->existing_images);
        }

        // อัพโลดรูปภาพเพิ่มเติมใหม่
        $newImages = [];
        if ($request->hasFile('additional_images')) {
            foreach ($request->file('additional_images') as $index => $image) {
                $filename = time() . '_add_' . $index . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('activities', $filename, 'public');
                $newImages[] = $imagePath;
            }
        }

        // รวมรูปภาพเก่าและใหม่
        $allAdditionalImages = array_merge($existingImages, $newImages);
        $data['images'] = $allAdditionalImages;

        // ลบรูปภาพเก่าที่ไม่ต้องการแล้ว
        if ($activity->images) {
            $oldImages = $activity->images;
            $imagesToDelete = array_diff($oldImages, $existingImages);
            
            foreach ($imagesToDelete as $imageToDelete) {
                if (Storage::disk('public')->exists($imageToDelete)) {
                    Storage::disk('public')->delete($imageToDelete);
                }
            }
        }

        $activity->update($data);

        return redirect()->route('admin.activities.index')
                        ->with('success', 'อัพเดทกิจกรรมสำเร็จ');
    }

    /**
     * ลบกิจกรรม
     */
    public function destroy(Activity $activity)
    {
        // ลบรูปภาพหลัก
        if ($activity->image && Storage::disk('public')->exists($activity->image)) {
            Storage::disk('public')->delete($activity->image);
        }

        // ลบรูปภาพเพิ่มเติม
        if ($activity->images && is_array($activity->images)) {
            foreach ($activity->images as $imagePath) {
                if (Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }
            }
        }

        $activity->delete();

        return redirect()->route('admin.activities.index')
                        ->with('success', 'ลบกิจกรรมสำเร็จ');
    }

    /**
     * เปลี่ยนสถานะการแสดงผล
     */
    public function toggleStatus(Activity $activity)
    {
        $activity->update(['is_active' => !$activity->is_active]);
        
        $status = $activity->is_active ? 'เปิด' : 'ปิด';
        return redirect()->back()
                        ->with('success', "เปลี่ยนสถานะเป็น {$status} การแสดงผลแล้ว");
    }
}