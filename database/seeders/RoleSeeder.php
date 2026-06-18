<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ─── Permissions ─────────────────────────────────────────────
        $permissions = [
            // Companies
            'manage-companies',
            // Branches
            'view-branches', 'create-branches', 'edit-branches', 'delete-branches',
            // Areas
            'view-areas', 'create-areas', 'edit-areas', 'delete-areas',
            // Processes
            'view-processes', 'create-processes', 'edit-processes', 'delete-processes',
            // Positions
            'view-positions', 'create-positions', 'edit-positions', 'delete-positions',
            // Employees
            'view-employees', 'create-employees', 'edit-employees', 'delete-employees', 'import-employees',
            // Courses
            'view-courses', 'create-courses', 'edit-courses', 'delete-courses',
            // Evaluations
            'view-evaluations', 'create-evaluations', 'edit-evaluations', 'delete-evaluations', 'take-evaluations',
            // Questions
            'view-questions', 'create-questions', 'edit-questions', 'delete-questions',
            // Certificates
            'view-certificates', 'create-certificates', 'revoke-certificates', 'manage-templates',
            // Microlearning
            'view-microlearning', 'create-microlearning', 'edit-microlearning', 'delete-microlearning', 'assign-microlearning',
            // Documents
            'view-documents', 'upload-documents', 'edit-documents', 'delete-documents',
            // Gamification
            'view-gamification', 'manage-badges', 'manage-challenges',
            // Reports
            'view-reports', 'export-reports',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // ─── Roles ───────────────────────────────────────────────────

        // Super Administrador (Master) — platform owner
        $superAdmin = Role::firstOrCreate(['name' => 'Super Administrador', 'guard_name' => 'web']);
        $superAdmin->givePermissionTo(Permission::all());

        // Administrador Empresa — company admin
        $companyAdmin = Role::firstOrCreate(['name' => 'Administrador Empresa', 'guard_name' => 'web']);
        $companyAdmin->givePermissionTo([
            'view-branches', 'create-branches', 'edit-branches', 'delete-branches',
            'view-areas', 'create-areas', 'edit-areas', 'delete-areas',
            'view-processes', 'create-processes', 'edit-processes', 'delete-processes',
            'view-positions', 'create-positions', 'edit-positions', 'delete-positions',
            'view-employees', 'create-employees', 'edit-employees', 'delete-employees', 'import-employees',
            'view-courses', 'create-courses', 'edit-courses', 'delete-courses',
            'view-evaluations', 'create-evaluations', 'edit-evaluations', 'delete-evaluations',
            'view-questions', 'create-questions', 'edit-questions', 'delete-questions',
            'view-certificates', 'create-certificates', 'revoke-certificates', 'manage-templates',
            'view-microlearning', 'create-microlearning', 'edit-microlearning', 'delete-microlearning', 'assign-microlearning',
            'view-documents', 'upload-documents', 'edit-documents', 'delete-documents',
            'view-gamification', 'manage-badges', 'manage-challenges',
            'view-reports', 'export-reports',
        ]);

        // Supervisor
        $supervisor = Role::firstOrCreate(['name' => 'Supervisor', 'guard_name' => 'web']);
        $supervisor->givePermissionTo([
            'view-employees', 'view-courses', 'view-evaluations', 'view-questions',
            'view-certificates', 'view-microlearning', 'view-documents',
            'view-gamification', 'view-reports',
        ]);

        // Líder
        $leader = Role::firstOrCreate(['name' => 'Líder', 'guard_name' => 'web']);
        $leader->givePermissionTo([
            'view-employees', 'view-courses', 'view-evaluations', 'view-microlearning',
            'view-documents', 'view-gamification',
        ]);

        // Instructor
        $instructor = Role::firstOrCreate(['name' => 'Instructor', 'guard_name' => 'web']);
        $instructor->givePermissionTo([
            'view-courses', 'create-courses', 'edit-courses',
            'view-questions', 'create-questions', 'edit-questions',
            'view-evaluations', 'create-evaluations', 'edit-evaluations',
            'view-microlearning', 'create-microlearning', 'edit-microlearning',
            'view-documents', 'upload-documents',
        ]);

        // Trabajador (Empleado)
        $worker = Role::firstOrCreate(['name' => 'Trabajador', 'guard_name' => 'web']);
        $worker->givePermissionTo([
            'view-courses', 'take-evaluations', 'view-certificates',
            'view-microlearning', 'view-documents',
        ]);

        // Invitado
        $guest = Role::firstOrCreate(['name' => 'Invitado', 'guard_name' => 'web']);
        $guest->givePermissionTo([
            'view-courses', 'view-documents',
        ]);
    }
}
