<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Http\Controllers\FrontendController;
use Illuminate\Http\Request;

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$request = Request::capture();
$response = $kernel->handle($request);

// Test if we can instantiate the controller
try {
    $controller = new FrontendController();
    echo "✅ FrontendController instantiated successfully\n";
    
    // Test the home method
    $result = $controller->home();
    echo "✅ Home method executed successfully\n";
    echo "✅ Response type: " . get_class($result) . "\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "❌ File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo "❌ Stack trace:\n" . $e->getTraceAsString() . "\n";
}

$kernel->terminate($request, $response);