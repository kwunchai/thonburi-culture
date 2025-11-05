<?php
/**
 * Quick Test - Simple Conflict Check
 * สำหรับระบบ Thonburi Culture IP Management
 */

require_once __DIR__ . '/vendor/autoload.php';

echo "🔧 Thonburi Culture - Quick Conflict Test\n";
echo "==========================================\n\n";

$issues = [];
$rootPath = __DIR__;

// Test 1: Check Models
echo "📊 Testing Models...\n";
try {
    if (class_exists('App\Models\IntellectualProperty')) {
        $ip = new \App\Models\IntellectualProperty();
        echo "  ✓ IntellectualProperty model exists\n";
        echo "  ✓ Route key: " . $ip->getRouteKeyName() . "\n";
    } else {
        $issues[] = "IntellectualProperty model not found";
        echo "  ❌ IntellectualProperty model missing\n";
    }

    if (class_exists('App\Models\CulturalItem')) {
        $cultural = new \App\Models\CulturalItem();
        echo "  ✓ CulturalItem model exists\n";
        echo "  ✓ Route key: " . $cultural->getRouteKeyName() . "\n";
    } else {
        $issues[] = "CulturalItem model not found";
        echo "  ❌ CulturalItem model missing\n";
    }
} catch (Exception $e) {
    $issues[] = "Model error: " . $e->getMessage();
    echo "  ❌ Model error: " . $e->getMessage() . "\n";
}

// Test 2: Check Enums
echo "\n📋 Testing Enums...\n";
try {
    if (enum_exists('App\Enums\IpType')) {
        echo "  ✓ IpType enum exists\n";
        $cases = \App\Enums\IpType::cases();
        echo "  ✓ IpType cases: " . count($cases) . " found\n";
        foreach ($cases as $case) {
            echo "    - {$case->name}: {$case->label()}\n";
        }
    } else {
        $issues[] = "IpType enum not found";
        echo "  ❌ IpType enum missing\n";
    }

    if (enum_exists('App\Enums\IpStatus')) {
        echo "  ✓ IpStatus enum exists\n";
        $cases = \App\Enums\IpStatus::cases();
        echo "  ✓ IpStatus cases: " . count($cases) . " found\n";
        foreach ($cases as $case) {
            echo "    - {$case->name}: {$case->label()}\n";
        }
    } else {
        $issues[] = "IpStatus enum not found";
        echo "  ❌ IpStatus enum missing\n";
    }
} catch (Exception $e) {
    $issues[] = "Enum error: " . $e->getMessage();
    echo "  ❌ Enum error: " . $e->getMessage() . "\n";
}

// Test 3: Check Views
echo "\n🎨 Testing Views...\n";
$viewPaths = [
    'resources/views/frontend/explore.blade.php',
    'resources/views/layouts/frontend.blade.php',
    'resources/views/layouts/admin.blade.php',
    'resources/views/pagination/thai.blade.php',
];

foreach ($viewPaths as $viewPath) {
    $fullPath = $rootPath . '/' . $viewPath;
    if (file_exists($fullPath)) {
        echo "  ✓ {$viewPath} exists\n";
    } else {
        $issues[] = "View missing: {$viewPath}";
        echo "  ❌ {$viewPath} missing\n";
    }
}

// Test 4: Check Routes
echo "\n🌐 Testing Routes...\n";
$routeFile = $rootPath . '/routes/web.php';
if (file_exists($routeFile)) {
    echo "  ✓ Route file exists\n";
    $content = file_get_contents($routeFile);
    
    // Check for key routes
    $routeChecks = [
        'cultural.explore' => 'Cultural explore route',
        'cultural-item.show' => 'Cultural item show route',
        'home' => 'Home route',
    ];
    
    foreach ($routeChecks as $route => $description) {
        if (strpos($content, $route) !== false) {
            echo "  ✓ {$description} found\n";
        } else {
            echo "  ⚠️  {$description} not found\n";
        }
    }
} else {
    $issues[] = "Route file missing";
    echo "  ❌ Route file missing\n";
}

// Test 5: Check Database Migrations
echo "\n🗄️  Testing Migrations...\n";
$migrationPath = $rootPath . '/database/migrations';
if (is_dir($migrationPath)) {
    $migrations = glob($migrationPath . '/*.php');
    echo "  ✓ Migration directory exists\n";
    echo "  ✓ Found " . count($migrations) . " migration files\n";
    
    // Check for important migrations
    $importantMigrations = [
        'cultural_items',
        'communities',
        'cultural_categories',
        'intellectual_properties',
    ];
    
    foreach ($importantMigrations as $table) {
        $found = false;
        foreach ($migrations as $migration) {
            if (strpos($migration, $table) !== false) {
                echo "  ✓ {$table} migration found\n";
                $found = true;
                break;
            }
        }
        if (!$found) {
            echo "  ⚠️  {$table} migration not found\n";
        }
    }
} else {
    $issues[] = "Migration directory missing";
    echo "  ❌ Migration directory missing\n";
}

// Test 6: Check Assets
echo "\n📦 Testing Assets...\n";
$assetPaths = [
    'public/build',
    'resources/css/app.css',
    'resources/js/app.js',
    'package.json',
    'vite.config.js',
];

foreach ($assetPaths as $assetPath) {
    $fullPath = $rootPath . '/' . $assetPath;
    if (file_exists($fullPath) || is_dir($fullPath)) {
        echo "  ✓ {$assetPath} exists\n";
    } else {
        echo "  ⚠️  {$assetPath} missing\n";
    }
}

// Test 7: Check Services and Policies
echo "\n⚙️  Testing Services & Policies...\n";
$classes = [
    'App\Services\IntellectualPropertyService' => 'IP Service',
    'App\Policies\IntellectualPropertyPolicy' => 'IP Policy',
];

foreach ($classes as $className => $description) {
    if (class_exists($className)) {
        echo "  ✓ {$description} exists\n";
    } else {
        echo "  ⚠️  {$description} missing\n";
    }
}

// Summary
echo "\n📋 SUMMARY\n";
echo "===========\n";

if (empty($issues)) {
    echo "🎉 All tests passed! No critical issues found.\n";
    echo "✅ System appears to be healthy.\n";
} else {
    echo "⚠️  Found " . count($issues) . " issues:\n";
    foreach ($issues as $issue) {
        echo "  - {$issue}\n";
    }
    echo "\n💡 Recommendation: Review and fix the issues above.\n";
}

echo "\n🚀 Additional Tests to Run:\n";
echo "  1. php artisan route:list\n";
echo "  2. php artisan migrate:status\n";
echo "  3. vendor\\bin\\pest (if tests exist)\n";
echo "  4. php artisan config:clear\n";

echo "\n📅 Test completed at: " . date('Y-m-d H:i:s') . "\n";