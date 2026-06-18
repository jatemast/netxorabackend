<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * List all registered companies with stats (master only).
     */
    public function index(Request $request): JsonResponse
    {
        $query = Company::withCount([
            'users',
            'employees',
            'courses',
            'evaluations',
            'certificates',
        ]);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nit', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        $perPage = $request->input('per_page', 15);
        $companies = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return response()->json($companies);
    }

    /**
     * Show a single company with full stats.
     */
    public function show(Company $company): JsonResponse
    {
        $company->loadCount([
            'users', 'employees', 'courses', 'evaluations',
            'certificates', 'microlearningContents',
        ]);

        return response()->json([
            'company' => $company,
        ]);
    }

    /**
     * Register a new company.
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:companies,slug',
            'nit' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:100',
            'logo' => 'nullable|string|max:500',
            'is_active' => 'nullable|boolean',
            'settings' => 'nullable|json',
        ]);

        $data['is_active'] = $data['is_active'] ?? true;
        $company = Company::create($data);

        return response()->json([
            'message' => 'Empresa creada exitosamente.',
            'company' => $company,
        ], 201);
    }

    /**
     * Update a company.
     */
    public function update(Request $request, Company $company): JsonResponse
    {
        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'slug' => 'sometimes|string|unique:companies,slug,' . $company->id,
            'nit' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:100',
            'logo' => 'nullable|string|max:500',
            'is_active' => 'nullable|boolean',
            'settings' => 'nullable|json',
        ]);

        $company->update($data);

        return response()->json([
            'message' => 'Empresa actualizada exitosamente.',
            'company' => $company->fresh(),
        ]);
    }

    /**
     * Deactivate (soft-delete) a company.
     */
    public function destroy(Company $company): JsonResponse
    {
        $company->update(['is_active' => false]);
        $company->delete();

        return response()->json([
            'message' => 'Empresa desactivada exitosamente.',
        ]);
    }

    /**
     * Toggle company active status.
     */
    public function toggleActive(Company $company): JsonResponse
    {
        $company->update(['is_active' => !$company->is_active]);

        return response()->json([
            'message' => $company->is_active
                ? 'Empresa activada exitosamente.'
                : 'Empresa desactivada exitosamente.',
            'company' => $company,
        ]);
    }
}
