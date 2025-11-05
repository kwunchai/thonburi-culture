<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    echo "Testing view rendering...\n";
    
    $ip = \App\Models\IntellectualProperty::where('ip_id', 44)->first();
    
    if (!$ip) {
        echo "IP not found\n";
        exit;
    }
    
    // Test view render
    $content = view('admin.ip.show', compact('ip'))->render();
    echo "View rendered successfully. Length: " . strlen($content) . "\n";
    
    // Check for errors
    if (stripos($content, 'undefined') !== false) {
        echo "Found 'undefined' in content\n";
    }
    
    if (stripos($content, 'error') !== false) {
        echo "Found 'error' in content\n";
    }
    
    echo "Test completed\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Line: " . $e->getLine() . "\n";
} catch (Error $e) {
    echo "Fatal: " . $e->getMessage() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}