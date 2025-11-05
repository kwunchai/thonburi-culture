<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\IntellectualProperty;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

echo "=== ทดสอบ Show Method ===\n\n";

try {
    // จำลอง authentication
    $admin = User::where('email', 'admin@thonburi.com')->first();
    if ($admin) {
        Auth::login($admin);
        echo "✅ Login as: {$admin->name}\n";
    }
    
    // จำลองการเรียก show method
    $controller = new App\Http\Controllers\Admin\IntellectualPropertyController();
    
    echo "📋 ทดสอบ show method กับ IP ID 44...\n";
    
    // ทดสอบการค้นหาข้อมูล
    $ip = IntellectualProperty::where('ip_id', 44)->first();
    if ($ip) {
        echo "✅ พบข้อมูล IP: {$ip->title}\n";
        echo "Type: {$ip->type} -> {$ip->type_label}\n";
        echo "Status: {$ip->status} -> {$ip->status_label}\n";
        
        // ทดสอบ relationships
        $ip->load(['owner', 'creator', 'updater']);
        echo "Owner: " . ($ip->owner ? $ip->owner->name : 'ไม่มี') . "\n";
        
        echo "\n✅ Controller method ควรทำงานได้ปกติ\n";
        
        // ทดสอบ route
        $route = route('admin.ip.show', 44);
        echo "Route URL: {$route}\n";
        
    } else {
        echo "❌ ไม่พบ IP ID 44\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}