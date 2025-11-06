<?php

echo "🚀 DEPLOYMENT READINESS CHECK\n";
echo "==============================\n\n";

// 1. Check PHP version compatibility
echo "1️⃣  PHP VERSION CHECK\n";
$phpVersion = PHP_VERSION;
echo "Current PHP: $phpVersion\n";
if (version_compare($phpVersion, '8.3.0', '>=')) {
    echo "✅ PHP 8.3+ requirement satisfied\n";
} else {
    echo "❌ PHP 8.3+ required for deployment\n";
}
echo "\n";

// 2. Check critical extensions
echo "2️⃣  CRITICAL EXTENSIONS CHECK\n";
$criticalExtensions = ['zip', 'mbstring', 'gd', 'pdo_mysql'];
$allCriticalLoaded = true;

foreach ($criticalExtensions as $ext) {
    if (extension_loaded($ext)) {
        echo "✅ $ext extension loaded\n";
    } else {
        echo "❌ $ext extension MISSING (CRITICAL)\n";
        $allCriticalLoaded = false;
    }
}

if ($allCriticalLoaded) {
    echo "✅ All critical extensions ready\n";
} else {
    echo "❌ Missing critical extensions will cause deployment failure\n";
}
echo "\n";

// 3. Check problematic packages
echo "3️⃣  DEPLOYMENT PACKAGES CHECK\n";
try {
    require_once __DIR__ . '/vendor/autoload.php';
    
    // Check ZipStream (the problem package)
    if (class_exists('ZipStream\ZipStream')) {
        echo "✅ ZipStream package (maennchen/zipstream-php)\n";
    } else {
        echo "❌ ZipStream package missing\n";
    }
    
    // Check PhpSpreadsheet
    if (class_exists('PhpOffice\PhpSpreadsheet\Spreadsheet')) {
        echo "✅ PhpSpreadsheet package (phpoffice/phpspreadsheet)\n";
    } else {
        echo "❌ PhpSpreadsheet package missing\n";
    }
    
    // Check Laravel Excel
    if (class_exists('Maatwebsite\Excel\Excel')) {
        echo "✅ Laravel Excel package (maatwebsite/excel)\n";
    } else {
        echo "❌ Laravel Excel package missing\n";
    }
    
} catch (Exception $e) {
    echo "❌ Package loading error: " . $e->getMessage() . "\n";
}
echo "\n";

// 4. Check composer.lock compatibility
echo "4️⃣  COMPOSER LOCK CHECK\n";
if (file_exists(__DIR__ . '/composer.lock')) {
    $lockData = json_decode(file_get_contents(__DIR__ . '/composer.lock'), true);
    
    // Check PHP requirement in lock file
    $phpRequirement = $lockData['platform']['php'] ?? 'not specified';
    echo "Lock file PHP requirement: $phpRequirement\n";
    
    // Find problematic packages in lock
    $packages = $lockData['packages'] ?? [];
    $problemPackages = ['maennchen/zipstream-php', 'phpoffice/phpspreadsheet', 'maatwebsite/excel'];
    
    foreach ($problemPackages as $packageName) {
        $found = false;
        foreach ($packages as $package) {
            if ($package['name'] === $packageName) {
                echo "✅ $packageName v{$package['version']} locked\n";
                $found = true;
                break;
            }
        }
        if (!$found) {
            echo "❌ $packageName not found in lock file\n";
        }
    }
    
    echo "✅ Composer lock file exists and valid\n";
} else {
    echo "❌ composer.lock missing - run 'composer install' first\n";
}
echo "\n";

// 5. Check Docker configuration
echo "5️⃣  DOCKER CONFIGURATION CHECK\n";
if (file_exists(__DIR__ . '/Dockerfile')) {
    $dockerfile = file_get_contents(__DIR__ . '/Dockerfile');
    
    if (strpos($dockerfile, 'php:8.3') !== false) {
        echo "✅ Dockerfile uses PHP 8.3\n";
    } else {
        echo "❌ Dockerfile not using PHP 8.3\n";
    }
    
    if (strpos($dockerfile, 'libzip-dev') !== false) {
        echo "✅ Dockerfile includes libzip-dev\n";
    } else {
        echo "❌ Dockerfile missing libzip-dev\n";
    }
    
    if (strpos($dockerfile, 'docker-php-ext-install') !== false && strpos($dockerfile, 'zip') !== false) {
        echo "✅ Dockerfile installs ZIP extension\n";
    } else {
        echo "❌ Dockerfile missing ZIP extension installation\n";
    }
    
} else {
    echo "❌ Dockerfile not found\n";
}
echo "\n";

// 6. Final deployment readiness
echo "6️⃣  DEPLOYMENT READINESS SUMMARY\n";
echo "===================================\n";

$phpOk = version_compare($phpVersion, '8.3.0', '>=');
$extensionsOk = $allCriticalLoaded;
$packagesOk = class_exists('ZipStream\ZipStream') && class_exists('PhpOffice\PhpSpreadsheet\Spreadsheet');
$dockerfileOk = file_exists(__DIR__ . '/Dockerfile') && 
    strpos(file_get_contents(__DIR__ . '/Dockerfile'), 'php:8.3') !== false;

if ($phpOk && $extensionsOk && $packagesOk && $dockerfileOk) {
    echo "🎉 READY FOR DEPLOYMENT!\n";
    echo "   All critical issues have been resolved.\n";
    echo "   The Railway deployment should now succeed.\n";
} else {
    echo "⚠️  NOT READY FOR DEPLOYMENT\n";
    echo "   Please fix the issues above before deploying.\n";
}

echo "\n💡 To deploy to Railway:\n";
echo "   git push origin main  # (if merged to main)\n";
echo "   # Or trigger Railway deployment manually\n\n";

echo "🔍 To test Docker build locally:\n";
echo "   docker build -t thonburi-culture .\n";
echo "   docker run --rm thonburi-culture php --version\n";
echo "\n";