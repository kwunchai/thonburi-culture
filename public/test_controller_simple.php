<?php
echo "Cultural Items Controller Test Page\n";
echo "===================================\n";

// Check if file exists
$controller_file = '../app/Http/Controllers/Admin/CulturalItemController.php';
if (file_exists($controller_file)) {
    echo "✓ Controller file exists\n";
} else {
    echo "✗ Controller file not found\n";
}

// Check class structure
if (file_exists($controller_file)) {
    $content = file_get_contents($controller_file);
    
    if (strpos($content, 'class CulturalItemController') !== false) {
        echo "✓ Controller class found\n";
    } else {
        echo "✗ Controller class not found\n";
    }
    
    if (strpos($content, 'public function index') !== false) {
        echo "✓ index() method found\n";
    } else {
        echo "✗ index() method not found\n";
    }
    
    if (strpos($content, 'public function export') !== false) {
        echo "✓ export() method found\n";
    } else {
        echo "✗ export() method not found\n";
    }
    
    // Count export methods
    $export_count = substr_count($content, 'public function export');
    echo "Found {$export_count} export method(s)\n";
    
    if ($export_count > 1) {
        echo "⚠️ WARNING: Multiple export methods detected!\n";
    }
}

echo "\nTest completed.\n";
?>