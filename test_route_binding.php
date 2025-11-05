<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\IntellectualProperty;

echo "=== ทดสอบ Route Model Binding ===\n\n";

try {
    // ทดสอบ ID 44 ที่ใช้ใน URL
    $ip = IntellectualProperty::find(44);
    
    if (!$ip) {
        echo "❌ ไม่พบ IP ID 44\n";
        
        // แสดง IP ที่มีอยู่
        $ips = IntellectualProperty::take(10)->get(['ip_id', 'title']);
        echo "📋 IP ที่มีอยู่:\n";
        foreach($ips as $item) {
            echo "- ID: {$item->ip_id} - {$item->title}\n";
        }
    } else {
        echo "✅ พบ IP ID 44: {$ip->title}\n";
        echo "Primary Key: {$ip->ip_id}\n";
        echo "Route Key: {$ip->getRouteKeyName()}\n";
        
        // ทดสอบ attributes ทั้งหมด
        echo "\n=== ทดสอบ Attributes ===\n";
        echo "Type: {$ip->type}\n";
        echo "Status: {$ip->status}\n";
        
        try {
            echo "Type Label: " . $ip->type_label . "\n";
            echo "Status Label: " . $ip->status_label . "\n";
        } catch (Exception $e) {
            echo "❌ Error with labels: " . $e->getMessage() . "\n";
        }
        
        // ทดสอบ owner relationship
        try {
            $owner = $ip->owner;
            echo "Owner: " . ($owner ? $owner->name : 'ไม่มี') . "\n";
        } catch (Exception $e) {
            echo "❌ Error with owner: " . $e->getMessage() . "\n";
        }
        
        // ทดสอบ dates
        try {
            echo "Created: " . $ip->created_at->format('d/m/Y H:i') . "\n";
            echo "Updated: " . $ip->updated_at->format('d/m/Y H:i') . "\n";
        } catch (Exception $e) {
            echo "❌ Error with dates: " . $e->getMessage() . "\n";
        }
    }
    
} catch (Exception $e) {
    echo "❌ Fatal Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}