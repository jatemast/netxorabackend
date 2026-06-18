<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\QuestionCategory;
use App\Models\QuestionOption;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $companyId = $request->input('company_id');

        $query = Question::where('company_id', $companyId)
            ->with(['category:id,name', 'options']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('question_text', 'like', "%{$search}%");
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('difficulty')) {
            $query->where('difficulty', $request->difficulty);
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        $perPage = $request->input('per_page', 15);
        $questions = $query->latest()->paginate($perPage);

        return response()->json($questions);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'type' => 'required|in:multiple_choice,true_false,multiple_select',
            'difficulty' => 'required|in:easy,medium,hard',
            'question_text' => 'required|string',
            'explanation' => 'nullable|string',
            'image_url' => 'nullable|string|max:500',
            'points' => 'nullable|integer|min:1',
            'category_id' => 'nullable|exists:question_categories,id',
            'options' => 'required|array|min:2',
            'options.*.option_text' => 'required|string',
            'options.*.is_correct' => 'required|boolean',
            'options.*.sort_order' => 'nullable|integer',
        ]);

        $data['company_id'] = $request->input('company_id');
        $data['is_active'] = true;

        $options = $data['options'];
        unset($data['options']);

        $question = Question::create($data);

        foreach ($options as $i => $opt) {
            QuestionOption::create([
                'question_id' => $question->id,
                'option_text' => $opt['option_text'],
                'is_correct' => $opt['is_correct'],
                'sort_order' => $opt['sort_order'] ?? $i,
            ]);
        }

        return response()->json([
            'message' => 'Pregunta creada exitosamente.',
            'question' => $question->load(['category', 'options']),
        ], 201);
    }

    public function show(Request $request, Question $question): JsonResponse
    {
        if ($question->company_id !== (int)$request->input('company_id')) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        return response()->json([
            'question' => $question->load(['category', 'options']),
        ]);
    }

    public function update(Request $request, Question $question): JsonResponse
    {
        if ($question->company_id !== (int)$request->input('company_id')) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        $data = $request->validate([
            'type' => 'sometimes|in:multiple_choice,true_false,multiple_select',
            'difficulty' => 'sometimes|in:easy,medium,hard',
            'question_text' => 'sometimes|string',
            'explanation' => 'nullable|string',
            'image_url' => 'nullable|string|max:500',
            'points' => 'nullable|integer|min:1',
            'category_id' => 'nullable|exists:question_categories,id',
            'is_active' => 'nullable|boolean',
            'options' => 'nullable|array|min:2',
            'options.*.id' => 'nullable|exists:question_options,id',
            'options.*.option_text' => 'required|string',
            'options.*.is_correct' => 'required|boolean',
            'options.*.sort_order' => 'nullable|integer',
        ]);

        $options = $data['options'] ?? null;
        unset($data['options']);

        $question->update($data);

        if ($options) {
            $question->options()->delete();
            foreach ($options as $i => $opt) {
                QuestionOption::create([
                    'question_id' => $question->id,
                    'option_text' => $opt['option_text'],
                    'is_correct' => $opt['is_correct'],
                    'sort_order' => $opt['sort_order'] ?? $i,
                ]);
            }
        }

        return response()->json([
            'message' => 'Pregunta actualizada exitosamente.',
            'question' => $question->fresh()->load(['category', 'options']),
        ]);
    }

    public function destroy(Request $request, Question $question): JsonResponse
    {
        if ($question->company_id !== (int)$request->input('company_id')) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        $question->delete();

        return response()->json(['message' => 'Pregunta eliminada exitosamente.']);
    }
}

