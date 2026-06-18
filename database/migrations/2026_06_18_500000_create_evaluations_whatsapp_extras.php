<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Expandir evaluations con nuevos tipos de pregunta y multimedia
        Schema::table('evaluations', function (Blueprint $table) {
            if (!Schema::hasColumn('evaluations', 'allowed_question_types')) {
                $table->json('allowed_question_types')->nullable()->after('difficulty_distribution');
            }
        });

        // Expandir questions con nuevos tipos
        Schema::table('questions', function (Blueprint $table) {
            // Modify type enum to include new types
            // Note: We use string instead of enum for flexibility with DB
        });

        // Tabla para opciones de ordenamiento
        Schema::create('question_ordering_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained()->cascadeOnDelete();
            $table->string('item_text');
            $table->integer('correct_order');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Tabla para relacionar (matching)
        Schema::create('question_matching_pairs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained()->cascadeOnDelete();
            $table->string('left_text');
            $table->string('right_text');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Certificados: agregar campos QR y firma digital
        Schema::table('certificates', function (Blueprint $table) {
            if (!Schema::hasColumn('certificates', 'signature_data')) {
                $table->json('signature_data')->nullable()->after('pdf_path');
            }
            if (!Schema::hasColumn('certificates', 'verification_url')) {
                $table->string('verification_url')->nullable()->after('signature_data');
            }
        });

        // WhatsApp Learning
        Schema::create('whatsapp_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('type')->default('microlearning'); // microlearning, survey, reminder, announcement
            $table->foreignId('microlearning_content_id')->nullable()->constrained()->nullOnDelete();
            $table->text('message_template')->nullable();
            $table->string('frequency')->default('daily'); // once, daily, weekly, custom
            $table->string('custom_cron')->nullable();
            $table->time('scheduled_time')->default('08:00:00');
            $table->json('target_filters')->nullable(); // filter by area, position, branch, etc.
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_sent_at')->nullable();
            $table->timestamp('next_send_at')->nullable();
            $table->timestamps();
        });

        // Tracking de envíos WhatsApp
        Schema::create('whatsapp_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->foreignId('schedule_id')->nullable()->constrained('whatsapp_schedules')->nullOnDelete();
            $table->string('type'); // microlearning, survey, reminder
            $table->text('message_content');
            $table->string('status')->default('pending'); // pending, sent, delivered, read, failed
            $table->string('whatsapp_message_id')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
        });

        // Encuestas/Encuestas por WhatsApp
        Schema::create('surveys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->json('questions')->nullable(); // survey questions
            $table->string('status')->default('draft'); // draft, active, closed
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->timestamps();
        });

        Schema::create('survey_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_id')->constrained()->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->json('answers');
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();

            $table->unique(['survey_id', 'employee_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('survey_responses');
        Schema::dropIfExists('surveys');
        Schema::dropIfExists('whatsapp_messages');
        Schema::dropIfExists('whatsapp_schedules');
        Schema::table('certificates', function (Blueprint $table) {
            $table->dropColumn(['signature_data', 'verification_url']);
        });
        Schema::dropIfExists('question_matching_pairs');
        Schema::dropIfExists('question_ordering_items');
    }
};
