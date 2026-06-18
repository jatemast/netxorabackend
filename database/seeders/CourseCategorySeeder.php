<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\CourseCategory;
use Illuminate\Database\Seeder;

class CourseCategorySeeder extends Seeder
{
    public function run(): void
    {
        $company1 = Company::where('slug', 'nexora-technologies')->first();

        $categories = [
            ['name' => 'Tecnología', 'slug' => 'tecnologia', 'description' => 'Cursos de tecnología y desarrollo', 'icon' => 'pi pi-code', 'color' => '#1E40AF', 'sort_order' => 1],
            ['name' => 'Liderazgo', 'slug' => 'liderazgo', 'description' => 'Habilidades de liderazgo y gestión', 'icon' => 'pi pi-users', 'color' => '#3B82F6', 'sort_order' => 2],
            ['name' => 'Ventas', 'slug' => 'ventas', 'description' => 'Técnicas de ventas y negociación', 'icon' => 'pi pi-chart-line', 'color' => '#06B6D4', 'sort_order' => 3],
            ['name' => 'Desarrollo Personal', 'slug' => 'desarrollo-personal', 'description' => 'Crecimiento personal y profesional', 'icon' => 'pi pi-star', 'color' => '#10B981', 'sort_order' => 4],
            ['name' => 'Seguridad', 'slug' => 'seguridad', 'description' => 'Seguridad informática y física', 'icon' => 'pi pi-shield', 'color' => '#EF4444', 'sort_order' => 5],
            ['name' => 'Idiomas', 'slug' => 'idiomas', 'description' => 'Aprendizaje de idiomas', 'icon' => 'pi pi-globe', 'color' => '#F59E0B', 'sort_order' => 6],
        ];

        foreach ($categories as $cat) {
            CourseCategory::firstOrCreate(
                ['slug' => $cat['slug']],
                array_merge(['company_id' => $company1->id, 'is_active' => true], $cat)
            );
        }
    }
}
