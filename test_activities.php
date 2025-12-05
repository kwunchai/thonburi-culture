<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Activity;
use App\Models\ActivityCategory;

echo "=== Activity System Test ===\n\n";

// Test 1: Count records
echo "1. Database Records:\n";
echo "   - Total Activities: " . Activity::count() . "\n";
echo "   - Active Activities: " . Activity::active()->count() . "\n";
echo "   - Activity Categories: " . ActivityCategory::count() . "\n";
echo "   - Active Categories: " . ActivityCategory::where('is_active', true)->count() . "\n\n";

// Test 2: Check ordering
echo "2. Ordering Test (scopeOrdered):\n";
$activities = Activity::active()->ordered()->limit(5)->get(['id', 'title', 'created_at']);
foreach ($activities as $activity) {
    echo "   - #{$activity->id}: {$activity->title} (Created: {$activity->created_at->format('Y-m-d H:i')})\n";
}
echo "\n";

// Test 3: Check relationships
echo "3. Relationship Test:\n";
$activity = Activity::with(['category', 'creator'])->first();
if ($activity) {
    echo "   - Activity: {$activity->title}\n";
    echo "   - Category: " . ($activity->category ? $activity->category->name : 'N/A') . "\n";
    echo "   - Creator: " . ($activity->creator ? $activity->creator->name : 'N/A') . "\n";
    echo "   - Images: " . (is_array($activity->images) ? count($activity->images) : 0) . " images\n";
} else {
    echo "   - No activities found!\n";
}
echo "\n";

// Test 4: Related activities logic
echo "4. Related Activities Test:\n";
if ($activity && $activity->category_id) {
    $relatedActivities = Activity::active()
        ->where('id', '!=', $activity->id)
        ->where('category_id', $activity->category_id)
        ->ordered()
        ->limit(8)
        ->get(['id', 'title', 'category_id']);
    
    echo "   - Main Activity: {$activity->title} (Category: {$activity->category->name})\n";
    echo "   - Related Activities Found: " . $relatedActivities->count() . "\n";
    
    foreach ($relatedActivities as $related) {
        echo "     * {$related->title}\n";
    }
} else {
    echo "   - Cannot test related activities (no activity with category found)\n";
}
echo "\n";

// Test 5: Categories with activities count
echo "5. Categories Statistics:\n";
$categories = ActivityCategory::withCount('activities')->get();
foreach ($categories as $category) {
    echo "   - {$category->name}: {$category->activities_count} activities\n";
}
echo "\n";

// Test 6: Upcoming vs Past activities
echo "6. Activity Timeline:\n";
$upcoming = Activity::active()->where('activity_date', '>=', now())->count();
$past = Activity::active()->where('activity_date', '<', now())->count();
echo "   - Upcoming Activities: {$upcoming}\n";
echo "   - Past Activities: {$past}\n";
echo "\n";

echo "=== Test Complete ===\n";
