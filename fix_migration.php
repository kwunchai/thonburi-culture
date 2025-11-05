<?php
/**
 * Fix Migration Issues - Thonburi Culture
 * แก้ไขปัญหา migration ที่ค้างอยู่
 */

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Support\Facades\DB;

echo "🔧 Fixing Migration Issues\n";
echo "===========================\n\n";

try {
    // Check database connection
    $connection = DB::connection();
    echo "✓ Database connection successful\n";
    
    // Check if table exists
    $tableExists = DB::getSchemaBuilder()->hasTable('intellectual_properties');
    
    if ($tableExists) {
        echo "✓ intellectual_properties table exists\n";
        
        // Get table structure
        echo "\n📊 Table Structure:\n";
        $columns = DB::select('DESCRIBE intellectual_properties');
        
        foreach ($columns as $column) {
            echo "  - {$column->Field}: {$column->Type}\n";
        }
        
        // Check data
        echo "\n📋 Current Data:\n";
        $count = DB::table('intellectual_properties')->count();
        echo "  Total records: {$count}\n";
        
        if ($count > 0) {
            $records = DB::table('intellectual_properties')
                        ->select('ip_id', 'type', 'status')
                        ->limit(5)
                        ->get();
            
            echo "  Sample records:\n";
            foreach ($records as $record) {
                echo "    IP {$record->ip_id}: type='{$record->type}', status='{$record->status}'\n";
            }
            
            // Check for problematic data
            echo "\n🔍 Checking for problematic data:\n";
            $invalidTypes = DB::table('intellectual_properties')
                           ->whereNotIn('type', [
                               'invention_patent', 'petty_patent', 'design_patent', 
                               'copyright', 'trademark', 'gi', 'tk', 'patent',
                               'local_wisdom', 'trade_secret', 'other'
                           ])
                           ->get();
            
            if ($invalidTypes->count() > 0) {
                echo "  ⚠️  Found {$invalidTypes->count()} records with invalid types:\n";
                foreach ($invalidTypes as $record) {
                    echo "    IP {$record->ip_id}: '{$record->type}'\n";
                }
                
                // Fix invalid types
                echo "\n🔧 Fixing invalid types:\n";
                foreach ($invalidTypes as $record) {
                    $newType = 'other'; // Default fallback
                    
                    // Map old values to new ones
                    switch (strtolower($record->type)) {
                        case 'patent':
                            $newType = 'invention_patent';
                            break;
                        case 'copyright':
                            $newType = 'copyright';
                            break;
                        case 'trademark':
                            $newType = 'trademark';
                            break;
                        default:
                            $newType = 'other';
                    }
                    
                    DB::table('intellectual_properties')
                      ->where('ip_id', $record->ip_id)
                      ->update(['type' => $newType]);
                    
                    echo "  ✓ Fixed IP {$record->ip_id}: '{$record->type}' → '{$newType}'\n";
                }
            } else {
                echo "  ✓ All type values are valid\n";
            }
        }
        
    } else {
        echo "❌ intellectual_properties table does not exist\n";
        echo "💡 You may need to run: php artisan migrate:fresh --seed\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "💡 Make sure your database is running and .env is configured correctly\n";
}

echo "\n🚀 Next Steps:\n";
echo "1. Run: php artisan migrate (to complete pending migrations)\n";
echo "2. Run: php artisan migrate:status (to verify)\n";
echo "3. Run: php artisan config:clear (to clear cache)\n";

echo "\n📅 Completed at: " . date('Y-m-d H:i:s') . "\n";