<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cultural_items', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('category_id')->constrained('cultural_categories')->onDelete('cascade');
            $table->foreignId('community_id')->constrained('communities')->onDelete('cascade');
            $table->text('description');
            $table->string('image')->nullable();
            $table->date('publish_date');
            $table->boolean('is_published')->default(true);
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cultural_items');
    }
};