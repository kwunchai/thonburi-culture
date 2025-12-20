<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Removes contact information and image-related fields from communities table.
     * These fields are no longer needed as the system focuses on core community data.
     */
    public function up(): void
    {
        Schema::table('communities', function (Blueprint $table) {
            // Drop contact information fields
            $table->dropColumn([
                'address',
                'contact_name',
                'contact_phone',
                'contact_email',
                'website',
                'facebook',
                'line_id',
                'working_hours',
            ]);
            
            // Drop gallery_images field only (no 'image' column exists)
            $table->dropColumn('gallery_images');
        });
    }

    /**
     * Reverse the migrations.
     * 
     * Recreates the removed columns with their original definitions.
     */
    public function down(): void
    {
        Schema::table('communities', function (Blueprint $table) {
            // Recreate contact information fields
            $table->string('address', 500)->nullable()->after('description');
            $table->string('contact_name')->nullable()->after('highlights');
            $table->string('contact_phone', 50)->nullable()->after('contact_name');
            $table->string('contact_email')->nullable()->after('contact_phone');
            $table->string('website')->nullable()->after('contact_email');
            $table->string('facebook')->nullable()->after('website');
            $table->string('line_id', 100)->nullable()->after('facebook');
            $table->string('working_hours')->nullable()->after('line_id');
            
            // Recreate gallery_images field only
            $table->json('gallery_images')->nullable()->after('working_hours');
        });
    }
};
