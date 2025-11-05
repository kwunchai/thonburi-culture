<?php

// เชื่อมต่อฐานข้อมูลโดยตรง
require_once 'vendor/autoload.php';

// Bootstrap Laravel app
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== ตรวจสอบข้อมูลวัฒนธรรม ===\n\n";

try {
    // ตรวจสอบจำนวนข้อมูล
    $cultural_count = \App\Models\CulturalItem::count();
    $category_count = \App\Models\CulturalCategory::count();
    $community_count = \App\Models\Community::count();
    
    echo "📊 สถิติปัจจุบัน:\n";
    echo "- ข้อมูลวัฒนธรรม: {$cultural_count} รายการ\n";
    echo "- หมวดหมู่: {$category_count} หมวด\n";
    echo "- ชุมชน: {$community_count} ชุมชน\n\n";
    
    if ($cultural_count < 5) {
        echo "🔄 สร้างข้อมูลทดสอบ...\n\n";
        
        // สร้างหมวดหมู่
        $categories = [
            'ประเพณีท้องถิ่น' => 'ประเพณีและพิธีกรรมของชุมชน',
            'อาหารพื้นบ้าน' => 'อาหารและขนมดั้งเดิม',
            'ศิลปะการแสดง' => 'การแสดงและดนตรีพื้นบ้าน',
            'หัตถกรรม' => 'งานฝีมือและหัตถกรรมท้องถิ่น',
            'ภูมิปัญญาท้องถิ่น' => 'ความรู้และภูมิปัญญาดั้งเดิม'
        ];
        
        foreach ($categories as $name => $desc) {
            $cat = \App\Models\CulturalCategory::firstOrCreate(
                ['name' => $name],
                ['description' => $desc]
            );
            echo "✓ หมวดหมู่: {$name}\n";
        }
        
        // สร้างชุมชน
        $communities = [
            'วัดระฆัง' => 'ชุมชนวัดระฆัง',
            'วัดอรุณราชวราราม' => 'ชุมชนวัดอรุณ',
            'ตลาดพลู' => 'ชุมชนตลาดพลู',
            'วัดปากน้ำ' => 'ชุมชนวัดปากน้ำ',
            'บางลำภูพลอย' => 'ชุมชนบางลำภูพลอย'
        ];
        
        foreach ($communities as $name => $desc) {
            $com = \App\Models\Community::firstOrCreate(
                ['name' => $name],
                [
                    'district' => 'เขตธนบุรี',
                    'province' => 'กรุงเทพมหานคร',
                    'description' => $desc
                ]
            );
            echo "✓ ชุมชน: {$name}\n";
        }
        
        // หาผู้ใช้ admin
        $admin = \App\Models\User::where('email', 'admin@thonburi.com')->first();
        if (!$admin) {
            $admin = \App\Models\User::create([
                'name' => 'Administrator',
                'email' => 'admin@thonburi.com',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'email_verified_at' => now()
            ]);
            echo "✓ สร้างผู้ใช้ admin\n";
        }
        
        // สร้างข้อมูลวัฒนธรรม
        $culturalData = [
            [
                'title' => 'งานไหว้พระจันทร์ วัดอรุณราชวราราม',
                'content' => 'ประเพณีไหว้พระจันทร์ที่จัดขึ้นในวันขึ้น 15 ค่ำ เดือน 12 ของทุกปี เป็นประเพณีที่สืบทอดกันมาอย่างยาวนาน ชาวบ้านจะมาร่วมงานกันอย่างพร้อมเพรียง',
                'category' => 'ประเพณีท้องถิ่น',
                'community' => 'วัดอรุณราชวราราม',
                'location' => 'วัดอรุณราชวราราม เขตธนบุรี'
            ],
            [
                'title' => 'ขนมครกธนบุรี',
                'content' => 'ขนมพื้นบ้านดั้งเดิมของชาวธนบุรี ทำจากแป้งข้าวเจ้า น้ำตาลโตนด และกะทิ มีรสหวานหอม เป็นขนมที่ขาดไม่ได้ในงานบุญและงานมงคล',
                'category' => 'อาหารพื้นบ้าน',
                'community' => 'ตลาดพลู',
                'location' => 'ตลาดพลู เขตธนบุรี'
            ],
            [
                'title' => 'การแสดงหุ่นกระบอกน้ำ',
                'content' => 'ศิลปะการแสดงท้องถิ่นที่เล่าเรื่องราวผ่านหุ่นที่เคลื่อนไหวบนผิวน้ำ เป็นการแสดงที่ต้องใช้ความชำนาญและความอดทน',
                'category' => 'ศิลปะการแสดง',
                'community' => 'วัดระฆัง',
                'location' => 'วัดระฆัง เขตธนบุรี'
            ],
            [
                'title' => 'การทอผ้าไหมยกดอก',
                'content' => 'หัตถกรรมการทอผ้าแบบดั้งเดิม ใช้เทคนิคการยกดอกที่ซับซ้อน ต้องใช้เวลานานในการผลิต ผ้าที่ได้จะมีลวดลายสวยงาม',
                'category' => 'หัตถกรรม',
                'community' => 'บางลำภูพลอย',
                'location' => 'บางลำภูพลอย เขตธนบุรี'
            ],
            [
                'title' => 'การใช้สมุนไพรรักษาโรค',
                'content' => 'ภูมิปัญญาการใช้สมุนไพรท้องถิ่นในการรักษาโรคที่ถ่ายทอดกันมารุ่นสู่รุ่น เป็นความรู้ที่มีคุณค่าและควรอนุรักษ์ไว้',
                'category' => 'ภูมิปัญญาท้องถิ่น',
                'community' => 'วัดปากน้ำ',
                'location' => 'วัดปากน้ำ เขตธนบุรี'
            ]
        ];
        
        foreach ($culturalData as $data) {
            $category = \App\Models\CulturalCategory::where('name', $data['category'])->first();
            $community = \App\Models\Community::where('name', $data['community'])->first();
            
            $item = \App\Models\CulturalItem::create([
                'title' => $data['title'],
                'content' => $data['content'],
                'category_id' => $category ? $category->id : null,
                'community_id' => $community ? $community->id : null,
                'location' => $data['location'],
                'tags' => 'ธนบุรี,วัฒนธรรม,ประเพณี',
                'is_published' => true,
                'is_featured' => rand(0, 1) == 1,
                'created_by' => $admin->id,
            ]);
            echo "✓ สร้าง: {$data['title']}\n";
        }
        
        echo "\n✅ สร้างข้อมูลเรียบร้อยแล้ว!\n";
    }
    
    // แสดงสถิติล่าสุด
    echo "\n=== สถิติล่าสุด ===\n";
    echo "📊 ข้อมูลวัฒนธรรม: " . \App\Models\CulturalItem::count() . " รายการ\n";
    echo "📂 หมวดหมู่: " . \App\Models\CulturalCategory::count() . " หมวด\n";
    echo "🏘️ ชุมชน: " . \App\Models\Community::count() . " ชุมชน\n";
    echo "⭐ รายการเด่น: " . \App\Models\CulturalItem::where('is_featured', true)->count() . " รายการ\n";
    
    // แสดงข้อมูลตัวอย่าง
    echo "\n=== ข้อมูลตัวอย่าง ===\n";
    $items = \App\Models\CulturalItem::with(['category', 'community'])
        ->latest()
        ->take(3)
        ->get();
    
    foreach ($items as $index => $item) {
        echo "\n" . ($index + 1) . ". {$item->title}\n";
        echo "   📂 หมวด: " . ($item->category ? $item->category->name : 'ไม่ระบุ') . "\n";
        echo "   🏘️ ชุมชน: " . ($item->community ? $item->community->name : 'ไม่ระบุ') . "\n";
        echo "   📍 ที่ตั้ง: {$item->location}\n";
        echo "   ⭐ เด่น: " . ($item->is_featured ? 'ใช่' : 'ไม่') . "\n";
    }
    
    echo "\n=== ลิงก์ทดสอบ ===\n";
    echo "🌐 หน้าแรก: http://localhost/thonburi-culture\n";
    echo "👨‍💼 Admin: http://localhost/thonburi-culture/admin/cultural-items\n";
    echo "📧 Login: admin@thonburi.com / password\n";
    
} catch (\Exception $e) {
    echo "❌ เกิดข้อผิดพลาด: " . $e->getMessage() . "\n";
    echo "📄 ไฟล์: " . $e->getFile() . "\n";
    echo "📍 บรรทัด: " . $e->getLine() . "\n";
}

echo "\n=== เสร็จสิ้น ===\n";