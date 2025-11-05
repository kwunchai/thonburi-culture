<?php

// สร้าง test route สำหรับ debug
require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\IntellectualProperty;
use App\Models\User;
use App\Http\Controllers\Admin\IntellectualPropertyController;
use Illuminate\Http\Request;

try {

    echo "=== Debug IP Show Route ===\n\n";

    // จำลอง request
    $request = new Request();
    
    // ทดสอบหา IP
    $ip = IntellectualProperty::where('ip_id', 44)->first();
    
    if (!$ip) {
        echo "❌ ไม่พบ IP ID 44\n";
        exit;
    }

    echo "✅ พบ IP: {$ip->title}\n";
    echo "IP ID: {$ip->ip_id}\n";

    // ทดสอบ resolveRouteBinding
    $model = new IntellectualProperty();
    $resolved = $model->resolveRouteBinding(44);
    
    if ($resolved) {
        echo "✅ Route binding ทำงาน\n";
    } else {
        echo "❌ Route binding ไม่ทำงาน\n";
        exit;
    }

    // ทดสอบ Controller
    echo "\n=== ทดสอบ Controller ===\n";
    
    try {
        $controller = new IntellectualPropertyController();
        
        // Load relationships ก่อน
        $ip->load(['owner', 'creator', 'updater']);
        
        echo "✅ Controller instance created\n";
        echo "✅ Relationships loaded\n";
        
        // ทดสอบ attributes
        echo "Type: {$ip->type}\n";
        echo "Status: {$ip->status}\n";
        echo "Type Label: {$ip->type_label}\n";
        echo "Status Label: {$ip->status_label}\n";
        
        // ทดสอบ owner
        if ($ip->owner) {
            echo "Owner: {$ip->owner->name}\n";
        } else {
            echo "Owner: ไม่มี\n";
        }

        echo "\n✅ ทุกอย่างพร้อม - View ควรแสดงได้\n";
        
    } catch (Exception $e) {
        echo "❌ Controller Error: " . $e->getMessage() . "\n";
        echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
        echo "Trace:\n" . $e->getTraceAsString() . "\n";
    }
    
} catch (Exception $e) {
    echo "❌ Fatal Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}