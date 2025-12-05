<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "=== สร้าง IP Manager User ===\n\n";

// สร้าง IP Manager User ตัวอย่าง
$ipManagerData = [
    'name' => 'IP Manager',
    'email' => 'ip-manager@thonburi.com',
    'password' => 'password',
    'role' => 'ip_manager'
];

$ipManager = User::where('email', $ipManagerData['email'])->first();

if (!$ipManager) {
    $ipManager = User::create([
        'name' => $ipManagerData['name'],
        'email' => $ipManagerData['email'],
        'password' => Hash::make($ipManagerData['password']),
        'role' => $ipManagerData['role'],
        'email_verified_at' => now(),
    ]);
    echo "✅ สร้าง IP Manager User ใหม่: {$ipManager->email}\n";
} else {
    $ipManager->update([
        'role' => $ipManagerData['role'],
        'password' => Hash::make($ipManagerData['password'])
    ]);
    echo "🔄 อัพเดต IP Manager User: {$ipManager->email}\n";
}

echo "\n" . str_repeat("=", 60) . "\n";
echo "🎯 ข้อมูลสำหรับ Login IP Manager:\n";
echo "📧 Email: {$ipManagerData['email']}\n";
echo "🔐 Password: {$ipManagerData['password']}\n";
echo "👤 Role: IP Manager (ผู้จัดการทรัพย์สินทางปัญญา)\n";
echo "🌐 URL: http://thonburi-culture.test/login\n";
echo str_repeat("=", 60) . "\n";

// แสดงสถิติ users ตามบทบาท
echo "\n📊 สถิติผู้ใช้งานตามบทบาท:\n";
$roles = [
    'admin' => 'ผู้ดูแลระบบ',
    'editor' => 'บรรณาธิการ', 
    'ip_manager' => 'ผู้จัดการ IP',
    'viewer' => 'ผู้ดู'
];

foreach ($roles as $role => $label) {
    $count = User::where('role', $role)->count();
    echo "- {$label}: {$count} คน\n";
}

$totalUsers = User::count();
echo "\nรวมทั้งหมด: {$totalUsers} คน\n";

echo "\n✅ การตั้งค่าเสร็จสมบูรณ์!\n";