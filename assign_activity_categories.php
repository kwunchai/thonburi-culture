<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Activity;
use App\Models\ActivityCategory;

echo "=== Assign Categories to Activities ===\n\n";

// Get all categories
$categories = ActivityCategory::all();
echo "Available Categories:\n";
foreach ($categories as $index => $category) {
    echo "  [{$category->id}] {$category->name}\n";
}
echo "\n";

// Get all activities without category
$activities = Activity::whereNull('category_id')->get();
echo "Activities without category: {$activities->count()}\n\n";

if ($activities->isEmpty()) {
    echo "All activities already have categories assigned!\n";
    exit;
}

// Auto-assign categories based on keywords in title
$categoryMappings = [
    'เทศกาลและงานประเพณี' => ['เทศกาล', 'ลอยกระทง', 'สงกรานต์', 'ประเพณี'],
    'กิจกรรมทางวัฒนธรรม' => ['วัฒนธรรม', 'ประวัติศาสตร์'],
    'กิจกรรมศึกษาเรียนรู้' => ['อบรม', 'เรียนรู้', 'ศึกษา', 'ค่าย', 'เยาวชน'],
    'การแสดงและศิลปะ' => ['แสดง', 'ศิลป'],
    'กิจกรรมชุมชน' => ['ชุมชน'],
    'ประชุมและสัมมนา' => ['ประชุม', 'สัมมนา'],
    'กิจกรรมพิเศษ' => ['นิทรรศการ', 'พิเศษ'],
];

$categoryCache = [];
foreach ($categories as $cat) {
    $categoryCache[$cat->name] = $cat->id;
}

$updated = 0;

foreach ($activities as $activity) {
    $assigned = false;
    
    // Try to match keywords
    foreach ($categoryMappings as $categoryName => $keywords) {
        foreach ($keywords as $keyword) {
            if (stripos($activity->title, $keyword) !== false) {
                if (isset($categoryCache[$categoryName])) {
                    $activity->category_id = $categoryCache[$categoryName];
                    $activity->save();
                    
                    echo "✓ Assigned '{$categoryName}' to: {$activity->title}\n";
                    $updated++;
                    $assigned = true;
                    break 2;
                }
            }
        }
    }
    
    // If no match found, assign to default category
    if (!$assigned) {
        $defaultCategory = ActivityCategory::first();
        if ($defaultCategory) {
            $activity->category_id = $defaultCategory->id;
            $activity->save();
            
            echo "⚠ Assigned default category '{$defaultCategory->name}' to: {$activity->title}\n";
            $updated++;
        }
    }
}

echo "\n=== Summary ===\n";
echo "Total activities updated: {$updated}\n";

// Show final statistics
echo "\nFinal Statistics:\n";
$categoriesWithCount = ActivityCategory::withCount('activities')->get();
foreach ($categoriesWithCount as $category) {
    echo "  - {$category->name}: {$category->activities_count} activities\n";
}

echo "\n✅ Categories assigned successfully!\n";
