<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Documentos
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->string('type')->default('document'); // document, norm, procedure, instructive, video, image, audio, pdf
            $table->string('category')->nullable(); // optional category grouping
            $table->string('file_path')->nullable();
            $table->string('file_url')->nullable();
            $table->string('file_type')->nullable(); // mime type
            $table->bigInteger('file_size')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('version', 20)->default('1.0');
            $table->string('status')->default('published'); // draft, published, archived
            $table->boolean('is_public')->default(false);
            $table->json('tags')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['company_id', 'slug']);
        });

        // Relación: documentos asignados a empleados/áreas/cargos
        Schema::create('document_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->constrained()->cascadeOnDelete();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('assignable_type'); // employee, area, position, branch, process
            $table->unsignedBigInteger('assignable_id');
            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('due_date')->nullable();
            $table->timestamps();

            $table->index(['assignable_type', 'assignable_id']);
        });

        // Tracking de lectura de documentos
        Schema::create('document_tracking', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->constrained()->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('status')->default('pending'); // pending, viewed, completed
            $table->timestamp('viewed_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->integer('time_spent_seconds')->nullable();
            $table->timestamps();

            $table->unique(['document_id', 'employee_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_tracking');
        Schema::dropIfExists('document_assignments');
        Schema::dropIfExists('documents');
    }
};
