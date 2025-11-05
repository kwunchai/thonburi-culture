<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\IntellectualProperty;
use App\Http\Controllers\Admin\IntellectualPropertyController;
use Illuminate\Http\Request;

try {
    echo "=== ทดสอบ Route การเข้าถึง IP Show ===\n\n";

    // จำลอง request แบบเต็ม
    $request = Request::create('/admin/ip/44', 'GET');
    
    // ตั้ง user session (จำลอง login)
    $user = \App\Models\User::first();
    if ($user) {
        auth()->login($user);
        echo "✅ Login ผู้ใช้: {$user->name}\n";
    }
    
    // หา IP
    $ip = IntellectualProperty::where('ip_id', 44)->first();
    
    if (!$ip) {
        echo "❌ ไม่พบ IP ID 44\n";
        exit;
    }

    echo "✅ พบ IP: {$ip->title}\n";

    // ทดสอบ resolveRouteBinding
    $model = new IntellectualProperty();
    $resolved = $model->resolveRouteBinding(44);
    
    if ($resolved) {
        echo "✅ Route binding สำเร็จ\n";
    } else {
        echo "❌ Route binding ล้มเหลว\n";
        exit;
    }

    // ทดสอบ Controller show method
    echo "\n=== ทดสอบ Controller Show Method ===\n";
    
    $controller = new IntellectualPropertyController();
    
    // เรียก show method โดยตรง
    $response = $controller->show($ip);
    
    echo "✅ Controller show method ทำงานสำเร็จ\n";
    echo "Response type: " . get_class($response) . "\n";
    
    if (method_exists($response, 'getStatusCode')) {
        echo "Status Code: " . $response->getStatusCode() . "\n";
    }
    
    echo "\n=== ทดสอบ View Rendering ===\n";
    
    // ทดสอบ render view
    $viewContent = view('admin.ip.show', compact('ip'))->render();
    
    echo "✅ View render สำเร็จ\n";
    echo "Content length: " . strlen($viewContent) . " characters\n";
    
    // ตรวจสอบ error ใน content
    if (strpos($viewContent, 'error') !== false || strpos($viewContent, 'exception') !== false) {
        echo "⚠️  พบ error ใน view content\n";
    } else {
        echo "✅ View content ไม่มี error\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo "\nStack trace:\n" . $e->getTraceAsString() . "\n";
} catch (Error $e) {
    echo "❌ Fatal Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo "\nStack trace:\n" . $e->getTraceAsString() . "\n";
}