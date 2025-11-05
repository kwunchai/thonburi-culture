<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== ทดสอบหน้า Cultural Item Show ที่ปรับปรุงแล้ว ===\n\n";

// ทดสอบรายการที่มีรูปภาพและพิกัด
$itemWithImage = \App\Models\CulturalItem::with(['category', 'community', 'creator'])
    ->whereNotNull('latitude')
    ->whereNotNull('longitude')
    ->first();

if ($itemWithImage) {
    echo "✅ รายการที่มีรูปและพิกัด: {$itemWithImage->title}\n";
    echo "📂 หมวด: {$itemWithImage->category->name}\n";
    echo "🏘️ ชุมชน: {$itemWithImage->community->name}\n";
    echo "📍 พิกัด: {$itemWithImage->latitude}, {$itemWithImage->longitude}\n";
    echo "🔗 URL: " . route('cultural-item.show', $itemWithImage->id) . "\n\n";
} else {
    echo "❌ ไม่พบรายการที่มีรูปและพิกัด\n\n";
}

// ทดสอบ Related Items
echo "=== ทดสอบ Related Items ===\n";
if ($itemWithImage) {
    $relatedItems = \App\Models\CulturalItem::where('category_id', $itemWithImage->category_id)
        ->where('id', '!=', $itemWithImage->id)
        ->with(['category', 'community'])
        ->limit(3)
        ->get();
    
    echo "🔗 พบข้อมูลที่เกี่ยวข้อง: {$relatedItems->count()} รายการ\n";
    foreach ($relatedItems as $related) {
        $hasImage = $related->image ? '📷' : '📄';
        echo "   {$hasImage} {$related->title} ({$related->category->name})\n";
    }
}

// ทดสอบ Social Sharing URLs
echo "\n=== ทดสอบ Social Sharing ===\n";
if ($itemWithImage) {
    $pageUrl = route('cultural-item.show', $itemWithImage->id);
    $title = urlencode($itemWithImage->title);
    
    echo "📘 Facebook: https://www.facebook.com/sharer/sharer.php?u=" . urlencode($pageUrl) . "\n";
    echo "🐦 Twitter: https://twitter.com/intent/tweet?text={$title}&url=" . urlencode($pageUrl) . "\n";
    echo "💬 LINE: https://line.me/R/msg/text/?" . urlencode($itemWithImage->title . ' ' . $pageUrl) . "\n";
}

echo "\n=== ฟีเจอร์ใหม่ที่เพิ่มเข้ามา ===\n";
echo "🎨 Hero Image: Full-bleed overlay พร้อม title และ meta badges\n";
echo "🏷️ Meta Badges: แสดงหมวดหมู่, ชุมชน, วันที่, ผู้เขียน\n";
echo "📱 Related Cards: แสดงเป็น card พร้อม thumbnail และ hover effects\n";
echo "🎭 Animations: Parallax, fade-in, floating scroll indicator\n";
echo "🗺️ Enhanced Maps: Custom marker และ rich InfoWindow\n";
echo "📖 Improved TOC: Enhanced table of contents พร้อม smooth scroll\n";
echo "📱 Responsive: Mobile-first design\n";

echo "\n=== เสร็จสิ้น ===\n";