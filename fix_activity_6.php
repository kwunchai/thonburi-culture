<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Activity;
use App\Models\ActivityCategory;

echo "=== Fix Activity #6 ===\n\n";

$activity6 = Activity::find(6);
if ($activity6) {
    echo "Activity #6 Details:\n";
    echo "  - Title: {$activity6->title}\n";
    echo "  - Category ID: {$activity6->category_id}\n";
    echo "  - Is Active: " . ($activity6->is_active ? 'Yes' : 'No') . "\n";
    
    if (!$activity6->is_active) {
        $activity6->is_active = true;
        $activity6->save();
        echo "\n✓ Activated activity #6\n";
    }
    
    if (!$activity6->category_id) {
        $category = ActivityCategory::where('name', 'การแสดงและศิลปะ')->first();
        if ($category) {
            $activity6->category_id = $category->id;
            $activity6->save();
            echo "✓ Assigned category to activity #6\n";
        }
    }
} else {
    echo "Activity #6 not found\n";
}

echo "\n=== Updated Statistics ===\n";
$categoriesWithCount = ActivityCategory::withCount('activities')->get();
foreach ($categoriesWithCount as $category) {
    echo "  - {$category->name}: {$category->activities_count} activities\n";
}

// Show all activities with their status
echo "\n=== All Activities ===\n";
$allActivities = Activity::with('category')->get();
foreach ($allActivities as $activity) {
    $status = $activity->is_active ? '✓' : '✗';
    $category = $activity->category ? $activity->category->name : 'No Category';
    echo "  {$status} #{$activity->id}: {$activity->title} [{$category}]\n";
}
