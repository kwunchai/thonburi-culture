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
        Schema::table('intellectual_properties', function (Blueprint $table) {
            // Change type and status columns to accommodate longer enum values
            $table->string('type', 50)->change();
            $table->string('status', 50)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('intellectual_properties', function (Blueprint $table) {
            // Revert back to shorter lengths
            $table->string('type', 20)->change();
            $table->string('status', 20)->change();
        });
    }
};
