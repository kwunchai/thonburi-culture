<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== ทดสอบการทำงานของ Explore Page ===\n\n";

// Simulate Controller logic
$search = '';
$category_id = '';
$community_id = '';
$sort = 'latest';
$per_page = 12;

// Query builder สำหรับ cultural items
$query = \App\Models\CulturalItem::with(['category', 'community', 'creator'])
    ->published();

echo "1. Base query count: " . $query->count() . "\n";

// Pagination
$items = $query->paginate($per_page);
echo "2. Paginated items count: " . $items->count() . "\n";
echo "3. Total items: " . $items->total() . "\n";

// ข้อมูลสำหรับ filters
$categories = \App\Models\CulturalCategory::withCount(['culturalItems' => function($query) {
    $query->published();
}])->orderBy('name')->get();

echo "4. Categories count: " . $categories->count() . "\n";

$communities = \App\Models\Community::withCount(['culturalItems' => function($query) {
    $query->published();
}])->orderBy('name')->get();

echo "5. Communities count: " . $communities->count() . "\n";

// สถิติการค้นหา
$stats = [
    'total_found' => $items->total(),
    'total_items' => \App\Models\CulturalItem::published()->count(),
    'total_categories' => $categories->count(),
    'total_communities' => $communities->count()
];

echo "6. Stats:\n";
foreach($stats as $key => $value) {
    echo "   - {$key}: {$value}\n";
}

// รายการที่นิยม (สำหรับ sidebar)
$popularItems = \App\Models\CulturalItem::published()
    ->inRandomOrder()
    ->take(5)
    ->get();

echo "7. Popular items count: " . $popularItems->count() . "\n";

// รายการล่าสุด (สำหรับ sidebar)
$latestItems = \App\Models\CulturalItem::published()
    ->orderBy('publish_date', 'desc')
    ->take(5)
    ->get();

echo "8. Latest items count: " . $latestItems->count() . "\n";

echo "\n=== รายการที่ได้จาก query ===\n";
foreach($items as $index => $item) {
    echo ($index + 1) . ". {$item->title}\n";
    echo "   - Category: " . ($item->category ? $item->category->name : 'NULL') . "\n";
    echo "   - Community: " . ($item->community ? $item->community->name : 'NULL') . "\n";
    echo "   - Image: " . ($item->image ? 'YES' : 'NO') . "\n";
    echo "   - Featured: " . ($item->is_featured ? 'YES' : 'NO') . "\n\n";
}

echo "\n=== Categories ที่มีจำนวน ===\n";
foreach($categories as $category) {
    echo "- {$category->name}: {$category->cultural_items_count} รายการ\n";
}

echo "\n=== Communities ที่มีจำนวน ===\n";
foreach($communities as $community) {
    echo "- {$community->name}: {$community->cultural_items_count} รายการ\n";
}