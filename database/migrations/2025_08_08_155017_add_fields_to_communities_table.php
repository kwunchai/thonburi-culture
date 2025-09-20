<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('communities', function (Blueprint $table) {
            $table->string('slug')->unique()->nullable()->after('name');
            $table->string('address', 500)->nullable()->after('description');
            $table->string('contact_phone', 50)->nullable()->after('address');
            $table->string('contact_email', 100)->nullable()->after('contact_phone');
            $table->string('website')->nullable()->after('contact_email');
            $table->string('facebook')->nullable()->after('website');
            $table->string('line_id', 100)->nullable()->after('facebook');
            $table->string('opening_hours')->nullable()->after('line_id');
            $table->boolean('is_active')->default(true)->after('opening_hours');
            $table->index('slug');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('communities', function (Blueprint $table) {
            $table->dropColumn([
                'slug', 'address', 'contact_phone', 'contact_email',
                'website', 'facebook', 'line_id', 'opening_hours', 'is_active'
            ]);
        });
    }
};