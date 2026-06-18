<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WhatsAppSchedule;
use App\Models\WhatsAppMessage;
use App\Models\Survey;
use App\Models\SurveyResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WhatsAppController extends Controller
{
    // ─── WhatsApp Schedules ────────────────────────────────────

    public function schedules(Request $request): JsonResponse
    {
        $companyId = $request->input('company_id');

        $schedules = WhatsAppSchedule::where('company_id', $companyId)
            ->with(['microlearningContent:id,title'])
            ->latest()
            ->get();

        return response()->json(['schedules' => $schedules]);
    }

    public function storeSchedule(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'microlearning_content_id' => 'nullable|exists:microlearning_contents,id',
            'message_template' => 'nullable|string',
            'frequency' => 'required|string|max:50',
            'custom_cron' => 'nullable|string|max:100',
            'scheduled_time' => 'nullable|date_format:H:i',
            'target_filters' => 'nullable|json',
            'is_active' => 'nullable|boolean',
        ]);

        $data['company_id'] = $request->input('company_id');

        $schedule = WhatsAppSchedule::create($data);

        return response()->json([
            'message' => 'Programación de WhatsApp creada exitosamente.',
            'schedule' => $schedule,
        ], 201);
    }

    public function updateSchedule(Request $request, WhatsAppSchedule $schedule): JsonResponse
    {
        if ($schedule->company_id !== (int) $request->input('company_id')) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'type' => 'sometimes|string|max:100',
            'microlearning_content_id' => 'nullable|exists:microlearning_contents,id',
            'message_template' => 'nullable|string',
            'frequency' => 'sometimes|string|max:50',
            'custom_cron' => 'nullable|string|max:100',
            'scheduled_time' => 'nullable|date_format:H:i',
            'target_filters' => 'nullable|json',
            'is_active' => 'nullable|boolean',
        ]);

        $schedule->update($data);

        return response()->json([
            'message' => 'Programación de WhatsApp actualizada exitosamente.',
            'schedule' => $schedule,
        ]);
    }

    public function destroySchedule(WhatsAppSchedule $schedule): JsonResponse
    {
        $schedule->delete();

        return response()->json([
            'message' => 'Programación de WhatsApp eliminada exitosamente.',
        ]);
    }

    // ─── WhatsApp Messages ─────────────────────────────────────

    public function messages(Request $request): JsonResponse
    {
        $companyId = $request->input('company_id');

        $query = WhatsAppMessage::where('company_id', $companyId)
            ->with(['employee:id,first_name,last_name,phone', 'schedule:id,name']);

        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        if ($request->filled('schedule_id')) {
            $query->where('schedule_id', $request->schedule_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $perPage = $request->input('per_page', 25);
        $messages = $query->latest()->paginate($perPage);

        return response()->json($messages);
    }

    // ─── Surveys ───────────────────────────────────────────────

    public function surveys(Request $request): JsonResponse
    {
        $companyId = $request->input('company_id');

        $surveys = Survey::where('company_id', $companyId)
            ->withCount('responses')
            ->latest()
            ->get();

        return response()->json(['surveys' => $surveys]);
    }

    public function storeSurvey(Request $request): JsonResponse
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'questions' => 'required|json',
            'status' => 'nullable|in:draft,published,closed',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after:starts_at',
        ]);

        $data['company_id'] = $request->input('company_id');

        $survey = Survey::create($data);

        return response()->json([
            'message' => 'Encuesta creada exitosamente.',
            'survey' => $survey,
        ], 201);
    }

    public function updateSurvey(Request $request, Survey $survey): JsonResponse
    {
        if ($survey->company_id !== (int) $request->input('company_id')) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        $data = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'questions' => 'sometimes|json',
            'status' => 'nullable|in:draft,published,closed',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after:starts_at',
        ]);

        $survey->update($data);

        return response()->json([
            'message' => 'Encuesta actualizada exitosamente.',
            'survey' => $survey,
        ]);
    }

    // ─── Submit Survey ─────────────────────────────────────────

    public function submitSurvey(Request $request, Survey $survey): JsonResponse
    {
        $companyId = $request->input('company_id');
        $employeeId = $request->input('employee_id');

        if ($survey->company_id !== (int) $companyId) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        // Check if already submitted
        $existing = SurveyResponse::where('survey_id', $survey->id)
            ->where('employee_id', $employeeId)
            ->first();

        if ($existing) {
            return response()->json(['message' => 'Ya has respondido esta encuesta.'], 409);
        }

        $data = $request->validate([
            'answers' => 'required|json',
        ]);

        $response = SurveyResponse::create([
            'survey_id' => $survey->id,
            'employee_id' => $employeeId,
            'company_id' => $companyId,
            'answers' => $data['answers'],
            'submitted_at' => now(),
        ]);

        return response()->json([
            'message' => 'Encuesta respondida exitosamente.',
            'response' => $response,
        ], 201);
    }

    // ─── Survey Results ────────────────────────────────────────

    public function surveyResults(Survey $survey): JsonResponse
    {
        $responses = $survey->responses()
            ->with('employee:id,first_name,last_name')
            ->latest('submitted_at')
            ->get();

        $totalResponses = $responses->count();

        return response()->json([
            'survey' => $survey->loadCount('responses'),
            'total_responses' => $totalResponses,
            'responses' => $responses,
        ]);
    }
}
