<?php

echo "🚂 RAILWAY NOT FOUND ERROR ANALYSIS\n";
echo "===================================\n\n";

// 1. Check current Railway configuration
echo "1️⃣  CURRENT RAILWAY CONFIGURATION\n";

$railwayToml = __DIR__ . '/railway.toml';
if (file_exists($railwayToml)) {
    $config = file_get_contents($railwayToml);
    echo "✅ railway.toml exists\n";
    
    // Show full configuration
    echo "\n📄 Current railway.toml content:\n";
    echo "```toml\n";
    echo $config;
    echo "```\n\n";
    
} else {
    echo "❌ railway.toml missing\n";
}

// 2. Check for common Railway deployment issues
echo "2️⃣  COMMON RAILWAY DEPLOYMENT ISSUES\n";

echo "Possible causes of 'Not Found' error:\n";
echo "   1. ❌ Service failed to start\n";
echo "   2. ❌ Build process failed\n";
echo "   3. ❌ Health check still failing\n";
echo "   4. ❌ Port binding issues\n";
echo "   5. ❌ Domain not provisioned\n";
echo "   6. ❌ Environment variables missing\n";
echo "\n";

// 3. Check critical files
echo "3️⃣  CRITICAL FILES CHECK\n";

$criticalFiles = [
    'railway.toml' => __DIR__ . '/railway.toml',
    'start.sh' => __DIR__ . '/start.sh',
    'composer.json' => __DIR__ . '/composer.json',
    'public/health.php' => __DIR__ . '/public/health.php',
    '.env.example' => __DIR__ . '/.env.example',
    'public/index.php' => __DIR__ . '/public/index.php'
];

foreach ($criticalFiles as $name => $path) {
    if (file_exists($path)) {
        echo "✅ $name exists\n";
        
        if ($name === 'start.sh') {
            if (is_executable($path)) {
                echo "   → ✅ Executable\n";
            } else {
                echo "   → ⚠️  Not executable (chmod will fix)\n";
            }
        }
        
        if ($name === 'public/index.php') {
            $size = filesize($path);
            echo "   → Size: {$size} bytes\n";
        }
        
    } else {
        echo "❌ $name missing\n";
    }
}
echo "\n";

// 4. Environment and Laravel requirements
echo "4️⃣  LARAVEL REQUIREMENTS CHECK\n";

// Check Laravel version
if (file_exists(__DIR__ . '/composer.json')) {
    $composer = json_decode(file_get_contents(__DIR__ . '/composer.json'), true);
    
    if (isset($composer['require']['laravel/framework'])) {
        $laravelVersion = $composer['require']['laravel/framework'];
        echo "✅ Laravel framework: $laravelVersion\n";
    }
    
    if (isset($composer['require']['php'])) {
        $phpVersion = $composer['require']['php'];
        echo "✅ PHP requirement: $phpVersion\n";
    }
}

// Check key Laravel files
$laravelFiles = [
    'app/Http/Kernel.php' => 'HTTP Kernel',
    'config/app.php' => 'App configuration',
    'routes/web.php' => 'Web routes',
    'bootstrap/app.php' => 'Bootstrap'
];

foreach ($laravelFiles as $file => $description) {
    if (file_exists(__DIR__ . '/' . $file)) {
        echo "✅ $description\n";
    } else {
        echo "❌ $description missing\n";
    }
}
echo "\n";

// 5. Railway deployment recommendations
echo "5️⃣  RAILWAY DEPLOYMENT RECOMMENDATIONS\n";
echo "=====================================\n";

echo "🔧 IMMEDIATE FIXES TO TRY:\n\n";

echo "Fix 1: Simplify railway.toml\n";
echo "   Remove complex configurations\n";
echo "   Use basic Laravel deployment\n";
echo "   Focus on getting service running first\n\n";

echo "Fix 2: Check Railway logs\n";
echo "   railway logs --follow\n";
echo "   Look for build/start errors\n";
echo "   Check for port binding issues\n\n";

echo "Fix 3: Use Railway CLI for debugging\n";
echo "   railway status\n";
echo "   railway ps\n";
echo "   railway variables\n\n";

echo "Fix 4: Test with minimal configuration\n";
echo "   Remove healthcheck temporarily\n";
echo "   Use simple start command\n";
echo "   Add complexity gradually\n\n";

// 6. Generate minimal railway.toml
echo "6️⃣  MINIMAL RAILWAY CONFIGURATION\n";
echo "=================================\n";

$minimalConfig = '[build]
buildCommand = "composer install --optimize-autoloader --no-dev && php artisan key:generate --ansi"

[deploy]
startCommand = "php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT"
healthcheckTimeout = 300

[environments.production.variables]
APP_ENV = "production"
APP_DEBUG = "false"
DB_CONNECTION = "mysql"
';

echo "📄 Minimal railway.toml for testing:\n";
echo "```toml\n";
echo $minimalConfig;
echo "```\n\n";

echo "This minimal config:\n";
echo "   → Removes complex build steps\n";
echo "   → Uses basic start command\n";
echo "   → No custom healthcheck path\n";
echo "   → Essential variables only\n\n";

// 7. Step-by-step debugging plan
echo "7️⃣  DEBUGGING PLAN\n";
echo "==================\n";

echo "Step 1: Apply minimal configuration\n";
echo "   - Replace current railway.toml with minimal version\n";
echo "   - Remove complex start.sh script temporarily\n";
echo "   - Deploy and check if service starts\n\n";

echo "Step 2: Check Railway dashboard\n";
echo "   - Verify service is running\n";
echo "   - Check logs for errors\n";
echo "   - Confirm domain is provisioned\n\n";

echo "Step 3: Test basic functionality\n";
echo "   - Access the Railway URL\n";
echo "   - Check if Laravel loads\n";
echo "   - Verify database connection\n\n";

echo "Step 4: Gradually add complexity\n";
echo "   - Add back healthcheck\n";
echo "   - Add custom start script\n";
echo "   - Add build optimizations\n\n";

echo "🚀 Ready to apply minimal fix and redeploy!\n";
echo "\n";