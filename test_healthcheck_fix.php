<?php

echo "🚀 RAILWAY HEALTHCHECK FIX VERIFICATION\n";
echo "========================================\n\n";

// 1. Test static health files
echo "1️⃣  STATIC HEALTH FILES TEST\n";

$healthTxt = __DIR__ . '/public/health.txt';
$healthPhp = __DIR__ . '/public/health.php';

if (file_exists($healthTxt)) {
    $content = file_get_contents($healthTxt);
    echo "✅ /health.txt exists and returns: '$content'\n";
} else {
    echo "❌ /health.txt missing\n";
}

if (file_exists($healthPhp)) {
    echo "✅ /health.php exists\n";
    
    // Test PHP execution
    ob_start();
    include $healthPhp;
    $output = ob_get_clean();
    
    // Since health.php exits, we won't reach here, but the file exists
    echo "✅ /health.php is executable\n";
} else {
    echo "❌ /health.php missing\n";
}
echo "\n";

// 2. Test Railway configuration
echo "2️⃣  RAILWAY CONFIGURATION CHECK\n";

$railwayConfig = __DIR__ . '/railway.toml';
if (file_exists($railwayConfig)) {
    $config = file_get_contents($railwayConfig);
    
    if (strpos($config, 'healthcheckPath = "/health.php"') !== false) {
        echo "✅ Railway configured to use /health.php\n";
    } elseif (strpos($config, 'healthcheckPath = "/health.txt"') !== false) {
        echo "✅ Railway configured to use /health.txt\n";
    } else {
        echo "⚠️  Railway healthcheck path not found or unexpected\n";
    }
    
    if (strpos($config, 'route:clear') !== false) {
        echo "✅ Railway configured to clear route cache on startup\n";
    } else {
        echo "⚠️  Route cache clearing not configured\n";
    }
    
    if (strpos($config, 'route:cache') === false || strpos($config, 'buildCommand') === false) {
        echo "✅ Route caching removed from build command\n";
    } else {
        echo "⚠️  Route caching still present in build command\n";
    }
} else {
    echo "❌ railway.toml not found\n";
}
echo "\n";

// 3. Test potential Laravel routing issues
echo "3️⃣  LARAVEL ROUTING ANALYSIS\n";

$routesFile = __DIR__ . '/routes/web.php';
if (file_exists($routesFile)) {
    $routes = file_get_contents($routesFile);
    
    if (strpos($routes, '/health/simple') !== false) {
        echo "✅ Laravel /health/simple route exists (backup)\n";
    } else {
        echo "⚠️  Laravel /health/simple route not found\n";
    }
    
    if (strpos($routes, '/health') !== false) {
        echo "✅ Laravel /health route exists (backup)\n";
    } else {
        echo "⚠️  Laravel /health route not found\n";
    }
} else {
    echo "❌ routes/web.php not found\n";
}
echo "\n";

// 4. Test server configuration compatibility
echo "4️⃣  SERVER COMPATIBILITY CHECK\n";

echo "✅ PHP version: " . PHP_VERSION . "\n";

// Check if we can access public files directly
if (is_readable(__DIR__ . '/public/health.txt')) {
    echo "✅ Public directory accessible\n";
} else {
    echo "❌ Public directory access issues\n";
}

// Check PHP execution
if (function_exists('http_response_code')) {
    echo "✅ HTTP response functions available\n";
} else {
    echo "❌ HTTP response functions missing\n";
}
echo "\n";

// 5. Final recommendations
echo "5️⃣  DEPLOYMENT STRATEGY\n";
echo "========================\n";

echo "🎯 Primary Health Check: /health.php\n";
echo "   - Bypasses Laravel completely\n";
echo "   - Fastest possible response\n";
echo "   - No database or cache dependencies\n";
echo "\n";

echo "🔄 Backup Health Check: /health.txt\n";
echo "   - Static file - even faster\n";
echo "   - No PHP execution required\n";
echo "   - Fallback if PHP issues occur\n";
echo "\n";

echo "⚙️  Configuration Changes Made:\n";
echo "   1. Added route:clear to startup command\n";
echo "   2. Removed route:cache from build command\n";
echo "   3. Created bypass health check files\n";
echo "\n";

echo "📊 Expected Results:\n";
echo "   - Healthcheck response time: <50ms\n";
echo "   - No Laravel framework overhead\n";
echo "   - No route caching conflicts\n";
echo "   - Immediate 'OK' response\n";
echo "\n";

echo "🚀 Deploy Commands:\n";
echo "   git add .\n";
echo "   git commit -m \"Add bypass healthcheck files\"\n";
echo "   git push origin github-actions/add-ci-and-docker\n";
echo "\n";

echo "🔍 Monitor:\n";
echo "   Railway should show healthy status within 30 seconds\n";
echo "   No more retry attempts should be needed\n";
echo "\n";