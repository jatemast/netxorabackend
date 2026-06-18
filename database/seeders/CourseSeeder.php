<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\User;
use App\Models\CourseModule;
use App\Models\CourseLesson;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $company1 = Company::where('slug', 'nexora-technologies')->first();
        $catTech = CourseCategory::where('slug', 'tecnologia')->first();
        $catLeadership = CourseCategory::where('slug', 'liderazgo')->first();
        $catSales = CourseCategory::where('slug', 'ventas')->first();
        $instructor = User::where('email', 'instructor@nexoratech.com')->first();

        $courses = [
            [
                'company_id' => $company1->id,
                'category_id' => $catTech->id,
                'instructor_id' => $instructor->id,
                'title' => 'Fundamentos de Programación Web',
                'slug' => 'fundamentos-programacion-web',
                'description' => 'Aprende los fundamentos de HTML, CSS y JavaScript para desarrollo web moderno.',
                'objectives' => 'Comprender la estructura de páginas web, estilizar con CSS, programar interactividad con JavaScript.',
                'level' => 'beginner',
                'status' => 'published',
                'has_certificate' => true,
                'passing_score' => 70,
                'max_attempts' => 3,
                'published_at' => now(),
            ],
            [
                'company_id' => $company1->id,
                'category_id' => $catLeadership->id,
                'instructor_id' => $instructor->id,
                'title' => 'Liderazgo Efectivo en Equipos Ágiles',
                'slug' => 'liderazgo-efectivo-equipos-agiles',
                'description' => 'Desarrolla habilidades de liderazgo para gestionar equipos ágiles de alto rendimiento.',
                'objectives' => 'Aprender metodologías ágiles, gestión de equipos, comunicación efectiva.',
                'level' => 'intermediate',
                'status' => 'published',
                'has_certificate' => true,
                'passing_score' => 75,
                'max_attempts' => 2,
                'published_at' => now(),
            ],
            [
                'company_id' => $company1->id,
                'category_id' => $catSales->id,
                'instructor_id' => $instructor->id,
                'title' => 'Técnicas Avanzadas de Negociación',
                'slug' => 'tecnicas-avanzadas-negociacion',
                'description' => 'Domina las técnicas de negociación moderna para cerrar más ventas.',
                'level' => 'advanced',
                'status' => 'published',
                'has_certificate' => true,
                'passing_score' => 80,
                'max_attempts' => 2,
                'published_at' => now(),
            ],
        ];

        foreach ($courses as $courseData) {
            $course = Course::firstOrCreate(['slug' => $courseData['slug']], $courseData);

            // Create modules and lessons for each course
            if ($course->wasRecentlyCreated || $course->modules()->count() === 0) {
                $modules = $this->getModulesForCourse($course);
                foreach ($modules as $i => $moduleData) {
                    $module = CourseModule::create(array_merge(
                        ['course_id' => $course->id, 'sort_order' => $i + 1],
                        $moduleData['module']
                    ));

                    foreach ($moduleData['lessons'] as $j => $lessonData) {
                        CourseLesson::create(array_merge(
                            ['module_id' => $module->id, 'sort_order' => $j + 1],
                            $lessonData
                        ));
                    }
                }
            }
        }
    }

    private function getModulesForCourse(Course $course): array
    {
        if ($course->slug === 'fundamentos-programacion-web') {
            return [
                [
                    'module' => ['title' => 'Introducción al Desarrollo Web', 'description' => 'Conceptos básicos', 'duration_minutes' => 60],
                    'lessons' => [
                        ['title' => '¿Qué es el Desarrollo Web?', 'content_type' => 'text', 'content' => '<p>El desarrollo web es el proceso de crear sitios y aplicaciones web...</p>', 'duration_minutes' => 15],
                        ['title' => 'Estructura de un Proyecto Web', 'content_type' => 'text', 'content' => '<p>Un proyecto web típico contiene archivos HTML, CSS y JavaScript...</p>', 'duration_minutes' => 20],
                        ['title' => 'Herramientas del Desarrollador', 'content_type' => 'video', 'video_url' => 'https://www.youtube.com/watch?v=example', 'duration_minutes' => 25],
                    ],
                ],
                [
                    'module' => ['title' => 'HTML5 Fundamentos', 'description' => 'Etiquetas y estructura', 'duration_minutes' => 90],
                    'lessons' => [
                        ['title' => 'Etiquetas HTML Básicas', 'content_type' => 'text', 'content' => '<p>HTML usa etiquetas como h1, p, div, span...</p>', 'duration_minutes' => 30],
                        ['title' => 'Formularios HTML', 'content_type' => 'text', 'content' => '<p>Los formularios permiten recopilar datos del usuario...</p>', 'duration_minutes' => 30],
                        ['title' => 'Semántica HTML5', 'content_type' => 'text', 'content' => '<p>HTML5 introdujo etiquetas semánticas como header, nav, main...</p>', 'duration_minutes' => 30],
                    ],
                ],
                [
                    'module' => ['title' => 'CSS3 y Diseño Responsive', 'description' => 'Estilizado y layouts', 'duration_minutes' => 120],
                    'lessons' => [
                        ['title' => 'Selectores CSS', 'content_type' => 'text', 'content' => '<p>Los selectores CSS permiten seleccionar elementos HTML para aplicar estilos...</p>', 'duration_minutes' => 30],
                        ['title' => 'Flexbox y Grid', 'content_type' => 'video', 'video_url' => 'https://www.youtube.com/watch?v=flexbox', 'duration_minutes' => 45],
                        ['title' => 'Diseño Responsive', 'content_type' => 'text', 'content' => '<p>El diseño responsive adapta la interfaz a diferentes tamaños de pantalla...</p>', 'duration_minutes' => 45],
                    ],
                ],
                [
                    'module' => ['title' => 'JavaScript Básico', 'description' => 'Fundamentos de programación', 'duration_minutes' => 120],
                    'lessons' => [
                        ['title' => 'Variables y Tipos de Datos', 'content_type' => 'text', 'content' => '<p>JavaScript tiene varios tipos de datos: string, number, boolean...</p>', 'duration_minutes' => 30],
                        ['title' => 'Funciones y Eventos', 'content_type' => 'text', 'content' => '<p>Las funciones son bloques de código reutilizables...</p>', 'duration_minutes' => 45],
                        ['title' => 'Manipulación del DOM', 'content_type' => 'video', 'video_url' => 'https://www.youtube.com/watch?v=dom', 'duration_minutes' => 45],
                    ],
                ],
            ];
        }

        if ($course->slug === 'liderazgo-efectivo-equipos-agiles') {
            return [
                [
                    'module' => ['title' => 'Fundamentos del Liderazgo Ágil', 'description' => 'Principios ágiles', 'duration_minutes' => 90],
                    'lessons' => [
                        ['title' => 'Manifiesto Ágil', 'content_type' => 'text', 'content' => '<p>El Manifiesto Ágil establece 4 valores y 12 principios...</p>', 'duration_minutes' => 30],
                        ['title' => 'Roles en Scrum', 'content_type' => 'text', 'content' => '<p>Scrum define tres roles: Product Owner, Scrum Master y Development Team...</p>', 'duration_minutes' => 30],
                        ['title' => 'Ceremonias Ágiles', 'content_type' => 'video', 'video_url' => 'https://www.youtube.com/watch?v=scrum', 'duration_minutes' => 30],
                    ],
                ],
                [
                    'module' => ['title' => 'Comunicación Efectiva', 'description' => 'Habilidades comunicativas', 'duration_minutes' => 60],
                    'lessons' => [
                        ['title' => 'Escucha Activa', 'content_type' => 'text', 'content' => '<p>La escucha activa es fundamental para un liderazgo efectivo...</p>', 'duration_minutes' => 30],
                        ['title' => 'Feedback Constructivo', 'content_type' => 'text', 'content' => '<p>Dar y recibir feedback de manera constructiva fortalece el equipo...</p>', 'duration_minutes' => 30],
                    ],
                ],
            ];
        }

        // Default modules for other courses
        return [
            [
                'module' => ['title' => 'Módulo 1: Introducción', 'description' => 'Conceptos fundamentales', 'duration_minutes' => 60],
                'lessons' => [
                    ['title' => 'Bienvenida al Curso', 'content_type' => 'text', 'content' => '<p>Bienvenido a este curso. Aquí aprenderás los fundamentos...</p>', 'duration_minutes' => 20],
                    ['title' => 'Objetivos de Aprendizaje', 'content_type' => 'text', 'content' => '<p>Al finalizar este curso, serás capaz de...</p>', 'duration_minutes' => 20],
                    ['title' => 'Metodología', 'content_type' => 'video', 'video_url' => 'https://www.youtube.com/watch?v=intro', 'duration_minutes' => 20],
                ],
            ],
            [
                'module' => ['title' => 'Módulo 2: Contenido Principal', 'description' => 'Desarrollo del tema', 'duration_minutes' => 90],
                'lessons' => [
                    ['title' => 'Conceptos Clave', 'content_type' => 'text', 'content' => '<p>Los conceptos fundamentales que necesitas dominar...</p>', 'duration_minutes' => 45],
                    ['title' => 'Caso Práctico', 'content_type' => 'text', 'content' => '<p>Aplicaremos lo aprendido en un caso real...</p>', 'duration_minutes' => 45],
                ],
            ],
        ];
    }
}
