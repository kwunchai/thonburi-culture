<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Community;
use Illuminate\Support\Facades\Storage;

echo "=== ตรวจสอบ gallery_images ของชุมชน ===\n\n";

$communities = Community::whereNotNull('gallery_images')->take(5)->get();

foreach ($communities as $community) {
    echo "ID: {$community->id}\n";
    echo "Name: {$community->name}\n";
    echo "Gallery Images (raw): " . $community->getRawOriginal('gallery_images') . "\n";
    
    $galleryImages = $community->gallery_images;
    if (is_string($galleryImages)) {
        $galleryImages = json_decode($galleryImages, true);
    }
    
    if (!empty($galleryImages) && is_array($galleryImages)) {
        echo "Gallery Images (decoded): " . print_r($galleryImages, true) . "\n";
        $firstImage = $galleryImages[0] ?? null;
        if ($firstImage) {
            echo "First Image: {$firstImage}\n";
            echo "Full URL: " . Storage::url($firstImage) . "\n";
            echo "File exists: " . (Storage::exists($firstImage) ? 'YES' : 'NO') . "\n";
        }
    } else {
        echo "No gallery images\n";
    }
    
    echo "---\n\n";
}
