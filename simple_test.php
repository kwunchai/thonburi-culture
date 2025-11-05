<?php

// เรียกใช้ Laravel แบบง่าย ๆ
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\CulturalItem;
use App\Models\CulturalCategory;
use App\Models\Community;
use App\Models\User;

echo "ตรวจสอบข้อมูล...\n";

// ตรวจสอบจำนวนข้อมูล
$items = CulturalItem::count();
$cats = CulturalCategory::count();
$coms = Community::count();

echo "ข้อมูลวัฒนธรรม: $items\n";
echo "หมวดหมู่: $cats\n";
echo "ชุมชน: $coms\n";

if ($items == 0) {
    echo "\nสร้างข้อมูลทดสอบ...\n";
    
    // สร้างหมวดหมู่
    $cat1 = CulturalCategory::create(['name' => 'ประเพณีท้องถิ่น', 'description' => 'ประเพณี']);
    $cat2 = CulturalCategory::create(['name' => 'อาหารพื้นบ้าน', 'description' => 'อาหาร']);
    
    // สร้างชุมชน
    $com1 = Community::create(['name' => 'วัดอรุณ', 'district' => 'ธนบุรี', 'province' => 'กทม', 'description' => 'วัดอรุณ']);
    $com2 = Community::create(['name' => 'ตลาดพลู', 'district' => 'ธนบุรี', 'province' => 'กทม', 'description' => 'ตลาดพลู']);
    
    // หาผู้ใช้ admin
    $admin = User::where('email', 'admin@thonburi.com')->first();
    if (!$admin) {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@thonburi.com', 
            'password' => bcrypt('password'),
            'role' => 'admin',
            'email_verified_at' => now()
        ]);
        echo "สร้าง admin\n";
    }
    
    // สร้างข้อมูลวัฒนธรรม
    CulturalItem::create([
        'title' => 'งานไหว้พระจันทร์',
        'content' => 'ประเพณีไหว้พระจันทร์ที่วัดอรุณ',
        'category_id' => $cat1->id,
        'community_id' => $com1->id,
        'location' => 'วัดอรุณ',
        'tags' => 'ประเพณี',
        'is_published' => true,
        'is_featured' => true,
        'created_by' => $admin->id
    ]);
    
    CulturalItem::create([
        'title' => 'ขนมครก',
        'content' => 'ขนมพื้นบ้านดั้งเดิม',
        'category_id' => $cat2->id,
        'community_id' => $com2->id,
        'location' => 'ตลาดพลู',
        'tags' => 'อาหาร',
        'is_published' => true,
        'is_featured' => false,
        'created_by' => $admin->id
    ]);
    
    CulturalItem::create([
        'title' => 'การแสดงหุ่นกระบอก',
        'content' => 'ศิลปะการแสดงท้องถิ่น',
        'category_id' => $cat1->id,
        'community_id' => $com1->id,
        'location' => 'วัดอรุณ',
        'tags' => 'การแสดง',
        'is_published' => true,
        'is_featured' => true,
        'created_by' => $admin->id
    ]);
    
    echo "สร้างข้อมูลแล้ว 3 รายการ\n";
}

// แสดงข้อมูลที่มี
echo "\nรายการข้อมูลวัฒนธรรม:\n";
$allItems = CulturalItem::with(['category', 'community'])->get();
foreach ($allItems as $item) {
    echo "- {$item->title} (หมวด: " . ($item->category ? $item->category->name : 'ไม่มี') . ")\n";
}

echo "\nเสร็จแล้ว!\n";
echo "เข้าดูได้ที่: http://localhost/thonburi-culture/admin/cultural-items\n";
echo "Login: admin@thonburi.com / password\n";