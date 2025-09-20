<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\CulturalCategory;
use App\Models\Community;
use App\Models\CulturalItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // สร้าง Admin
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@thonburi.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // สร้าง Editor
        $editor = User::create([
            'name' => 'Editor',
            'email' => 'editor@thonburi.com',
            'password' => Hash::make('password'),
            'role' => 'editor',
        ]);

        // สร้างหมวดหมู่
        $categories = [
            ['name' => 'ประวัติศาสตร์', 'slug' => 'history', 'icon' => 'fa-landmark', 'description' => 'ประวัติศาสตร์และเรื่องราวของเขตธนบุรี'],
            ['name' => 'ศิลปะพื้นบ้าน', 'slug' => 'folk-art', 'icon' => 'fa-palette', 'description' => 'งานศิลปะและหัตถกรรมพื้นบ้าน'],
            ['name' => 'อาหารท้องถิ่น', 'slug' => 'local-food', 'icon' => 'fa-utensils', 'description' => 'อาหารพื้นบ้านและขนมไทย'],
            ['name' => 'เทศกาลและประเพณี', 'slug' => 'festival', 'icon' => 'fa-calendar-star', 'description' => 'เทศกาลและประเพณีสำคัญ'],
            ['name' => 'วัดและศาสนสถาน', 'slug' => 'temple', 'icon' => 'fa-dharmachakra', 'description' => 'วัดและสถานที่ทางศาสนา'],
            ['name' => 'วิถีชีวิตริมน้ำ', 'slug' => 'waterside-life', 'icon' => 'fa-water', 'description' => 'วิถีชีวิตของชุมชนริมน้ำเจ้าพระยา'],
        ];

        foreach ($categories as $category) {
            CulturalCategory::create($category);
        }

        // สร้างชุมชน
        $communities = [
            ['name' => 'ชุมชนกุฎีจีน', 'description' => 'ชุมชนเก่าแก่ริมน้ำเจ้าพระยา', 'latitude' => 13.7203, 'longitude' => 100.4762],
            ['name' => 'ชุมชนวัดกัลยาณ์', 'description' => 'ชุมชนรอบวัดกัลยาณมิตร', 'latitude' => 13.7407, 'longitude' => 100.4892],
            ['name' => 'ชุมชนวัดอรุณ', 'description' => 'ชุมชนรอบวัดอรุณราชวราราม', 'latitude' => 13.7437, 'longitude' => 100.4894],
            ['name' => 'ชุมชนตลาดพลู', 'description' => 'ชุมชนการค้าเก่าแก่', 'latitude' => 13.7140, 'longitude' => 100.4760],
            ['name' => 'ชุมชนคลองบางกอกใหญ่', 'description' => 'ชุมชนริมคลองบางกอกใหญ่', 'latitude' => 13.7280, 'longitude' => 100.4720],
            ['name' => 'ชุมชนวัดราชโอรส', 'description' => 'ชุมชนวัดราชโอรสาราม', 'latitude' => 13.7370, 'longitude' => 100.4850],
        ];

        foreach ($communities as $community) {
            Community::create($community);
        }

        // สร้างข้อมูลวัฒนธรรมตัวอย่าง
        $sampleItems = [
            [
                'title' => 'ประเพณีตักบาตรน้ำผึ้ง วัดอรุณราชวราราม',
                'category_id' => 4,
                'community_id' => 3,
                'description' => 'ประเพณีตักบาตรน้ำผึ้งเป็นประเพณีที่สืบทอดกันมายาวนานในชุมชนวัดอรุณ จัดขึ้นในช่วงเทศกาลสำคัญทางพุทธศาสนา ชาวบ้านจะนำน้ำผึ้งมาถวายพระสงฆ์เพื่อความเป็นสิริมงคล นอกจากน้ำผึ้งแล้ว ยังมีการถวายอาหารคาวหวาน ผลไม้ และปัจจัยต่างๆ การตักบาตรน้ำผึ้งนี้เชื่อกันว่าจะช่วยให้ชีวิตหวานชื่นราบรื่น ปราศจากอุปสรรค',
                'publish_date' => now(),
                'is_published' => true,
                'is_featured' => true,
                'featured_order' => 1,
                'created_by' => $editor->id,
            ],
            [
                'title' => 'ศิลปะการทำเครื่องปั้นดินเผาเบญจรงค์',
                'category_id' => 2,
                'community_id' => 1,
                'description' => 'เบญจรงค์เป็นเครื่องปั้นดินเผาชั้นสูงของไทย มีลวดลายอันวิจิตรงดงาม สะท้อนถึงความประณีตของช่างฝีมือไทย ชุมชนกุฎีจีนเป็นแหล่งผลิตเบญจรงค์ที่สำคัญแห่งหนึ่ง มีการสืบทอดภูมิปัญญาการทำเบญจรงค์มาหลายชั่วอายุคน กรรมวิธีการผลิตต้องอาศัยความชำนาญและความอดทน ตั้งแต่การปั้น การเผา การเขียนลาย และการเคลือบ',
                'publish_date' => now(),
                'is_published' => true,
                'is_featured' => true,
                'featured_order' => 2,
                'created_by' => $editor->id,
            ],
            [
                'title' => 'ขนมฝอยทองตำรับชาววัง',
                'category_id' => 3,
                'community_id' => 4,
                'description' => 'ขนมฝอยทองเป็นขนมไทยโบราณที่มีมาตั้งแต่สมัยอยุธยา สูตรของชุมชนตลาดพลูได้รับการสืบทอดมาจากชาววังฝั่งธนบุรี มีความหวานกำลังดีและเส้นฝอยที่ละเอียด วิธีการทำต้องใช้ความชำนาญในการควบคุมความร้อนและการหยอดแป้งให้เป็นเส้นฝอยที่สม่ำเสมอ ปัจจุบันยังคงมีการทำขนมฝอยทองแบบดั้งเดิมเพื่อจำหน่ายในชุมชน',
                'publish_date' => now(),
                'is_published' => true,
                'is_featured' => true,
                'featured_order' => 3,
                'created_by' => $admin->id,
            ],
            [
                'title' => 'วิถีชีวิตริมคลองบางกอกใหญ่',
                'category_id' => 6,
                'community_id' => 5,
                'description' => 'ชุมชนริมคลองบางกอกใหญ่ยังคงรักษาวิถีชีวิตแบบดั้งเดิม มีการใช้เรือเป็นพาหนะหลัก การค้าขายทางน้ำ และบ้านเรือนแบบไทยที่ปลูกริมน้ำ ชาวบ้านส่วนใหญ่ประกอบอาชีพประมงและค้าขายของสด มีตลาดน้ำเล็กๆ ที่ยังคงความเป็นเอกลักษณ์ วิถีชีวิตที่เรียบง่ายแต่อบอุ่นของชุมชนริมน้ำแห่งนี้สะท้อนให้เห็นถึงความผูกพันระหว่างคนกับสายน้ำ',
                'publish_date' => now(),
                'is_published' => true,
                'is_featured' => true,
                'featured_order' => 4,
                'created_by' => $admin->id,
            ],
            [
                'title' => 'ประวัติวัดกัลยาณมิตรวรมหาวิหาร',
                'category_id' => 5,
                'community_id' => 2,
                'description' => 'วัดกัลยาณมิตรสร้างขึ้นในสมัยรัชกาลที่ 3 โดยเจ้าพระยานิกรบดินทร์ (โต กัลยาณมิตร) เป็นวัดที่มีพระพุทธรูปองค์ใหญ่และมีสถาปัตยกรรมที่งดงาม พระอุโบสถมีภาพจิตรกรรมฝาผนังที่วิจิตรงดงาม เล่าเรื่องราวพุทธประวัติและชาดก นอกจากนี้ยังมีพระวิหารที่ประดิษฐานพระพุทธรูปสำคัญหลายองค์',
                'publish_date' => now()->subDays(1),
                'is_published' => true,
                'created_by' => $editor->id,
            ],
            [
                'title' => 'งานแกะสลักไม้วัดราชโอรส',
                'category_id' => 2,
                'community_id' => 6,
                'description' => 'งานแกะสลักไม้ที่วัดราชโอรสเป็นศิลปะชั้นสูง แสดงถึงฝีมือช่างไทยในอดีต ลวดลายประณีตงดงาม โดยเฉพาะบานประตูและหน้าต่างของอุโบสถที่แกะสลักเป็นลายพรรณพฤกษาและลายกนก ช่างแกะสลักได้ถ่ายทอดเรื่องราวทางพุทธศาสนาผ่านงานศิลปะที่งดงาม',
                'publish_date' => now()->subDays(2),
                'is_published' => true,
                'created_by' => $admin->id,
            ],
        ];

        foreach ($sampleItems as $item) {
            CulturalItem::create($item);
        }
    }
}