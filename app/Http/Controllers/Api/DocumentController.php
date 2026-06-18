<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $companyId = $request->input('company_id');

        $query = Document::where('company_id', $companyId)
            ->with(['uploadedBy:id,name']);

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $perPage = $request->input('per_page', 15);
        $documents = $query->latest()->paginate($perPage);

        return response()->json($documents);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string|max:100',
            'category' => 'nullable|string|max:100',
            'file_path' => 'nullable|string|max:500',
            'file_url' => 'nullable|string|max:500',
            'file_type' => 'nullable|string|max:50',
            'file_size' => 'nullable|integer',
            'thumbnail' => 'nullable|string|max:500',
            'version' => 'nullable|string|max:20',
            'status' => 'nullable|string|max:50',
            'is_public' => 'nullable|boolean',
            'tags' => 'nullable|json',
            'metadata' => 'nullable|json',
        ]);

        $data['company_id'] = $request->input('company_id');
        $data['uploaded_by'] = $request->user()->id;
        $data['slug'] = Str::slug($data['title']);

        $document = Document::create($data);

        return response()->json([
            'message' => 'Documento creado exitosamente.',
            'document' => $document,
        ], 201);
    }

    public function show(Request $request, Document $document): JsonResponse
    {
        if ($document->company_id !== (int) $request->input('company_id')) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        return response()->json([
            'document' => $document->load(['uploadedBy:id,name', 'documentAssignments', 'documentTracking']),
        ]);
    }

    public function update(Request $request, Document $document): JsonResponse
    {
        if ($document->company_id !== (int) $request->input('company_id')) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        $data = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'type' => 'sometimes|string|max:100',
            'category' => 'nullable|string|max:100',
            'file_path' => 'nullable|string|max:500',
            'file_url' => 'nullable|string|max:500',
            'file_type' => 'nullable|string|max:50',
            'file_size' => 'nullable|integer',
            'thumbnail' => 'nullable|string|max:500',
            'version' => 'nullable|string|max:20',
            'status' => 'nullable|string|max:50',
            'is_public' => 'nullable|boolean',
            'tags' => 'nullable|json',
            'metadata' => 'nullable|json',
        ]);

        if (isset($data['title'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $document->update($data);

        return response()->json([
            'message' => 'Documento actualizado exitosamente.',
            'document' => $document,
        ]);
    }

    public function destroy(Document $document): JsonResponse
    {
        $document->delete();

        return response()->json([
            'message' => 'Documento eliminado exitosamente.',
        ]);
    }

    public function assign(Request $request, Document $document): JsonResponse
    {
        if ($document->company_id !== (int) $request->input('company_id')) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        $data = $request->validate([
            'employee_ids' => 'nullable|array',
            'employee_ids.*' => 'exists:employees,id',
            'area_ids' => 'nullable|array',
            'area_ids.*' => 'exists:areas,id',
            'position_ids' => 'nullable|array',
            'position_ids.*' => 'exists:positions,id',
            'due_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $assignments = [];

        // Assign to employees
        if (!empty($data['employee_ids'])) {
            foreach ($data['employee_ids'] as $employeeId) {
                $assignments[] = $document->documentAssignments()->create([
                    'document_id' => $document->id,
                    'employee_id' => $employeeId,
                    'company_id' => $document->company_id,
                    'assigned_by' => $request->user()->id,
                    'due_date' => $data['due_date'] ?? null,
                    'notes' => $data['notes'] ?? null,
                ]);
            }
        }

        // Assign to areas (all employees in those areas)
        if (!empty($data['area_ids'])) {
            $employeesInAreas = \App\Models\Employee::whereIn('area_id', $data['area_ids'])
                ->where('company_id', $document->company_id)
                ->pluck('id');

            foreach ($employeesInAreas as $employeeId) {
                $assignments[] = $document->documentAssignments()->firstOrCreate(
                    [
                        'document_id' => $document->id,
                        'employee_id' => $employeeId,
                    ],
                    [
                        'company_id' => $document->company_id,
                        'assigned_by' => $request->user()->id,
                        'due_date' => $data['due_date'] ?? null,
                        'notes' => $data['notes'] ?? null,
                    ]
                );
            }
        }

        // Assign to positions (all employees in those positions)
        if (!empty($data['position_ids'])) {
            $employeesInPositions = \App\Models\Employee::whereIn('position_id', $data['position_ids'])
                ->where('company_id', $document->company_id)
                ->pluck('id');

            foreach ($employeesInPositions as $employeeId) {
                $assignments[] = $document->documentAssignments()->firstOrCreate(
                    [
                        'document_id' => $document->id,
                        'employee_id' => $employeeId,
                    ],
                    [
                        'company_id' => $document->company_id,
                        'assigned_by' => $request->user()->id,
                        'due_date' => $data['due_date'] ?? null,
                        'notes' => $data['notes'] ?? null,
                    ]
                );
            }
        }

        return response()->json([
            'message' => 'Documento asignado exitosamente.',
            'assignments_count' => count($assignments),
        ]);
    }

    public function tracking(Request $request): JsonResponse
    {
        $companyId = $request->input('company_id');
        $employeeId = $request->input('employee_id');

        $query = \App\Models\DocumentTracking::where('company_id', $companyId)
            ->with(['document:id,title', 'employee:id,first_name,last_name']);

        if ($employeeId) {
            $query->where('employee_id', $employeeId);
        }

        $perPage = $request->input('per_page', 15);
        $tracking = $query->latest()->paginate($perPage);

        return response()->json($tracking);
    }
}
