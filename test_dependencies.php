<?php

// Test dependencies compatibility
echo "Testing PHP version and extensions...\n";
echo "PHP Version: " . PHP_VERSION . "\n";

// Test required extensions
$required_extensions = [
    'zip', 'mbstring', 'gd', 'pdo_mysql', 'bcmath', 'exif', 'pcntl'
];

foreach ($required_extensions as $ext) {
    if (extension_loaded($ext)) {
        echo "✅ Extension '$ext' is loaded\n";
    } else {
        echo "❌ Extension '$ext' is NOT loaded\n";
    }
}

// Test Composer packages
echo "\nTesting Composer packages...\n";

try {
    require_once __DIR__ . '/vendor/autoload.php';
    echo "✅ Composer autoloader loaded successfully\n";
    
    // Test specific packages
    if (class_exists('ZipStream\ZipStream')) {
        echo "✅ ZipStream package loaded\n";
    } else {
        echo "❌ ZipStream package NOT found\n";
    }
    
    if (class_exists('PhpOffice\PhpSpreadsheet\Spreadsheet')) {
        echo "✅ PhpSpreadsheet package loaded\n";
    } else {
        echo "❌ PhpSpreadsheet package NOT found\n";
    }
    
    if (class_exists('Maatwebsite\Excel\Excel')) {
        echo "✅ Laravel Excel package loaded\n";
    } else {
        echo "❌ Laravel Excel package NOT found\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error loading Composer packages: " . $e->getMessage() . "\n";
}

echo "\nTest completed!\n";