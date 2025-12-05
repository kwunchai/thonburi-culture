<?php

// Railway Laravel Deployment Verification Script
echo "🚂 RAILWAY LARAVEL DEPLOYMENT CHECK\n";
echo "=====================================\n\n";

// 1. Check Laravel artisan serve configuration
echo "1️⃣  LARAVEL ARTISAN SERVE CHECK\n";

$railwayConfig = __DIR__ . '/railway.toml';
if (file_exists($railwayConfig)) {
    $config = file_get_contents($railwayConfig);
    
    // Check port configuration
    if (strpos($config, '--port=$PORT') !== false) {
        echo "✅ Laravel artisan serve configured to use Railway \$PORT\n";
    } else {
        echo "❌ Laravel artisan serve not configured for Railway port\n";
    }
    
    // Check host configuration
    if (strpos($config, '--host=0.0.0.0') !== false) {
        echo "✅ Laravel artisan serve configured for external access (0.0.0.0)\n";
    } else {
        echo "❌ Laravel artisan serve host not configured for Railway\n";
    }
    
    // Check healthcheck timeout
    if (preg_match('/healthcheckTimeout = (\d+)/', $config, $matches)) {
        $timeout = (int)$matches[1];
        echo "✅ Healthcheck timeout: {$timeout} seconds\n";
        if ($timeout > 60 && $timeout < 180) {
            echo "   → Good range for Laravel bootstrap\n";
        } elseif ($timeout >= 180) {
            echo "   → May be too long, consider reducing\n";
        } else {
            echo "   → May be too short for Laravel, consider increasing\n";
        }
    }
    
} else {
    echo "❌ railway.toml not found\n";
}
echo "\n";

// 2. Test Railway-optimized health check
echo "2️⃣  RAILWAY HEALTH CHECK TEST\n";

$healthFiles = [
    '/health.php' => 'PHP health check',
    '/health.txt' => 'Static health check'
];

foreach ($healthFiles as $path => $description) {
    $fullPath = __DIR__ . '/public' . $path;
    if (file_exists($fullPath)) {
        echo "✅ $description exists ($path)\n";
        
        if ($path === '/health.php') {
            // Test PHP execution
            ob_start();
            $startTime = microtime(true);
            
            // Capture any output/errors
            try {
                include $fullPath;
                $endTime = microtime(true);
                $responseTime = round(($endTime - $startTime) * 1000, 2);
                echo "   → Response time: {$responseTime}ms\n";
            } catch (Exception $e) {
                echo "   → Error: " . $e->getMessage() . "\n";
            }
            
            ob_end_clean();
        }
    } else {
        echo "❌ $description missing ($path)\n";
    }
}
echo "\n";

// 3. Check Laravel environment for Railway
echo "3️⃣  LARAVEL RAILWAY ENVIRONMENT CHECK\n";

$envExample = __DIR__ . '/.env.example';
if (file_exists($envExample)) {
    echo "✅ .env.example exists (Railway will copy this)\n";
    
    $envContent = file_get_contents($envExample);
    
    // Check critical Laravel configurations
    $requiredVars = [
        'APP_KEY' => 'Application encryption key',
        'DB_CONNECTION' => 'Database connection type',
        'DB_HOST' => 'Database host',
        'DB_DATABASE' => 'Database name'
    ];
    
    foreach ($requiredVars as $var => $description) {
        if (strpos($envContent, $var . '=') !== false) {
            echo "✅ $description ($var) configured\n";
        } else {
            echo "⚠️  $description ($var) may need configuration\n";
        }
    }
} else {
    echo "❌ .env.example missing - Railway needs this for initial setup\n";
}
echo "\n";

// 4. Check Laravel performance optimizations
echo "4️⃣  LARAVEL PERFORMANCE CHECK\n";

$optimizations = [
    'config:cache' => 'Configuration caching',
    'route:cache' => 'Route caching (removed for health check fix)',
    'view:cache' => 'View caching',
    'event:cache' => 'Event caching'
];

if (file_exists($railwayConfig)) {
    $config = file_get_contents($railwayConfig);
    
    foreach ($optimizations as $command => $description) {
        if (strpos($config, $command) !== false) {
            if ($command === 'route:cache') {
                echo "⚠️  $description found in build (may conflict with health routes)\n";
            } else {
                echo "✅ $description enabled\n";
            }
        } else {
            if ($command === 'route:cache') {
                echo "✅ $description disabled (good for health check)\n";
            } else {
                echo "⚠️  $description not found\n";
            }
        }
    }
}
echo "\n";

// 5. Railway deployment recommendations
echo "5️⃣  RAILWAY DEPLOYMENT RECOMMENDATIONS\n";
echo "=====================================\n";

echo "🎯 Critical Railway Settings to Verify:\n\n";

echo "📋 In Railway Dashboard → Project → Service → Settings:\n";
echo "   → Root Directory: (leave empty or set to project root)\n";
echo "   → Build Command: (use railway.toml configuration)\n";
echo "   → Start Command: (use railway.toml configuration)\n";
echo "\n";

echo "🔧 Environment Variables to Add in Railway Dashboard:\n";
echo "   PORT=\${{RAILWAY_DEPLOY_PORT}} (Railway sets this automatically)\n";
echo "   APP_KEY=<your-generated-key> (run: php artisan key:generate --show)\n";
echo "   APP_URL=https://your-service.railway.app\n";
echo "   DB_HOST=\${{MYSQL_HOST}} (if using Railway MySQL)\n";
echo "   DB_PORT=\${{MYSQL_PORT}}\n";
echo "   DB_DATABASE=\${{MYSQL_DATABASE}}\n";
echo "   DB_USERNAME=\${{MYSQL_USER}}\n";
echo "   DB_PASSWORD=\${{MYSQL_PASSWORD}}\n";
echo "\n";

echo "⚡ Laravel Performance Tips for Railway:\n";
echo "   → Use database sessions (already configured)\n";
echo "   → Enable opcache in production\n";
echo "   → Use database cache driver (already configured)\n";
echo "   → Keep route caching disabled until health check is stable\n";
echo "\n";

echo "🔍 Testing Commands:\n";
echo "   Local test: php artisan serve --host=0.0.0.0 --port=8000\n";
echo "   Health check: curl http://localhost:8000/health.php\n";
echo "   Deploy: git push origin main\n";
echo "\n";

echo "🚀 Expected Railway Deployment Flow:\n";
echo "   1. Build: 3-5 minutes (Composer + NPM + Laravel caching)\n";
echo "   2. Deploy: 1-2 minutes (Migration + Server start)\n";
echo "   3. Health Check: <30 seconds (/health.php response)\n";
echo "   4. Status: Healthy ✅\n";
echo "\n";