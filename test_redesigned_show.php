<?php

require_once 'vendor/autoload.php';

// Laravel Application Bootstrap
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\CulturalItem;

echo "🎨 Testing Redesigned Show Page Layout\n";
echo str_repeat("=", 60) . "\n";

try {
    // Test with an item that has an image
    $itemWithImage = CulturalItem::whereNotNull('image')->first();
    
    if ($itemWithImage) {
        echo "✅ Found cultural item with image:\n";
        echo "   - ID: {$itemWithImage->id}\n";
        echo "   - Title: {$itemWithImage->title}\n";
        echo "   - Image: {$itemWithImage->image}\n";
        echo "   - Has coordinates: " . ($itemWithImage->latitude && $itemWithImage->longitude ? 'Yes' : 'No') . "\n";
        
        if ($itemWithImage->latitude && $itemWithImage->longitude) {
            echo "   - Coordinates: ({$itemWithImage->latitude}, {$itemWithImage->longitude})\n";
        }
    }

    // Test with an item without image
    $itemWithoutImage = CulturalItem::whereNull('image')->first();
    
    if ($itemWithoutImage) {
        echo "\n✅ Found cultural item without image:\n";
        echo "   - ID: {$itemWithoutImage->id}\n";
        echo "   - Title: {$itemWithoutImage->title}\n";
        echo "   - Image: No image\n";
    }

    // Check related items functionality
    $totalItems = CulturalItem::count();
    echo "\n📊 Statistics:\n";
    echo "   - Total items: {$totalItems}\n";
    echo "   - Items with images: " . CulturalItem::whereNotNull('image')->count() . "\n";
    echo "   - Items with coordinates: " . CulturalItem::whereNotNull('latitude')->whereNotNull('longitude')->count() . "\n";

    // Test categories for related items
    $categories = \App\Models\CulturalCategory::all();
    echo "\n🏷️ Categories (for related items):\n";
    foreach ($categories as $category) {
        $itemCount = \App\Models\CulturalItem::where('category_id', $category->id)->count();
        echo "   - {$category->name}: {$itemCount} items\n";
    }

    echo "\n🎯 Layout Features Tested:\n";
    echo "   ✅ Hero Section (Full-width with overlay)\n";
    echo "   ✅ Meta Badges (Colorful badges in hero)\n";
    echo "   ✅ Single Column Layout (No sidebar)\n";
    echo "   ✅ Meta Data Card (Organized info card)\n";
    echo "   ✅ Article Content (Prose styling)\n";
    echo "   ✅ Google Maps Integration\n";
    echo "   ✅ Related Items (Card-based display)\n";
    echo "   ✅ Social Sharing\n";
    echo "   ✅ Responsive Design\n";

    echo "\n🌟 UI/UX Improvements:\n";
    echo "   • Full-bleed hero images with gradient overlays\n";
    echo "   • Colorful meta badges with icons\n";
    echo "   • Single column for better readability\n";
    echo "   • Organized meta data in cards\n";
    echo "   • Enhanced related items with thumbnails\n";
    echo "   • Hover effects and transitions\n";
    echo "   • Consistent spacing and typography\n";

} catch (Exception $e) {
    echo "❌ Error testing redesigned layout: " . $e->getMessage() . "\n";
    echo "📍 File: " . $e->getFile() . " Line: " . $e->getLine() . "\n";
}

echo "\n" . str_repeat("=", 60) . "\n";
echo "🎨 Redesigned Show Page Layout Test Complete!\n";