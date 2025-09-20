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
            // ข้อมูลที่อยู่และการติดต่อ
            //$table->string('address', 500)->nullable()->after('description');
            //$table->string('contact_name')->nullable()->after('address');
            //$table->string('contact_phone', 50)->nullable()->after('contact_name');
            //$table->string('contact_email')->nullable()->after('contact_phone');
            //$table->string('website')->nullable()->after('contact_email');
            //$table->string('facebook')->nullable()->after('website');
            //$table->string('line_id', 100)->nullable()->after('facebook');
            
            // ข้อมูลเพิ่มเติม
            //$table->json('gallery_images')->nullable()->after('image');
            //$table->integer('established_year')->nullable()->after('longitude');
            //$table->integer('population')->nullable()->after('established_year');
            //$table->decimal('area_size', 10, 2)->nullable()->after('population');
            //$table->text('highlights')->nullable()->after('area_size');
            //$table->string('working_hours')->nullable()->after('highlights');
            
            // สถานะ
            //$table->boolean('is_active')->default(true)->after('working_hours');
            
            // Indexes
            //$table->index('is_active');
            $table->index('established_year');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('communities', function (Blueprint $table) {
            $table->dropColumn([
                'address',
                'contact_name',
                'contact_phone',
                'contact_email',
                'website',
                'facebook',
                'line_id',
                'gallery_images',
                'established_year',
                'population',
                'area_size',
                'highlights',
                'working_hours',
                'is_active'
            ]);
        });
    }
};
