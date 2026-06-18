<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $companyId = $request->input('company_id');

        $query = Course::byCompany($companyId)
            ->with(['category:id,name', 'instructor:id,name,lastname']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $sortField = $request->input('sort_field', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');

        $perPage = $request->input('per_page', 15);
        $courses = $query->orderBy($sortField, $sortOrder)->paginate($perPage);

        return response()->json($courses);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:courses,slug',
            'description' => 'nullable|string',
            'objectives' => 'nullable|string',
            'requirements' => 'nullable|string',
            'category_id' => 'nullable|exists:course_categories,id',
            'instructor_id' => 'nullable|exists:users,id',
            'thumbnail' => 'nullable|string|max:500',
            'cover_image' => 'nullable|string|max:500',
            'duration_hours' => 'nullable|integer|min:0',
            'duration_minutes' => 'nullable|integer|min:0',
            'level' => 'nullable|in:beginner,intermediate,advanced,expert',
            'status' => 'nullable|in:draft,published,archived',
            'is_featured' => 'nullable|boolean',
            'has_certificate' => 'nullable|boolean',
            'passing_score' => 'nullable|numeric|min:0|max:100',
            'max_attempts' => 'nullable|integer|min:1',
            'metadata' => 'nullable|json',
        ]);

        $data['company_id'] = $request->input('company_id');
        $course = Course::create($data);

        return response()->json([
            'message' => 'Curso creado exitosamente.',
            'course' => $course->load(['category', 'instructor']),
        ], 201);
    }

    public function show(Request $request, Course $course): JsonResponse
    {
        if ($course->company_id !== (int)$request->input('company_id')) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        return response()->json([
            'course' => $course->load([
                'category', 'instructor',
                'modules.lessons',
                'evaluations',
                'enrollments' => fn($q) => $q->with('employee')->limit(20),
            ]),
        ]);
    }

    public function update(Request $request, Course $course): JsonResponse
    {
        if ($course->company_id !== (int)$request->input('company_id')) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        $data = $request->validate([
            'title' => 'sometimes|string|max:255',
            'slug' => 'sometimes|string|unique:courses,slug,' . $course->id,
            'description' => 'nullable|string',
            'objectives' => 'nullable|string',
            'requirements' => 'nullable|string',
            'category_id' => 'nullable|exists:course_categories,id',
            'instructor_id' => 'nullable|exists:users,id',
            'thumbnail' => 'nullable|string|max:500',
            'cover_image' => 'nullable|string|max:500',
            'duration_hours' => 'nullable|integer|min:0',
            'duration_minutes' => 'nullable|integer|min:0',
            'level' => 'nullable|in:beginner,intermediate,advanced,expert',
            'status' => 'nullable|in:draft,published,archived',
            'is_featured' => 'nullable|boolean',
            'has_certificate' => 'nullable|boolean',
            'passing_score' => 'nullable|numeric|min:0|max:100',
            'max_attempts' => 'nullable|integer|min:1',
            'metadata' => 'nullable|json',
        ]);

        $course->update($data);

        return response()->json([
            'message' => 'Curso actualizado exitosamente.',
            'course' => $course->fresh()->load(['category', 'instructor']),
        ]);
    }

    public function destroy(Request $request, Course $course): JsonResponse
    {
        if ($course->company_id !== (int)$request->input('company_id')) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        $course->delete();

        return response()->json(['message' => 'Curso eliminado exitosamente.']);
    }
}

