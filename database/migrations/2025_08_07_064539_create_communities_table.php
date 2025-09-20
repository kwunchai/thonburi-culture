<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('communities', function (Blueprint $table) {
        $table->id(); // คำสั่งนี้สร้างคอลัมน์ 'id'
        $table->string('name');
        $table->string('location')->nullable(); // ไวยากรณ์ที่ถูกต้อง
        $table->text('description')->nullable();
        $table->string('established_year')->nullable();
        $table->enum('status', ['active', 'inactive'])->default('active');
        $table->timestamps(); // คำสั่งนี้สร้าง 'created_at' และ 'updated_at'
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('communities');
    }
};