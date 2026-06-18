<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Insignias (Badges)
        Schema::create('badges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->string('color', 7)->nullable();
            $table->string('category')->default('achievement'); // achievement, skill, participation, special
            $table->json('criteria')->nullable(); // conditions to earn
            $table->integer('points_awarded')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['company_id', 'slug']);
        });

        // Insignias ganadas por empleados
        Schema::create('employee_badges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('badge_id')->constrained()->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->timestamp('earned_at')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->unique(['badge_id', 'employee_id']);
        });

        // Puntos y Experiencia
        Schema::create('employee_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->integer('total_points')->default(0);
            $table->integer('total_experience')->default(0);
            $table->integer('level')->default(1);
            $table->integer('current_level_points')->default(0);
            $table->integer('points_to_next_level')->default(100);
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->unique('employee_id');
        });

        // Historial de puntos
        Schema::create('point_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('type'); // badge_earned, course_completed, evaluation_passed, challenge_completed, daily_login, bonus
            $table->integer('points');
            $table->integer('experience')->default(0);
            $table->string('description')->nullable();
            $table->string('reference_type')->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->timestamps();

            $table->index(['reference_type', 'reference_id']);
        });

        // Ranking
        Schema::create('rankings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('type')->default('points'); // points, experience, courses, evaluations
            $table->string('period')->default('all_time'); // all_time, monthly, weekly
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Retos (Challenges)
        Schema::create('challenges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->string('type')->default('individual'); // individual, team, company
            $table->json('criteria')->nullable(); // conditions to complete
            $table->integer('points_reward')->default(0);
            $table->integer('experience_reward')->default(0);
            $table->foreignId('badge_reward_id')->nullable()->constrained('badges')->nullOnDelete();
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['company_id', 'slug']);
        });

        // Participación en retos
        Schema::create('challenge_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('challenge_id')->constrained()->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->string('status')->default('active'); // active, completed, failed
            $table->integer('progress')->default(0); // 0-100
            $table->timestamp('completed_at')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->unique(['challenge_id', 'employee_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('challenge_participants');
        Schema::dropIfExists('challenges');
        Schema::dropIfExists('rankings');
        Schema::dropIfExists('point_transactions');
        Schema::dropIfExists('employee_points');
        Schema::dropIfExists('employee_badges');
        Schema::dropIfExists('badges');
    }
};
