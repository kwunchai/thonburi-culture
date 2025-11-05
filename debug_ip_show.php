<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\IntellectualProperty;

echo "=== ทดสอบ IP Show Function ===\n\n";

try {
    $ip = IntellectualProperty::find(54);
    
    if (!$ip) {
        echo "❌ ไม่พบ IP ID 54\n";
        
        // หา IP ที่มีอยู่
        $first = IntellectualProperty::first();
        if ($first) {
            echo "📋 IP แรกที่มี: ID {$first->ip_id} - {$first->title}\n";
            $ip = $first;
        } else {
            echo "❌ ไม่มี IP ในระบบเลย\n";
            exit;
        }
    }
    
    echo "✅ พบ IP: {$ip->title}\n";
    echo "ID: {$ip->ip_id}\n";
    echo "Type: {$ip->type}\n";
    echo "Status: {$ip->status}\n";
    
    // ทดสอบ accessors
    echo "\n=== ทดสอบ Labels ===\n";
    try {
        echo "Type Label: " . $ip->type_label . "\n";
        echo "Status Label: " . $ip->status_label . "\n";
    } catch (Exception $e) {
        echo "❌ Error with labels: " . $e->getMessage() . "\n";
    }
    
    // ทดสอบ relationships
    echo "\n=== ทดสอบ Relationships ===\n";
    try {
        $owner = $ip->owner;
        echo "Owner: " . ($owner ? $owner->name : 'ไม่มี') . "\n";
    } catch (Exception $e) {
        echo "❌ Error with owner: " . $e->getMessage() . "\n";
    }
    
    // ทดสอบ metadata
    echo "\n=== ทดสอบ Metadata ===\n";
    try {
        $metadata = $ip->metadata;
        echo "Metadata type: " . gettype($metadata) . "\n";
        if ($metadata) {
            if (is_string($metadata)) {
                $decoded = json_decode($metadata, true);
                echo "JSON decoded: " . (is_array($decoded) ? 'Yes' : 'No') . "\n";
            }
        }
    } catch (Exception $e) {
        echo "❌ Error with metadata: " . $e->getMessage() . "\n";
    }
    
    // ทดสอบ dates
    echo "\n=== ทดสอบ Dates ===\n";
    try {
        echo "Registration Date: " . ($ip->registration_date ? $ip->registration_date->format('d/m/Y') : 'ไม่มี') . "\n";
        echo "Expiry Date: " . ($ip->expiry_date ? $ip->expiry_date->format('d/m/Y') : 'ไม่มี') . "\n";
    } catch (Exception $e) {
        echo "❌ Error with dates: " . $e->getMessage() . "\n";
    }
    
} catch (Exception $e) {
    echo "❌ Fatal Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}