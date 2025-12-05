<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\CulturalItem;
use App\Models\CulturalCategory;
use App\Models\Community;

echo "=== ตรวจสอบข้อมูลวัฒนธรรมในระบบ ===\n\n";

try {
    // ตรวจสอบจำนวนข้อมูล
    $cultural_count = CulturalItem::count();
    $category_count = CulturalCategory::count();
    $community_count = Community::count();
    
    echo "📊 สถิติปัจจุบัน:\n";
    echo "- ข้อมูลวัฒนธรรม: {$cultural_count} รายการ\n";
    echo "- หมวดหมู่: {$category_count} หมวด\n";
    echo "- ชุมชน: {$community_count} ชุมชน\n\n";
    
    if ($cultural_count == 0) {
        echo "🔄 ไม่มีข้อมูลวัฒนธรรม กำลังเพิ่มข้อมูลตัวอย่าง...\n\n";
        
        // รัน seeder
        $seeder = new \Database\Seeders\CulturalItemSeeder();
        $seeder->run();
        
        // ตรวจสอบอีกครั้ง
        $new_count = CulturalItem::count();
        echo "\n✅ เพิ่มข้อมูลสำเร็จ! ตอนนี้มี {$new_count} รายการ\n";
    } else {
        echo "✅ มีข้อมูลอยู่แล้ว!\n";
    }
    
    // แสดงข้อมูลตัวอย่าง
    echo "\n=== ข้อมูลตัวอย่าง 5 รายการล่าสุด ===\n";
    $items = CulturalItem::with(['category', 'community'])
        ->latest()
        ->take(5)
        ->get();
    
    foreach ($items as $index => $item) {
        echo "\n" . ($index + 1) . ". {$item->title}\n";
        echo "   📂 หมวด: " . ($item->category ? $item->category->name : 'ไม่ระบุ') . "\n";
        echo "   🏘️ ชุมชน: " . ($item->community ? $item->community->name : 'ไม่ระบุ') . "\n";
        echo "   📍 ที่ตั้ง: {$item->location}\n";
    }
    
    echo "\n=== ลิงก์ทดสอบ ===\n";
    echo "🌐 หน้าแรก: http://localhost/thonburi-culture\n";
    echo "👨‍💼 Admin: http://localhost/thonburi-culture/admin/cultural-items\n";
    echo "📧 Login: admin@thonburi.com / password\n";
    
} catch (Exception $e) {
    echo "❌ เกิดข้อผิดพลาด: " . $e->getMessage() . "\n";
    echo "ไฟล์: " . $e->getFile() . " บรรทัด: " . $e->getLine() . "\n";
}

echo "\n=== เสร็จสิ้น ===\n";