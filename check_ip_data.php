<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\IntellectualProperty;

echo "=== ตรวจสอบข้อมูลทรัพย์สินทางปัญญา ===\n\n";

$total = IntellectualProperty::count();
echo "จำนวนทั้งหมด: {$total} รายการ\n\n";

echo "แยกตามประเภท:\n";
$byType = IntellectualProperty::groupBy('type')
    ->selectRaw('type, count(*) as count')
    ->get();

foreach($byType as $stat) {
    echo "- {$stat->type}: {$stat->count} รายการ\n";
}

echo "\nแยกตามสถานะ:\n";
$byStatus = IntellectualProperty::groupBy('status')
    ->selectRaw('status, count(*) as count')
    ->get();

foreach($byStatus as $stat) {
    echo "- {$stat->status}: {$stat->count} รายการ\n";
}

echo "\nตัวอย่างข้อมูล 5 รายการแรก:\n";
$samples = IntellectualProperty::with('owner')->take(5)->get();

foreach($samples as $ip) {
    echo "\n" . str_repeat('-', 50) . "\n";
    echo "ID: {$ip->id}\n";
    echo "ชื่อ: {$ip->title}\n";
    echo "ประเภท: {$ip->type}\n";
    echo "สถานะ: {$ip->status}\n";
    echo "เจ้าของ: " . ($ip->owner ? $ip->owner->name : 'ไม่ระบุ') . "\n";
    echo "วันที่ลงทะเบียน: " . ($ip->registration_date ? $ip->registration_date->format('d/m/Y') : 'ไม่ระบุ') . "\n";
    echo "เลขที่ลงทะเบียน: " . ($ip->registration_number ?? 'ไม่ระบุ') . "\n";
}

echo "\n" . str_repeat('=', 50) . "\n";
echo "เสร็จสิ้นการตรวจสอบข้อมูล\n";