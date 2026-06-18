<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\MicrolearningContent;
use Illuminate\Database\Seeder;

class MicrolearningSeeder extends Seeder
{
    public function run(): void
    {
        $company1 = Company::where('slug', 'nexora-technologies')->first();

        $contents = [
            [
                'company_id' => $company1->id,
                'title' => 'Tip del día: Atajos de teclado en VS Code',
                'description' => 'Aprende los atajos más útiles para aumentar tu productividad.',
                'content_type' => 'text',
                'content' => '<p>Ctrl+P: Abrir archivo rápidamente. Ctrl+Shift+P: Paleta de comandos. Ctrl+D: Seleccionar siguiente ocurrencia. Alt+↑/↓: Mover línea.</p>',
                'read_time_minutes' => 3,
                'frequency' => 'daily',
                'status' => 'published',
                'tags' => json_encode(['productividad', 'desarrollo', 'tips']),
                'scheduled_at' => now(),
            ],
            [
                'company_id' => $company1->id,
                'title' => 'Microlearning: Comunicación Asertiva',
                'description' => 'Técnica semanal para mejorar la comunicación en el equipo.',
                'content_type' => 'video',
                'video_url' => 'https://www.youtube.com/watch?v=comunicacion',
                'content' => '<p>La comunicación asertiva implica expresar tus ideas con claridad y respeto.</p>',
                'read_time_minutes' => 5,
                'frequency' => 'weekly',
                'status' => 'published',
                'tags' => json_encode(['liderazgo', 'comunicacion', 'soft-skills']),
                'scheduled_at' => now()->addDay(),
            ],
            [
                'company_id' => $company1->id,
                'title' => 'Concepto: Principio de Responsabilidad Única (SOLID)',
                'description' => 'Uno de los principios SOLID más importantes en programación.',
                'content_type' => 'text',
                'content' => '<p>El Principio de Responsabilidad Única establece que una clase debe tener una sola razón para cambiar. Esto hace el código más mantenible y fácil de entender.</p>',
                'read_time_minutes' => 4,
                'frequency' => 'daily',
                'status' => 'published',
                'tags' => json_encode(['desarrollo', 'arquitectura', 'SOLID']),
                'scheduled_at' => now()->addHours(6),
            ],
        ];

        foreach ($contents as $data) {
            MicrolearningContent::firstOrCreate(
                ['title' => $data['title'], 'company_id' => $company1->id],
                $data
            );
        }
    }
}
