<?php
/**
 * Test Image Display - Thonburi Culture
 * ทดสอบการแสดงรูปภาพ
 */

require_once __DIR__ . '/vendor/autoload.php';

echo "🖼️ Testing Image Display\n";
echo "========================\n\n";

try {
    // Check cultural items with images
    $itemsWithImages = \App\Models\CulturalItem::whereNotNull('image')
                       ->take(5)
                       ->get(['id', 'title', 'image']);
    
    echo "📊 Items with images:\n";
    foreach ($itemsWithImages as $item) {
        echo "  ID: {$item->id}\n";
        echo "  Title: {$item->title}\n";
        echo "  Image: {$item->image}\n";
        
        // Check if file exists
        $imagePath = storage_path('app/public/' . $item->image);
        $publicPath = public_path('storage/' . $item->image);
        
        echo "  Storage path: " . ($imagePath ? '✓' : '❌') . " {$imagePath}\n";
        echo "  File exists in storage: " . (file_exists($imagePath) ? '✓' : '❌') . "\n";
        echo "  Public path: " . ($publicPath ? '✓' : '❌') . " {$publicPath}\n";
        echo "  File exists in public: " . (file_exists($publicPath) ? '✓' : '❌') . "\n";
        echo "  Expected URL: " . asset('storage/' . $item->image) . "\n";
        echo "  ---\n";
    }
    
    // Check storage link
    echo "\n🔗 Storage Link Status:\n";
    $publicStoragePath = public_path('storage');
    $storageAppPublicPath = storage_path('app/public');
    
    echo "  Public storage dir exists: " . (is_dir($publicStoragePath) ? '✓' : '❌') . "\n";
    echo "  Storage app/public exists: " . (is_dir($storageAppPublicPath) ? '✓' : '❌') . "\n";
    echo "  Link is working: " . (is_link($publicStoragePath) ? '✓' : '❌') . "\n";
    
    // Check specific image files
    echo "\n📁 Sample Image Files:\n";
    $culturalItemsDir = $storageAppPublicPath . '/cultural-items';
    if (is_dir($culturalItemsDir)) {
        $files = array_slice(scandir($culturalItemsDir), 2, 3); // Skip . and ..
        foreach ($files as $file) {
            if ($file !== '.gitignore') {
                $fullPath = $culturalItemsDir . '/' . $file;
                $size = file_exists($fullPath) ? filesize($fullPath) : 0;
                echo "  {$file}: " . ($size > 0 ? "✓ {$size} bytes" : "❌ Missing") . "\n";
            }
        }
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n💡 Troubleshooting:\n";
echo "1. Make sure symbolic link exists: php artisan storage:link\n";
echo "2. Check file permissions in storage/app/public/\n";
echo "3. Verify web server can access public/storage/\n";
echo "4. Clear browser cache if needed\n";

echo "\n📅 Test completed at: " . date('Y-m-d H:i:s') . "\n";