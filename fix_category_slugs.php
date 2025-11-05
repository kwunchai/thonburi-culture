<?php

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\CulturalCategory;

echo "=== อัปเดต slug สำหรับ Cultural Categories ===\n\n";

try {
    $categories = CulturalCategory::whereNull('slug')->orWhere('slug', '')->get();
    
    echo "พบ categories ที่ไม่มี slug: " . $categories->count() . " รายการ\n\n";
    
    if ($categories->count() == 0) {
        echo "✅ ทุก categories มี slug แล้ว\n";
        exit;
    }
    
    foreach ($categories as $category) {
        $slug = \Illuminate\Support\Str::slug($category->name);
        
        // หาก slug เป็นค่าว่าง ให้ใช้ชื่อภาษาอังกฤษ
        if (empty($slug)) {
            $englishNames = [
                'ประเพณีท้องถิ่น' => 'local-tradition',
                'อาหารพื้นบ้าน' => 'local-food',
                'ศิลปะพื้นบ้าน' => 'folk-art',
                'หัตถกรรม' => 'handicraft',
                'ภูมิปัญญาท้องถิ่น' => 'local-wisdom',
                'สถาปัตยกรรม' => 'architecture',
                'ดนตรีพื้นบ้าน' => 'folk-music'
            ];
            $slug = $englishNames[$category->name] ?? 'category-' . $category->id;
        }
        
        // ตรวจสอบว่า slug ซ้ำหรือไม่
        $counter = 1;
        $originalSlug = $slug;
        while (CulturalCategory::where('slug', $slug)->where('id', '!=', $category->id)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        
        $category->update(['slug' => $slug]);
        echo "✅ {$category->name} -> {$slug}\n";
    }
    
    echo "\n=== สำเร็จ! อัปเดต slug ครบถ้วนแล้ว ===\n";
    
    // แสดงรายการทั้งหมด
    echo "\n=== รายการ categories ทั้งหมด ===\n";
    $allCategories = CulturalCategory::all();
    foreach ($allCategories as $cat) {
        echo "- {$cat->name} ({$cat->slug})\n";
    }
    
} catch (Exception $e) {
    echo "❌ เกิดข้อผิดพลาด: " . $e->getMessage() . "\n";
    echo "📄 ไฟล์: " . $e->getFile() . "\n";
    echo "📍 บรรทัด: " . $e->getLine() . "\n";
}

echo "\n=== เสร็จสิ้น ===\n";