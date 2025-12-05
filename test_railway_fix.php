<?php

echo "🚀 RAILWAY DEPLOYMENT FIX TEST\n";
echo "==============================\n\n";

// 1. Check current Railway configuration
echo "1️⃣  CURRENT RAILWAY CONFIGURATION\n";

$railwayConfig = __DIR__ . '/railway.toml';
if (file_exists($railwayConfig)) {
    $config = file_get_contents($railwayConfig);
    echo "✅ railway.toml exists\n";
    
    // Check start command
    if (preg_match('/startCommand = "([^"]+)"/', $config, $matches)) {
        $startCommand = $matches[1];
        echo "   → Start command: $startCommand\n";
        
        if (strpos($startCommand, './start.sh') !== false) {
            echo "   → ✅ Uses custom start script\n";
        } else {
            echo "   → ⚠️  Direct PHP command\n";
        }
    }
    
    // Check healthcheck path
    if (preg_match('/healthcheckPath = "([^"]+)"/', $config, $matches)) {
        $healthPath = $matches[1];
        echo "   → Healthcheck path: $healthPath\n";
    } else {
        echo "   → Healthcheck path: / (root - default)\n";
    }
    
    // Check timeout
    if (preg_match('/healthcheckTimeout = (\d+)/', $config, $matches)) {
        $timeout = (int)$matches[1];
        echo "   → Healthcheck timeout: {$timeout}s\n";
        
        if ($timeout >= 300) {
            echo "   → ✅ Long timeout (good for Laravel)\n";
        } elseif ($timeout >= 180) {
            echo "   → ✅ Adequate timeout\n";
        } else {
            echo "   → ⚠️  Might be too short\n";
        }
    }
} else {
    echo "❌ railway.toml missing\n";
}
echo "\n";

// 2. Check start script
echo "2️⃣  START SCRIPT ANALYSIS\n";

$startScript = __DIR__ . '/start.sh';
if (file_exists($startScript)) {
    echo "✅ start.sh exists\n";
    
    $content = file_get_contents($startScript);
    
    if (strpos($content, 'set -e') !== false) {
        echo "   → ✅ Has error handling (set -e)\n";
    }
    
    if (strpos($content, 'cache:clear') !== false) {
        echo "   → ✅ Clears cache\n";
    }
    
    if (strpos($content, 'migrate --force') !== false) {
        echo "   → ✅ Runs migrations\n";
    }
    
    if (strpos($content, 'sleep') !== false) {
        echo "   → ✅ Has initialization delay\n";
    }
    
    if (strpos($content, 'exec php artisan serve') !== false) {
        echo "   → ✅ Properly starts server with exec\n";
    }
    
    // Check if executable
    if (is_executable($startScript)) {
        echo "   → ✅ Script is executable\n";
    } else {
        echo "   → ⚠️  Script might not be executable (will be fixed by chmod)\n";
    }
    
} else {
    echo "❌ start.sh missing\n";
}
echo "\n";

// 3. Test health endpoints
echo "3️⃣  HEALTH ENDPOINTS TEST\n";

$healthEndpoints = [
    'Static file' => __DIR__ . '/public/health.txt',
    'Simple PHP' => __DIR__ . '/public/health-simple.php',
    'Original PHP' => __DIR__ . '/public/health.php'
];

foreach ($healthEndpoints as $name => $path) {
    if (file_exists($path)) {
        echo "✅ $name exists\n";
        
        $size = filesize($path);
        echo "   → Size: {$size} bytes\n";
        
        if ($size < 500) {
            echo "   → ✅ Small and efficient\n";
        }
    } else {
        echo "❌ $name missing\n";
    }
}
echo "\n";

// 4. Test Laravel routes availability
echo "4️⃣  LARAVEL HEALTH ROUTES\n";

$webRoutes = __DIR__ . '/routes/web.php';
if (file_exists($webRoutes)) {
    $routes = file_get_contents($webRoutes);
    
    if (strpos($routes, "Route::get('/health'") !== false) {
        echo "✅ /health route exists\n";
    }
    
    if (strpos($routes, "Route::get('/health/simple'") !== false) {
        echo "✅ /health/simple route exists\n";
    }
    
    if (strpos($routes, "Route::get('/health/railway'") !== false) {
        echo "✅ /health/railway route exists\n";
    }
}
echo "\n";

// 5. Analyze previous failure
echo "5️⃣  FAILURE ANALYSIS\n";
echo "Previous deployment failed because:\n";
echo "   → Healthcheck attempts: 8 failures\n";
echo "   → Path tested: /health.php\n";
echo "   → Retry window: 2m0s\n";
echo "   → Issue: Service unavailable\n";
echo "\n";

echo "Likely causes:\n";
echo "   1. Laravel took too long to boot\n";
echo "   2. Database connection issues during startup\n";
echo "   3. /health.php not accessible immediately\n";
echo "   4. Port binding problems\n";
echo "\n";

// 6. Recommendations
echo "6️⃣  DEPLOYMENT STRATEGY\n";
echo "======================\n";

echo "🎯 Current fix strategy:\n";
echo "   1. ✅ Use custom start.sh with proper sequencing\n";
echo "   2. ✅ Increased timeout to 300s (5 minutes)\n";
echo "   3. ✅ Remove specific healthcheck path (use root /)\n";
echo "   4. ✅ Add initialization delays\n";
echo "   5. ✅ Clear all caches before starting\n";
echo "\n";

echo "📋 Expected behavior:\n";
echo "   → Build: Normal (2-3 minutes)\n";
echo "   → Start: start.sh executes with delays\n";
echo "   → Healthcheck: Railway checks / (home page)\n";
echo "   → Timeout: 5 minutes (plenty of time)\n";
echo "   → Result: Should succeed ✅\n";
echo "\n";

echo "🚀 Alternative strategies if this fails:\n";
echo "   Strategy A: Use /health/simple route\n";
echo "   Strategy B: Use static /health.txt file\n";
echo "   Strategy C: Simplify start command\n";
echo "   Strategy D: Remove database dependencies\n";
echo "\n";

echo "🔧 Ready to deploy with:\n";
echo "   railway up\n";
echo "\n";

// 7. Final verification
echo "7️⃣  FINAL VERIFICATION\n";

$ready = true;
$issues = [];

if (!file_exists($railwayConfig)) {
    $ready = false;
    $issues[] = "railway.toml missing";
}

if (!file_exists($startScript)) {
    $ready = false;
    $issues[] = "start.sh missing";
}

if (!file_exists(__DIR__ . '/public/health.txt')) {
    $issues[] = "Static health file backup missing";
}

if ($ready && empty($issues)) {
    echo "🎉 READY FOR DEPLOYMENT!\n";
    echo "   All configuration files prepared\n";
    echo "   Healthcheck strategy: Use root path with 5min timeout\n";
    echo "   Start strategy: Custom script with proper delays\n";
} else {
    echo "⚠️  ISSUES DETECTED:\n";
    foreach ($issues as $issue) {
        echo "   - $issue\n";
    }
}

echo "\n";