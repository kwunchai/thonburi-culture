<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== ตรวจสอบ Column Names ===\n";
$columns = \Illuminate\Support\Facades\Schema::getColumnListing('cultural_items');
echo "Columns in cultural_items table:\n";
foreach($columns as $column) {
    echo "- {$column}\n";
}

echo "\n=== ตรวจสอบการ Query แบบที่ Controller ใช้ ===\n";
// ใช้ query แบบเดียวกับใน Controller
$query = \App\Models\CulturalItem::with(['category', 'community', 'creator'])
    ->published();

echo "Query SQL: " . $query->toSql() . "\n";
echo "Query count: " . $query->count() . "\n";

// ตรวจสอบ relation
echo "\n=== ตรวจสอบ Relations ===\n";
$item = \App\Models\CulturalItem::first();
if($item) {
    echo "Item: {$item->title}\n";
    echo "Category: " . ($item->category ? $item->category->name : 'NULL') . "\n";
    echo "Community: " . ($item->community ? $item->community->name : 'NULL') . "\n";
    echo "Status: {$item->status}\n";
    echo "Is Featured: " . ($item->is_featured ? 'Yes' : 'No') . "\n";
}

// ตรวจสอบ scope published
echo "\n=== ตรวจสอบ Published Scope ===\n";
$allItems = \App\Models\CulturalItem::all();
echo "All items count: " . $allItems->count() . "\n";
foreach($allItems as $item) {
    echo "- {$item->title} (status: {$item->status})\n";
}