<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\QuestionCategory;
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Database\Seeder;

class QuestionBankSeeder extends Seeder
{
    public function run(): void
    {
        $company1 = Company::where('slug', 'nexora-technologies')->first();

        $categories = [
            ['name' => 'Desarrollo Web', 'slug' => 'desarrollo-web', 'description' => 'Preguntas sobre HTML, CSS y JavaScript'],
            ['name' => 'Liderazgo', 'slug' => 'liderazgo-preguntas', 'description' => 'Preguntas sobre liderazgo y gestión'],
            ['name' => 'Seguridad Informática', 'slug' => 'seguridad-informatica', 'description' => 'Preguntas sobre ciberseguridad'],
        ];

        foreach ($categories as $cat) {
            QuestionCategory::firstOrCreate(
                ['slug' => $cat['slug']],
                array_merge(['company_id' => $company1->id, 'is_active' => true], $cat)
            );
        }

        $catWeb = QuestionCategory::where('slug', 'desarrollo-web')->first();
        $catLeadership = QuestionCategory::where('slug', 'liderazgo-preguntas')->first();
        $catSecurity = QuestionCategory::where('slug', 'seguridad-informatica')->first();

        $questions = [
            // Desarrollo Web - Multiple Choice
            [
                'company_id' => $company1->id, 'category_id' => $catWeb->id,
                'type' => 'multiple_choice', 'difficulty' => 'easy',
                'question_text' => '¿Qué significa HTML?',
                'explanation' => 'HTML significa HyperText Markup Language, es el lenguaje estándar para crear páginas web.',
                'points' => 1,
                'options' => [
                    ['option_text' => 'HyperText Markup Language', 'is_correct' => true],
                    ['option_text' => 'High Tech Modern Language', 'is_correct' => false],
                    ['option_text' => 'HyperTool Markup Language', 'is_correct' => false],
                    ['option_text' => 'Home Tool Markup Language', 'is_correct' => false],
                ],
            ],
            [
                'company_id' => $company1->id, 'category_id' => $catWeb->id,
                'type' => 'multiple_choice', 'difficulty' => 'easy',
                'question_text' => '¿Cuál es la etiqueta correcta para un párrafo en HTML?',
                'points' => 1,
                'options' => [
                    ['option_text' => '<p>', 'is_correct' => true],
                    ['option_text' => '<paragraph>', 'is_correct' => false],
                    ['option_text' => '<par>', 'is_correct' => false],
                    ['option_text' => '<pg>', 'is_correct' => false],
                ],
            ],
            [
                'company_id' => $company1->id, 'category_id' => $catWeb->id,
                'type' => 'multiple_choice', 'difficulty' => 'medium',
                'question_text' => '¿Qué método JavaScript se usa para seleccionar un elemento por su ID?',
                'points' => 1,
                'options' => [
                    ['option_text' => 'document.getElementById()', 'is_correct' => true],
                    ['option_text' => 'document.querySelectorClass()', 'is_correct' => false],
                    ['option_text' => 'document.getElementByName()', 'is_correct' => false],
                    ['option_text' => 'document.selectById()', 'is_correct' => false],
                ],
            ],
            // Desarrollo Web - True/False
            [
                'company_id' => $company1->id, 'category_id' => $catWeb->id,
                'type' => 'true_false', 'difficulty' => 'easy',
                'question_text' => 'CSS significa Cascading Style Sheets.',
                'explanation' => 'Correcto, CSS (Cascading Style Sheets) se usa para estilizar páginas web.',
                'points' => 1,
                'options' => [
                    ['option_text' => 'Verdadero', 'is_correct' => true],
                    ['option_text' => 'Falso', 'is_correct' => false],
                ],
            ],
            [
                'company_id' => $company1->id, 'category_id' => $catWeb->id,
                'type' => 'true_false', 'difficulty' => 'medium',
                'question_text' => 'JavaScript solo se ejecuta en el servidor.',
                'explanation' => 'Falso, JavaScript se ejecuta tanto en el navegador (cliente) como en el servidor (Node.js).',
                'points' => 1,
                'options' => [
                    ['option_text' => 'Verdadero', 'is_correct' => false],
                    ['option_text' => 'Falso', 'is_correct' => true],
                ],
            ],
            // Desarrollo Web - Multiple Select
            [
                'company_id' => $company1->id, 'category_id' => $catWeb->id,
                'type' => 'multiple_select', 'difficulty' => 'hard',
                'question_text' => '¿Cuáles de los siguientes son frameworks de JavaScript? (Seleccione todos los que apliquen)',
                'explanation' => 'React, Vue.js y Angular son frameworks/bibliotecas de JavaScript. Django es de Python.',
                'points' => 2,
                'options' => [
                    ['option_text' => 'React', 'is_correct' => true],
                    ['option_text' => 'Django', 'is_correct' => false],
                    ['option_text' => 'Vue.js', 'is_correct' => true],
                    ['option_text' => 'Angular', 'is_correct' => true],
                ],
            ],
            // Liderazgo
            [
                'company_id' => $company1->id, 'category_id' => $catLeadership->id,
                'type' => 'multiple_choice', 'difficulty' => 'medium',
                'question_text' => '¿Cuál es un principio del Manifiesto Ágil?',
                'points' => 1,
                'options' => [
                    ['option_text' => 'Individuos e interacciones sobre procesos y herramientas', 'is_correct' => true],
                    ['option_text' => 'Documentación exhaustiva sobre software funcionando', 'is_correct' => false],
                    ['option_text' => 'Seguir el plan sobre responder al cambio', 'is_correct' => false],
                    ['option_text' => 'Negociación de contratos sobre colaboración con el cliente', 'is_correct' => false],
                ],
            ],
            [
                'company_id' => $company1->id, 'category_id' => $catLeadership->id,
                'type' => 'true_false', 'difficulty' => 'easy',
                'question_text' => 'Un líder efectivo debe saber delegar responsabilidades.',
                'points' => 1,
                'options' => [
                    ['option_text' => 'Verdadero', 'is_correct' => true],
                    ['option_text' => 'Falso', 'is_correct' => false],
                ],
            ],
            // Seguridad
            [
                'company_id' => $company1->id, 'category_id' => $catSecurity->id,
                'type' => 'multiple_choice', 'difficulty' => 'medium',
                'question_text' => '¿Qué es phishing?',
                'points' => 1,
                'options' => [
                    ['option_text' => 'Un ataque que suplanta identidades para robar información', 'is_correct' => true],
                    ['option_text' => 'Un tipo de firewall', 'is_correct' => false],
                    ['option_text' => 'Un protocolo de cifrado', 'is_correct' => false],
                    ['option_text' => 'Un antivirus', 'is_correct' => false],
                ],
            ],
            [
                'company_id' => $company1->id, 'category_id' => $catSecurity->id,
                'type' => 'true_false', 'difficulty' => 'easy',
                'question_text' => 'Es seguro usar la misma contraseña en todas tus cuentas.',
                'points' => 1,
                'options' => [
                    ['option_text' => 'Verdadero', 'is_correct' => false],
                    ['option_text' => 'Falso', 'is_correct' => true],
                ],
            ],
        ];

        foreach ($questions as $qData) {
            $options = $qData['options'];
            unset($qData['options']);

            $question = Question::firstOrCreate(
                ['question_text' => $qData['question_text'], 'company_id' => $company1->id],
                $qData
            );

            if ($question->wasRecentlyCreated || $question->options()->count() === 0) {
                foreach ($options as $i => $opt) {
                    QuestionOption::create(array_merge(
                        ['question_id' => $question->id, 'sort_order' => $i],
                        $opt
                    ));
                }
            }
        }
    }
}
