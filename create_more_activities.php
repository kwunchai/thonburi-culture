<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Activity;
use App\Models\ActivityCategory;
use App\Models\User;

echo "=== Create More Activities for Testing ===\n\n";

$admin = User::where('role', 'admin')->first();
if (!$admin) {
    echo "✗ No admin user found!\n";
    exit;
}

$categories = ActivityCategory::all();
if ($categories->isEmpty()) {
    echo "✗ No categories found!\n";
    exit;
}

// Sample activities to create
$newActivities = [
    [
        'title' => 'งานวันลอยกระทงสานสัมพันธ์ชุมชน',
        'description' => 'กิจกรรมลอยกระทงร่วมกันในชุมชนเขตธนบุรี เพื่อสืบสานประเพณีและสร้างความสามัคคี',
        'category' => 'เทศกาลและงานประเพณี',
        'location' => 'วัดอรุณราชวราราม',
        'activity_date' => '2024-11-15',
    ],
    [
        'title' => 'มหกรรมอาหารท้องถิ่นธนบุรี',
        'description' => 'งานแสดงและจำหน่ายอาหารพื้นบ้านธนบุรีที่หาทานได้ยาก',
        'category' => 'เทศกาลและงานประเพณี',
        'location' => 'ตลาดพระราม 2',
        'activity_date' => '2024-12-20',
    ],
    [
        'title' => 'การแสดงรำไทยและดนตรีไทย',
        'description' => 'การแสดงศิลปะการรำไทยและบรรเลงดนตรีไทยโดยคณะศิลปินท้องถิ่น',
        'category' => 'การแสดงและศิลปะ',
        'location' => 'ศูนย์วัฒนธรรมเขตธนบุรี',
        'activity_date' => '2024-11-25',
    ],
    [
        'title' => 'ค่ายอนุรักษ์สิ่งแวดล้อมริมแม่น้ำเจ้าพระยา',
        'description' => 'กิจกรรมอนุรักษ์และฟื้นฟูสภาพแวดล้อมริมแม่น้ำเจ้าพระยาในเขตธนบุรี',
        'category' => 'กิจกรรมชุมชน',
        'location' => 'ริมแม่น้ำเจ้าพระยา ฝั่งธนบุรี',
        'activity_date' => '2024-11-30',
    ],
    [
        'title' => 'อบรมทำขนมไทยโบราณ',
        'description' => 'เรียนรู้วิธีการทำขนมไทยโบราณจากผู้เชี่ยวชาญ',
        'category' => 'กิจกรรมศึกษาเรียนรู้',
        'location' => 'ศาลาอเนกประสงค์วัดประยุรวงศาวาส',
        'activity_date' => '2024-12-10',
    ],
    [
        'title' => 'สัมมนาการอนุรักษ์มรดกทางวัฒนธรรม',
        'description' => 'สัมมนาวิชาการเกี่ยวกับแนวทางการอนุรักษ์และพัฒนามรดกทางวัฒนธรรมในเขตธนบุรี',
        'category' => 'ประชุมและสัมมนา',
        'location' => 'โรงแรมอิบิส ริเวอร์ไซด์',
        'activity_date' => '2024-12-05',
    ],
    [
        'title' => 'นิทรรศการภาพถ่ายธนบุรีในอดีต',
        'description' => 'จัดแสดงภาพถ่ายเก่าและเอกสารทางประวัติศาสตร์ของเขตธนบุรี',
        'category' => 'กิจกรรมพิเศษ',
        'location' => 'พิพิธภัณฑ์ท้องถิ่นธนบุรี',
        'activity_date' => '2024-11-20',
    ],
    [
        'title' => 'กิจกรรมปลูกต้นไม้เพื่อสิ่งแวดล้อม',
        'description' => 'ร่วมปลูกต้นไม้เพื่อเพิ่มพื้นที่สีเขียวในชุมชนเขตธนบุรี',
        'category' => 'กิจกรรมชุมชน',
        'location' => 'สวนสาธารณะสมเด็จพระศรีนครินทร์',
        'activity_date' => '2024-12-15',
    ],
];

$categoryCache = [];
foreach ($categories as $cat) {
    $categoryCache[$cat->name] = $cat->id;
}

$created = 0;

foreach ($newActivities as $activityData) {
    // Check if already exists
    $exists = Activity::where('title', $activityData['title'])->exists();
    if ($exists) {
        echo "⊘ Skip (already exists): {$activityData['title']}\n";
        continue;
    }
    
    $categoryId = $categoryCache[$activityData['category']] ?? null;
    
    $activity = Activity::create([
        'title' => $activityData['title'],
        'description' => $activityData['description'],
        'category_id' => $categoryId,
        'location' => $activityData['location'],
        'activity_date' => $activityData['activity_date'],
        'creator_id' => $admin->id,
        'is_active' => true,
        'is_featured' => false,
    ]);
    
    echo "✓ Created: {$activity->title} [{$activityData['category']}]\n";
    $created++;
}

echo "\n=== Summary ===\n";
echo "Total new activities created: {$created}\n";
echo "Total active activities: " . Activity::active()->count() . "\n";

echo "\n=== Category Distribution ===\n";
$categoriesWithCount = ActivityCategory::withCount('activities')->get();
foreach ($categoriesWithCount as $category) {
    echo "  - {$category->name}: {$category->activities_count} activities\n";
}

echo "\n✅ Activities created successfully!\n";
