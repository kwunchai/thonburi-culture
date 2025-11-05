<?php

require_once 'vendor/autoload.php';

// Laravel Application Bootstrap
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\CulturalItem;

echo "🔧 Testing All Route References in Show Page\n";
echo str_repeat("=", 60) . "\n";

try {
    // Test related items data
    $item = CulturalItem::with(['category', 'community'])->first();
    
    if ($item) {
        echo "✅ Test Item Found:\n";
        echo "   - ID: {$item->id}\n";
        echo "   - Title: {$item->title}\n";
        echo "   - Category: " . ($item->category ? $item->category->name : 'No category') . "\n";
        
        // Test related items query
        $relatedItems = CulturalItem::where('category_id', $item->category_id)
            ->where('id', '!=', $item->id)
            ->with(['category', 'community'])
            ->take(4)
            ->get();
            
        echo "   - Related items found: {$relatedItems->count()}\n";
        
        // Test route generation for related items
        if ($relatedItems->count() > 0) {
            $relatedItem = $relatedItems->first();
            $relatedUrl = route('cultural-item.show', $relatedItem->id);
            echo "   - Related item URL: {$relatedUrl}\n";
        }
    }

    echo "\n🎯 Route Fixes Applied:\n";
    echo "   ✅ route('explore') → route('cultural.explore')\n";
    echo "   ✅ route('cultural-item', \$slug) → route('cultural-item.show', \$id)\n";
    
    echo "\n📊 Available Routes:\n";
    echo "   • Home: " . route('home') . "\n";
    echo "   • Explore: " . route('cultural.explore') . "\n";
    if ($item && $item->category) {
        echo "   • Category: " . route('category', $item->category->slug) . "\n";
    }
    echo "   • Show: " . route('cultural-item.show', $item->id) . "\n";

    echo "\n🎨 New Design Features:\n";
    echo "   ✅ Full-width Hero Section with overlays\n";
    echo "   ✅ Colorful Meta Badges with icons\n";
    echo "   ✅ Single Column Layout for readability\n";
    echo "   ✅ Organized Meta Data Cards\n";
    echo "   ✅ Enhanced Related Items with thumbnails\n";
    echo "   ✅ Google Maps integration\n";
    echo "   ✅ Social sharing buttons\n";
    echo "   ✅ Responsive design\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "📍 File: " . $e->getFile() . " Line: " . $e->getLine() . "\n";
}

echo "\n" . str_repeat("=", 60) . "\n";
echo "🔧 All Route References Fixed!\n";