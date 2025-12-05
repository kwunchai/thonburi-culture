<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if table exists and has data before updating
        if (Schema::hasTable('intellectual_properties')) {
            
            // Safely update type values only if they exist
            $typeUpdates = [
                'patent' => 'invention_patent',
                'local_wisdom' => 'tk',
            ];
            
            foreach ($typeUpdates as $oldValue => $newValue) {
                $count = DB::table('intellectual_properties')
                          ->where('type', $oldValue)
                          ->count();
                          
                if ($count > 0) {
                    DB::table('intellectual_properties')
                      ->where('type', $oldValue)
                      ->update(['type' => $newValue]);
                      
                    echo "Updated {$count} records: {$oldValue} → {$newValue}\n";
                }
            }
            
            // Safely update status values only if they exist
            $statusUpdates = [
                'pending' => 'submitted',
                'active' => 'registered',
            ];
            
            foreach ($statusUpdates as $oldValue => $newValue) {
                $count = DB::table('intellectual_properties')
                          ->where('status', $oldValue)
                          ->count();
                          
                if ($count > 0) {
                    DB::table('intellectual_properties')
                      ->where('status', $oldValue)
                      ->update(['status' => $newValue]);
                      
                    echo "Updated {$count} records: {$oldValue} → {$newValue}\n";
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse the changes safely
        if (Schema::hasTable('intellectual_properties')) {
            
            $typeReverseUpdates = [
                'invention_patent' => 'patent',
                'tk' => 'local_wisdom',
            ];
            
            foreach ($typeReverseUpdates as $newValue => $oldValue) {
                $count = DB::table('intellectual_properties')
                          ->where('type', $newValue)
                          ->count();
                          
                if ($count > 0) {
                    DB::table('intellectual_properties')
                      ->where('type', $newValue)
                      ->update(['type' => $oldValue]);
                }
            }
            
            $statusReverseUpdates = [
                'submitted' => 'pending',
                'registered' => 'active',
            ];
            
            foreach ($statusReverseUpdates as $newValue => $oldValue) {
                $count = DB::table('intellectual_properties')
                          ->where('status', $newValue)
                          ->count();
                          
                if ($count > 0) {
                    DB::table('intellectual_properties')
                      ->where('status', $newValue)
                      ->update(['status' => $oldValue]);
                }
            }
        }
    }
};
