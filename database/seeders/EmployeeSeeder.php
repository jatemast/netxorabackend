<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $company1 = Company::where('slug', 'nexora-technologies')->first();

        $employees = [
            [
                'company_id' => $company1->id,
                'first_name' => 'Andrea', 'last_name' => 'Ramírez',
                'document_type' => 'CC', 'document_number' => '1234567890',
                'email' => 'aramirez@nexoratech.com', 'phone' => '+57 310 111 2233',
                'position' => 'Desarrollador Senior', 'department' => 'Tecnología',
                'area' => 'Desarrollo', 'status' => 'active',
                'hire_date' => '2024-01-15', 'gender' => 'Femenino',
            ],
            [
                'company_id' => $company1->id,
                'first_name' => 'Juan', 'last_name' => 'Pérez',
                'document_type' => 'CC', 'document_number' => '2345678901',
                'email' => 'jperez@nexoratech.com', 'phone' => '+57 310 222 3344',
                'position' => 'Ingeniero DevOps', 'department' => 'Tecnología',
                'area' => 'Infraestructura', 'status' => 'active',
                'hire_date' => '2024-02-20', 'gender' => 'Masculino',
            ],
            [
                'company_id' => $company1->id,
                'first_name' => 'Sofía', 'last_name' => 'García',
                'document_type' => 'CC', 'document_number' => '3456789012',
                'email' => 'sgarcia@nexoratech.com', 'phone' => '+57 310 333 4455',
                'position' => 'Diseñadora UX/UI', 'department' => 'Diseño',
                'area' => 'UX', 'status' => 'active',
                'hire_date' => '2024-03-10', 'gender' => 'Femenino',
            ],
            [
                'company_id' => $company1->id,
                'first_name' => 'Miguel', 'last_name' => 'Ortiz',
                'document_type' => 'CC', 'document_number' => '4567890123',
                'email' => 'mortiz@nexoratech.com', 'phone' => '+57 310 444 5566',
                'position' => 'Gerente de Proyecto', 'department' => 'Operaciones',
                'area' => 'Proyectos', 'status' => 'active',
                'hire_date' => '2024-04-05', 'gender' => 'Masculino',
            ],
            [
                'company_id' => $company1->id,
                'first_name' => 'Valentina', 'last_name' => 'Castro',
                'document_type' => 'CC', 'document_number' => '5678901234',
                'email' => 'vcastro@nexoratech.com', 'phone' => '+57 310 555 6677',
                'position' => 'Analista QA', 'department' => 'Calidad',
                'area' => 'Testing', 'status' => 'active',
                'hire_date' => '2024-05-15', 'gender' => 'Femenino',
            ],
            [
                'company_id' => $company1->id,
                'first_name' => 'Daniel', 'last_name' => 'Morales',
                'document_type' => 'CC', 'document_number' => '6789012345',
                'email' => 'dmorales@nexoratech.com', 'phone' => '+57 310 666 7788',
                'position' => 'Business Analyst', 'department' => 'Negocios',
                'area' => 'Análisis', 'status' => 'active',
                'hire_date' => '2024-06-01', 'gender' => 'Masculino',
            ],
            [
                'company_id' => $company1->id,
                'first_name' => 'Camila', 'last_name' => 'Ríos',
                'document_type' => 'CC', 'document_number' => '7890123456',
                'email' => 'crios@nexoratech.com', 'phone' => '+57 310 777 8899',
                'position' => 'Data Scientist', 'department' => 'Tecnología',
                'area' => 'Datos', 'status' => 'active',
                'hire_date' => '2024-07-10', 'gender' => 'Femenino',
            ],
            [
                'company_id' => $company1->id,
                'first_name' => 'Andrés', 'last_name' => 'Vargas',
                'document_type' => 'CC', 'document_number' => '8901234567',
                'email' => 'avargas@nexoratech.com', 'phone' => '+57 310 888 9900',
                'position' => 'Soporte Técnico', 'department' => 'Soporte',
                'area' => 'Help Desk', 'status' => 'active',
                'hire_date' => '2024-08-20', 'gender' => 'Masculino',
            ],
            [
                'company_id' => $company1->id,
                'first_name' => 'Natalia', 'last_name' => 'Jiménez',
                'document_type' => 'CC', 'document_number' => '9012345678',
                'email' => 'njimenez@nexoratech.com', 'phone' => '+57 310 999 0011',
                'position' => 'Marketing Digital', 'department' => 'Marketing',
                'area' => 'Digital', 'status' => 'active',
                'hire_date' => '2024-09-05', 'gender' => 'Femenino',
            ],
            [
                'company_id' => $company1->id,
                'first_name' => 'Fernando', 'last_name' => 'Medina',
                'document_type' => 'CC', 'document_number' => '0123456789',
                'email' => 'fmedina@nexoratech.com', 'phone' => '+57 310 000 1122',
                'position' => 'Contador', 'department' => 'Finanzas',
                'area' => 'Contabilidad', 'status' => 'inactive',
                'hire_date' => '2024-10-01', 'gender' => 'Masculino',
            ],
        ];

        foreach ($employees as $data) {
            Employee::firstOrCreate(['document_number' => $data['document_number']], $data);
        }
    }
}
