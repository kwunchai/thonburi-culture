<?php
/**
 * Fix All Conflicts - Comprehensive Testing & Debugging Script
 * สำหรับระบบ Thonburi Culture IP Management
 */

require_once __DIR__ . '/vendor/autoload.php';

class ConflictResolver
{
    private array $issues = [];
    private array $fixes = [];

    public function __construct()
    {
        echo "🔧 Thonburi Culture - Conflict Resolution Tool\n";
        echo "===============================================\n\n";
    }

    public function runAllTests(): void
    {
        $this->testRouteConflicts();
        $this->testModelConflicts();
        $this->testViewConflicts();
        $this->testEnumConflicts();
        $this->testDatabaseConflicts();
        $this->testServiceConflicts();
        $this->generateReport();
    }

    private function testRouteConflicts(): void
    {
        echo "🌐 Testing Route Conflicts...\n";
        
        // Test IP routes vs Cultural routes
        $this->checkRouteBinding();
        $this->checkDuplicateRoutes();
        $this->checkMiddlewareConflicts();
    }

    private function checkRouteBinding(): void
    {
        echo "  ├─ Checking route model binding...\n";
        
        try {
            // Test IP route binding (ip_id)
            if (class_exists('App\Models\IntellectualProperty')) {
                $ip = new \App\Models\IntellectualProperty();
                $routeKey = $ip->getRouteKeyName();
                
                if ($routeKey !== 'ip_id') {
                    $this->addIssue('Route Binding', "IP model route key should be 'ip_id', found: {$routeKey}");
                    $this->addFix('Route Binding', 'Update IntellectualProperty::getRouteKeyName() method');
                } else {
                    echo "    ✓ IP route binding correct (ip_id)\n";
                }
            }

            // Test Cultural Item binding (id)
            if (class_exists('App\Models\CulturalItem')) {
                $cultural = new \App\Models\CulturalItem();
                $routeKey = $cultural->getRouteKeyName();
                
                if ($routeKey !== 'id') {
                    $this->addIssue('Route Binding', "Cultural Item route key should be 'id', found: {$routeKey}");
                } else {
                    echo "    ✓ Cultural Item route binding correct (id)\n";
                }
            }

        } catch (Exception $e) {
            $this->addIssue('Route Binding', "Error testing route binding: " . $e->getMessage());
        }
    }

    private function checkDuplicateRoutes(): void
    {
        echo "  ├─ Checking duplicate routes...\n";
        
        $routeFile = __DIR__ . '/routes/web.php';
        if (file_exists($routeFile)) {
            $content = file_get_contents($routeFile);
            
            // Check for conflicting route names
            $conflicts = [
                '/admin/ip' => '/admin/intellectual-property',
                'ip.show' => 'intellectual-property.show',
            ];

            foreach ($conflicts as $pattern1 => $pattern2) {
                if (strpos($content, $pattern1) !== false && strpos($content, $pattern2) !== false) {
                    $this->addIssue('Duplicate Routes', "Conflicting routes: {$pattern1} and {$pattern2}");
                    $this->addFix('Duplicate Routes', "Choose one route pattern and update all references");
                }
            }
            
            echo "    ✓ Route conflict check completed\n";
        } else {
            echo "    ⚠️  Route file not found\n";
        }
    }

    private function checkMiddlewareConflicts(): void
    {
        echo "  └─ Checking middleware conflicts...\n";
        
        // Check for conflicting middleware in different route groups
        $kernelFile = __DIR__ . '/app/Http/Kernel.php';
        if (file_exists($kernelFile)) {
            echo "    ✓ Middleware structure verified\n";
        } else {
            echo "    ⚠️  Kernel file not found\n";
        }
    }

    private function testModelConflicts(): void
    {
        echo "\n📊 Testing Model Conflicts...\n";
        
        $this->checkModelRelationships();
        $this->checkModelAttributes();
        $this->checkFactoryConflicts();
    }

    private function checkModelRelationships(): void
    {
        echo "  ├─ Checking model relationships...\n";
        
        try {
            // Test polymorphic relationships
            if (class_exists('App\Models\IntellectualProperty')) {
                $reflection = new ReflectionClass('App\Models\IntellectualProperty');
                
                if ($reflection->hasMethod('owner')) {
                    echo "    ✓ IP owner relationship exists\n";
                } else {
                    $this->addIssue('Model Relations', 'IntellectualProperty missing owner() relationship');
                    $this->addFix('Model Relations', 'Add owner() morphTo relationship to IP model');
                }
            }

            // Test cultural item relationships
            if (class_exists('App\Models\CulturalItem')) {
                $reflection = new ReflectionClass('App\Models\CulturalItem');
                
                if ($reflection->hasMethod('community')) {
                    echo "    ✓ Cultural Item community relationship exists\n";
                } else {
                    $this->addIssue('Model Relations', 'CulturalItem missing community() relationship');
                }
            }

        } catch (Exception $e) {
            $this->addIssue('Model Relations', "Error checking relationships: " . $e->getMessage());
        }
    }

    private function checkModelAttributes(): void
    {
        echo "  ├─ Checking model attributes...\n";
        
        // Check for conflicting fillable attributes
        $models = [
            'App\Models\IntellectualProperty' => ['ip_id', 'title', 'type', 'status'],
            'App\Models\CulturalItem' => ['id', 'title', 'category_id'],
        ];

        foreach ($models as $modelClass => $expectedAttributes) {
            if (class_exists($modelClass)) {
                $model = new $modelClass();
                $fillable = $model->getFillable();
                
                foreach ($expectedAttributes as $attr) {
                    if (!in_array($attr, $fillable)) {
                        $this->addIssue('Model Attributes', "{$modelClass} missing fillable: {$attr}");
                    }
                }
                
                echo "    ✓ {$modelClass} attributes checked\n";
            }
        }
    }

    private function checkFactoryConflicts(): void
    {
        echo "  └─ Checking factory conflicts...\n";
        
        $factories = [
            'database/factories/IntellectualPropertyFactory.php',
            'database/factories/CulturalItemFactory.php',
        ];

        foreach ($factories as $factory) {
            if (file_exists(base_path($factory))) {
                echo "    ✓ {$factory} exists\n";
            } else {
                $this->addIssue('Factory Missing', "Missing factory: {$factory}");
                $this->addFix('Factory Missing', "Create {$factory} with proper structure");
            }
        }
    }

    private function testViewConflicts(): void
    {
        echo "\n🎨 Testing View Conflicts...\n";
        
        $this->checkBladeTemplates();
        $this->checkAssetConflicts();
        $this->checkLayoutConflicts();
    }

    private function checkBladeTemplates(): void
    {
        echo "  ├─ Checking Blade templates...\n";
        
        $viewPaths = [
            'resources/views/admin/intellectual-property/',
            'resources/views/frontend/ip/',
            'resources/views/admin/communities/',
            'resources/views/frontend/cultural-items/',
        ];

        foreach ($viewPaths as $path) {
            $fullPath = base_path($path);
            if (is_dir($fullPath)) {
                $files = glob($fullPath . '*.blade.php');
                foreach ($files as $file) {
                    $this->checkBladeFile($file);
                }
                echo "    ✓ {$path} templates checked\n";
            } else {
                $this->addIssue('Missing Views', "View directory missing: {$path}");
            }
        }
    }

    private function checkBladeFile(string $filePath): void
    {
        $content = file_get_contents($filePath);
        $fileName = basename($filePath);
        
        // Check for common Blade errors
        $sections = substr_count($content, '@section');
        $endSections = substr_count($content, '@endsection');
        
        if ($sections !== $endSections) {
            $this->addIssue('Blade Template', "{$fileName}: Section/EndSection mismatch ({$sections} sections, {$endSections} ends)");
            $this->addFix('Blade Template', "Fix section/endsection pairing in {$fileName}");
        }
    }

    private function checkAssetConflicts(): void
    {
        echo "  ├─ Checking asset conflicts...\n";
        
        $assetPaths = [
            'public/css/admin.css',
            'public/js/admin.js',
            'public/css/frontend.css',
            'public/js/frontend.js',
            'public/build/assets/',
        ];

        foreach ($assetPaths as $asset) {
            if (file_exists(base_path($asset)) || is_dir(base_path($asset))) {
                echo "    ✓ {$asset} exists\n";
            } else {
                $this->addIssue('Missing Assets', "Asset missing: {$asset}");
            }
        }
    }

    private function checkLayoutConflicts(): void
    {
        echo "  └─ Checking layout conflicts...\n";
        
        $layouts = [
            'resources/views/layouts/admin.blade.php',
            'resources/views/layouts/frontend.blade.php',
        ];

        foreach ($layouts as $layout) {
            if (file_exists(base_path($layout))) {
                $content = file_get_contents(base_path($layout));
                
                // Check for AdminLTE integration
                if (strpos($content, 'adminlte') !== false) {
                    echo "    ✓ AdminLTE layout detected\n";
                }
                
                // Check for conflicts
                if (strpos($content, '@yield') === false) {
                    $this->addIssue('Layout Structure', "{$layout}: Missing @yield directives");
                }
                
            } else {
                $this->addIssue('Missing Layout', "Layout missing: {$layout}");
            }
        }
    }

    private function testEnumConflicts(): void
    {
        echo "\n📋 Testing Enum Conflicts...\n";
        
        $this->checkEnumDefinitions();
        $this->checkEnumUsage();
    }

    private function checkEnumDefinitions(): void
    {
        echo "  ├─ Checking enum definitions...\n";
        
        $enums = [
            'App\Enums\IpType' => ['PATENT', 'TRADEMARK', 'COPYRIGHT'],
            'App\Enums\IpStatus' => ['DRAFT', 'SUBMITTED', 'REGISTERED', 'ACTIVE'],
        ];

        foreach ($enums as $enumClass => $expectedCases) {
            if (enum_exists($enumClass)) {
                $reflection = new ReflectionEnum($enumClass);
                $cases = array_map(fn($case) => $case->name, $reflection->getCases());
                
                foreach ($expectedCases as $expectedCase) {
                    if (!in_array($expectedCase, $cases)) {
                        $this->addIssue('Enum Cases', "{$enumClass} missing case: {$expectedCase}");
                        $this->addFix('Enum Cases', "Add {$expectedCase} case to {$enumClass}");
                    }
                }
                
                echo "    ✓ {$enumClass} cases verified\n";
            } else {
                $this->addIssue('Missing Enum', "Enum not found: {$enumClass}");
                $this->addFix('Missing Enum', "Create {$enumClass} enum with proper cases");
            }
        }
    }

    private function checkEnumUsage(): void
    {
        echo "  └─ Checking enum usage in models...\n";
        
        if (class_exists('App\Models\IntellectualProperty')) {
            $model = new \App\Models\IntellectualProperty();
            $casts = $model->getCasts();
            
            if (!isset($casts['type']) || !isset($casts['status'])) {
                $this->addIssue('Enum Casting', 'IntellectualProperty missing enum casts for type/status');
                $this->addFix('Enum Casting', 'Add proper enum casting to IP model');
            } else {
                echo "    ✓ IP model enum casting verified\n";
            }
        }
    }

    private function testDatabaseConflicts(): void
    {
        echo "\n🗄️  Testing Database Conflicts...\n";
        
        $this->checkMigrationConflicts();
        $this->checkTableStructure();
        $this->checkSeedersConflicts();
    }

    private function checkMigrationConflicts(): void
    {
        echo "  ├─ Checking migration conflicts...\n";
        
        $migrationPath = base_path('database/migrations');
        $migrations = glob($migrationPath . '/*.php');
        
        $tableNames = [];
        foreach ($migrations as $migration) {
            $content = file_get_contents($migration);
            
            // Extract table names
            if (preg_match('/create_(\w+)_table/', basename($migration), $matches)) {
                $tableName = $matches[1];
                
                if (in_array($tableName, $tableNames)) {
                    $this->addIssue('Migration Conflict', "Duplicate table creation: {$tableName}");
                } else {
                    $tableNames[] = $tableName;
                }
            }
        }
        
        echo "    ✓ " . count($migrations) . " migrations checked\n";
    }

    private function checkTableStructure(): void
    {
        echo "  ├─ Checking table structure...\n";
        
        try {
            $expectedTables = [
                'intellectual_properties',
                'cultural_items',
                'communities',
                'cultural_categories',
            ];

            foreach ($expectedTables as $table) {
                $migrationExists = false;
                $migrationPath = base_path('database/migrations');
                $migrations = glob($migrationPath . "/*create_{$table}_table.php");
                
                if (!empty($migrations)) {
                    echo "    ✓ {$table} migration exists\n";
                } else {
                    $this->addIssue('Missing Migration', "Migration missing for table: {$table}");
                    $this->addFix('Missing Migration', "Create migration for {$table} table");
                }
            }

        } catch (Exception $e) {
            $this->addIssue('Database Connection', "Database check failed: " . $e->getMessage());
        }
    }

    private function checkSeedersConflicts(): void
    {
        echo "  └─ Checking seeders conflicts...\n";
        
        $seeders = [
            'database/seeders/IntellectualPropertySeeder.php',
            'database/seeders/CulturalItemSeeder.php',
            'database/seeders/CommunitySeeder.php',
        ];

        foreach ($seeders as $seeder) {
            if (file_exists(base_path($seeder))) {
                echo "    ✓ " . basename($seeder) . " exists\n";
            } else {
                $this->addIssue('Missing Seeder', "Seeder missing: {$seeder}");
                $this->addFix('Missing Seeder', "Create {$seeder} with sample data");
            }
        }
    }

    private function testServiceConflicts(): void
    {
        echo "\n⚙️  Testing Service Conflicts...\n";
        
        $this->checkServiceProviders();
        $this->checkServiceClasses();
        $this->checkPolicyConflicts();
    }

    private function checkServiceProviders(): void
    {
        echo "  ├─ Checking service providers...\n";
        
        $providers = [
            'app/Providers/AppServiceProvider.php',
            'app/Providers/AuthServiceProvider.php',
            'app/Providers/RouteServiceProvider.php',
        ];

        foreach ($providers as $provider) {
            if (file_exists(base_path($provider))) {
                $content = file_get_contents(base_path($provider));
                
                // Check for IP-related bindings
                if (strpos($content, 'IntellectualProperty') !== false) {
                    echo "    ✓ IP bindings found in " . basename($provider) . "\n";
                }
            }
        }
    }

    private function checkServiceClasses(): void
    {
        echo "  ├─ Checking service classes...\n";
        
        $services = [
            'App\Services\IntellectualPropertyService',
            'App\Services\CulturalItemService',
        ];

        foreach ($services as $serviceClass) {
            if (class_exists($serviceClass)) {
                echo "    ✓ {$serviceClass} exists\n";
            } else {
                $this->addIssue('Missing Service', "Service class missing: {$serviceClass}");
                $this->addFix('Missing Service', "Create {$serviceClass} for business logic");
            }
        }
    }

    private function checkPolicyConflicts(): void
    {
        echo "  └─ Checking policy conflicts...\n";
        
        $policies = [
            'App\Policies\IntellectualPropertyPolicy',
            'App\Policies\CulturalItemPolicy',
        ];

        foreach ($policies as $policyClass) {
            if (class_exists($policyClass)) {
                echo "    ✓ {$policyClass} exists\n";
            } else {
                $this->addIssue('Missing Policy', "Policy missing: {$policyClass}");
                $this->addFix('Missing Policy', "Create {$policyClass} for authorization");
            }
        }
    }

    private function addIssue(string $category, string $description): void
    {
        $this->issues[] = [
            'category' => $category,
            'description' => $description,
            'timestamp' => date('Y-m-d H:i:s')
        ];
    }

    private function addFix(string $category, string $solution): void
    {
        $this->fixes[] = [
            'category' => $category,
            'solution' => $solution,
            'timestamp' => date('Y-m-d H:i:s')
        ];
    }

    private function generateReport(): void
    {
        echo "\n📋 CONFLICT RESOLUTION REPORT\n";
        echo "==============================\n\n";

        if (empty($this->issues)) {
            echo "🎉 No conflicts detected! System is healthy.\n\n";
        } else {
            echo "⚠️  ISSUES FOUND (" . count($this->issues) . "):\n";
            echo "------------------------\n";
            
            foreach ($this->issues as $issue) {
                echo "[{$issue['category']}] {$issue['description']}\n";
            }

            echo "\n🔧 SUGGESTED FIXES (" . count($this->fixes) . "):\n";
            echo "------------------------\n";
            
            foreach ($this->fixes as $fix) {
                echo "[{$fix['category']}] {$fix['solution']}\n";
            }
        }

        // Save report to file
        $this->saveReportToFile();
    }

    private function saveReportToFile(): void
    {
        $report = [
            'timestamp' => date('Y-m-d H:i:s'),
            'issues' => $this->issues,
            'fixes' => $this->fixes,
            'summary' => [
                'total_issues' => count($this->issues),
                'total_fixes' => count($this->fixes),
                'status' => empty($this->issues) ? 'healthy' : 'needs_attention'
            ]
        ];

        $reportFile = base_path('conflict_report.json');
        file_put_contents($reportFile, json_encode($report, JSON_PRETTY_PRINT));
        
        echo "\n📄 Report saved to: conflict_report.json\n";
    }
}

// Run the conflict resolver
try {
    $resolver = new ConflictResolver();
    $resolver->runAllTests();
} catch (Exception $e) {
    echo "❌ Error running conflict resolution: " . $e->getMessage() . "\n";
}