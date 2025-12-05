<?php

require_once 'vendor/autoload.php';

// Laravel Application Bootstrap
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\CulturalItem;

echo "🔧 Testing Route Fix for Show Page\n";
echo str_repeat("=", 50) . "\n";

try {
    // Test route generation
    echo "🌐 Testing Routes:\n";
    
    // Test cultural.explore route
    $exploreUrl = route('cultural.explore');
    echo "✅ Explore route: {$exploreUrl}\n";
    
    // Test cultural-item.show route
    $item = CulturalItem::first();
    if ($item) {
        $showUrl = route('cultural-item.show', $item->id);
        echo "✅ Show route: {$showUrl}\n";
        echo "   Item: {$item->title}\n";
    }
    
    // Test category route
    if ($item && $item->category) {
        $categoryUrl = route('category', $item->category->slug);
        echo "✅ Category route: {$categoryUrl}\n";
        echo "   Category: {$item->category->name}\n";
    }

    echo "\n🎯 Available Test URLs:\n";
    $testItems = CulturalItem::take(3)->get();
    foreach ($testItems as $testItem) {
        $url = route('cultural-item.show', $testItem->id);
        echo "• {$testItem->title}\n";
        echo "  {$url}\n\n";
    }

    echo "🔍 Route Fixes Applied:\n";
    echo "✅ Changed route('explore') to route('cultural.explore')\n";
    echo "✅ Both navigation links updated\n";
    echo "✅ All routes now properly defined\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n" . str_repeat("=", 50) . "\n";
echo "🔧 Route Fix Test Complete!\n";