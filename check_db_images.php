<?php
/**
 * Check Database Images - Simple Query
 */
echo "🔍 Checking Database for Images\n";
echo "===============================\n\n";

// Connect to database using PDO
try {
    $host = '127.0.0.1';
    $dbname = 'thonburi_culture';
    $username = 'root';
    $password = '';
    
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✓ Database connected successfully\n\n";
    
    // Get cultural items with images
    $sql = "SELECT id, title, image, is_featured FROM cultural_items WHERE image IS NOT NULL ORDER BY is_featured DESC, id ASC LIMIT 10";
    $stmt = $pdo->query($sql);
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "📊 Cultural Items with Images (" . count($items) . " items):\n";
    echo "==================================================\n";
    
    foreach ($items as $item) {
        $featured = $item['is_featured'] ? '⭐ Featured' : '  Regular';
        echo "ID: {$item['id']} | {$featured}\n";
        echo "Title: {$item['title']}\n";
        echo "Image: {$item['image']}\n";
        
        // Check if file exists
        $imagePath = __DIR__ . '/storage/app/public/' . $item['image'];
        $publicPath = __DIR__ . '/public/storage/' . $item['image'];
        
        echo "Storage file: " . (file_exists($imagePath) ? '✓' : '❌') . " {$imagePath}\n";
        echo "Public file:  " . (file_exists($publicPath) ? '✓' : '❌') . " {$publicPath}\n";
        echo "Expected URL: http://thonburi-culture.test/storage/{$item['image']}\n";
        echo "---\n";
    }
    
    // Check featured items specifically
    echo "\n⭐ Featured Items Status:\n";
    echo "========================\n";
    $featuredSql = "SELECT id, title, image, featured_order FROM cultural_items WHERE is_featured = 1 ORDER BY featured_order ASC";
    $featuredStmt = $pdo->query($featuredSql);
    $featuredItems = $featuredStmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Total featured items: " . count($featuredItems) . "\n";
    echo "Featured items with images: " . count(array_filter($featuredItems, fn($item) => !empty($item['image']))) . "\n\n";
    
    foreach ($featuredItems as $item) {
        $hasImage = !empty($item['image']);
        echo "#{$item['featured_order']}: {$item['title']} - " . ($hasImage ? '✓ Has image' : '❌ No image') . "\n";
        if ($hasImage) {
            echo "    Image: {$item['image']}\n";
        }
    }
    
} catch (PDOException $e) {
    echo "❌ Database error: " . $e->getMessage() . "\n";
    echo "💡 Make sure your database is running and credentials are correct in .env\n";
}

echo "\n📅 Check completed at: " . date('Y-m-d H:i:s') . "\n";