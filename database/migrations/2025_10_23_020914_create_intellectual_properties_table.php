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
        Schema::create('intellectual_properties', function (Blueprint $table) {
            $table->id('ip_id');
            $table->string('title')->unique();
            $table->enum('type', [
                'copyright',
                'patent',
                'trademark',
                'local_wisdom',
                'trade_secret',
                'other'
            ])->index();
            $table->text('description');
            
            // Owner relationship (can be user_id or organization_id)
            $table->unsignedBigInteger('owner_id')->index();
            $table->string('owner_type')->default('user'); // polymorphic relation
            
            // Registration info
            $table->date('registration_date')->nullable();
            $table->string('registration_number')->nullable()->unique();
            
            // Status management
            $table->enum('status', [
                'draft',
                'pending',
                'registered',
                'active',
                'expired',
                'rejected',
                'revoked'
            ])->default('draft')->index();
            
            // Additional metadata as JSON
            $table->json('metadata')->nullable();
            
            // File attachments
            $table->json('attachments')->nullable();
            
            // Expiry tracking
            $table->date('expiry_date')->nullable();
            
            // Audit fields
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            
            $table->timestamps();
            $table->softDeletes(); // Soft delete support
            
            // Indexes for performance
            $table->index(['owner_id', 'owner_type']);
            // $table->index('status'); // Index นี้ถูกเพิ่มใน enum('status') แล้ว
            $table->index('registration_date');
            
            // Foreign keys
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });
        
        // --- การแก้ไข: เพิ่มการตรวจสอบ Driver สำหรับ FullText Index ---
        $driver = Schema::connection($this->getConnection())->getConnection()->getDriverName();

        if ($driver === 'mysql' || $driver === 'mariadb') {
             // คำสั่งนี้จะถูกรันเฉพาะเมื่อใช้ MySQL หรือ MariaDB
            DB::statement('ALTER TABLE intellectual_properties ADD FULLTEXT search(title, description)');
        }
        // คำสั่งนี้จะถูกข้ามเมื่อใช้ SQLite ในการรัน Test
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // --- การแก้ไข: เพิ่มการตรวจสอบ Driver สำหรับการลบ FullText Index ---
        $driver = Schema::connection($this->getConnection())->getConnection()->getDriverName();
        
        // ลบ Foreign keys ก่อน drop table
        Schema::table('intellectual_properties', function (Blueprint $table) use ($driver) {
            $table->dropForeign(['owner_id']);
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);

            if ($driver === 'mysql' || $driver === 'mariadb') {
                // ลบ Index เมื่อทำ rollback
                $table->dropIndex('search'); 
            }
        });

        Schema::dropIfExists('intellectual_properties');
    }
};
