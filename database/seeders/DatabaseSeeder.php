<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleAndPermissionSeeder::class,
            CompanySeeder::class,
            UserSeeder::class,
            EmployeeSeeder::class,
            CourseCategorySeeder::class,
            CourseSeeder::class,
            CourseCatalogSeeder::class,
            QuestionBankSeeder::class,
            EvaluationSeeder::class,
            MicrolearningSeeder::class,
            CertificateTemplateSeeder::class,
        ]);
    }
}
