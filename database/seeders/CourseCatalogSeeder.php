<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CourseCatalogSeeder extends Seeder
{
    private array $catalog = [];

    public function __construct()
    {
        $this->catalog = [
            'CAT-01 🦺 Seguridad y Salud en el Trabajo (SG-SST)' => [
                'Inducción', 'Riesgos laborales', 'Elementos de Protección Personal (EPP)',
                'COPASST', 'Comité de Convivencia Laboral', 'Preparación y respuesta ante emergencias',
                'Accidentes e incidentes de trabajo', 'Ergonomía y biomecánica', 'Medicina preventiva y del trabajo',
                'Higiene industrial', 'Inspecciones de seguridad', 'Gestión documental del SG-SST',
                'Investigación de incidentes y acciones correctivas', 'Auditorías e indicadores del SG-SST',
                'Cultura y liderazgo en seguridad',
            ],
            'CAT-02 🚛 Transporte y Seguridad Vial' => [
                'Inducción al transporte', 'PESV', 'Manejo defensivo', 'Inspección preoperacional',
                'Mecánica básica', 'Transporte de carga', 'Transporte de pasajeros', 'Logística y distribución',
                'Fatiga y factores humanos', 'Normatividad vial', 'Mercancías peligrosas', 'Gestión de flotas',
                'Atención de emergencias viales', 'Servicio al cliente', 'Tecnología aplicada al transporte',
            ],
            'CAT-03 🍽 Seguridad Alimentaria e Inocuidad' => [
                'Inducción', 'BPM', 'HACCP', 'Manipulación de alimentos', 'Higiene personal',
                'Limpieza y desinfección', 'Control de plagas', 'Cadena de frío', 'Alérgenos',
                'Contaminación cruzada', 'Trazabilidad', 'ISO 22000', 'Food Defense', 'Food Fraud',
                'Auditorías de inocuidad',
            ],
            'CAT-04 🏗 Construcción e Infraestructura' => [
                'Inducción', 'Trabajo en alturas', 'Excavaciones', 'Andamios', 'Izaje de cargas',
                'Demoliciones', 'Espacios confinados', 'Herramientas manuales', 'Herramientas eléctricas',
                'Señalización', 'Orden y aseo', 'Seguridad eléctrica', 'Maquinaria amarilla',
                'Obras civiles', 'Supervisión de obra',
            ],
            'CAT-05 🏭 Industria y Manufactura' => [
                'Inducción', 'Producción', 'Lean Manufacturing', '5S', 'TPM', 'Kaizen', 'Calidad',
                'Control de procesos', 'Mantenimiento', 'Seguridad industrial', 'Gestión visual',
                'Productividad', 'Mejora continua', 'Operación de maquinaria', 'Indicadores industriales',
            ],
            'CAT-06 ⚡ Riesgo Eléctrico y Energías' => [
                'Riesgo eléctrico', 'RETIE', 'LOTO', 'Media tensión', 'Baja tensión', 'Alta tensión',
                'Energía solar', 'Energía eólica', 'Subestaciones', 'Mantenimiento eléctrico',
                'Arco eléctrico', 'Herramientas dieléctricas', 'Primeros auxilios eléctricos',
                'Permisos de trabajo', 'Inspecciones eléctricas',
            ],
            'CAT-07 ⛏ Minería, Petróleo y Gas' => [
                'Inducción', 'HSE', 'Espacios confinados', 'Trabajos en caliente', 'Izaje',
                'Perforación', 'Producción', 'Transporte de hidrocarburos', 'Atmósferas explosivas',
                'Control de pozos', 'Emergencias', 'Medio ambiente', 'Equipos industriales',
                'Permisos de trabajo', 'Operaciones críticas',
            ],
            'CAT-08 🌱 Agroindustria' => [
                'BPA', 'Bioseguridad', 'Agroquímicos', 'Fertilizantes', 'Riego', 'Cosecha',
                'Postcosecha', 'Maquinaria agrícola', 'Ganadería', 'Avicultura', 'Porcicultura',
                'Acuicultura', 'Agricultura sostenible', 'Trazabilidad', 'Seguridad rural',
            ],
            'CAT-09 🏥 Salud' => [
                'Bioseguridad', 'Seguridad del paciente', 'Historia clínica', 'Humanización',
                'Medicamentos', 'Esterilización', 'Residuos hospitalarios', 'Atención de urgencias',
                'Calidad', 'Habilitación', 'PAMEC', 'IAAS', 'Atención al usuario',
                'Gestión del riesgo', 'Ética asistencial',
            ],
            'CAT-10 🧪 Laboratorios' => [
                'Bioseguridad', 'BPL', 'Reactivos', 'Muestras', 'Equipos', 'Calibración',
                'Validación', 'Metrología', 'Residuos', 'Riesgo químico', 'Riesgo biológico',
                'Calidad', 'ISO 17025', 'Documentación', 'Auditorías',
            ],
            'CAT-11 🏨 Hotelería y Turismo' => [
                'Recepción', 'Housekeeping', 'Alimentos y bebidas', 'Servicio al cliente', 'Reservas',
                'Turismo sostenible', 'Eventos', 'Protocolo', 'Seguridad hotelera', 'Quejas',
                'Limpieza', 'Atención internacional', 'Primeros auxilios', 'Emergencias',
                'Calidad del servicio',
            ],
            'CAT-12 👥 Recursos Humanos' => [
                'Reclutamiento', 'Selección', 'Inducción', 'Evaluación', 'Capacitación', 'Bienestar',
                'Nómina', 'Legislación laboral', 'Clima organizacional', 'Desempeño', 'Competencias',
                'Cultura organizacional', 'Comunicación interna', 'Gestión del cambio', 'Offboarding',
            ],
            'CAT-13 🎯 Liderazgo y Habilidades Blandas' => [
                'Liderazgo', 'Comunicación', 'Inteligencia emocional', 'Trabajo en equipo',
                'Negociación', 'Resolución de conflictos', 'Gestión del tiempo', 'Productividad',
                'Coaching', 'Pensamiento crítico', 'Creatividad', 'Adaptabilidad', 'Toma de decisiones',
                'Gestión del estrés', 'Presentaciones efectivas',
            ],
            'CAT-14 🤝 Ventas y Servicio al Cliente' => [
                'Atención al cliente', 'Ventas consultivas', 'CRM', 'Negociación', 'Objeciones',
                'Fidelización', 'PQR', 'Servicio postventa', 'Marketing digital', 'Redes sociales',
                'Ventas B2B', 'Ventas B2C', 'Call Center', 'Omnicanalidad', 'Experiencia del cliente',
            ],
            'CAT-15 💻 Tecnología, Transformación Digital e IA' => [
                'Inteligencia Artificial', 'IA Generativa', 'Automatización', 'Ofimática',
                'Ciberseguridad', 'Computación en la nube', 'Análisis de datos', 'Desarrollo de software',
                'Bases de datos', 'Power BI', 'Excel', 'SAP', 'n8n y automatización', 'DevOps',
                'Transformación digital',
            ],
            'CAT-16 ⚖️ Cumplimiento Legal y Compliance' => [
                'Protección de datos', 'Habeas Data', 'Ética empresarial', 'Anticorrupción',
                'SARLAFT', 'SAGRILAFT', 'PTEE', 'Libre competencia', 'Lavado de activos',
                'Gestión documental', 'Contratación', 'Gobierno corporativo', 'Auditoría',
                'Riesgos de cumplimiento', 'Investigaciones internas',
            ],
            'CAT-17 📋 Sistemas Integrados de Gestión' => [
                'ISO 9001', 'ISO 14001', 'ISO 45001', 'ISO 27001', 'ISO 22000', 'Auditorías internas',
                'Gestión documental', 'Gestión por procesos', 'Indicadores', 'Acciones correctivas',
                'Gestión del riesgo', 'Mejora continua', 'No conformidades', 'Contexto organizacional',
                'Planeación estratégica',
            ],
            'CAT-18 ♻️ Gestión Ambiental' => [
                'Residuos', 'Economía circular', 'Cambio climático', 'Huella de carbono', 'Agua',
                'Energía', 'Biodiversidad', 'Gestión ambiental empresarial', 'ISO 14001', 'ESG',
                'Educación ambiental', 'Vertimientos', 'Emisiones', 'Sustancias peligrosas',
                'Licenciamiento ambiental',
            ],
            'CAT-19 💼 Administración y Finanzas' => [
                'Contabilidad', 'Finanzas', 'Presupuestos', 'Costos', 'Compras', 'Inventarios',
                'Tesorería', 'Facturación', 'Tributación', 'Planeación financiera', 'Indicadores financieros',
                'Gestión administrativa', 'Archivo', 'Contratación', 'Servicio administrativo',
            ],
            'CAT-20 🚀 Innovación y Competencias del Futuro' => [
                'Innovación', 'Design Thinking', 'Lean Startup', 'Agilidad', 'Scrum', 'Productividad',
                'Gestión del conocimiento', 'Transformación cultural', 'Economía digital', 'Emprendimiento',
                'Creatividad', 'Sostenibilidad empresarial', 'Future Skills', 'Aprendizaje continuo',
                'Gestión de proyectos',
            ],
        ];
    }

    public function run(): void
    {
        $companyId = 1; // Default company — change as needed

        $sortOrder = 0;
        $totalCourses = 0;

        foreach ($this->catalog as $categoryName => $courses) {
            $sortOrder += 10;

            // Extract code and clean name for slug
            $parts = explode(' ', $categoryName, 2);
            $code = $parts[0]; // CAT-01
            $name = $categoryName; // Full name with emoji

            $categorySlug = Str::slug(str_replace(['🦺','🚛','🍽','🏗','🏭','⚡','⛏','🌱','🏥','🧪','🏨','👥','🎯','🤝','💻','⚖️','📋','♻️','💼','🚀'], '', $code . ' ' . ($parts[1] ?? '')), '-');

            $category = CourseCategory::firstOrCreate(
                ['slug' => $categorySlug, 'company_id' => $companyId],
                [
                    'company_id' => $companyId,
                    'name' => $name,
                    'description' => "Categoría de cursos: {$name}",
                    'sort_order' => $sortOrder,
                    'is_active' => true,
                ]
            );

            // Create courses for this category
            $courseOrder = 0;
            foreach ($courses as $courseTitle) {
                $courseOrder++;
                $courseSlug = Str::slug($courseTitle, '-') . '-' . Str::random(4);

                Course::firstOrCreate(
                    ['slug' => $courseSlug, 'company_id' => $companyId],
                    [
                        'company_id' => $companyId,
                        'category_id' => $category->id,
                        'title' => $courseTitle,
                        'description' => "Curso de {$courseTitle} - {$name}. Aprende los fundamentos, mejores prácticas y normativas aplicables en este tema esencial para el desarrollo profesional.",
                        'level' => $this->randomLevel(),
                        'status' => 'published',
                        'is_featured' => $courseOrder <= 3,
                        'has_certificate' => true,
                        'passing_score' => 70,
                        'max_attempts' => 3,
                        'duration_hours' => rand(1, 8),
                        'duration_minutes' => 0,
                        'sort_order' => $courseOrder * 10,
                        'published_at' => now()->subDays(rand(1, 90)),
                    ]
                );

                $totalCourses++;
            }
        }

        $this->command->info("✅ CourseCatalogSeeder: {$totalCourses} cursos creados en 20 categorías.");
    }

    private function randomLevel(): string
    {
        $levels = ['beginner', 'intermediate', 'advanced', 'expert'];
        return $levels[array_rand($levels)];
    }
}
