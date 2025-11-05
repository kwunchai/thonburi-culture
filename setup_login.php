<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "=== สรุปข้อมูล Admin Users ===\n\n";

$users = [
    [
        'name' => 'Admin',
        'email' => 'admin@thonburi.com',
        'password' => 'password'
    ],
    [
        'name' => 'Test Admin',
        'email' => 'test@thonburi.com', 
        'password' => 'password'
    ]
];

foreach ($users as $userData) {
    $user = User::where('email', $userData['email'])->first();
    
    if (!$user) {
        $user = User::create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => Hash::make($userData['password']),
            'email_verified_at' => now(),
        ]);
        echo "✅ สร้างใหม่: ";
    } else {
        $user->update([
            'password' => Hash::make($userData['password'])
        ]);
        echo "🔄 อัพเดต: ";
    }
    
    echo "{$user->email} (รหัสผ่าน: {$userData['password']})\n";
}

echo "\n" . str_repeat("=", 50) . "\n";
echo "🎯 ข้อมูลสำหรับ Login:\n";
echo "📧 Email: admin@thonburi.com\n";
echo "🔐 Password: password\n";
echo "🌐 URL: http://thonburi-culture.test/login\n";
echo str_repeat("=", 50) . "\n";

echo "\n📊 สถิติ Users ในระบบ:\n";
echo "Total Users: " . User::count() . "\n";
echo "Verified Users: " . User::whereNotNull('email_verified_at')->count() . "\n";