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
        // Update old enum values to new enum values
        
        // Update type values
        DB::table('intellectual_properties')
            ->where('type', 'patent')
            ->update(['type' => 'invention_patent']);
            
        DB::table('intellectual_properties')
            ->where('type', 'local_wisdom')
            ->update(['type' => 'tk']);
            
        // Update status values
        DB::table('intellectual_properties')
            ->where('status', 'pending')
            ->update(['status' => 'submitted']);
            
        DB::table('intellectual_properties')
            ->where('status', 'active')
            ->update(['status' => 'registered']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse the changes
        
        // Reverse type values
        DB::table('intellectual_properties')
            ->where('type', 'invention_patent')
            ->update(['type' => 'patent']);
            
        DB::table('intellectual_properties')
            ->where('type', 'tk')
            ->update(['type' => 'local_wisdom']);
            
        // Reverse status values
        DB::table('intellectual_properties')
            ->where('status', 'submitted')
            ->update(['status' => 'pending']);
            
        DB::table('intellectual_properties')
            ->where('status', 'registered')
            ->update(['status' => 'active']);
    }
};
