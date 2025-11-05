<?php

// ทดสอบโหลด view ทั้งหมด
require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\IntellectualProperty;

try {
    echo "=== ทดสอบ View Rendering ===\n\n";
    
    // หา IP
    $ip = IntellectualProperty::where('ip_id', 44)->first();
    
    if (!$ip) {
        echo "❌ ไม่พบ IP ID 44\n";
        exit;
    }

    // Load relationships
    $ip->load(['owner', 'creator', 'updater']);
    
    echo "✅ พบ IP: {$ip->title}\n";
    
    // ทดสอบ is_expired accessor
    echo "is_expired: " . ($ip->is_expired ? 'true' : 'false') . "\n";
    
    // ทดสอบ attributes อื่นๆ ที่ใช้ใน view
    echo "type_label: {$ip->type_label}\n";
    echo "status_label: {$ip->status_label}\n";
    echo "registration_number: " . ($ip->registration_number ?? 'null') . "\n";
    echo "registration_date: " . ($ip->registration_date ? $ip->registration_date->format('d/m/Y') : 'null') . "\n";
    echo "expiry_date: " . ($ip->expiry_date ? $ip->expiry_date->format('d/m/Y') : 'null') . "\n";
    echo "description: " . ($ip->description ? 'มี' : 'ไม่มี') . "\n";
    echo "certificate_path: " . ($ip->certificate_path ? 'มี' : 'ไม่มี') . "\n";
    
    // ทดสอบ relationships
    echo "owner: " . ($ip->owner ? $ip->owner->name : 'null') . "\n";
    echo "creator: " . ($ip->creator ? $ip->creator->name : 'null') . "\n";
    echo "updater: " . ($ip->updater ? $ip->updater->name : 'null') . "\n";
    
    echo "\n✅ ข้อมูลทั้งหมดพร้อม - View ควรใช้งานได้\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}