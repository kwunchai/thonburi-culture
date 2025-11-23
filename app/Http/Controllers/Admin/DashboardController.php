<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CulturalItem;
use App\Models\CulturalCategory;
use App\Models\Community;
use App\Models\User;
use App\Models\IntellectualProperty;
use App\Models\Activity;
use App\Models\ActivityCategory;

class DashboardController extends Controller
{
    public function index()
    {
        // สถิติทั่วไป
        $generalStats = [
            'communities' => Community::count(),
            'cultural_items' => CulturalItem::count(),
            'activities' => Activity::count(),
            'intellectual_properties' => IntellectualProperty::count(),
            'research_data' => rand(15, 25), // สำหรับแสดงตัวอย่าง
            'innovations' => rand(8, 18), // สำหรับแสดงตัวอย่าง
        ];

        // สถิติข้อมูลชุมชน
        $communityStats = [
            'total' => Community::count(),
            'with_location' => Community::whereNotNull('latitude')->whereNotNull('longitude')->count(),
            'with_cultural_items' => Community::has('culturalItems')->count(),
            'monthly_data' => $this->getCommunityMonthlyData(),
        ];

        // สถิติข้อมูลวัฒนธรรม
        $culturalStats = [
            'total' => CulturalItem::count(),
            'published' => CulturalItem::where('is_published', true)->count(),
            'featured' => CulturalItem::where('is_featured', true)->count(),
            'by_category' => $this->getCulturalItemsByCategory(),
            'monthly_data' => $this->getCulturalItemsMonthlyData(),
        ];

        // สถิติทรัพย์สินทางปัญญา
        $ipStats = [
            'total' => IntellectualProperty::count(),
            'active' => IntellectualProperty::where('status', 'active')->count(),
            'registered' => IntellectualProperty::where('status', 'registered')->count(),
            'by_type' => $this->getIPByType(),
            'monthly_data' => $this->getIPMonthlyData(),
        ];

        // สถิติกิจกรรม
        $activityStats = [
            'total' => Activity::count(),
            'active' => Activity::where('is_active', true)->count(),
            'upcoming' => Activity::upcoming()->count(),
            'past' => Activity::past()->count(),
            'by_category' => $this->getActivitiesByCategory(),
            'monthly_data' => $this->getActivitiesMonthlyData(),
            'popular' => Activity::popular(5)->get(),
        ];

        // สถิติข้อมูลงานวิจัย (ตัวอย่าง)
        $researchStats = [
            'total' => $generalStats['research_data'],
            'published' => rand(8, 15),
            'ongoing' => rand(3, 8),
            'monthly_data' => $this->getResearchMonthlyData(),
        ];

        // สถิติข้อมูลนวัตกรรม (ตัวอย่าง)
        $innovationStats = [
            'total' => $generalStats['innovations'],
            'patents' => rand(3, 8),
            'prototypes' => rand(2, 6),
            'monthly_data' => $this->getInnovationMonthlyData(),
        ];

        // ข้อมูลล่าสุด
        $recentData = [
            'cultural_items' => CulturalItem::with(['category', 'community'])
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get(),
            'communities' => Community::orderBy('created_at', 'desc')
                ->take(5)
                ->get(),
            'activities' => Activity::with(['category', 'creator'])
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get(),
            'ip_items' => IntellectualProperty::orderBy('created_at', 'desc')
                ->take(5)
                ->get(),
        ];

        return view('admin.dashboard', compact(
            'generalStats',
            'communityStats', 
            'culturalStats',
            'activityStats',
            'ipStats',
            'researchStats',
            'innovationStats',
            'recentData'
        ));
    }

    private function getCommunityMonthlyData()
    {
        $months = [];
        $data = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->format('M Y');
            $data[] = Community::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }
        
        return compact('months', 'data');
    }

    private function getCulturalItemsMonthlyData()
    {
        $months = [];
        $data = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->format('M Y');
            $data[] = CulturalItem::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }
        
        return compact('months', 'data');
    }

    private function getCulturalItemsByCategory()
    {
        return CulturalItem::join('cultural_categories', 'cultural_items.category_id', '=', 'cultural_categories.id')
            ->selectRaw('cultural_categories.name, COUNT(*) as count')
            ->groupBy('cultural_categories.id', 'cultural_categories.name')
            ->get();
    }

    private function getIPByType()
    {
        return IntellectualProperty::selectRaw('type, COUNT(*) as count')
            ->groupBy('type')
            ->get();
    }

    private function getResearchMonthlyData()
    {
        $months = [];
        $data = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->format('M Y');
            // สร้างข้อมูลตัวอย่างสำหรับงานวิจัย
            $data[] = rand(0, 3);
        }
        
        return compact('months', 'data');
    }

    // สถิติกิจกรรมตามหมวดหมู่
    private function getActivitiesByCategory()
    {
        return ActivityCategory::withCount('activities')
            ->active()
            ->ordered()
            ->get()
            ->map(function($category) {
                return [
                    'name' => $category->name,
                    'count' => $category->activities_count,
                    'color' => $category->color,
                    'percentage' => Activity::count() > 0 ? round(($category->activities_count / Activity::count()) * 100, 1) : 0
                ];
            });
    }

    // ข้อมูลกิจกรรมรายเดือน
    private function getActivitiesMonthlyData()
    {
        $months = [];
        $data = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->format('M Y');
            
            $count = Activity::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $data[] = $count;
        }
        
        return compact('months', 'data');
    }

    private function getInnovationMonthlyData()
    {
        $months = [];
        $data = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->format('M Y');
            // สร้างข้อมูลตัวอย่างสำหรับนวัตกรรม
            $data[] = rand(0, 2);
        }
        
        return compact('months', 'data');
    }

    private function getIPMonthlyData()
    {
        $months = [];
        $data = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->format('M Y');
            $data[] = IntellectualProperty::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }
        
        return compact('months', 'data');
    }
}