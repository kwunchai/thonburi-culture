<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityCategory;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * แสดงหน้ากิจกรรมสำหรับ Frontend
     */
    public function index(Request $request)
    {
        $query = Activity::with(['category', 'creator'])->active();

        // Filter by category
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        // Search by title or description
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->where('activity_date', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->where('activity_date', '<=', $request->date_to);
        }

        // Sort options
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'upcoming':
                $query->upcoming()->orderBy('activity_date', 'asc');
                break;
            case 'popular':
                $query->orderBy('views_count', 'desc');
                break;
            case 'date_asc':
                $query->orderBy('activity_date', 'asc');
                break;
            case 'date_desc':
                $query->orderBy('activity_date', 'desc');
                break;
            default: // latest - เรียงตามวันที่เพิ่มล่าสุด
                $query->orderBy('created_at', 'desc');
        }

        $activities = $query->paginate(12);
        $categories = ActivityCategory::active()->ordered()->get();

        // Statistics for display
        $stats = [
            'total' => Activity::active()->count(),
            'upcoming' => Activity::active()->upcoming()->count(),
            'categories' => $categories->count()
        ];

        return view('frontend.activities', compact('activities', 'categories', 'stats'));
    }

    /**
     * แสดงรายละเอียดกิจกรรมแต่ละอัน
     */
    public function show(Activity $activity)
    {
        // ตรวจสอบว่ากิจกรรมนั้นเปิดใช้งานหรือไม่
        if (!$activity->is_active) {
            abort(404);
        }

        // นับจำนวนการเข้าชม
        $activity->incrementViews();

        // โหลด relationships ที่จำเป็น
        $activity->load(['category', 'creator']);

        // กิจกรรมที่เกี่ยวข้อง (ดึงจากหมวดหมู่เดียวกัน, เรียงจากใหม่ไปเก่า)
        $relatedActivities = Activity::active()
            ->where('id', '!=', $activity->id)
            ->when($activity->category_id, function($query) use ($activity) {
                return $query->where('category_id', $activity->category_id);
            })
            ->ordered()
            ->limit(8)
            ->get();

        return view('frontend.activity-detail', compact('activity', 'relatedActivities'));
    }

    /**
     * แสดงกิจกรรมตามหมวดหมู่
     */
    public function byCategory(ActivityCategory $category)
    {
        if (!$category->is_active) {
            abort(404);
        }

        $activities = Activity::with(['category', 'creator'])
            ->active()
            ->byCategory($category->id)
            ->ordered()
            ->paginate(12);

        $stats = [
            'total' => $activities->total(),
            'upcoming' => Activity::active()->byCategory($category->id)->upcoming()->count(),
        ];

        return view('frontend.activities-by-category', compact('category', 'activities', 'stats'));
    }
}