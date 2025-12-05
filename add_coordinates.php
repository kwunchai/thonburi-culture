<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== เพิ่มพิกัด Google Maps ===\n\n";

// พิกัดตัวอย่างในเขตธนบุรี
$coordinates = [
    'วัดระฆังโฆสิตาราม' => ['lat' => 13.7563, 'lng' => 100.4918], // วัดระฆัง
    'วัดกัลยาณมิตรวรมหาวิหาร' => ['lat' => 13.7574, 'lng' => 100.4928], // วัดกัลยาณ์
    'วัดอรุณราชวราราม' => ['lat' => 13.7437, 'lng' => 100.4891], // วัดอรุณ
    'ตลาดน้ำคลองสาน' => ['lat' => 13.7218, 'lng' => 100.4743], // คลองสาน
    'ตลาดพลู' => ['lat' => 13.7244, 'lng' => 100.4756], // ตลาดพลู
];

$updated = 0;

foreach ($coordinates as $keyword => $coord) {
    $items = \App\Models\CulturalItem::where('title', 'LIKE', "%{$keyword}%")
        ->orWhere('description', 'LIKE', "%{$keyword}%")
        ->get();

    foreach ($items as $item) {
        $item->update([
            'latitude' => $coord['lat'],
            'longitude' => $coord['lng']
        ]);
        
        echo "✅ อัปเดตพิกัด: {$item->title} ({$coord['lat']}, {$coord['lng']})\n";
        $updated++;
    }
}

echo "\n🎉 อัปเดตพิกัดสำเร็จ {$updated} รายการ\n";

// แสดงรายการที่มีพิกัด
echo "\n=== รายการที่มีพิกัด ===\n";
$itemsWithCoords = \App\Models\CulturalItem::whereNotNull('latitude')
    ->whereNotNull('longitude')
    ->get();

foreach ($itemsWithCoords as $item) {
    echo "📍 {$item->title}: {$item->latitude}, {$item->longitude}\n";
}

echo "\n=== เสร็จสิ้น ===\n";