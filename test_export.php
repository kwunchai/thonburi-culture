<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$request = Illuminate\Http\Request::capture();

// ตั้งค่า URL สำหรับการทดสอบ
$request->server->set('REQUEST_URI', '/admin/cultural-items/export?export=excel');
$request->query->set('export', 'excel');

echo "Testing Cultural Items Export...\n";
echo "URL: " . $request->fullUrl() . "\n";

try {
    $response = $kernel->handle($request);
    echo "Status: " . $response->getStatusCode() . "\n";
    echo "Headers: " . json_encode($response->headers->all()) . "\n";
    echo "Success!\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

$kernel->terminate($request, $response ?? null);