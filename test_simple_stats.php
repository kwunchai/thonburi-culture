<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== สถิติข้อมูลวัฒนธรรม ===\n\n";

$stats = [
    'cultural_items' => \App\Models\CulturalItem::count(),
    'categories' => \App\Models\CulturalCategory::count(),
    'communities' => \App\Models\Community::count(),
    'featured_items' => \App\Models\CulturalItem::where('is_featured', true)->count(),
    'published_items' => \App\Models\CulturalItem::where('is_published', true)->count(),
];

echo "📋 ข้อมูลวัฒนธรรมทั้งหมด: {$stats['cultural_items']} รายการ\n";
echo "📂 หมวดหมู่: {$stats['categories']} หมวด\n";
echo "🏘️ ชุมชน: {$stats['communities']} ชุมชน\n";
echo "⭐ รายการเด่น: {$stats['featured_items']} รายการ\n";
echo "📰 รายการที่เผยแพร่: {$stats['published_items']} รายการ\n";

echo "\n=== ตัวอย่างข้อมูลล่าสุด ===\n";

$latestItems = \App\Models\CulturalItem::with(['category', 'community'])
    ->orderBy('created_at', 'desc')
    ->limit(5)
    ->get();

foreach ($latestItems as $item) {
    echo "🎯 {$item->title}\n";
    echo "   📂 หมวด: {$item->category->name}\n";
    echo "   🏘️ ชุมชน: {$item->community->name}\n";
    echo "   📅 วันที่: {$item->publish_date->format('d/m/Y')}\n";
    echo "   ⭐ เด่น: " . ($item->is_featured ? 'ใช่' : 'ไม่') . "\n\n";
}

echo "=== เสร็จสิ้น ===\n";