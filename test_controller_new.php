<?php

use Illuminate\Http\Request;

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== ทดสอบ Controller Variables ===\n";

// สร้าง mock request
$request = new Request();
$controller = new \App\Http\Controllers\FrontendController();

try {
    // เรียก explore method
    echo "เรียก explore method...\n";
    $response = $controller->explore($request);
    
    // ตรวจสอบ view data
    $viewData = $response->getData();
    
    echo "Variables ที่ส่งไป view:\n";
    foreach($viewData as $key => $value) {
        if(is_object($value)) {
            if(method_exists($value, 'count')) {
                echo "- {$key}: " . get_class($value) . " (count: {$value->count()})\n";
            } else {
                echo "- {$key}: " . get_class($value) . "\n";
            }
        } elseif(is_array($value)) {
            echo "- {$key}: array (" . count($value) . " items)\n";
            if($key === 'stats') {
                foreach($value as $statKey => $statValue) {
                    echo "  - {$statKey}: {$statValue}\n";
                }
            }
        } else {
            echo "- {$key}: {$value}\n";
        }
    }
    
} catch(\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}