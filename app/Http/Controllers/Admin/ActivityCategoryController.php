<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ActivityCategoryController extends Controller
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
     * แสดงรายการหมวดหมู่กิจกรรมทั้งหมด
     */
    public function index()
    {
        $categories = ActivityCategory::withCount('activities')
                                    ->ordered()
                                    ->paginate(15);

        return view('admin.activity-categories.index', compact('categories'));
    }

    /**
     * แสดงฟอร์มสร้างหมวดหมู่ใหม่
     */
    public function create()
    {
        return view('admin.activity-categories.create');
    }

    /**
     * บันทึกหมวดหมู่ใหม่
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500'
        ]);

        $data = $request->only(['name', 'description']);
        $data['slug'] = Str::slug($request->name);
        $data['color'] = '#f97316'; // Default orange color
        $data['icon'] = 'fas fa-calendar'; // Default calendar icon
        $data['is_active'] = true; // Default active

        ActivityCategory::create($data);

        return redirect()->route('admin.activity-categories.index')
                        ->with('success', 'เพิ่มหมวดหมู่กิจกรรมสำเร็จ');
    }

    /**
     * แสดงรายละเอียดหมวดหมู่
     */
    public function show(ActivityCategory $activityCategory)
    {
        // Load กิจกรรมล่าสุด 10 รายการ พร้อมนับจำนวนทั้งหมด
        $activityCategory->loadCount('activities')
                        ->load(['activities' => function ($query) {
                            $query->latest('created_at')->limit(10);
                        }]);

        return view('admin.activity-categories.show', compact('activityCategory'));
    }

    /**
     * แสดงฟอร์มแก้ไขหมวดหมู่
     */
    public function edit(ActivityCategory $activityCategory)
    {
        return view('admin.activity-categories.edit', compact('activityCategory'));
    }

    /**
     * อัพเดทหมวดหมู่
     */
    public function update(Request $request, ActivityCategory $activityCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500'
        ]);

        $data = $request->only(['name', 'description']);
        
        // อัพเดท slug ถ้าชื่อเปลี่ยน
        if ($request->name !== $activityCategory->name) {
            $data['slug'] = Str::slug($request->name);
        }

        $activityCategory->update($data);

        return redirect()->route('admin.activity-categories.index')
                        ->with('success', 'อัพเดทหมวดหมู่กิจกรรมสำเร็จ');
    }

    /**
     * ลบหมวดหมู่
     */
    public function destroy(ActivityCategory $activityCategory)
    {
        // ตรวจสอบว่ามีกิจกรรมใช้หมวดหมู่นี้อยู่หรือไม่
        if ($activityCategory->activities()->count() > 0) {
            return redirect()->route('admin.activity-categories.index')
                           ->with('error', 'ไม่สามารถลบหมวดหมู่นี้ได้ เนื่องจากมีกิจกรรมที่ใช้หมวดหมู่นี้อยู่');
        }

        $activityCategory->delete();

        return redirect()->route('admin.activity-categories.index')
                        ->with('success', 'ลบหมวดหมู่กิจกรรมสำเร็จ');
    }

    /**
     * เปลี่ยนสถานะการแสดงผล
     */
    public function toggleStatus(ActivityCategory $activityCategory)
    {
        $activityCategory->update(['is_active' => !$activityCategory->is_active]);
        
        $status = $activityCategory->is_active ? 'เปิด' : 'ปิด';
        return redirect()->back()
                        ->with('success', "เปลี่ยนสถานะเป็น {$status} การแสดงผลแล้ว");
    }
}