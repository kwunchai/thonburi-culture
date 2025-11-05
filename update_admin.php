<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "=== อัพเดต Admin User ===\n\n";

// ค้นหา admin user ที่มีอยู่
$admin = User::where('email', 'admin@thonburi.com')->first();

if (!$admin) {
    // หากไม่มี ให้สร้างใหม่
    $admin = User::create([
        'name' => 'Administrator',
        'email' => 'admin@thonburi.com',
        'password' => Hash::make('password'),
        'email_verified_at' => now(),
    ]);
    echo "สร้าง Admin user ใหม่:\n";
} else {
    // หากมีอยู่แล้ว ให้อัพเดต password
    $admin->update([
        'password' => Hash::make('password')
    ]);
    echo "อัพเดต Admin user:\n";
}

echo "Email: admin@thonburi.com\n";
echo "Password: password\n";
echo "Name: " . $admin->name . "\n";
echo "ID: " . $admin->id . "\n";

// ตรวจสอบว่ามี admin user อื่นหรือไม่
$otherAdmins = User::where('email', '!=', 'admin@thonburi.com')
    ->where('email', 'like', '%admin%')
    ->get();

if ($otherAdmins->count() > 0) {
    echo "\nAdmin users อื่นในระบบ:\n";
    foreach($otherAdmins as $user) {
        echo "- {$user->email} ({$user->name})\n";
    }
}

echo "\n=== เสร็จสิ้น ===\n";