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
        Schema::table('communities', function (Blueprint $table) {
            $table->string('contact_name')->nullable()->after('contact_email');
            $table->integer('population')->nullable()->after('contact_name');
            $table->decimal('area_size', 10, 2)->nullable()->after('population');
            $table->text('highlights')->nullable()->after('area_size');
            $table->string('working_hours')->nullable()->after('highlights');
            $table->json('gallery_images')->nullable()->after('working_hours');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('communities', function (Blueprint $table) {
            $table->dropColumn(['contact_name', 'population', 'area_size', 'highlights', 'working_hours', 'gallery_images']);
        });
    }
};
