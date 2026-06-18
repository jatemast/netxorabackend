<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'users.view', 'users.create', 'users.edit', 'users.delete',
            'employees.view', 'employees.create', 'employees.edit', 'employees.delete', 'employees.import', 'employees.export',
            'courses.view', 'courses.create', 'courses.edit', 'courses.delete',
            'modules.view', 'modules.create', 'modules.edit', 'modules.delete',
            'lessons.view', 'lessons.create', 'lessons.edit', 'lessons.delete',
            'enrollments.view', 'enrollments.manage',
            'questions.view', 'questions.create', 'questions.edit', 'questions.delete',
            'evaluations.view', 'evaluations.create', 'evaluations.edit', 'evaluations.delete', 'evaluations.grade',
            'certificates.view', 'certificates.create', 'certificates.revoke', 'certificates.templates.manage',
            'microlearning.view', 'microlearning.create', 'microlearning.edit', 'microlearning.delete', 'microlearning.assign',
            'companies.view', 'companies.create', 'companies.edit', 'companies.delete',
            'dashboard.view', 'dashboard.export',
            'reports.view', 'reports.export',
            'settings.view', 'settings.edit',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
        }

        // Super Administrador
        $superAdmin = Role::firstOrCreate(['name' => 'Super Administrador', 'guard_name' => 'web']);
        $superAdmin->givePermissionTo(Permission::all());

        // Administrador Empresa
        $companyAdmin = Role::firstOrCreate(['name' => 'Administrador Empresa', 'guard_name' => 'web']);
        $companyAdmin->givePermissionTo([
            'users.view', 'users.create', 'users.edit',
            'employees.view', 'employees.create', 'employees.edit', 'employees.import', 'employees.export',
            'courses.view', 'courses.create', 'courses.edit',
            'modules.view', 'modules.create', 'modules.edit',
            'lessons.view', 'lessons.create', 'lessons.edit',
            'enrollments.view', 'enrollments.manage',
            'questions.view', 'questions.create', 'questions.edit',
            'evaluations.view', 'evaluations.create', 'evaluations.edit', 'evaluations.grade',
            'certificates.view', 'certificates.create', 'certificates.templates.manage',
            'microlearning.view', 'microlearning.create', 'microlearning.edit', 'microlearning.assign',
            'dashboard.view', 'reports.view', 'reports.export',
            'settings.view', 'settings.edit',
        ]);

        // Instructor
        $instructor = Role::firstOrCreate(['name' => 'Instructor', 'guard_name' => 'web']);
        $instructor->givePermissionTo([
            'courses.view', 'courses.edit',
            'modules.view', 'modules.create', 'modules.edit',
            'lessons.view', 'lessons.create', 'lessons.edit',
            'enrollments.view',
            'questions.view', 'questions.create', 'questions.edit',
            'evaluations.view', 'evaluations.create', 'evaluations.edit', 'evaluations.grade',
            'certificates.view',
            'microlearning.view', 'microlearning.create', 'microlearning.edit',
            'dashboard.view',
        ]);

        // Supervisor
        $supervisor = Role::firstOrCreate(['name' => 'Supervisor', 'guard_name' => 'web']);
        $supervisor->givePermissionTo([
            'employees.view',
            'courses.view',
            'enrollments.view',
            'evaluations.view', 'evaluations.grade',
            'certificates.view',
            'microlearning.view',
            'dashboard.view',
            'reports.view',
        ]);

        // Empleado
        $employee = Role::firstOrCreate(['name' => 'Empleado', 'guard_name' => 'web']);
        $employee->givePermissionTo([
            'courses.view',
            'lessons.view',
            'evaluations.view',
            'certificates.view',
            'microlearning.view',
            'dashboard.view',
        ]);
    }
}
