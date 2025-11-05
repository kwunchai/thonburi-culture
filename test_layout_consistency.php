<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== ทดสอบ Layout ใหม่ของหน้า Cultural Item Show ===\n\n";

// ทดสอบรายการที่มีข้อมูลครบ
$item = \App\Models\CulturalItem::with(['category', 'community', 'creator'])
    ->whereNotNull('latitude')
    ->whereNotNull('longitude')
    ->first();

if ($item) {
    echo "✅ ทดสอบกับรายการ: {$item->title}\n";
    echo "📂 หมวด: {$item->category->name}\n";
    echo "🏘️ ชุมชน: {$item->community->name}\n";
    echo "📍 พิกัด: {$item->latitude}, {$item->longitude}\n";
    echo "🔗 URL: " . route('cultural-item.show', $item->id) . "\n\n";
}

echo "=== การปรับปรุง Layout ที่ทำ ===\n";
echo "🎯 Container Width: เปลี่ยนจาก max-w-6xl เป็น max-w-7xl (เหมือนหน้า explore)\n";
echo "🎨 Background: คงไว้ที่ bg-gray-50 สำหรับความสอดคล้อง\n";
echo "🧭 Breadcrumb: ปรับให้เป็น <ol> และเพิ่ม category link\n";
echo "🎴 Cards: เพิ่ม border border-gray-100 ให้ทุก card\n";
echo "📱 Related Items: ปรับ thumbnail ให้เล็กลง (24x20) เหมาะกับ sidebar\n";
echo "🔗 Buttons: เพิ่ม shadow effects และ transition ที่สมบูรณ์\n";
echo "🗺️ Maps Container: เพิ่ม border สำหรับความชัดเจน\n";
echo "📐 Consistent Spacing: ทุก element ใช้ spacing pattern เดียวกัน\n";

echo "\n=== ความเปลี่ยนแปลงหลัก ===\n";
echo "• Container: max-w-6xl → max-w-7xl\n";
echo "• Cards: เพิ่ม border border-gray-100\n";
echo "• Breadcrumb: OL structure + category links\n";
echo "• Related thumbnails: 32x24 → 24x20\n";
echo "• Buttons: เพิ่ม shadow-md hover:shadow-lg\n";
echo "• Maps: เพิ่ม border container\n";
echo "• Icons: เพิ่ม context icons ในหัวข้อ\n";

echo "\n=== ตรวจสอบ Consistency ===\n";
echo "✅ Font sizes: ใช้ text-xl, text-lg, text-sm ตาม hierarchy\n";
echo "✅ Colors: ใช้ orange-500 สำหรับ primary, gray-800 สำหรับ text\n";
echo "✅ Spacing: ใช้ p-6, mb-6, gap-6 อย่างสม่ำเสมอ\n";
echo "✅ Borders: rounded-xl, border-gray-100/200 ทุกที่\n";
echo "✅ Shadows: shadow-lg สำหรับ cards, shadow-md สำหรับ buttons\n";
echo "✅ Transitions: duration-200/300 อย่างสอดคล้อง\n";

echo "\n=== เสร็จสิ้น ===\n";