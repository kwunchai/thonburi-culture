<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CulturalItem;
use App\Models\CulturalCategory;
use App\Models\Community;
use App\Models\User;

class QuickCulturalSeeder extends Seeder
{
    public function run()
    {
        // สร้างหมวดหมู่ถ้ายังไม่มี
        $categories = [
            'ประเพณีท้องถิ่น',
            'อาหารพื้นบ้าน', 
            'ศิลปะการแสดง',
            'หัตถกรรม',
            'ภูมิปัญญาท้องถิ่น'
        ];

        foreach ($categories as $catName) {
            CulturalCategory::firstOrCreate([
                'name' => $catName
            ], [
                'name' => $catName,
                'description' => "หมวดหมู่ {$catName}",
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // สร้างชุมชนถ้ายังไม่มี
        $communities = [
            'วัดระฆัง',
            'วัดอรุณราชวราราม',
            'ตลาดพลู',
            'วัดปากน้ำ',
            'บางลำภูพลอย'
        ];

        foreach ($communities as $comName) {
            Community::firstOrCreate([
                'name' => $comName
            ], [
                'name' => $comName,
                'district' => 'เขตธนบุรี',
                'province' => 'กรุงเทพมหานคร',
                'description' => "ชุมชน {$comName}",
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // หาผู้ใช้ admin
        $admin = User::where('email', 'admin@thonburi.com')->first();
        if (!$admin) {
            echo "ไม่พบผู้ใช้ admin กำลังสร้าง...\n";
            $admin = User::create([
                'name' => 'Administrator',
                'email' => 'admin@thonburi.com',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'email_verified_at' => now()
            ]);
        }

        // สร้างข้อมูลวัฒนธรรม 5 รายการทดสอบ
        $culturalData = [
            [
                'title' => 'งานไหว้พระจันทร์ วัดอรุณราชวราราม',
                'content' => 'ประเพณีไหว้พระจันทร์ที่จัดขึ้นในวันขึ้น 15 ค่ำ เดือน 12 ของทุกปี เป็นประเพณีที่สืบทอดกันมาอย่างยาวนาน',
                'category' => 'ประเพณีท้องถิ่น',
                'community' => 'วัดอรุณราชวราราม',
                'location' => 'วัดอรุณราชวราราม เขตธนบุรี'
            ],
            [
                'title' => 'ขนมครกธนบุรี',
                'content' => 'ขนมพื้นบ้านดั้งเดิมของชาวธนบุรี ทำจากแป้งข้าวเจ้า น้ำตาลโตนด และกะทิ มีรสหวานหอม',
                'category' => 'อาหารพื้นบ้าน',
                'community' => 'ตลาดพลู',
                'location' => 'ตลาดพลู เขตธนบุรี'
            ],
            [
                'title' => 'การแสดงหุ่นกระบอกน้ำ',
                'content' => 'ศิลปะการแสดงท้องถิ่นที่เล่าเรื่องราวผ่านหุ่นที่เคลื่อนไหวบนผิวน้ำ',
                'category' => 'ศิลปะการแสดง',
                'community' => 'วัดระฆัง',
                'location' => 'วัดระฆัง เขตธนบุรี'
            ],
            [
                'title' => 'การทอผ้าไหมยกดอก',
                'content' => 'หัตถกรรมการทอผ้าแบบดั้งเดิม ใช้เทคนิคการยกดอกที่ซับซ้อน',
                'category' => 'หัตถกรรม',
                'community' => 'บางลำภูพลอย',
                'location' => 'บางลำภูพลอย เขตธนบุรี'
            ],
            [
                'title' => 'การใช้สมุนไพรรักษาโรค',
                'content' => 'ภูมิปัญญาการใช้สมุนไพรท้องถิ่นในการรักษาโรคที่ถ่ายทอดกันมารุ่นสู่รุ่น',
                'category' => 'ภูมิปัญญาท้องถิ่น',
                'community' => 'วัดปากน้ำ',
                'location' => 'วัดปากน้ำ เขตธนบุรี'
            ]
        ];

        foreach ($culturalData as $data) {
            $category = CulturalCategory::where('name', $data['category'])->first();
            $community = Community::where('name', $data['community'])->first();

            CulturalItem::create([
                'title' => $data['title'],
                'content' => $data['content'],
                'category_id' => $category ? $category->id : null,
                'community_id' => $community ? $community->id : null,
                'location' => $data['location'],
                'tags' => 'ธนบุรี,วัฒนธรรม,ประเพณี',
                'is_published' => true,
                'is_featured' => false,
                'created_by' => $admin->id,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        echo "✅ สร้างข้อมูลวัฒนธรรมเรียบร้อยแล้ว!\n";
        echo "📊 รวม " . CulturalItem::count() . " รายการ\n";
    }
}