<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== ข้อมูลในระบบ ===\n";
echo "Cultural Items: " . \App\Models\CulturalItem::count() . "\n";
echo "Published Items: " . \App\Models\CulturalItem::published()->count() . "\n";
echo "Featured Items: " . \App\Models\CulturalItem::where('is_featured', 1)->count() . "\n";
echo "Categories: " . \App\Models\CulturalCategory::count() . "\n";
echo "Communities: " . \App\Models\Community::count() . "\n\n";

echo "=== รายการล่าสุด 5 รายการ ===\n";
$latestItems = \App\Models\CulturalItem::published()->latest()->take(5)->get();
foreach($latestItems as $item) {
    echo "- {$item->title}\n";
}

echo "\n=== หมวดหมู่ที่มีข้อมูล ===\n";
$categories = \App\Models\CulturalCategory::withCount('culturalItems')->get();
foreach($categories as $category) {
    echo "- {$category->name}: {$category->cultural_items_count} รายการ\n";
}

echo "\n=== ชุมชนที่มีข้อมูล ===\n";
$communities = \App\Models\Community::withCount('culturalItems')->get();
foreach($communities as $community) {
    echo "- {$community->name}: {$community->cultural_items_count} รายการ\n";
}