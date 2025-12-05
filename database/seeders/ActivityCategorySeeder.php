<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ActivityCategory;

class ActivityCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'เทศกาลและงานประเพณี',
                'slug' => 'festivals',
                'description' => 'เทศกาลต่างๆ และงานประเพณีท้องถิ่น',
                'color' => '#f97316', // orange
                'icon' => 'fas fa-calendar-star',
                'sort_order' => 1
            ],
            [
                'name' => 'กิจกรรมทางวัฒนธรรม',
                'slug' => 'cultural-activities', 
                'description' => 'กิจกรรมที่เกี่ยวข้องกับการอนุรักษ์วัฒนธรรม',
                'color' => '#10b981', // emerald
                'icon' => 'fas fa-masks-theater',
                'sort_order' => 2
            ],
            [
                'name' => 'กิจกรรมศึกษาเรียนรู้',
                'slug' => 'educational',
                'description' => 'กิจกรรมเพื่อการศึกษาและเรียนรู้',
                'color' => '#3b82f6', // blue
                'icon' => 'fas fa-graduation-cap',
                'sort_order' => 3
            ],
            [
                'name' => 'การแสดงและศิลปะ',
                'slug' => 'arts-performance',
                'description' => 'การแสดงดนตรี นาฏกรรม และงานศิลปะ',
                'color' => '#8b5cf6', // violet
                'icon' => 'fas fa-music',
                'sort_order' => 4
            ],
            [
                'name' => 'กิจกรรมชุมชน',
                'slug' => 'community',
                'description' => 'กิจกรรมร่วมของชุมชนและประชาชน',
                'color' => '#06b6d4', // cyan
                'icon' => 'fas fa-users',
                'sort_order' => 5
            ],
            [
                'name' => 'ประชุมและสัมมนา',
                'slug' => 'conferences',
                'description' => 'งานประชุม สัมมนา และการจัดฝึกอบรม',
                'color' => '#64748b', // slate
                'icon' => 'fas fa-chalkboard-teacher',
                'sort_order' => 6
            ],
            [
                'name' => 'กิจกรรมพิเศษ',
                'slug' => 'special-events',
                'description' => 'กิจกรรมพิเศษและโอกาสสำคัญต่างๆ',
                'color' => '#dc2626', // red
                'icon' => 'fas fa-star',
                'sort_order' => 7
            ]
        ];

        foreach ($categories as $category) {
            ActivityCategory::create($category);
        }
    }
}