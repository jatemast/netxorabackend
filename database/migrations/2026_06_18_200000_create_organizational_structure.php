<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Sucursales (Branches)
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->string('code', 20)->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('manager_name')->nullable();
            $table->boolean('is_active')->default(true);
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['company_id', 'slug']);
        });

        // Áreas (Areas)
        Schema::create('areas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->string('code', 20)->nullable();
            $table->text('description')->nullable();
            $table->foreignId('parent_id')->nullable()->constrained('areas')->nullOnDelete();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['branch_id', 'slug']);
        });

        // Procesos (Processes)
        Schema::create('processes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('area_id')->constrained()->cascadeOnDelete();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->string('code', 20)->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['area_id', 'slug']);
        });

        // Cargos (Positions)
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('process_id')->constrained()->cascadeOnDelete();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->string('code', 20)->nullable();
            $table->text('description')->nullable();
            $table->text('responsibilities')->nullable();
            $table->text('requirements')->nullable();
            $table->decimal('min_salary', 12, 2)->nullable();
            $table->decimal('max_salary', 12, 2)->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['process_id', 'slug']);
        });

        // Add cargo_id to employees
        Schema::table('employees', function (Blueprint $table) {
            $table->foreignId('position_id')->nullable()->after('department')->constrained('positions')->nullOnDelete();
            $table->foreignId('branch_id')->nullable()->after('position_id')->constrained('branches')->nullOnDelete();
            $table->foreignId('area_id')->nullable()->after('branch_id')->constrained('areas')->nullOnDelete();
            $table->foreignId('process_id')->nullable()->after('area_id')->constrained('processes')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropForeign(['position_id']);
            $table->dropForeign(['branch_id']);
            $table->dropForeign(['area_id']);
            $table->dropForeign(['process_id']);
            $table->dropColumn(['position_id', 'branch_id', 'area_id', 'process_id']);
        });

        Schema::dropIfExists('positions');
        Schema::dropIfExists('processes');
        Schema::dropIfExists('areas');
        Schema::dropIfExists('branches');
    }
};
