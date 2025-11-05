<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\IntellectualProperty;

echo "=== ทดสอบ Custom Route Binding ===\n\n";

try {
    // ทดสอบ resolveRouteBinding method
    $model = new IntellectualProperty();
    $result = $model->resolveRouteBinding(44);
    
    if ($result) {
        echo "✅ Route binding ทำงาน: พบ IP ID 44\n";
        echo "Title: {$result->title}\n";
        echo "IP ID: {$result->ip_id}\n";
        echo "Type: {$result->type_label}\n";
        echo "Status: {$result->status_label}\n";
    } else {
        echo "❌ Route binding ไม่ทำงาน: ไม่พบ IP ID 44\n";
    }
    
    // ทดสอบกับ ID อื่น
    echo "\n=== ทดสอบกับ IP ID อื่น ===\n";
    $ips = IntellectualProperty::take(3)->get(['ip_id', 'title']);
    foreach($ips as $ip) {
        $test = $model->resolveRouteBinding($ip->ip_id);
        echo ($test ? "✅" : "❌") . " IP ID {$ip->ip_id}: {$ip->title}\n";
    }
    
    echo "\n=== ทดสอบ Route Generation ===\n";
    $firstIp = IntellectualProperty::first();
    if ($firstIp) {
        $showUrl = route('admin.ip.show', $firstIp);
        $editUrl = route('admin.ip.edit', $firstIp);
        echo "Show URL: {$showUrl}\n";
        echo "Edit URL: {$editUrl}\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}