<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('microlearning_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('content_type', ['text', 'image', 'video', 'pdf', 'link', 'embed'])->default('text');
            $table->longText('content')->nullable();
            $table->string('image_url')->nullable();
            $table->string('video_url')->nullable();
            $table->string('file_url')->nullable();
            $table->string('external_url')->nullable();
            $table->integer('read_time_minutes')->default(5);
            $table->enum('frequency', ['daily', 'weekly', 'custom'])->default('daily');
            $table->string('custom_cron')->nullable();
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->json('tags')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('microlearning_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('microlearning_content_id')->constrained('microlearning_contents')->cascadeOnDelete();
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->enum('assign_type', ['employee', 'area', 'position', 'department', 'all'])->default('all');
            $table->unsignedBigInteger('assignee_id')->nullable(); // employee_id, or null for all
            $table->string('assignee_value')->nullable(); // area name, position name, department name
            $table->timestamp('assigned_at')->useCurrent();
            $table->timestamps();
        });

        Schema::create('microlearning_tracking', function (Blueprint $table) {
            $table->id();
            $table->foreignId('microlearning_content_id')->constrained('microlearning_contents')->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->enum('status', ['delivered', 'seen', 'completed'])->default('delivered');
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('seen_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->integer('time_spent_seconds')->default(0);
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->unique(['microlearning_content_id', 'employee_id'], 'ml_tracking_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('microlearning_tracking');
        Schema::dropIfExists('microlearning_assignments');
        Schema::dropIfExists('microlearning_contents');
    }
};
