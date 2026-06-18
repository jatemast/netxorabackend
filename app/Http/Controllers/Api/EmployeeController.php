<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Imports\EmployeesImport;
use App\Exports\EmployeesExport;
use App\Models\Employee;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $companyId = $request->input('company_id');

        $query = Employee::byCompany($companyId)
            ->with(['user:id,name,lastname,email']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('document_number', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('position', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('area')) {
            $query->where('area', $request->area);
        }

        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        $sortField = $request->input('sort_field', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');
        $query->orderBy($sortField, $sortOrder);

        $perPage = $request->input('per_page', 15);
        $employees = $query->paginate($perPage);

        return response()->json($employees);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'document_type' => 'nullable|string|max:10',
            'document_number' => 'required|string|unique:employees,document_number',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'position' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'area' => 'nullable|string|max:255',
            'status' => 'nullable|in:active,inactive,suspended',
            'hire_date' => 'nullable|date',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:255',
            'emergency_contact' => 'nullable|string|max:255',
            'emergency_phone' => 'nullable|string|max:20',
            'notes' => 'nullable|string',
        ]);

        $data['company_id'] = $request->input('company_id');

        $employee = Employee::create($data);

        return response()->json([
            'message' => 'Empleado creado exitosamente.',
            'employee' => $employee->load('user'),
        ], 201);
    }

    public function show(Request $request, Employee $employee): JsonResponse
    {
        if ($employee->company_id !== (int)$request->input('company_id')) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        return response()->json([
            'employee' => $employee->load([
                'user', 'certificates', 'courseEnrollments.course',
            ]),
        ]);
    }

    public function update(Request $request, Employee $employee): JsonResponse
    {
        if ($employee->company_id !== (int)$request->input('company_id')) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        $data = $request->validate([
            'first_name' => 'sometimes|string|max:255',
            'last_name' => 'sometimes|string|max:255',
            'document_type' => 'nullable|string|max:10',
            'document_number' => 'sometimes|string|unique:employees,document_number,' . $employee->id,
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'position' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'area' => 'nullable|string|max:255',
            'status' => 'nullable|in:active,inactive,suspended',
            'hire_date' => 'nullable|date',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:255',
            'emergency_contact' => 'nullable|string|max:255',
            'emergency_phone' => 'nullable|string|max:20',
            'notes' => 'nullable|string',
        ]);

        $employee->update($data);

        return response()->json([
            'message' => 'Empleado actualizado exitosamente.',
            'employee' => $employee->fresh()->load('user'),
        ]);
    }

    public function destroy(Request $request, Employee $employee): JsonResponse
    {
        if ($employee->company_id !== (int)$request->input('company_id')) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        $employee->delete();

        return response()->json(['message' => 'Empleado eliminado exitosamente.']);
    }

    public function import(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:5000',
        ]);

        $companyId = $request->input('company_id');

        try {
            $import = new EmployeesImport($companyId);
            Excel::import($import, $request->file('file'));

            return response()->json([
                'message' => 'Importación completada.',
                'successful' => $import->getRowCount(),
                'errors' => $import->getErrors(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error en la importación: ' . $e->getMessage(),
            ], 422);
        }
    }

    public function export(Request $request)
    {
        $companyId = $request->input('company_id');
        $filters = $request->only(['status', 'area', 'department']);

        return Excel::download(
            new EmployeesExport($companyId, $filters),
            'empleados_' . date('Y-m-d_His') . '.xlsx'
        );
    }

    public function areas(Request $request): JsonResponse
    {
        $areas = Employee::byCompany($request->input('company_id'))
            ->distinct()
            ->whereNotNull('area')
            ->pluck('area');

        return response()->json(['areas' => $areas]);
    }

    public function departments(Request $request): JsonResponse
    {
        $departments = Employee::byCompany($request->input('company_id'))
            ->distinct()
            ->whereNotNull('department')
            ->pluck('department');

        return response()->json(['departments' => $departments]);
    }
}
