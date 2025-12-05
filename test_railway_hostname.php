<?php

echo "🚂 RAILWAY HOSTNAME COMPATIBILITY TEST\n";
echo "======================================\n\n";

// 1. Test TrustedHosts middleware
echo "1️⃣  TRUSTED HOSTS MIDDLEWARE TEST\n";

$trustedHostsFile = __DIR__ . '/app/Http/Middleware/TrustedHosts.php';
if (file_exists($trustedHostsFile)) {
    echo "✅ TrustedHosts middleware created\n";
    
    $content = file_get_contents($trustedHostsFile);
    if (strpos($content, 'healthcheck.railway.app') !== false) {
        echo "✅ Railway healthcheck hostname configured\n";
    } else {
        echo "❌ Railway healthcheck hostname missing\n";
    }
    
    if (strpos($content, 'isRailwayHealthcheck') !== false) {
        echo "✅ Railway healthcheck detection method implemented\n";
    } else {
        echo "❌ Railway healthcheck detection missing\n";
    }
} else {
    echo "❌ TrustedHosts middleware not found\n";
}
echo "\n";

// 2. Test bootstrap configuration
echo "2️⃣  BOOTSTRAP CONFIGURATION TEST\n";

$bootstrapFile = __DIR__ . '/bootstrap/app.php';
if (file_exists($bootstrapFile)) {
    $content = file_get_contents($bootstrapFile);
    
    if (strpos($content, 'TrustedHosts') !== false) {
        echo "✅ TrustedHosts middleware registered in bootstrap\n";
    } else {
        echo "❌ TrustedHosts middleware not registered\n";
    }
    
    if (strpos($content, 'trusted.hosts') !== false) {
        echo "✅ TrustedHosts middleware alias configured\n";
    } else {
        echo "❌ TrustedHosts middleware alias missing\n";
    }
} else {
    echo "❌ Bootstrap file not found\n";
}
echo "\n";

// 3. Test Railway configuration
echo "3️⃣  RAILWAY CONFIGURATION TEST\n";

$railwayFile = __DIR__ . '/railway.toml';
if (file_exists($railwayFile)) {
    $content = file_get_contents($railwayFile);
    
    if (strpos($content, 'TRUSTED_HOSTS') !== false) {
        echo "✅ TRUSTED_HOSTS environment variable configured\n";
    } else {
        echo "❌ TRUSTED_HOSTS environment variable missing\n";
    }
    
    if (strpos($content, 'healthcheck.railway.app') !== false) {
        echo "✅ Railway healthcheck hostname in environment\n";
    } else {
        echo "❌ Railway healthcheck hostname missing from environment\n";
    }
} else {
    echo "❌ railway.toml not found\n";
}
echo "\n";

// 4. Test health check files
echo "4️⃣  HEALTH CHECK FILES TEST\n";

$healthFiles = [
    '/public/health.php' => 'PHP health check with hostname handling',
    '/public/health.txt' => 'Static health check file'
];

foreach ($healthFiles as $path => $description) {
    $fullPath = __DIR__ . $path;
    if (file_exists($fullPath)) {
        echo "✅ $description exists\n";
        
        if ($path === '/public/health.php') {
            $content = file_get_contents($fullPath);
            if (strpos($content, 'HTTP_HOST') !== false) {
                echo "   → Includes host checking logic\n";
            }
            if (strpos($content, 'railway.app') !== false) {
                echo "   → Includes Railway hostname detection\n";
            }
        }
    } else {
        echo "❌ $description missing\n";
    }
}
echo "\n";

// 5. Test Laravel health routes
echo "5️⃣  LARAVEL HEALTH ROUTES TEST\n";

$routesFile = __DIR__ . '/routes/web.php';
if (file_exists($routesFile)) {
    $content = file_get_contents($routesFile);
    
    $healthRoutes = [
        '/health' => 'JSON health check with hostname info',
        '/health/simple' => 'Simple text health check',
        '/health/railway' => 'Railway-specific health check'
    ];
    
    foreach ($healthRoutes as $route => $description) {
        if (strpos($content, $route) !== false) {
            echo "✅ $description route configured\n";
        } else {
            echo "❌ $description route missing\n";
        }
    }
    
    if (strpos($content, 'railway.app') !== false) {
        echo "✅ Railway hostname detection in routes\n";
    } else {
        echo "❌ Railway hostname detection missing in routes\n";
    }
} else {
    echo "❌ Routes file not found\n";
}
echo "\n";

// 6. Simulate hostname checking
echo "6️⃣  HOSTNAME CHECKING SIMULATION\n";

$testHosts = [
    'healthcheck.railway.app' => 'Railway healthcheck',
    'myapp.up.railway.app' => 'Railway app domain',
    'localhost' => 'Local development',
    'malicious.com' => 'Untrusted host'
];

echo "Simulating hostname validation:\n";

foreach ($testHosts as $host => $description) {
    $isRailway = strpos($host, 'railway.app') !== false || 
                 strpos($host, 'localhost') !== false ||
                 strpos($host, '127.0.0.1') !== false;
    
    $status = $isRailway ? '✅ ALLOWED' : '❌ BLOCKED';
    echo "   $host ($description): $status\n";
}
echo "\n";

// 7. Expected Railway behavior
echo "7️⃣  EXPECTED RAILWAY BEHAVIOR\n";
echo "==============================\n";

echo "🔍 Railway Healthcheck Process:\n";
echo "   1. Railway sends request from: healthcheck.railway.app\n";
echo "   2. Request hits: /health.php (bypass Laravel)\n";
echo "   3. health.php checks hostname and allows Railway\n";
echo "   4. Response: 'OK' with debugging headers\n";
echo "   5. Railway marks service as healthy ✅\n";
echo "\n";

echo "🔧 If healthcheck still fails:\n";
echo "   → Check Railway logs for hostname-related errors\n";
echo "   → Verify X-Request-Host header in health.php\n";
echo "   → Test /health/railway route for detailed info\n";
echo "   → Ensure Railway app domain is in trusted hosts\n";
echo "\n";

echo "📋 Debugging Commands:\n";
echo "   # Test health endpoint locally\n";
echo "   curl -H \"Host: healthcheck.railway.app\" http://localhost:8000/health.php\n";
echo "\n";
echo "   # Check Laravel route with hostname info\n";
echo "   curl http://localhost:8000/health/railway\n";
echo "\n";

echo "🎯 This configuration addresses Railway hostname restrictions by:\n";
echo "   ✅ Allowing healthcheck.railway.app in middleware\n";
echo "   ✅ Bypassing Laravel for /health.php (fastest)\n";
echo "   ✅ Including Railway detection in Laravel routes\n";
echo "   ✅ Adding debugging headers for troubleshooting\n";
echo "\n";

echo "🚀 Deploy and monitor:\n";
echo "   git add . && git commit -m \"Fix Railway hostname restrictions\"\n";
echo "   git push origin github-actions/add-ci-and-docker\n";
echo "\n";