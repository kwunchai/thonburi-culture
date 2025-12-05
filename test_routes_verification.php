<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Route Verification Test ===\n\n";

// Test all frontend routes
$routes = [
    'home' => 'หน้าแรก',
    'cultural.explore' => 'สำรวจวัฒนธรรม',
    'activities' => 'กิจกรรม',
    'about' => 'เกี่ยวกับ',
    'contact' => 'ติดต่อเรา',
    'activity.show' => 'รายละเอียดกิจกรรม (with ID)',
];

echo "1. Frontend Routes:\n";
$errors = [];
foreach ($routes as $routeName => $label) {
    try {
        if ($routeName === 'activity.show') {
            // Test with sample ID
            $url = route($routeName, 1);
        } else {
            $url = route($routeName);
        }
        echo "   ✓ {$label} ({$routeName}): {$url}\n";
    } catch (Exception $e) {
        echo "   ✗ {$label} ({$routeName}): ERROR\n";
        $errors[] = "{$routeName}: {$e->getMessage()}";
    }
}

// Test view files
echo "\n2. View Files Check:\n";
$viewFiles = [
    'about' => 'resources/views/frontend/about.blade.php',
    'contact' => 'resources/views/frontend/contact.blade.php',
    'activities' => 'resources/views/frontend/activities.blade.php',
    'activity-detail' => 'resources/views/frontend/activity-detail.blade.php',
];

foreach ($viewFiles as $name => $path) {
    $fullPath = base_path($path);
    if (file_exists($fullPath)) {
        echo "   ✓ {$name}: EXISTS\n";
    } else {
        echo "   ✗ {$name}: MISSING\n";
        $errors[] = "Missing view: {$path}";
    }
}

// Check for route usage in about.blade.php
echo "\n3. About Page Route Usage:\n";
$aboutPath = resource_path('views/frontend/about.blade.php');
if (file_exists($aboutPath)) {
    $content = file_get_contents($aboutPath);
    
    $routeChecks = [
        "route('cultural.explore')" => 'cultural.explore',
        "route('activities')" => 'activities',
        "route('contact')" => 'contact',
        "route('about')" => 'about (self-reference)',
    ];
    
    foreach ($routeChecks as $search => $description) {
        $count = substr_count($content, $search);
        if ($count > 0) {
            echo "   ✓ {$description}: {$count} usage(s)\n";
        } else {
            echo "   ⚠ {$description}: NOT FOUND\n";
        }
    }
    
    // Check for problematic routes
    if (strpos($content, "route('explore')") !== false) {
        echo "   ✗ FOUND OLD ROUTE: route('explore') - NEEDS FIX!\n";
        $errors[] = "Old route('explore') found in about.blade.php";
    }
} else {
    echo "   ✗ About view file not found\n";
    $errors[] = "about.blade.php missing";
}

// Summary
echo "\n=== Summary ===\n";
if (empty($errors)) {
    echo "✅ All routes and views are correct!\n";
    echo "\n🌐 Test URLs:\n";
    echo "   - Home: http://thonburi-culture.test\n";
    echo "   - Explore: http://thonburi-culture.test/explore\n";
    echo "   - Activities: http://thonburi-culture.test/activities\n";
    echo "   - About: http://thonburi-culture.test/about\n";
    echo "   - Contact: http://thonburi-culture.test/contact\n";
} else {
    echo "❌ Found " . count($errors) . " error(s):\n";
    foreach ($errors as $error) {
        echo "   • {$error}\n";
    }
}
