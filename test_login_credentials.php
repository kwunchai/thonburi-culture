<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "=== ทดสอบ Login Credentials ===\n\n";

// Test credentials
$testCredentials = [
    ['email' => 'admin@thonburi.com', 'password' => 'password'],
    ['email' => 'admin@thonburi-culture.com', 'password' => 'password123'],
    ['email' => 'editor@thonburi.com', 'password' => 'password'],
];

foreach ($testCredentials as $credential) {
    $user = User::where('email', $credential['email'])->first();
    
    if ($user) {
        $passwordMatch = Hash::check($credential['password'], $user->password);
        echo "Email: {$credential['email']}\n";
        echo "Password: {$credential['password']}\n";
        echo "User Name: {$user->name}\n";
        echo "Role: {$user->role}\n";
        echo "Password Match: " . ($passwordMatch ? "✓ YES" : "✗ NO") . "\n";
        echo "Email Verified: " . ($user->email_verified_at ? "✓ YES" : "✗ NO") . "\n";
        echo "---\n\n";
    } else {
        echo "Email: {$credential['email']} - ไม่พบ user นี้\n\n";
    }
}

echo "=== User ทั้งหมดในระบบ ===\n";
$users = User::all();
echo "จำนวน users: {$users->count()}\n\n";

foreach ($users->take(10) as $user) {
    echo "ID: {$user->id}\n";
    echo "Name: {$user->name}\n";
    echo "Email: {$user->email}\n";
    echo "Role: {$user->role}\n";
    echo "Verified: " . ($user->email_verified_at ? "YES" : "NO") . "\n";
    echo "---\n";
}
