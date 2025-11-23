<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Activity;
use App\Models\User;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ดึง user admin หรือสร้างใหม่ถ้าไม่มี
        $admin = User::where('role', 'admin')->first() ?? User::first();
        
        if (!$admin) {
            $admin = User::create([
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
                'role' => 'admin'
            ]);
        }

        $activities = [
            [
                'title' => 'งานประจำปีเทศกาลลอยกระทง ประจำปี 2567',
                'description' => 'กิจกรรมประเพณีลอยกระทงประจำปี ณ วัดดาวดึงส์ เขตธนบุรี ร่วมงานชมกระทง ชมไฟ และกิจกรรมทางวัฒนธรรมมากมาย',
                'activity_date' => '2024-11-15',
                'location' => 'วัดดาวดึงส์ เขตธนบุรี',
                'is_active' => true,
                'sort_order' => 1,
                'created_by' => $admin->id
            ],
            [
                'title' => 'อบรมเชิงปฏิบัติการอนุรักษ์ภูมิปัญญาท้องถิ่น',
                'description' => 'โครงการถ่ายทอดภูมิปัญญาจากผู้สูงอายุสู่เยาวชน ครอบคลุมการทำผ้า การทำอาหาร และการแสดงพื้นบ้าน',
                'activity_date' => '2024-10-20',
                'location' => 'ศูนย์วัฒนธรรมเขตธนบุรี',
                'is_active' => true,
                'sort_order' => 2,
                'created_by' => $admin->id
            ],
            [
                'title' => 'นิทรรศการมรดกทางวัฒนธรรมเขตธนบุรี',
                'description' => 'การจัดแสดงนิทรรศการเพื่อสืบสานมรดกทางวัฒนธรรม แสดงประวัติศาสตร์และงานศิลปะของท้องถิ่น',
                'activity_date' => '2024-09-15',
                'location' => 'ห้องแสดงผลงาน ที่ว่าการเขตธนบุรี',
                'is_active' => true,
                'sort_order' => 3,
                'created_by' => $admin->id
            ],
            [
                'title' => 'ค่ายเยาวชนอนุรักษ์วัฒนธรรม',
                'description' => 'กิจกรรมค่ายสำหรับเยาวชนในการเรียนรู้และอนุรักษ์วัฒนธรรมท้องถิ่น ผ่านกิจกรรมต่างๆ มากมาย',
                'activity_date' => '2024-08-10',
                'location' => 'โรงเรียนวัดดาวดึงส์',
                'is_active' => true,
                'sort_order' => 4,
                'created_by' => $admin->id
            ],
            [
                'title' => 'งานวันสงกรานต์ประจำปี 2567',
                'description' => 'กิจกรรมสงกรานต์ประเพณี สรงน้ำพระ รดน้ำดำหัวผู้สูงอายุ และกิจกรรมแห่น้ำพระประจำปี',
                'activity_date' => '2024-04-13',
                'location' => 'วัดสองยอด เขตธนบุรี',
                'is_active' => true,
                'sort_order' => 5,
                'created_by' => $admin->id
            ],
            [
                'title' => 'งานแสดงละครพื้นบ้าน',
                'description' => 'การแสดงละครพื้นบ้านประจำปี นำแสดงโดยกลุ่มศิลปินท้องถิ่น เพื่อสืบสานงานศิลปะการแสดง',
                'activity_date' => '2024-03-25',
                'location' => 'หอประชุมเขตธนบุรี',
                'is_active' => false,
                'sort_order' => 6,
                'created_by' => $admin->id
            ]
        ];

        foreach ($activities as $activity) {
            Activity::create($activity);
        }

        $this->command->info('สร้างข้อมูลกิจกรรมตัวอย่างเรียบร้อยแล้ว!');
    }
}
