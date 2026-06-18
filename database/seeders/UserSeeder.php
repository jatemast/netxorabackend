<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Company;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $company1 = Company::where('slug', 'nexora-technologies')->first();
        $company2 = Company::where('slug', 'innovacion-digital')->first();
        $company3 = Company::where('slug', 'aprendizaje-global')->first();

        $users = [
            // Super Administrador
            [
                'company_id' => null,
                'name' => 'Javier',
                'lastname' => 'Teherán',
                'email' => 'admin@nexora.com',
                'password' => bcrypt('password123'),
                'phone' => '+57 300 111 2233',
                'position' => 'Super Administrador',
                'is_active' => true,
                'role' => 'Super Administrador',
            ],
            // Administrador Empresa 1
            [
                'company_id' => $company1->id,
                'name' => 'María',
                'lastname' => 'Gómez',
                'email' => 'admin@nexoratech.com',
                'password' => bcrypt('password123'),
                'phone' => '+57 300 222 3344',
                'position' => 'Administrador Empresa',
                'is_active' => true,
                'role' => 'Administrador Empresa',
            ],
            // Instructor Empresa 1
            [
                'company_id' => $company1->id,
                'name' => 'Carlos',
                'lastname' => 'Rodríguez',
                'email' => 'instructor@nexoratech.com',
                'password' => bcrypt('password123'),
                'phone' => '+57 300 333 4455',
                'position' => 'Instructor Senior',
                'is_active' => true,
                'role' => 'Instructor',
            ],
            // Supervisor Empresa 1
            [
                'company_id' => $company1->id,
                'name' => 'Ana',
                'lastname' => 'Martínez',
                'email' => 'supervisor@nexoratech.com',
                'password' => bcrypt('password123'),
                'phone' => '+57 300 444 5566',
                'position' => 'Supervisor de Ventas',
                'is_active' => true,
                'role' => 'Supervisor',
            ],
            // Empleado Empresa 1
            [
                'company_id' => $company1->id,
                'name' => 'Pedro',
                'lastname' => 'López',
                'email' => 'empleado@nexoratech.com',
                'password' => bcrypt('password123'),
                'phone' => '+57 300 555 6677',
                'position' => 'Analista de Soporte',
                'is_active' => true,
                'role' => 'Empleado',
            ],
            // Admin Empresa 2
            [
                'company_id' => $company2->id,
                'name' => 'Laura',
                'lastname' => 'Hernández',
                'email' => 'admin@innovaciondigital.com',
                'password' => bcrypt('password123'),
                'phone' => '+57 300 666 7788',
                'position' => 'Administrador Empresa',
                'is_active' => true,
                'role' => 'Administrador Empresa',
            ],
            // Instructor Empresa 2
            [
                'company_id' => $company2->id,
                'name' => 'Diego',
                'lastname' => 'Torres',
                'email' => 'instructor@innovaciondigital.com',
                'password' => bcrypt('password123'),
                'phone' => '+57 300 777 8899',
                'position' => 'Instructor',
                'is_active' => true,
                'role' => 'Instructor',
            ],
        ];

        foreach ($users as $data) {
            $role = $data['role'];
            unset($data['role']);

            $user = User::firstOrCreate(['email' => $data['email']], $data);
            $user->assignRole($role);
        }
    }
}
