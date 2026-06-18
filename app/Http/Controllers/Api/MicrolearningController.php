<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MicrolearningContent;
use App\Models\MicrolearningAssignment;
use App\Models\MicrolearningTracking;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MicrolearningController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $companyId = $request->input('company_id');

        $query = MicrolearningContent::where('company_id', $companyId);

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
        if ($request->filled('frequency')) {
            $query->where('frequency', $request->frequency);
        }

        $perPage = $request->input('per_page', 15);
        $contents = $query->latest()->paginate($perPage);

        return response()->json($contents);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content_type' => 'required|in:text,image,video,pdf,link,embed',
            'content' => 'nullable|string',
            'image_url' => 'nullable|string|max:500',
            'video_url' => 'nullable|string|max:500',
            'file_url' => 'nullable|string|max:500',
            'external_url' => 'nullable|string|max:500',
            'read_time_minutes' => 'nullable|integer|min:1',
            'frequency' => 'required|in:daily,weekly,custom',
            'custom_cron' => 'nullable|string|max:50',
            'status' => 'nullable|in:draft,published,archived',
            'tags' => 'nullable|json',
            'scheduled_at' => 'nullable|date',
        ]);

        $data['company_id'] = $request->input('company_id');
        $content = MicrolearningContent::create($data);

        return response()->json([
            'message' => 'Contenido de microlearning creado exitosamente.',
            'content' => $content,
        ], 201);
    }

    public function show(Request $request, MicrolearningContent $content): JsonResponse
    {
        if ($content->company_id !== (int)$request->input('company_id')) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        return response()->json([
            'content' => $content->load(['assignments', 'tracking' => fn($q) => $q->with('employee')->latest()->limit(20)]),
        ]);
    }

    public function update(Request $request, MicrolearningContent $content): JsonResponse
    {
        if ($content->company_id !== (int)$request->input('company_id')) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        $content->update($request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'content_type' => 'sometimes|in:text,image,video,pdf,link,embed',
            'content' => 'nullable|string',
            'image_url' => 'nullable|string|max:500',
            'video_url' => 'nullable|string|max:500',
            'file_url' => 'nullable|string|max:500',
            'external_url' => 'nullable|string|max:500',
            'read_time_minutes' => 'nullable|integer|min:1',
            'frequency' => 'sometimes|in:daily,weekly,custom',
            'custom_cron' => 'nullable|string|max:50',
            'status' => 'nullable|in:draft,published,archived',
            'tags' => 'nullable|json',
            'scheduled_at' => 'nullable|date',
        ]));

        return response()->json([
            'message' => 'Contenido actualizado exitosamente.',
            'content' => $content->fresh(),
        ]);
    }

    public function destroy(Request $request, MicrolearningContent $content): JsonResponse
    {
        if ($content->company_id !== (int)$request->input('company_id')) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        $content->delete();

        return response()->json(['message' => 'Contenido eliminado exitosamente.']);
    }

    public function assign(Request $request, MicrolearningContent $content): JsonResponse
    {
        $request->validate([
            'assign_type' => 'required|in:employee,area,position,department,all',
            'assignee_id' => 'nullable|integer',
            'assignee_value' => 'nullable|string|max:255',
        ]);

        $assignment = MicrolearningAssignment::create([
            'microlearning_content_id' => $content->id,
            'company_id' => $request->input('company_id'),
            'assign_type' => $request->assign_type,
            'assignee_id' => $request->assignee_id,
            'assignee_value' => $request->assignee_value,
            'assigned_at' => now(),
        ]);

        return response()->json([
            'message' => 'Contenido asignado exitosamente.',
            'assignment' => $assignment,
        ], 201);
    }

    public function tracking(Request $request): JsonResponse
    {
        $companyId = $request->input('company_id');
        $employeeId = $request->input('employee_id');

        $query = MicrolearningTracking::where('company_id', $companyId)
            ->with(['content:id,title,content_type', 'employee:id,first_name,last_name']);

        if ($employeeId) {
            $query->where('employee_id', $employeeId);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return response()->json($query->latest()->paginate(20));
    }

    public function markStatus(Request $request): JsonResponse
    {
        $request->validate([
            'content_id' => 'required|exists:microlearning_contents,id',
            'employee_id' => 'required|exists:employees,id',
            'status' => 'required|in:seen,completed',
        ]);

        $tracking = MicrolearningTracking::firstOrCreate(
            [
                'microlearning_content_id' => $request->content_id,
                'employee_id' => $request->employee_id,
            ],
            [
                'company_id' => $request->input('company_id'),
                'status' => 'delivered',
                'delivered_at' => now(),
            ]
        );

        $updateData = ['status' => $request->status];
        if ($request->status === 'seen' && !$tracking->seen_at) {
            $updateData['seen_at'] = now();
        }
        if ($request->status === 'completed' && !$tracking->completed_at) {
            $updateData['completed_at'] = now();
        }

        $tracking->update($updateData);

        return response()->json([
            'message' => 'Estado actualizado exitosamente.',
            'tracking' => $tracking,
        ]);
    }
}
