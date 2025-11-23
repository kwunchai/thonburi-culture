<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable()->after('description');
            $table->datetime('start_time')->nullable()->after('activity_date');
            $table->datetime('end_time')->nullable()->after('start_time');
            $table->json('images')->nullable()->after('image'); // Multiple images support
            $table->integer('views_count')->default(0)->after('sort_order');
            $table->json('meta_data')->nullable()->after('views_count'); // Additional data
            
            // Foreign key constraint
            $table->foreign('category_id')->references('id')->on('activity_categories')->onDelete('set null');
            
            // New indexes
            $table->index('category_id');
            $table->index('views_count');
            $table->index(['start_time', 'end_time']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropIndex(['category_id']);
            $table->dropIndex(['views_count']);
            $table->dropIndex(['start_time', 'end_time']);
            
            $table->dropColumn([
                'category_id', 
                'start_time', 
                'end_time', 
                'images', 
                'views_count',
                'meta_data'
            ]);
        });
    }
};