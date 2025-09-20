<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('intellectual_properties', function (Blueprint $table) {
            $table->id();
            $table->string('application_no')->nullable()->index();   // เลขที่คำขอ
            $table->string('title');                                  // ชื่องานสร้างสรรค์
            $table->string('type')->index();                          // ประเภทผลงาน (enum เก็บเป็น string)
            $table->string('status')->nullable()->index();            // สถานะ
            $table->string('applicant_name')->nullable();             // ผู้ขอ
            $table->string('faculty')->nullable();                    // คณะ
            $table->string('research_title')->nullable();             // ชื่องานวิจัย
            $table->unsignedInteger('budget_year')->nullable();       // ปีงบประมาณที่ได้รับทุน (พ.ศ.)
            $table->string('funding_source')->nullable();             // แหล่งทุน
            $table->string('submitter_name')->nullable();             // ผู้ยื่น
            $table->string('certificate_no')->nullable();             // เลขใบรับรอง (ถ้ามี)
            $table->string('certificate_path')->nullable();           // ไฟล์ใบรับรอง
            $table->text('remark')->nullable();                       // หมายเหตุ
            // เผื่ออนาคต:
            $table->string('slug')->unique()->nullable();
            $table->timestamp('published_at')->nullable();
            $table->boolean('is_published')->default(true);
            $table->json('attachments')->nullable();                  // เก็บไฟล์อื่น ๆ
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('intellectual_properties');
    }
};
