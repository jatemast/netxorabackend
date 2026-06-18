<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Evaluation;
use App\Models\EvaluationAttempt;
use App\Models\EvaluationAnswer;
use App\Models\Question;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $companyId = $request->input('company_id');

        $query = Evaluation::where('company_id', $companyId)
            ->with(['course:id,title']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%");
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $perPage = $request->input('per_page', 15);
        $evaluations = $query->latest()->paginate($perPage);

        return response()->json($evaluations);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'instructions' => 'nullable|string',
            'course_id' => 'nullable|exists:courses,id',
            'total_questions' => 'required|integer|min:1',
            'time_limit_minutes' => 'required|integer|min:1',
            'passing_score' => 'required|numeric|min:0|max:100',
            'max_attempts' => 'required|integer|min:1',
            'randomize_questions' => 'nullable|boolean',
            'randomize_options' => 'nullable|boolean',
            'show_results' => 'nullable|boolean',
            'show_correct_answers' => 'nullable|boolean',
            'status' => 'nullable|in:draft,published,archived',
            'question_categories' => 'nullable|json',
            'difficulty_distribution' => 'nullable|json',
            'available_from' => 'nullable|date',
            'available_until' => 'nullable|date|after:available_from',
        ]);

        $data['company_id'] = $request->input('company_id');
        $evaluation = Evaluation::create($data);

        return response()->json([
            'message' => 'Evaluación creada exitosamente.',
            'evaluation' => $evaluation,
        ], 201);
    }

    public function show(Request $request, Evaluation $evaluation): JsonResponse
    {
        if ($evaluation->company_id !== (int)$request->input('company_id')) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        return response()->json([
            'evaluation' => $evaluation->load(['course', 'attempts' => fn($q) => $q->with('employee')->latest()->limit(20)]),
        ]);
    }

    public function update(Request $request, Evaluation $evaluation): JsonResponse
    {
        if ($evaluation->company_id !== (int)$request->input('company_id')) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        $evaluation->update($request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'instructions' => 'nullable|string',
            'course_id' => 'nullable|exists:courses,id',
            'total_questions' => 'sometimes|integer|min:1',
            'time_limit_minutes' => 'sometimes|integer|min:1',
            'passing_score' => 'sometimes|numeric|min:0|max:100',
            'max_attempts' => 'sometimes|integer|min:1',
            'randomize_questions' => 'nullable|boolean',
            'randomize_options' => 'nullable|boolean',
            'show_results' => 'nullable|boolean',
            'show_correct_answers' => 'nullable|boolean',
            'status' => 'nullable|in:draft,published,archived',
            'question_categories' => 'nullable|json',
            'difficulty_distribution' => 'nullable|json',
            'available_from' => 'nullable|date',
            'available_until' => 'nullable|date|after:available_from',
        ]));

        return response()->json([
            'message' => 'Evaluación actualizada exitosamente.',
            'evaluation' => $evaluation->fresh(),
        ]);
    }

    public function destroy(Request $request, Evaluation $evaluation): JsonResponse
    {
        if ($evaluation->company_id !== (int)$request->input('company_id')) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        $evaluation->delete();

        return response()->json(['message' => 'Evaluación eliminada exitosamente.']);
    }

    public function start(Request $request, Evaluation $evaluation): JsonResponse
    {
        $employeeId = $request->input('employee_id');
        $companyId = $request->input('company_id');

        if (!$employeeId) {
            return response()->json(['message' => 'Se requiere employee_id.'], 400);
        }

        // Check attempt limit
        $attemptCount = EvaluationAttempt::where('evaluation_id', $evaluation->id)
            ->where('employee_id', $employeeId)
            ->count();

        if ($attemptCount >= $evaluation->max_attempts) {
            return response()->json(['message' => 'Has alcanzado el límite máximo de intentos.'], 422);
        }

        // Generate random questions
        $questionsQuery = Question::where('company_id', $companyId)->active();

        if (!empty($evaluation->question_categories)) {
            $categories = is_array($evaluation->question_categories)
                ? $evaluation->question_categories
                : json_decode($evaluation->question_categories, true);

            if (!empty($categories)) {
                $categorySlugs = array_column($categories, 0) ?: $categories;
                $questionsQuery->whereHas('category', fn($q) => $q->whereIn('slug', $categorySlugs));
            }
        }

        $questions = $questionsQuery
            ->with('options')
            ->inRandomOrder()
            ->take($evaluation->total_questions)
            ->get();

        if ($questions->count() < $evaluation->total_questions) {
            $questions = Question::where('company_id', $companyId)
                ->active()
                ->with('options')
                ->inRandomOrder()
                ->take($evaluation->total_questions)
                ->get();
        }

        // Create attempt
        $attempt = EvaluationAttempt::create([
            'evaluation_id' => $evaluation->id,
            'employee_id' => $employeeId,
            'company_id' => $companyId,
            'attempt_number' => $attemptCount + 1,
            'status' => 'in_progress',
            'started_at' => now(),
            'questions_snapshot' => $questions->map(fn($q) => [
                'id' => $q->id,
                'question_text' => $q->question_text,
                'type' => $q->type,
                'points' => $q->points,
                'options' => $q->options->map(fn($o) => [
                    'id' => $o->id,
                    'option_text' => $o->option_text,
                    'sort_order' => $o->sort_order,
                ]),
            ])->toArray(),
        ]);

        $questionsData = $questions->map(fn($q) => [
            'id' => $q->id,
            'question_text' => $q->question_text,
            'type' => $q->type,
            'points' => $q->points,
            'image_url' => $q->image_url,
            'options' => $evaluation->randomize_options
                ? $q->options->shuffle()->map(fn($o) => ['id' => $o->id, 'option_text' => $o->option_text])
                : $q->options->map(fn($o) => ['id' => $o->id, 'option_text' => $o->option_text]),
        ]);

        return response()->json([
            'attempt' => [
                'id' => $attempt->id,
                'attempt_number' => $attempt->attempt_number,
                'time_limit_minutes' => $evaluation->time_limit_minutes,
                'total_questions' => $evaluation->total_questions,
                'passing_score' => $evaluation->passing_score,
            ],
            'questions' => $questionsData,
        ]);
    }

    public function submit(Request $request, EvaluationAttempt $attempt): JsonResponse
    {
        if ($attempt->status !== 'in_progress') {
            return response()->json(['message' => 'Este intento ya fue completado.'], 422);
        }

        $request->validate([
            'answers' => 'required|array',
            'answers.*.question_id' => 'required|exists:questions,id',
            'answers.*.selected_options' => 'required|array',
            'time_spent_seconds' => 'nullable|integer',
        ]);

        $questionsSnapshot = is_array($attempt->questions_snapshot)
            ? $attempt->questions_snapshot
            : json_decode($attempt->questions_snapshot, true);

        $totalPoints = 0;
        $earnedPoints = 0;

        foreach ($request->answers as $answerData) {
            $question = Question::with('correctOptions')->find($answerData['question_id']);
            if (!$question) continue;

            $totalPoints += $question->points;
            $selected = $answerData['selected_options'];

            // Check if correct
            $correctOptionIds = $question->correctOptions->pluck('id')->toArray();
            sort($selected);
            sort($correctOptionIds);
            $isCorrect = $selected == $correctOptionIds;

            if ($isCorrect) {
                $earnedPoints += $question->points;
            }

            EvaluationAnswer::create([
                'attempt_id' => $attempt->id,
                'question_id' => $question->id,
                'selected_options' => json_encode($selected),
                'is_correct' => $isCorrect,
                'points_earned' => $isCorrect ? $question->points : 0,
            ]);
        }

        $percentage = $totalPoints > 0 ? round(($earnedPoints / $totalPoints) * 100, 2) : 0;
        $isPassed = $percentage >= $attempt->evaluation->passing_score;

        $attempt->update([
            'score' => $earnedPoints,
            'total_points' => $totalPoints,
            'percentage' => $percentage,
            'is_passed' => $isPassed,
            'status' => 'completed',
            'time_spent_seconds' => $request->input('time_spent_seconds', 0),
            'completed_at' => now(),
        ]);

        return response()->json([
            'message' => $isPassed ? '¡Felicitaciones! Has aprobado la evaluación.' : 'Has completado la evaluación. No alcanzaste la nota mínima.',
            'result' => [
                'score' => $earnedPoints,
                'total_points' => $totalPoints,
                'percentage' => $percentage,
                'is_passed' => $isPassed,
                'passing_score' => $attempt->evaluation->passing_score,
            ],
        ]);
    }

    public function results(Request $request, EvaluationAttempt $attempt): JsonResponse
    {
        $answers = $attempt->answers()->with('question.options')->get();

        return response()->json([
            'attempt' => $attempt->load('evaluation'),
            'answers' => $answers,
        ]);
    }

    public function employeeAttempts(Request $request): JsonResponse
    {
        $employeeId = $request->input('employee_id');

        $attempts = EvaluationAttempt::where('employee_id', $employeeId)
            ->with('evaluation:id,title,passing_score')
            ->latest()
            ->paginate(15);

        return response()->json($attempts);
    }
}
