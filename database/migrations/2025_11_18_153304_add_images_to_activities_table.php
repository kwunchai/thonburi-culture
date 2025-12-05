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
            // ตรวจสอบว่ามีคอลัมน์ images อยู่แล้วหรือไม่
            if (!Schema::hasColumn('activities', 'images')) {
                // เพิ่มคอลัมน์ images สำหรับเก็บรูปภาพหลายรูปเป็น JSON
                $table->json('images')->nullable()->after('image');
                // เก็บ image เก่าไว้สำหรับ backward compatibility
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropColumn('images');
        });
    }
};
