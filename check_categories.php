<?php

require 'vendor/autoload.php';

use App\Models\CulturalCategory;

$app = require 'bootstrap/app.php';
$app->boot();

echo "All Categories:\n";
echo "====================\n";

$categories = CulturalCategory::all();

foreach($categories as $cat) {
    $slug = $cat->slug ?? 'NULL';
    echo "ID: {$cat->id} | Name: {$cat->name} | Slug: {$slug}\n";
}

echo "\nTotal categories: " . $categories->count() . "\n";
echo "Categories with slugs: " . $categories->where('slug', '!=', null)->count() . "\n";
echo "Categories without slugs: " . $categories->where('slug', null)->count() . "\n";