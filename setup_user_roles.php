<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;

echo "=== อัพเดต Role สำหรับ Admin Users ===\n\n";

// ตั้งค่า role สำหรับ admin users ที่มีอยู่
$adminEmails = [
    'admin@thonburi.com',
    'admin@thonburi-culture.com'
];

foreach ($adminEmails as $email) {
    $user = User::where('email', $email)->first();
    if ($user) {
        $user->update(['role' => 'admin']);
        echo "✅ อัพเดต {$email} เป็น Admin\n";
    }
}

// แสดงสถิติ users
$stats = [
    'total' => User::count(),
    'admin' => User::where('role', 'admin')->count(),
    'editor' => User::where('role', 'editor')->count(),
    'viewer' => User::where('role', 'viewer')->orWhereNull('role')->count(),
];

echo "\n📊 สถิติผู้ใช้งาน:\n";
echo "ทั้งหมด: {$stats['total']}\n";
echo "Admin: {$stats['admin']}\n"; 
echo "Editor: {$stats['editor']}\n";
echo "Viewer: {$stats['viewer']}\n";

echo "\n=== เสร็จสิ้น ===\n";