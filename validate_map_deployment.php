#!/usr/bin/env php
<?php
/**
 * Production Map Deployment Validator
 * Checks if all requirements for Google Maps are met before deployment
 */

echo "\n";
echo "═══════════════════════════════════════════════════════════\n";
echo "  PRODUCTION MAP DEPLOYMENT VALIDATOR\n";
echo "═══════════════════════════════════════════════════════════\n\n";

$errors = [];
$warnings = [];
$passed = 0;

// 1. Check .env.example has GOOGLE_MAPS_API_KEY
echo "✓ Checking .env.example...\n";
$envExample = file_get_contents('.env.example');
if (strpos($envExample, 'GOOGLE_MAPS_API_KEY') === false) {
    $errors[] = ".env.example missing GOOGLE_MAPS_API_KEY";
} else {
    $passed++;
    echo "  ✓ GOOGLE_MAPS_API_KEY found in .env.example\n";
}

// 2. Check railway.toml has GOOGLE_MAPS_API_KEY
echo "\n✓ Checking railway.toml...\n";
$railwayToml = file_get_contents('railway.toml');
if (strpos($railwayToml, 'GOOGLE_MAPS_API_KEY') === false) {
    $errors[] = "railway.toml missing GOOGLE_MAPS_API_KEY in [environments.production.variables]";
} else {
    $passed++;
    echo "  ✓ GOOGLE_MAPS_API_KEY found in railway.toml\n";
}

// 3. Check railway.toml build includes npm build
echo "\n✓ Checking Railway build script...\n";
if (strpos($railwayToml, 'npm run build') === false) {
    $errors[] = "railway.toml buildCommand missing 'npm run build'";
} else {
    $passed++;
    echo "  ✓ npm run build found in buildCommand\n";
}

// 4. Check config/maps.php exists and is configured
echo "\n✓ Checking config/maps.php...\n";
if (!file_exists('config/maps.php')) {
    $errors[] = "config/maps.php missing";
} else {
    $configContent = file_get_contents('config/maps.php');
    if (strpos($configContent, "env('GOOGLE_MAPS_API_KEY'") === false) {
        $warnings[] = "config/maps.php might not load GOOGLE_MAPS_API_KEY from env";
    } else {
        $passed++;
        echo "  ✓ config/maps.php correctly configured\n";
    }
}

// 5. Check frontend home view has map script
echo "\n✓ Checking frontend home.blade.php...\n";
if (!file_exists('resources/views/frontend/home.blade.php')) {
    $errors[] = "resources/views/frontend/home.blade.php missing";
} else {
    $homeView = file_get_contents('resources/views/frontend/home.blade.php');
    if (strpos($homeView, 'maps.googleapis.com') === false) {
        $errors[] = "home.blade.php missing Google Maps script tag";
    } else if (strpos($homeView, "config('maps.api_key')") === false) {
        $errors[] = "home.blade.php not using config('maps.api_key') for API key";
    } else {
        $passed++;
        echo "  ✓ Map script correctly configured in home.blade.php\n";
    }
}

// 6. Check Vite build exists
echo "\n✓ Checking Vite build...\n";
if (!file_exists('public/build/manifest.json')) {
    $warnings[] = "public/build/manifest.json missing - run 'npm run build'";
} else {
    $passed++;
    echo "  ✓ Vite build manifest found\n";
}

// 7. Check package.json has build script
echo "\n✓ Checking package.json...\n";
if (!file_exists('package.json')) {
    $errors[] = "package.json missing";
} else {
    $packageJson = json_decode(file_get_contents('package.json'), true);
    if (!isset($packageJson['scripts']['build'])) {
        $errors[] = "package.json missing 'build' script";
    } else {
        $passed++;
        echo "  ✓ npm build script configured\n";
    }
}

// Results
echo "\n";
echo "═══════════════════════════════════════════════════════════\n";
echo "  VALIDATION RESULTS\n";
echo "═══════════════════════════════════════════════════════════\n\n";

echo "Passed Checks: {$passed}\n";
echo "Errors: " . count($errors) . "\n";
echo "Warnings: " . count($warnings) . "\n\n";

if (count($errors) > 0) {
    echo "❌ ERRORS (Must fix before deployment):\n";
    foreach ($errors as $error) {
        echo "   • {$error}\n";
    }
    echo "\n";
}

if (count($warnings) > 0) {
    echo "⚠️  WARNINGS (Recommended to fix):\n";
    foreach ($warnings as $warning) {
        echo "   • {$warning}\n";
    }
    echo "\n";
}

if (count($errors) === 0) {
    echo "✅ ALL CRITICAL CHECKS PASSED!\n";
    echo "\n";
    echo "DEPLOYMENT CHECKLIST:\n";
    echo "1. Run: npm run build\n";
    echo "2. Commit changes to git\n";
    echo "3. Push to Railway\n";
    echo "4. Verify GOOGLE_MAPS_API_KEY in Railway dashboard\n";
    echo "5. Wait for deployment to complete\n";
    echo "6. Test map on production URL\n";
    echo "\n";
    exit(0);
} else {
    echo "❌ DEPLOYMENT BLOCKED - Fix errors above first\n\n";
    exit(1);
}
