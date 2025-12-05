<?php
echo "PHP is working!";
echo "\nCurrent directory: " . __DIR__;
echo "\nPHP version: " . phpversion();
echo "\nLaravel test: ";

// Test Laravel bootstrap
require_once __DIR__ . '/vendor/autoload.php';
echo "Autoload OK\n";

try {
    $app = require_once __DIR__ . '/bootstrap/app.php';
    echo "Bootstrap OK\n";
    
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    echo "Kernel OK\n";
    
    // Create a simple request
    $request = Illuminate\Http\Request::create('/', 'GET');
    echo "Request created\n";
    
    // Get response (this will trigger the route)
    $response = $kernel->handle($request);
    echo "Status Code: " . $response->getStatusCode() . "\n";
    
    if ($response->getStatusCode() === 200) {
        echo "SUCCESS: Laravel is working!\n";
    } else {
        echo "ERROR: Status " . $response->getStatusCode() . "\n";
        echo "Content: " . substr($response->getContent(), 0, 200) . "...\n";
    }
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " Line: " . $e->getLine() . "\n";
}
?>