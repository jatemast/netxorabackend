<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Area;
use App\Models\Process;
use App\Models\Position;
use App\Models\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrganizationalStructureController extends Controller
{
    // ─── Branches ──────────────────────────────────────────────

    public function branches(Request $request): JsonResponse
    {
        $companyId = $request->input('company_id');

        $branches = Branch::where('company_id', $companyId)
            ->withCount('areas')
            ->orderBy('name')
            ->get();

        return response()->json(['branches' => $branches]);
    }

    public function storeBranch(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
            'manager_name' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
            'metadata' => 'nullable|json',
        ]);

        $data['company_id'] = $request->input('company_id');
        $data['slug'] = Str::slug($data['name']);

        $branch = Branch::create($data);

        return response()->json([
            'message' => 'Sede creada exitosamente.',
            'branch' => $branch,
        ], 201);
    }

    public function updateBranch(Request $request, Branch $branch): JsonResponse
    {
        if ($branch->company_id !== (int) $request->input('company_id')) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'code' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
            'manager_name' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
            'metadata' => 'nullable|json',
        ]);

        if (isset($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $branch->update($data);

        return response()->json([
            'message' => 'Sede actualizada exitosamente.',
            'branch' => $branch,
        ]);
    }

    public function destroyBranch(Branch $branch): JsonResponse
    {
        $branch->delete();

        return response()->json([
            'message' => 'Sede eliminada exitosamente.',
        ]);
    }

    // ─── Areas ─────────────────────────────────────────────────

    public function areas(Request $request): JsonResponse
    {
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
        ]);

        $companyId = $request->input('company_id');
        $branchId = $request->input('branch_id');

        $areas = Area::where('company_id', $companyId)
            ->where('branch_id', $branchId)
            ->withCount('processes')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return response()->json(['areas' => $areas]);
    }

    public function storeArea(Request $request): JsonResponse
    {
        $data = $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:areas,id',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
            'metadata' => 'nullable|json',
        ]);

        $data['company_id'] = $request->input('company_id');
        $data['slug'] = Str::slug($data['name']);

        $area = Area::create($data);

        return response()->json([
            'message' => 'Área creada exitosamente.',
            'area' => $area,
        ], 201);
    }

    public function updateArea(Request $request, Area $area): JsonResponse
    {
        if ($area->company_id !== (int) $request->input('company_id')) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        $data = $request->validate([
            'branch_id' => 'sometimes|exists:branches,id',
            'name' => 'sometimes|string|max:255',
            'code' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:areas,id',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
            'metadata' => 'nullable|json',
        ]);

        if (isset($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $area->update($data);

        return response()->json([
            'message' => 'Área actualizada exitosamente.',
            'area' => $area,
        ]);
    }

    public function destroyArea(Area $area): JsonResponse
    {
        $area->delete();

        return response()->json([
            'message' => 'Área eliminada exitosamente.',
        ]);
    }

    // ─── Processes ─────────────────────────────────────────────

    public function processes(Request $request): JsonResponse
    {
        $request->validate([
            'area_id' => 'required|exists:areas,id',
        ]);

        $companyId = $request->input('company_id');
        $areaId = $request->input('area_id');

        $processes = Process::where('company_id', $companyId)
            ->where('area_id', $areaId)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return response()->json(['processes' => $processes]);
    }

    public function storeProcess(Request $request): JsonResponse
    {
        $data = $request->validate([
            'area_id' => 'required|exists:areas,id',
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
            'metadata' => 'nullable|json',
        ]);

        $data['company_id'] = $request->input('company_id');
        $data['slug'] = Str::slug($data['name']);

        $process = Process::create($data);

        return response()->json([
            'message' => 'Proceso creado exitosamente.',
            'process' => $process,
        ], 201);
    }

    public function updateProcess(Request $request, Process $process): JsonResponse
    {
        if ($process->company_id !== (int) $request->input('company_id')) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        $data = $request->validate([
            'area_id' => 'sometimes|exists:areas,id',
            'name' => 'sometimes|string|max:255',
            'code' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
            'metadata' => 'nullable|json',
        ]);

        if (isset($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $process->update($data);

        return response()->json([
            'message' => 'Proceso actualizado exitosamente.',
            'process' => $process,
        ]);
    }

    public function destroyProcess(Process $process): JsonResponse
    {
        $process->delete();

        return response()->json([
            'message' => 'Proceso eliminado exitosamente.',
        ]);
    }

    // ─── Positions ─────────────────────────────────────────────

    public function positions(Request $request): JsonResponse
    {
        $request->validate([
            'process_id' => 'required|exists:processes,id',
        ]);

        $companyId = $request->input('company_id');
        $processId = $request->input('process_id');

        $positions = Position::where('company_id', $companyId)
            ->where('process_id', $processId)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return response()->json(['positions' => $positions]);
    }

    public function storePosition(Request $request): JsonResponse
    {
        $data = $request->validate([
            'process_id' => 'required|exists:processes,id',
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'responsibilities' => 'nullable|string',
            'requirements' => 'nullable|string',
            'min_salary' => 'nullable|numeric',
            'max_salary' => 'nullable|numeric',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
            'metadata' => 'nullable|json',
        ]);

        $data['company_id'] = $request->input('company_id');
        $data['slug'] = Str::slug($data['name']);

        $position = Position::create($data);

        return response()->json([
            'message' => 'Cargo creado exitosamente.',
            'position' => $position,
        ], 201);
    }

    public function updatePosition(Request $request, Position $position): JsonResponse
    {
        if ($position->company_id !== (int) $request->input('company_id')) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        $data = $request->validate([
            'process_id' => 'sometimes|exists:processes,id',
            'name' => 'sometimes|string|max:255',
            'code' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'responsibilities' => 'nullable|string',
            'requirements' => 'nullable|string',
            'min_salary' => 'nullable|numeric',
            'max_salary' => 'nullable|numeric',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
            'metadata' => 'nullable|json',
        ]);

        if (isset($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $position->update($data);

        return response()->json([
            'message' => 'Cargo actualizado exitosamente.',
            'position' => $position,
        ]);
    }

    public function destroyPosition(Position $position): JsonResponse
    {
        $position->delete();

        return response()->json([
            'message' => 'Cargo eliminado exitosamente.',
        ]);
    }

    // ─── Organigram (Full Tree) ────────────────────────────────

    public function organigram(Request $request, Company $company): JsonResponse
    {
        $tree = Branch::where('company_id', $company->id)
            ->with([
                'areas' => function ($q) {
                    $q->orderBy('sort_order')->orderBy('name')
                        ->with([
                            'processes' => function ($q) {
                                $q->orderBy('sort_order')->orderBy('name')
                                    ->with([
                                        'positions' => function ($q) {
                                            $q->orderBy('sort_order')->orderBy('name');
                                        },
                                    ]);
                            },
                        ]);
                },
            ])
            ->orderBy('name')
            ->get();

        return response()->json([
            'company' => $company,
            'organigram' => $tree,
        ]);
    }
}
