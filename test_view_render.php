<?php

// Simple test file to check view rendering
require_once __DIR__ . '/vendor/autoload.php';

// Start Laravel Application
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Testing View Compilation...\n";
echo "================================\n\n";

try {
    // Test 1: Check if we can compile the view
    echo "1. Testing view existence and syntax...\n";
    
    $viewExists = view()->exists('frontend.home');
    echo "   View exists: " . ($viewExists ? 'YES' : 'NO') . "\n";
    
    if (!$viewExists) {
        echo "   ❌ View file not found!\n";
        exit(1);
    }
    
    // Test 2: Try to get some sample data
    echo "\n2. Preparing test data...\n";
    
    $culturalItems = App\Models\CulturalItem::with(['category', 'community'])
        ->whereNotNull('latitude')
        ->whereNotNull('longitude')
        ->published()
        ->limit(5)
        ->get();
    
    echo "   Cultural items with location: " . $culturalItems->count() . "\n";
    
    // Test 3: Try to render the view with minimal data
    echo "\n3. Testing view compilation with minimal data...\n";
    
    $testData = [
        'featuredItems' => collect([]),
        'latestItems' => collect([]),
        'culturalItemsWithLocation' => $culturalItems,
        'stats' => [
            'total_items' => 10,
            'total_categories' => 5,
            'total_communities' => 3,
            'total_innovations' => 8,
            'total_research' => 15,
            'total_ip' => 12,
        ]
    ];
    
    // Try to compile the view
    $view = view('frontend.home', $testData);
    
    echo "   ✅ View compilation successful!\n";
    
    // Test 4: Try to render to string (this will catch most template errors)
    echo "\n4. Testing full view rendering...\n";
    
    $content = $view->render();
    $contentLength = strlen($content);
    
    echo "   ✅ View rendered successfully!\n";
    echo "   Content length: " . number_format($contentLength) . " characters\n";
    
    // Check for common patterns
    if (strpos($content, 'สถิติข้อมูลทั้งหมด') !== false) {
        echo "   ✅ Statistics section found\n";
    }
    
    if (strpos($content, 'แผนที่มรดกทางวัฒนธรรม') !== false) {
        echo "   ✅ Cultural map section found\n";
    } else {
        echo "   ℹ️  Cultural map section not found (may be conditional)\n";
    }
    
    echo "\n🎉 ALL TESTS PASSED!\n";
    echo "The home page should work correctly now.\n";
    echo "\nNext steps:\n";
    echo "- Clear caches: php artisan view:clear && php artisan config:clear\n";
    echo "- Check web server configuration if still getting 500 errors\n";
    
} catch (Throwable $e) {
    echo "\n❌ ERROR FOUND:\n";
    echo "================\n";
    echo "Type: " . get_class($e) . "\n";
    echo "Message: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo "\nStack Trace:\n";
    echo $e->getTraceAsString() . "\n";
    
    // Specific error handling
    if ($e instanceof \Illuminate\View\ViewException) {
        echo "\n🔍 VIEW COMPILATION ERROR DETECTED\n";
        echo "This error occurred while compiling the Blade template.\n";
        echo "Check the syntax in: resources/views/frontend/home.blade.php\n";
        echo "Around line: " . $e->getLine() . "\n";
    }
    
    if (strpos($e->getMessage(), 'route') !== false) {
        echo "\n🔍 ROUTE ERROR DETECTED\n";
        echo "Check route names and parameters in the view.\n";
    }
    
    if (strpos($e->getMessage(), 'undefined') !== false) {
        echo "\n🔍 UNDEFINED VARIABLE/METHOD ERROR\n";
        echo "Check for typos in variable names or missing relationships.\n";
    }
}