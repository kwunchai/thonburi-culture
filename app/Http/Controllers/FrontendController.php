<?php

namespace App\Http\Controllers;

use App\Models\CulturalItem;
use App\Models\CulturalCategory;
use App\Models\Community;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class FrontendController extends Controller
{
    /**
     * แสดงหน้าแรก
     */
    public function home()
    {
        // เคลียร์ cache ทั้งหมดก่อน
        Cache::flush();
        
        // Log debug information
        Log::info('FrontendController@home called at: ' . now());
        
        // ตรวจสอบข้อมูลที่มี is_featured = 1 ในฐานข้อมูล
        $rawFeaturedCount = DB::table('cultural_items')->where('is_featured', 1)->count();
        Log::info('Raw featured count from DB: ' . $rawFeaturedCount);
        
        // Force fresh data without cache - ใช้ fresh query
        $featuredItems = CulturalItem::query()
            ->with(['category', 'community', 'creator'])
            ->whereRaw('is_featured = 1')  // ใช้ whereRaw เพื่อบังคับ fresh query
            ->where('is_published', 1)
            ->where('publish_date', '<=', now())
            ->visibleOnFrontend()  // เฉพาะชุมชนที่เปิดใช้งาน
            ->orderBy('featured_order', 'asc')
            ->orderBy('publish_date', 'desc')
            ->get()
            ->fresh();  // Force reload from database
        
        Log::info('Final featured items count: ' . $featuredItems->count());
        
        // Double check - filter อีกครั้งเพื่อให้แน่ใจ
        $featuredItems = $featuredItems->filter(function($item) {
            // Reload item to get latest data
            $fresh = CulturalItem::find($item->id);
            return $fresh && $fresh->is_featured == 1;
        });
        
        Log::info('After filtering featured items count: ' . $featuredItems->count());
        
        // Debug each item
        foreach($featuredItems as $item) {
            Log::info("Item ID: {$item->id}, is_featured: {$item->is_featured}, title: {$item->title}");
        }
        
        // ถ้าไม่มี featured items หรือมีน้อยกว่า 4 ให้ดึงรายการล่าสุดมาเติม
        if ($featuredItems->count() < 4) {
            // ดึง IDs ของ featured items ที่มีอยู่
            $excludeIds = $featuredItems->pluck('id')->toArray();
            
            // ดึงรายการเพิ่มเติม
            $additionalItems = CulturalItem::with(['category', 'community', 'creator'])
                ->whereNotIn('id', $excludeIds)
                ->published()
                ->visibleOnFrontend()  // เฉพาะชุมชนที่เปิดใช้งาน
                ->orderBy('publish_date', 'desc')
                ->take(4 - $featuredItems->count())
                ->get();
            
            // รวม featured items กับรายการเพิ่มเติม
            $featuredItems = $featuredItems->concat($additionalItems);
        }
        
        // ไม่ต้องดึงหมวดหมู่แล้ว - ถูกลบออกจากหน้าแรก
        // $categories = CulturalCategory::withCount(['culturalItems' => function($query) {
        //     $query->published();
        // }])->orderBy('name')->get();
        
        // ดึงข้อมูลวัฒนธรรมล่าสุด
        // ถ้าข้อมูลมีน้อย (< 12 รายการ) ให้แสดงทั้งหมดโดยไม่ยกเว้น featured
        // เพื่อให้มั่นใจว่าจะมีข้อมูลแสดงในส่วน "ข้อมูลวัฒนธรรมล่าสุด"
        $totalPublishedItems = CulturalItem::published()->visibleOnFrontend()->count();
        
        if ($totalPublishedItems < 12) {
            // ถ้าข้อมูลน้อย ดึงทั้งหมดมาแสดง (ไม่ยกเว้น featured)
            $latestItems = CulturalItem::with(['category', 'community'])
                ->published()
                ->visibleOnFrontend()
                ->orderBy('publish_date', 'desc')
                ->take(8)
                ->get();
        } else {
            // ถ้าข้อมูลเยอะพอ ให้ยกเว้น featured items
            $featuredIds = $featuredItems->pluck('id')->toArray();
            $latestItems = CulturalItem::with(['category', 'community'])
                ->whereNotIn('id', $featuredIds)
                ->published()
                ->visibleOnFrontend()
                ->orderBy('publish_date', 'desc')
                ->take(8)
                ->get();
        }
        
        // ไม่ต้องดึงข้อมูลชุมชนแล้ว - ถูกลบออกจากหน้าแรก
        // $communities = Community::withCount(['culturalItems' => function($query) {
        //     $query->published();
        // }])->orderBy('name')->get();
        
        // ดึงสถิติสำหรับแสดง
        $stats = [
            'total_items' => CulturalItem::published()->visibleOnFrontend()->count(),
            'total_categories' => CulturalCategory::count(),
            'total_communities' => Community::active()->count(),
            'total_innovations' => rand(8, 18), // ข้อมูลตัวอย่างสำหรับนวัตกรรม
            'total_research' => rand(15, 25), // ข้อมูลตัวอย่างสำหรับงานวิจัย
            'total_ip' => rand(10, 20), // ข้อมูลตัวอย่างสำหรับทรัพย์สินทางปัญญา
        ];

        // ดึงข้อมูลวัฒนธรรมที่มีพิกัดสำหรับแผนที่
        $culturalItemsWithLocation = CulturalItem::with(['category', 'community'])
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->published()
            ->visibleOnFrontend()  // เฉพาะชุมชนที่เปิดใช้งาน
            ->get();

        return view('frontend.home', compact(
            'featuredItems', 
            'latestItems', 
            'stats',
            'culturalItemsWithLocation'
        ));
    }

    /**
     * แสดงหน้าสำรวจวัฒนธรรม - สำหรับการค้นหาและเรียกดูข้อมูลวัฒนธรรม
     */
    public function explore(Request $request)
    {
        // รับ parameters จาก URL
        $search = $request->get('search', '');
        $category_id = $request->get('category_id', '');
        $community_id = $request->get('community_id', '');
        $sort = $request->get('sort', 'latest');
        $per_page = $request->get('per_page', 12);

        // Query builder สำหรับ cultural items
        $query = CulturalItem::with(['category', 'community', 'creator'])
            ->published()
            ->visibleOnFrontend();  // เฉพาะชุมชนที่เปิดใช้งาน

        // ค้นหาตามคำค้นหา
        // ค้นหาเฉพาะใน column ที่มีอยู่จริง: title, description
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        // กรองตามหมวดหมู่
        if (!empty($category_id)) {
            $query->where('category_id', $category_id);
        }

        // กรองตามชุมชน
        if (!empty($community_id)) {
            $query->where('community_id', $community_id);
        }

        // เรียงลำดับ
        switch ($sort) {
            case 'oldest':
                $query->orderBy('publish_date', 'asc');
                break;
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;
            case 'popular':
                // ใช้ created_at แทน view_count เพื่อหาข้อมูลที่น่าสนใจ
                $query->orderBy('created_at', 'desc');
                break;
            case 'latest':
            default:
                $query->orderBy('publish_date', 'desc');
                break;
        }

        // Pagination
        $items = $query->paginate($per_page)->appends($request->query());

        // ข้อมูลสำหรับ filters - เฉพาะชุมชนที่เปิดใช้งาน
        $categories = CulturalCategory::withCount(['culturalItems' => function($query) {
            $query->published()->visibleOnFrontend();
        }])->orderBy('name')->get();

        $communities = Community::active()->withCount(['culturalItems' => function($query) {
            $query->published();
        }])->orderBy('name')->get();

        // สถิติการค้นหา
        $stats = [
            'total_found' => $items->total(),
            'total_items' => CulturalItem::published()->visibleOnFrontend()->count(),
            'total_categories' => $categories->count(),
            'total_communities' => $communities->count()
        ];

        // รายการที่นิยม (สำหรับ sidebar) - ใช้ random แทน view_count
        $popularItems = CulturalItem::published()
            ->visibleOnFrontend()  // เฉพาะชุมชนที่เปิดใช้งาน
            ->inRandomOrder()
            ->take(5)
            ->get();

        // รายการล่าสุด (สำหรับ sidebar)
        $latestItems = CulturalItem::published()
            ->visibleOnFrontend()  // เฉพาะชุมชนที่เปิดใช้งาน
            ->orderBy('publish_date', 'desc')
            ->take(5)
            ->get();

        return view('frontend.explore', compact(
            'items',
            'categories', 
            'communities',
            'stats',
            'popularItems',
            'latestItems',
            'search',
            'category_id',
            'community_id',
            'sort',
            'per_page'
        ));
    }

    /**
     * แสดงหน้าหมวดหมู่
     */
    public function category($slug)
    {
        // ดึงข้อมูลหมวดหมู่
        $category = CulturalCategory::where('slug', $slug)->firstOrFail();
        
        // ดึงรายการในหมวดหมู่
        $items = $category->culturalItems()
            ->with(['community', 'creator'])
            ->published()
            ->visibleOnFrontend()  // เฉพาะชุมชนที่เปิดใช้งาน
            ->orderBy('publish_date', 'desc')
            ->paginate(12);
        
        // ดึงหมวดหมู่อื่นๆ สำหรับ sidebar
        $otherCategories = CulturalCategory::where('id', '!=', $category->id)
            ->withCount(['culturalItems' => function($query) {
                $query->published();
            }])
            ->orderBy('name')
            ->get();
        
        // ดึงรายการยอดนิยม (สุ่ม) ในหมวดหมู่นี้
        $popularItems = $category->culturalItems()
            ->published()
            ->visibleOnFrontend()  // เฉพาะชุมชนที่เปิดใช้งาน
            ->inRandomOrder()
            ->take(5)
            ->get();

        return view('frontend.category', compact(
            'category', 
            'items', 
            'otherCategories',
            'popularItems'
        ));
    }

    /**
     * แสดงรายละเอียดข้อมูลวัฒนธรรม
     */
    public function show($id)
    {
        // ดึงข้อมูลหลัก
        $item = CulturalItem::with(['category', 'community', 'creator'])
            ->published()
            ->findOrFail($id);
        
        // ตรวจสอบว่าชุมชนเปิดใช้งานหรือไม่ - ถ้าปิดให้คืน 404
        if (!$item->community || !$item->community->is_active) {
            abort(404, 'ไม่พบข้อมูลที่ค้นหา');
        }
        
        // ดึงรายการที่เกี่ยวข้อง (ในหมวดหมู่เดียวกัน)
        $relatedItems = CulturalItem::where('category_id', $item->category_id)
            ->where('id', '!=', $id)
            ->with(['community'])
            ->published()
            ->visibleOnFrontend()  // เฉพาะชุมชนที่เปิดใช้งาน
            ->orderBy('publish_date', 'desc')
            ->take(4)
            ->get();
        
        // ถ้ารายการที่เกี่ยวข้องน้อยเกินไป ดึงจากชุมชนเดียวกันมาเสริม
        if ($relatedItems->count() < 4) {
            $excludeIds = $relatedItems->pluck('id')->push($id)->toArray();
            
            $communityItems = CulturalItem::where('community_id', $item->community_id)
                ->whereNotIn('id', $excludeIds)
                ->with(['category', 'community'])
                ->published()
                ->visibleOnFrontend()  // เฉพาะชุมชนที่เปิดใช้งาน
                ->orderBy('publish_date', 'desc')
                ->take(4 - $relatedItems->count())
                ->get();
            
            $relatedItems = $relatedItems->concat($communityItems);
        }
        
        // ดึงรายการก่อนหน้าและถัดไป
        $previousItem = CulturalItem::where('id', '<', $item->id)
            ->published()
            ->visibleOnFrontend()  // เฉพาะชุมชนที่เปิดใช้งาน
            ->orderBy('id', 'desc')
            ->first();
            
        $nextItem = CulturalItem::where('id', '>', $item->id)
            ->published()
            ->visibleOnFrontend()  // เฉพาะชุมชนที่เปิดใช้งาน
            ->orderBy('id', 'asc')
            ->first();

        return view('frontend.show', compact(
            'item', 
            'relatedItems',
            'previousItem',
            'nextItem'
        ));
    }

    /**
     * แสดงหน้าชุมชน
     */
    public function community($id)
    {
        // ดึงข้อมูลชุมชน
        $community = Community::findOrFail($id);
        
        // ตรวจสอบว่าชุมชนเปิดใช้งานหรือไม่ - ถ้าปิดให้คืน 404
        if (!$community->is_active) {
            abort(404, 'ไม่พบข้อมูลชุมชนที่ค้นหา');
        }
        
        // ดึงรายการในชุมชน
        $items = $community->culturalItems()
            ->with(['category', 'creator'])
            ->published()
            ->orderBy('publish_date', 'desc')
            ->paginate(12);
        
        // ดึงชุมชนอื่นๆ
        $otherCommunities = Community::where('id', '!=', $community->id)
            ->active()  // เฉพาะชุมชนที่เปิดใช้งาน
            ->withCount(['culturalItems' => function($query) {
                $query->published();
            }])
            ->orderBy('name')
            ->get();
        
        // ดึงหมวดหมู่ที่มีในชุมชนนี้
        $categories = CulturalCategory::whereHas('culturalItems', function($query) use ($community) {
            $query->where('community_id', $community->id)
                  ->published();
        })->withCount(['culturalItems' => function($query) use ($community) {
            $query->where('community_id', $community->id)
                  ->published();
        }])->get();

        return view('frontend.community', compact(
            'community', 
            'items', 
            'otherCommunities',
            'categories'
        ));
    }

    /**
     * หน้าค้นหา
     */
    public function search(Request $request)
    {
        $query = $request->input('q');
        $category_id = $request->input('category');
        $community_id = $request->input('community');
        $sort = $request->input('sort', 'latest');
        
        // สร้าง query builder
        $itemsQuery = CulturalItem::with(['category', 'community', 'creator'])
            ->published()
            ->visibleOnFrontend();  // เฉพาะชุมชนที่เปิดใช้งาน
        
        // ค้นหาด้วยคำค้น
        if ($query) {
            $itemsQuery->where(function($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%");
            });
        }
        
        // กรองตามหมวดหมู่
        if ($category_id) {
            $itemsQuery->where('category_id', $category_id);
        }
        
        // กรองตามชุมชน
        if ($community_id) {
            $itemsQuery->where('community_id', $community_id);
        }
        
        // เรียงลำดับ
        switch($sort) {
            case 'oldest':
                $itemsQuery->orderBy('publish_date', 'asc');
                break;
            case 'title':
                $itemsQuery->orderBy('title', 'asc');
                break;
            default: // latest
                $itemsQuery->orderBy('publish_date', 'desc');
                break;
        }
        
        // ดึงผลลัพธ์
        $items = $itemsQuery->paginate(12)->appends($request->all());
        
        // ดึงข้อมูลสำหรับ filter - เฉพาะชุมชนที่เปิดใช้งาน
        $categories = CulturalCategory::orderBy('name')->get();
        $communities = Community::active()->orderBy('name')->get();

        return view('frontend.search', compact(
            'items', 
            'query', 
            'categories', 
            'communities',
            'category_id',
            'community_id',
            'sort'
        ));
    }

    /**
     * หน้าเกี่ยวกับเรา
     */
    public function about()
    {
        // ดึงสถิติ
        $stats = [
            'total_items' => CulturalItem::published()->count(),
            'total_categories' => CulturalCategory::count(),
            'total_communities' => Community::count(),
            'years_of_service' => date('Y') - 2020, // สมมติเริ่มปี 2020
        ];
        
        // ดึงทีมงาน (ถ้ามี)
        $team = [
            [
                'name' => 'คุณสมชาย ใจดี',
                'position' => 'ผู้อำนวยการ',
                'image' => 'https://via.placeholder.com/200',
                'description' => 'ผู้ริเริ่มโครงการอนุรักษ์วัฒนธรรมธนบุรี'
            ],
            [
                'name' => 'คุณสมหญิง รักไทย',
                'position' => 'นักวิชาการวัฒนธรรม',
                'image' => 'https://via.placeholder.com/200',
                'description' => 'ผู้เชี่ยวชาญด้านประวัติศาสตร์ท้องถิ่น'
            ],
        ];

        return view('frontend.about', compact('stats', 'team'));
    }

    /**
     * หน้าติดต่อเรา
     */
    public function contact()
    {
        // ข้อมูลติดต่อ
        $contactInfo = [
            'address' => 'เขตธนบุรี กรุงเทพมหานคร 10600',
            'phone' => '02-XXX-XXXX',
            'email' => 'info@thonburi-culture.go.th',
            'facebook' => 'https://facebook.com/thonburiculture',
            'line' => '@thonburiculture',
            'working_hours' => [
                'weekday' => 'จันทร์ - ศุกร์: 08:30 - 16:30 น.',
                'weekend' => 'เสาร์ - อาทิตย์: ปิดทำการ'
            ]
        ];

        return view('frontend.contact', compact('contactInfo'));
    }

    /**
     * ส่งข้อความติดต่อ
     */
    public function sendContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
            'phone' => 'nullable|string|max:20'
        ]);
        
        // บันทึกข้อความลง database หรือส่ง email
        // ตัวอย่าง: บันทึกลง database
        DB::table('contact_messages')->insert([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        // ส่ง email (optional)
        // Mail::to('admin@thonburi-culture.go.th')->send(new ContactMessage($validated));
        
        return redirect()->route('contact')
            ->with('success', 'ข้อความของคุณถูกส่งเรียบร้อยแล้ว เราจะติดต่อกลับโดยเร็วที่สุด');
    }

    /**
     * หน้าแผนที่วัฒนธรรม
     */
    public function map()
    {
        // ดึงชุมชนพร้อมพิกัด
        $communities = Community::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->withCount(['culturalItems' => function($query) {
                $query->published();
            }])
            ->get();
        
        // ดึงรายการที่มีพิกัด (ถ้ามี)
        $items = CulturalItem::with(['category', 'community'])
            ->published()
            ->whereHas('community', function($query) {
                $query->whereNotNull('latitude')
                      ->whereNotNull('longitude');
            })
            ->get();
        
        // จัดกลุ่มตามหมวดหมู่สำหรับ legend
        $categoriesWithItems = CulturalCategory::whereHas('culturalItems', function($query) {
            $query->published()
                  ->whereHas('community', function($q) {
                      $q->whereNotNull('latitude')
                        ->whereNotNull('longitude');
                  });
        })->get();

        return view('frontend.map', compact('communities', 'items', 'categoriesWithItems'));
    }

    /**
     * หน้าข่าวสารและกิจกรรม
     */
    public function news()
    {
        // ดึงข่าวสารล่าสุด (สมมติใช้ cultural_items ที่มี category เป็นข่าวสาร)
        $newsCategory = CulturalCategory::where('slug', 'news')->first();
        
        if ($newsCategory) {
            $news = $newsCategory->culturalItems()
                ->with(['community', 'creator'])
                ->published()
                ->orderBy('publish_date', 'desc')
                ->paginate(9);
        } else {
            $news = collect(); // empty collection
        }
        
        // ดึงกิจกรรมที่กำลังจะมาถึง
        $upcomingEvents = CulturalItem::with(['category', 'community'])
            ->where('publish_date', '>', now())
            ->where('is_published', true)
            ->orderBy('publish_date', 'asc')
            ->take(5)
            ->get();
        
        // ดึงรายการที่มีผู้เข้าชมมากที่สุด (สมมติ)
        $popularItems = CulturalItem::with(['category', 'community'])
            ->published()
            ->inRandomOrder() // ในระบบจริงอาจใช้ view_count
            ->take(5)
            ->get();

        return view('frontend.news', compact('news', 'upcomingEvents', 'popularItems'));
    }

    /**
     * หน้า Gallery
     */
    public function gallery()
    {
        // ดึงรายการที่มีรูปภาพ
        $items = CulturalItem::with(['category', 'community'])
            ->whereNotNull('image')
            ->published()
            ->orderBy('publish_date', 'desc')
            ->paginate(12);
        
        // จัดกลุ่มตามหมวดหมู่
        $categories = CulturalCategory::whereHas('culturalItems', function($query) {
            $query->whereNotNull('image')
                  ->published();
        })->withCount(['culturalItems' => function($query) {
            $query->whereNotNull('image')
                  ->published();
        }])->get();

        return view('frontend.gallery', compact('items', 'categories'));
    }

    /**
     * Download ไฟล์ (ถ้ามี)
     */
    public function download($id)
    {
        $item = CulturalItem::published()->findOrFail($id);
        
        if (!$item->image || !Storage::exists('public/' . $item->image)) {
            abort(404, 'ไม่พบไฟล์');
        }
        
        return Storage::download('public/' . $item->image, $item->title . '.jpg');
    }

    /**
     * สร้าง Sitemap (SEO)
     */
    public function sitemap()
    {
        $items = CulturalItem::published()
            ->orderBy('updated_at', 'desc')
            ->get();
            
        $categories = CulturalCategory::all();
        $communities = Community::all();
        
        $content = view('frontend.sitemap', compact('items', 'categories', 'communities'));
        
        return response($content)
            ->header('Content-Type', 'text/xml');
    }
}