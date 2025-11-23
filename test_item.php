<?php
// Simple test page
require_once __DIR__.'/bootstrap/app.php';

$app = Illuminate\Foundation\Application::getInstance();
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

try {
    echo "Testing database connection...\n";
    $item = \App\Models\CulturalItem::find(13);
    
    if (!$item) {
        echo "❌ Cultural item #13 not found\n";
        exit;
    }
    
    echo "✅ Cultural item found: " . $item->title . "\n";
    
    // Test relationships
    echo "Testing relationships...\n";
    
    if ($item->category) {
        echo "✅ Category: " . $item->category->name . "\n";
    } else {
        echo "⚠️ No category\n";
    }
    
    if ($item->community) {
        echo "✅ Community: " . $item->community->name . "\n"; 
    } else {
        echo "⚠️ No community\n";
    }
    
    if ($item->creator) {
        echo "✅ Creator: " . $item->creator->name . "\n";
    } else {
        echo "⚠️ No creator\n";
    }
    
    if ($item->place) {
        echo "✅ Place: " . ($item->place->name ?? 'No name') . "\n";
    } else {
        echo "⚠️ No place\n";
    }
    
    echo "\nAll tests passed! ✅\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " Line: " . $e->getLine() . "\n";
}