<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Database\Seeders\CulturalItemSeeder;

echo "=== เริ่มต้นการเพิ่มข้อมูลวัฒนธรรม 20 ตัวอย่าง ===\n\n";

try {
    // รัน seeder
    $seeder = new CulturalItemSeeder();
    $seeder->run();
    
    echo "\n=== สถิติข้อมูลหลังการเพิ่ม ===\n";
    
    // แสดงสถิติ
    $stats = [
        'cultural_items' => \App\Models\CulturalItem::count(),
        'categories' => \App\Models\CulturalCategory::count(),
        'communities' => \App\Models\Community::count(),
        'featured_items' => \App\Models\CulturalItem::where('is_featured', true)->count(),
        'published_items' => \App\Models\CulturalItem::where('is_published', true)->count(), // แก้ไขจาก 'status' เป็น 'is_published'
    ];
    
    echo "📋 ข้อมูลวัฒนธรรมทั้งหมด: {$stats['cultural_items']} รายการ\n";
    echo "📂 หมวดหมู่: {$stats['categories']} หมวด\n";
    echo "🏘️ ชุมชน: {$stats['communities']} ชุมชน\n";
    echo "⭐ รายการเด่น: {$stats['featured_items']} รายการ\n";
    echo "📰 รายการที่เผยแพร่: {$stats['published_items']} รายการ\n";
    
    echo "\n=== ตัวอย่างข้อมูลที่สร้าง ===\n";
    
    // แสดงข้อมูลตัวอย่าง 5 รายการ
    $samples = \App\Models\CulturalItem::with(['category', 'community'])
        ->latest()
        ->take(5)
        ->get();
    
    foreach ($samples as $item) {
        echo "\n" . str_repeat('-', 60) . "\n";
        echo "🎯 ชื่อ: {$item->title}\n";
        echo "📂 หมวดหมู่: " . ($item->category ? $item->category->name : 'ไม่ระบุ') . "\n";
        echo "🏘️ ชุมชน: " . ($item->community ? $item->community->name : 'ไม่ระบุ') . "\n";
        echo "📍 สถานที่: {$item->location}\n";
        echo "🏷️ แท็ก: {$item->tags}\n";
        echo "👁️ จำนวนผู้ดู: {$item->view_count} ครั้ง\n";
        echo "⭐ รายการเด่น: " . ($item->is_featured ? 'ใช่' : 'ไม่') . "\n";
        echo "📅 วันที่เผยแพร่: " . $item->publish_date->format('d/m/Y') . "\n";
    }
    
    echo "\n" . str_repeat('=', 60) . "\n";
    echo "✅ การทดสอบเสร็จสมบูรณ์!\n";
    echo "🌐 สามารถดูข้อมูลได้ที่: http://thonburi-culture.test/admin/cultural-items\n";
    echo "🏠 หน้าแรก: http://thonburi-culture.test\n";
    
} catch (Exception $e) {
    echo "❌ เกิดข้อผิดพลาด: " . $e->getMessage() . "\n";
    echo "📄 ไฟล์: " . $e->getFile() . "\n";
    echo "📍 บรรทัดที่: " . $e->getLine() . "\n";
}

echo "\n=== การทดสอบเสร็จสิ้น ===\n";