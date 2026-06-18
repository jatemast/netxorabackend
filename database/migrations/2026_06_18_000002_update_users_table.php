<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // First, modify the existing users table
        if (!Schema::hasColumn('users', 'company_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->foreignId('company_id')->nullable()->after('id')->constrained('companies')->nullOnDelete();
                $table->string('lastname')->nullable()->after('name');
                $table->string('document_type')->nullable()->after('lastname');
                $table->string('document_number')->nullable()->after('document_type');
                $table->string('phone')->nullable()->after('email');
                $table->string('position')->nullable()->after('phone');
                $table->string('avatar')->nullable()->after('position');
                $table->boolean('is_active')->default(true)->after('avatar');
                $table->json('preferences')->nullable()->after('is_active');
                $table->softDeletes();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('users', 'company_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropForeign(['company_id']);
                $table->dropColumn([
                    'company_id', 'lastname', 'document_type', 'document_number',
                    'phone', 'position', 'avatar', 'is_active', 'preferences'
                ]);
                $table->dropSoftDeletes();
            });
        }
    }
};
