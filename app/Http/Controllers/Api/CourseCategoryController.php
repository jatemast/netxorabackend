<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CourseCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CourseCategoryController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $categories = CourseCategory::where('company_id', $request->input('company_id'))
            ->where('is_active', true)
            ->withCount('courses')
            ->orderBy('sort_order')
            ->get();

        return response()->json(['categories' => $categories]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:course_categories,slug',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:course_categories,id',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:7',
            'sort_order' => 'nullable|integer',
        ]);
        $data['company_id'] = $request->input('company_id');
        $data['is_active'] = true;
        $category = CourseCategory::create($data);
        return response()->json(['message' => 'Categoría creada exitosamente.', 'category' => $category], 201);
    }

    public function update(Request $request, CourseCategory $category): JsonResponse
    {
        if ($category->company_id !== (int)$request->input('company_id')) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }
        $category->update($request->validate([
            'name' => 'sometimes|string|max:255',
            'slug' => 'sometimes|string|unique:course_categories,slug,' . $category->id,
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:course_categories,id',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:7',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]));
        return response()->json(['message' => 'Categoría actualizada exitosamente.', 'category' => $category->fresh()]);
    }

    public function destroy(Request $request, CourseCategory $category): JsonResponse
    {
        if ($category->company_id !== (int)$request->input('company_id')) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }
        $category->delete();
        return response()->json(['message' => 'Categoría eliminada exitosamente.']);
    }
}
