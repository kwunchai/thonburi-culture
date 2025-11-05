<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "=== สร้าง Admin User ===\n\n";

// Check if admin exists
$admin = User::where('email', 'admin@thonburi-culture.com')->first();

if ($admin) {
    echo "Admin user มีอยู่แล้ว:\n";
    echo "Email: " . $admin->email . "\n";
    echo "Name: " . $admin->name . "\n";
} else {
    // Create admin user
    $admin = User::create([
        'name' => 'Administrator',
        'email' => 'admin@thonburi-culture.com',
        'password' => Hash::make('password123'),
        'email_verified_at' => now(),
    ]);
    
    echo "สร้าง Admin user สำเร็จ:\n";
    echo "Email: admin@thonburi-culture.com\n";
    echo "Password: password123\n";
}

echo "\n=== ข้อมูล User ทั้งหมด ===\n";
$users = User::take(5)->get();
foreach($users as $user) {
    echo "ID: {$user->id} - {$user->name} ({$user->email})\n";
}