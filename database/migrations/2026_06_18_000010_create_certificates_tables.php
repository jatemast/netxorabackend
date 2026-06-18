<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificate_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->string('name');
            $table->string('title')->default('Certificate of Completion');
            $table->text('subtitle')->nullable();
            $table->text('body_text')->nullable();
            $table->string('logo')->nullable();
            $table->string('background_image')->nullable();
            $table->string('background_color')->default('#FFFFFF');
            $table->string('primary_color')->default('#1E40AF');
            $table->string('secondary_color')->default('#3B82F6');
            $table->string('accent_color')->default('#06B6D4');
            $table->string('text_color')->default('#0F172A');
            $table->string('font_family')->default('Helvetica');
            $table->string('orientation')->default('landscape');
            $table->string('paper_size')->default('letter');
            $table->boolean('show_logo')->default(true);
            $table->boolean('show_qr')->default(true);
            $table->boolean('show_signature')->default(false);
            $table->string('signature_image')->nullable();
            $table->string('signature_name')->nullable();
            $table->string('signature_title')->nullable();
            $table->json('custom_styles')->nullable();
            $table->boolean('is_default')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();
            $table->foreignId('course_id')->nullable()->constrained('courses')->nullOnDelete();
            $table->foreignId('evaluation_id')->nullable()->constrained('evaluations')->nullOnDelete();
            $table->foreignId('template_id')->nullable()->constrained('certificate_templates')->nullOnDelete();
            $table->string('certificate_code')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('issue_date');
            $table->date('expiry_date')->nullable();
            $table->decimal('score', 5, 2)->nullable();
            $table->string('qr_code_path')->nullable();
            $table->string('pdf_path')->nullable();
            $table->json('metadata')->nullable();
            $table->enum('status', ['active', 'revoked', 'expired'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificates');
        Schema::dropIfExists('certificate_templates');
    }
};
