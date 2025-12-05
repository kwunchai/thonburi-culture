<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;

echo "=== Verify Email สำหรับ Admin Users ===\n\n";

// Verify admin users
$admins = User::whereIn('email', [
    'admin@thonburi.com',
    'editor@thonburi.com',
    'admin@thonburi-culture.com'
])->get();

foreach ($admins as $user) {
    if (!$user->email_verified_at) {
        $user->email_verified_at = now();
        $user->save();
        echo "✓ Verified: {$user->email} ({$user->name})\n";
    } else {
        echo "Already verified: {$user->email} ({$user->name})\n";
    }
}

echo "\n=== Login Credentials ที่พร้อมใช้งาน ===\n\n";

echo "1. Admin User:\n";
echo "   Email: admin@thonburi.com\n";
echo "   Password: password\n";
echo "   Role: admin\n\n";

echo "2. Editor User:\n";
echo "   Email: editor@thonburi.com\n";
echo "   Password: password\n";
echo "   Role: editor\n\n";

echo "3. Alternative Admin:\n";
echo "   Email: admin@thonburi-culture.com\n";
echo "   Password: password123\n";
echo "   Role: editor\n\n";

echo "=== ทดสอบเข้าสู่ระบบได้แล้ว ===\n";
