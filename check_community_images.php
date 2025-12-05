<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Community;
use Illuminate\Support\Facades\Storage;

echo "=== ตรวจสอบรูปภาพชุมชน ===\n\n";

$communities = Community::take(10)->get();

foreach ($communities as $community) {
    echo "ID: {$community->id}\n";
    echo "Name: {$community->name}\n";
    echo "Image field: " . ($community->image ?? 'NULL') . "\n";
    
    if ($community->image) {
        echo "Full URL: " . Storage::url($community->image) . "\n";
        echo "File exists: " . (Storage::exists($community->image) ? 'YES' : 'NO') . "\n";
        echo "Full path: " . Storage::path($community->image) . "\n";
    } else {
        echo "No image set\n";
    }
    
    echo "---\n";
}

echo "\n=== ตรวจสอบ Storage Config ===\n";
echo "Default disk: " . config('filesystems.default') . "\n";
echo "Public URL: " . config('filesystems.disks.public.url') . "\n";
echo "Public root: " . config('filesystems.disks.public.root') . "\n";
