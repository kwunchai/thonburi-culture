<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\IntellectualProperty;

echo "=== ตรวจสอบ IP Model และข้อมูล ===\n\n";

$ip = IntellectualProperty::first();

if ($ip) {
    echo "IP ID: " . $ip->ip_id . "\n";
    echo "Title: " . $ip->title . "\n";
    echo "Primary Key Name: " . $ip->getKeyName() . "\n";
    echo "Route Key Name: " . $ip->getRouteKeyName() . "\n";
    echo "Type: " . $ip->type . "\n";
    echo "Status: " . $ip->status . "\n";
    
    // Test accessors
    try {
        echo "Type Label: " . $ip->type_label . "\n";
        echo "Status Label: " . $ip->status_label . "\n";
    } catch (Exception $e) {
        echo "Error with labels: " . $e->getMessage() . "\n";
    }
    
    // Test route generation
    try {
        echo "Edit Route: " . route('admin.ip.edit', $ip) . "\n";
    } catch (Exception $e) {
        echo "Route Error: " . $e->getMessage() . "\n";
    }
    
} else {
    echo "No IP found\n";
}

echo "\n=== ตัวอย่าง 3 รายการแรก ===\n";
$items = IntellectualProperty::take(3)->get();
foreach ($items as $item) {
    echo "\nID: " . $item->ip_id . " - " . $item->title . "\n";
}