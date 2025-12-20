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
        Schema::table('communities', function (Blueprint $table) {
            // Change established_year from integer to string (for Buddhist Era years like 2510)
            $table->string('established_year')->nullable()->change();
            
            // Change population from integer to text (for free text like "1,500-1,800" or "ประมาณ 2,000 คน")
            $table->text('population')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('communities', function (Blueprint $table) {
            // Note: Reverting text to integer may cause data loss if non-numeric data exists
            // Convert text population back to integer (will lose text data)
            DB::statement('UPDATE communities SET population = NULL WHERE population NOT REGEXP "^[0-9]+$"');
            $table->integer('population')->nullable()->change();
            
            // Convert string year back to integer
            DB::statement('UPDATE communities SET established_year = NULL WHERE established_year NOT REGEXP "^[0-9]+$"');
            $table->integer('established_year')->nullable()->change();
        });
    }
};
