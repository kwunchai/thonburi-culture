<?php

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\CulturalItem;
use App\Models\User;

echo "=== ทดสอบฟังก์ชัน Google Maps ===\n\n";

try {
    // อัปเดตข้อมูลตัวอย่างด้วยพิกัด
    $testCoordinates = [
        ['lat' => 13.7563, 'lng' => 100.5018], // ธนบุรี
        ['lat' => 13.7407, 'lng' => 100.5135], // วัดอรุณ
        ['lat' => 13.7650, 'lng' => 100.4930], // วัดคลองสาน
    ];
    
    $items = CulturalItem::take(3)->get();
    
    foreach ($items as $index => $item) {
        $coords = $testCoordinates[$index] ?? $testCoordinates[0];
        
        $item->update([
            'latitude' => $coords['lat'],
            'longitude' => $coords['lng']
        ]);
        
        echo "✅ อัปเดตพิกัด: {$item->title}\n";
        echo "   📍 ละติจูด: {$coords['lat']}, ลองจิจูด: {$coords['lng']}\n\n";
    }
    
    echo "=== สรุป ===\n";
    echo "📊 ข้อมูลที่มีพิกัด: " . CulturalItem::whereNotNull('latitude')->whereNotNull('longitude')->count() . " รายการ\n";
    echo "📊 ข้อมูลทั้งหมด: " . CulturalItem::count() . " รายการ\n\n";
    
    echo "=== ลิงก์ทดสอบ ===\n";
    echo "🔗 หน้าเพิ่มข้อมูลใหม่ (ฟอร์มแผนที่):\n";
    echo "   http://localhost/thonburi-culture/admin/cultural-items/create\n\n";
    
    $testItem = CulturalItem::whereNotNull('latitude')->first();
    if ($testItem) {
        echo "🔗 หน้าดูข้อมูล (แสดงแผนที่):\n";
        echo "   http://localhost/thonburi-culture/cultural-item/{$testItem->id}\n\n";
        
        echo "🔗 หน้าแก้ไขข้อมูล (ฟอร์มแผนที่):\n";
        echo "   http://localhost/thonburi-culture/admin/cultural-items/{$testItem->id}/edit\n\n";
    }
    
    echo "⚠️ **สำคัญ**: อย่าลืมเพิ่ม GOOGLE_MAPS_API_KEY ในไฟล์ .env\n";
    echo "📋 ตัวอย่าง: GOOGLE_MAPS_API_KEY=your_api_key_here\n\n";
    
} catch (Exception $e) {
    echo "❌ เกิดข้อผิดพลาด: " . $e->getMessage() . "\n";
}