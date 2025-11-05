<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== ทดสอบหน้า Cultural Item Show ===\n\n";

// หาข้อมูลวัฒนธรรมตัวอย่าง
$item = \App\Models\CulturalItem::with(['category', 'community', 'creator'])->first();

if (!$item) {
    echo "❌ ไม่พบข้อมูลวัฒนธรรม\n";
    exit;
}

echo "✅ พบข้อมูลวัฒนธรรม: {$item->title}\n";
echo "📂 หมวด: {$item->category->name}\n";
echo "🏘️ ชุมชน: {$item->community->name}\n";
echo "📅 วันที่เผยแพร่: {$item->publish_date->format('d/m/Y')}\n";
echo "📄 คำอธิบาย: " . \Illuminate\Support\Str::limit($item->description, 100) . "\n\n";

// ทดสอบ Route
echo "=== ทดสอบ Route ===\n";
try {
    $showRoute = route('cultural-item.show', $item->id);
    echo "✅ Route ถูกต้อง: {$showRoute}\n";
} catch (\Exception $e) {
    echo "❌ Route ผิดพลาด: {$e->getMessage()}\n";
}

// ทดสอบ Related Items
echo "\n=== ทดสอบ Related Items ===\n";
$relatedItems = \App\Models\CulturalItem::where('category_id', $item->category_id)
    ->where('id', '!=', $item->id)
    ->limit(5)
    ->get();

echo "🔗 พบข้อมูลที่เกี่ยวข้อง: {$relatedItems->count()} รายการ\n";
foreach ($relatedItems as $related) {
    echo "   • {$related->title}\n";
}

// ทดสอบ Navigation
echo "\n=== ทดสอบ Navigation ===\n";
$previousItem = \App\Models\CulturalItem::where('id', '<', $item->id)->orderBy('id', 'desc')->first();
$nextItem = \App\Models\CulturalItem::where('id', '>', $item->id)->orderBy('id', 'asc')->first();

echo "⬅️ ก่อนหน้า: " . ($previousItem ? $previousItem->title : 'ไม่มี') . "\n";
echo "➡️ ถัดไป: " . ($nextItem ? $nextItem->title : 'ไม่มี') . "\n";

// ทดสอบ Google Maps
echo "\n=== ทดสอบ Google Maps ===\n";
if ($item->latitude && $item->longitude) {
    echo "✅ มีพิกัด: {$item->latitude}, {$item->longitude}\n";
    echo "🗺️ Google Maps URL: https://www.google.com/maps?q={$item->latitude},{$item->longitude}\n";
} else {
    echo "❌ ไม่มีพิกัด\n";
}

echo "\n=== ทดสอบเสร็จสิ้น ===\n";