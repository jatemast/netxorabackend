<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Course;
use App\Models\Evaluation;
use Illuminate\Database\Seeder;

class EvaluationSeeder extends Seeder
{
    public function run(): void
    {
        $company1 = Company::where('slug', 'nexora-technologies')->first();
        $course1 = Course::where('slug', 'fundamentos-programacion-web')->first();
        $course2 = Course::where('slug', 'liderazgo-efectivo-equipos-agiles')->first();

        $evaluations = [
            [
                'company_id' => $company1->id,
                'course_id' => $course1->id,
                'title' => 'Evaluación Final - Fundamentos de Programación Web',
                'description' => 'Evaluación final del curso de fundamentos de programación web.',
                'instructions' => 'Responde todas las preguntas. Tienes 30 minutos. Necesitas 70% para aprobar.',
                'total_questions' => 10,
                'time_limit_minutes' => 30,
                'passing_score' => 70,
                'max_attempts' => 3,
                'randomize_questions' => true,
                'randomize_options' => true,
                'show_results' => true,
                'show_correct_answers' => false,
                'status' => 'published',
                'question_categories' => json_encode(['desarrollo-web']),
                'difficulty_distribution' => json_encode(['easy' => 40, 'medium' => 40, 'hard' => 20]),
            ],
            [
                'company_id' => $company1->id,
                'course_id' => $course2->id,
                'title' => 'Evaluación Final - Liderazgo Efectivo',
                'description' => 'Evaluación del curso de liderazgo efectivo en equipos ágiles.',
                'instructions' => 'Responde todas las preguntas. Tienes 25 minutos.',
                'total_questions' => 8,
                'time_limit_minutes' => 25,
                'passing_score' => 75,
                'max_attempts' => 2,
                'randomize_questions' => true,
                'randomize_options' => true,
                'show_results' => true,
                'status' => 'published',
                'question_categories' => json_encode(['liderazgo-preguntas']),
                'difficulty_distribution' => json_encode(['easy' => 50, 'medium' => 50]),
            ],
        ];

        foreach ($evaluations as $data) {
            Evaluation::firstOrCreate(
                ['title' => $data['title'], 'company_id' => $company1->id],
                $data
            );
        }
    }
}
