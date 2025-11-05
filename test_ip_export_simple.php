<?php

// Simple test for IP export
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';

try {
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    
    // Create a simple test request
    $request = Illuminate\Http\Request::create('/admin/ip/export?export=excel', 'GET');
    
    // Add basic auth context (bypass middleware for testing)
    $app->bind('auth', function() {
        return new class {
            public function user() {
                return (object) ['id' => 1, 'role' => 'admin'];
            }
            public function check() {
                return true;
            }
        };
    });
    
    echo "Testing IP Export Method...\n";
    echo "URL: " . $request->fullUrl() . "\n";
    
    // Directly call the controller method
    $controller = new \App\Http\Controllers\Admin\IntellectualPropertyController();
    $response = $controller->export($request);
    
    echo "Response Type: " . get_class($response) . "\n";
    
    if (method_exists($response, 'getStatusCode')) {
        echo "Status Code: " . $response->getStatusCode() . "\n";
    }
    
    if (method_exists($response, 'headers')) {
        $headers = $response->headers->all();
        echo "Headers: " . json_encode(array_keys($headers)) . "\n";
    }
    
    echo "✅ Export method works!\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}