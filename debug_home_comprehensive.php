<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

try {
    echo "Testing Laravel Application...\n\n";
    
    // Test basic config
    echo "1. Application Environment: " . $app->environment() . "\n";
    echo "2. Debug Mode: " . (config('app.debug') ? 'ON' : 'OFF') . "\n";
    
    // Test database connection
    echo "\n3. Testing Database Connection...\n";
    $pdo = DB::connection()->getPdo();
    echo "   ✅ Database connected successfully\n";
    
    // Test CulturalItem model
    echo "\n4. Testing CulturalItem model...\n";
    $itemCount = App\Models\CulturalItem::count();
    echo "   ✅ Total cultural items: $itemCount\n";
    
    $itemsWithLocation = App\Models\CulturalItem::whereNotNull('latitude')->whereNotNull('longitude')->count();
    echo "   ✅ Items with location: $itemsWithLocation\n";
    
    // Test FrontendController
    echo "\n5. Testing FrontendController...\n";
    $controller = new App\Http\Controllers\FrontendController();
    $view = $controller->home();
    echo "   ✅ Controller executed successfully\n";
    
    $data = $view->getData();
    echo "   ✅ View data keys: " . implode(', ', array_keys($data)) . "\n";
    
    // Test view rendering
    echo "\n6. Testing view rendering...\n";
    $content = $view->render();
    echo "   ✅ View rendered successfully (length: " . strlen($content) . " chars)\n";
    
    echo "\n🎉 All tests passed! The application should work correctly.\n";
    
} catch (Throwable $e) {
    echo "\n❌ Error encountered:\n";
    echo "   Type: " . get_class($e) . "\n";
    echo "   Message: " . $e->getMessage() . "\n";
    echo "   File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo "   Stack trace:\n" . $e->getTraceAsString() . "\n";
    
    // If it's a view compilation error, show more details
    if ($e instanceof ErrorException && str_contains($e->getMessage(), 'view')) {
        echo "\n🔍 This appears to be a view compilation error.\n";
        echo "   Try clearing view cache: php artisan view:clear\n";
    }
}