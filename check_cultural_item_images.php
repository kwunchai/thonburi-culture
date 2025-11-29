<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Community;
use App\Models\CulturalItem;
use Illuminate\Support\Facades\Storage;

echo "=== ดึงรูปภาพจาก Cultural Items ของชุมชน ===\n\n";

$communities = Community::with(['culturalItems' => function($query) {
    $query->whereNotNull('image')->limit(1);
}])->take(10)->get();

foreach ($communities as $community) {
    echo "ID: {$community->id} - {$community->name}\n";
    
    $firstItem = $community->culturalItems->first();
    if ($firstItem && $firstItem->image) {
        echo "  Found cultural item image: {$firstItem->image}\n";
        echo "  Item: {$firstItem->title}\n";
        echo "  File exists: " . (Storage::exists($firstItem->image) ? 'YES' : 'NO') . "\n";
    } else {
        echo "  No cultural item with image\n";
    }
    
    echo "\n";
}
