<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Badge;
use App\Models\Challenge;
use App\Models\ChallengeParticipant;
use App\Models\EmployeeBadge;
use App\Models\EmployeePoint;
use App\Models\PointTransaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GamificationController extends Controller
{
    // ─── Badges ────────────────────────────────────────────────

    public function badges(Request $request): JsonResponse
    {
        $companyId = $request->input('company_id');

        $badges = Badge::where('company_id', $companyId)
            ->orderBy('name')
            ->get();

        return response()->json(['badges' => $badges]);
    }

    public function storeBadge(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:500',
            'color' => 'nullable|string|max:50',
            'category' => 'nullable|string|max:100',
            'criteria' => 'nullable|json',
            'points_awarded' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $data['company_id'] = $request->input('company_id');
        $data['slug'] = Str::slug($data['name']);

        $badge = Badge::create($data);

        return response()->json([
            'message' => 'Insignia creada exitosamente.',
            'badge' => $badge,
        ], 201);
    }

    public function updateBadge(Request $request, Badge $badge): JsonResponse
    {
        if ($badge->company_id !== (int) $request->input('company_id')) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:500',
            'color' => 'nullable|string|max:50',
            'category' => 'nullable|string|max:100',
            'criteria' => 'nullable|json',
            'points_awarded' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        if (isset($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $badge->update($data);

        return response()->json([
            'message' => 'Insignia actualizada exitosamente.',
            'badge' => $badge,
        ]);
    }

    public function destroyBadge(Badge $badge): JsonResponse
    {
        $badge->delete();

        return response()->json([
            'message' => 'Insignia eliminada exitosamente.',
        ]);
    }

    // ─── Employee Badges ───────────────────────────────────────

    public function employeeBadges(Request $request): JsonResponse
    {
        $employeeId = $request->input('employee_id');
        $companyId = $request->input('company_id');

        $badges = EmployeeBadge::where('employee_id', $employeeId)
            ->where('company_id', $companyId)
            ->with('badge')
            ->latest('earned_at')
            ->get();

        return response()->json(['badges' => $badges]);
    }

    // ─── Points ────────────────────────────────────────────────

    public function points(Request $request): JsonResponse
    {
        $employeeId = $request->input('employee_id');
        $companyId = $request->input('company_id');

        $points = EmployeePoint::where('employee_id', $employeeId)
            ->where('company_id', $companyId)
            ->first();

        $transactions = PointTransaction::where('employee_id', $employeeId)
            ->where('company_id', $companyId)
            ->latest()
            ->limit(50)
            ->get();

        return response()->json([
            'points' => $points,
            'transactions' => $transactions,
        ]);
    }

    // ─── Leaderboard ───────────────────────────────────────────

    public function leaderboard(Request $request): JsonResponse
    {
        $companyId = $request->input('company_id');
        $type = $request->input('type', 'points'); // points | experience
        $period = $request->input('period', 'all'); // all | monthly | weekly

        $query = EmployeePoint::where('company_id', $companyId)
            ->with(['employee:id,first_name,last_name,avatar,area_id,position_id']);

        if ($type === 'experience') {
            $query->orderBy('total_experience', 'desc');
        } else {
            $query->orderBy('total_points', 'desc');
        }

        $limit = $request->input('limit', 20);
        $leaderboard = $query->limit($limit)->get();

        // Assign rank numbers
        $ranked = $leaderboard->map(function ($item, $index) {
            $item->rank = $index + 1;
            return $item;
        });

        return response()->json([
            'type' => $type,
            'period' => $period,
            'leaderboard' => $ranked,
        ]);
    }

    // ─── Challenges ────────────────────────────────────────────

    public function challenges(Request $request): JsonResponse
    {
        $companyId = $request->input('company_id');

        $challenges = Challenge::where('company_id', $companyId)
            ->with(['badge:id,name,icon', 'participants:id,challenge_id,employee_id,status'])
            ->withCount('participants')
            ->latest()
            ->get();

        return response()->json(['challenges' => $challenges]);
    }

    public function storeChallenge(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string|max:100',
            'criteria' => 'nullable|json',
            'points_reward' => 'nullable|integer|min:0',
            'experience_reward' => 'nullable|integer|min:0',
            'badge_reward_id' => 'nullable|exists:badges,id',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after:starts_at',
            'is_active' => 'nullable|boolean',
        ]);

        $data['company_id'] = $request->input('company_id');
        $data['slug'] = Str::slug($data['name']);

        $challenge = Challenge::create($data);

        return response()->json([
            'message' => 'Desafío creado exitosamente.',
            'challenge' => $challenge,
        ], 201);
    }

    public function updateChallenge(Request $request, Challenge $challenge): JsonResponse
    {
        if ($challenge->company_id !== (int) $request->input('company_id')) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'type' => 'sometimes|string|max:100',
            'criteria' => 'nullable|json',
            'points_reward' => 'nullable|integer|min:0',
            'experience_reward' => 'nullable|integer|min:0',
            'badge_reward_id' => 'nullable|exists:badges,id',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after:starts_at',
            'is_active' => 'nullable|boolean',
        ]);

        if (isset($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $challenge->update($data);

        return response()->json([
            'message' => 'Desafío actualizado exitosamente.',
            'challenge' => $challenge,
        ]);
    }

    // ─── Join Challenge ────────────────────────────────────────

    public function joinChallenge(Request $request, Challenge $challenge): JsonResponse
    {
        $companyId = $request->input('company_id');
        $employeeId = $request->input('employee_id');

        if ($challenge->company_id !== (int) $companyId) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        // Check if already joined
        $existing = ChallengeParticipant::where('challenge_id', $challenge->id)
            ->where('employee_id', $employeeId)
            ->first();

        if ($existing) {
            return response()->json(['message' => 'Ya estás participando en este desafío.'], 409);
        }

        $participant = ChallengeParticipant::create([
            'challenge_id' => $challenge->id,
            'employee_id' => $employeeId,
            'status' => 'joined',
            'progress' => 0,
        ]);

        return response()->json([
            'message' => 'Te has unido al desafío exitosamente.',
            'participant' => $participant,
        ], 201);
    }

    // ─── Complete Challenge ────────────────────────────────────

    public function completeChallenge(Request $request, Challenge $challenge): JsonResponse
    {
        $companyId = $request->input('company_id');
        $employeeId = $request->input('employee_id');

        if ($challenge->company_id !== (int) $companyId) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        $participant = ChallengeParticipant::where('challenge_id', $challenge->id)
            ->where('employee_id', $employeeId)
            ->first();

        if (!$participant) {
            return response()->json(['message' => 'No estás participando en este desafío.'], 404);
        }

        if ($participant->status === 'completed') {
            return response()->json(['message' => 'Ya has completado este desafío.'], 409);
        }

        // Mark as completed
        $participant->update([
            'status' => 'completed',
            'progress' => 100,
            'completed_at' => now(),
        ]);

        // Award points
        if ($challenge->points_reward > 0 || $challenge->experience_reward > 0) {
            $employeePoints = EmployeePoint::firstOrCreate(
                ['employee_id' => $employeeId, 'company_id' => $companyId],
                [
                    'total_points' => 0,
                    'total_experience' => 0,
                    'level' => 1,
                    'current_level_points' => 0,
                    'points_to_next_level' => 100,
                ]
            );

            $newTotalPoints = $employeePoints->total_points + ($challenge->points_reward ?? 0);
            $newTotalExp = $employeePoints->total_experience + ($challenge->experience_reward ?? 0);

            // Simple level calculation: 100 points per level
            $level = max(1, (int) floor($newTotalPoints / 100) + 1);
            $currentLevelPoints = $newTotalPoints % 100;
            $pointsToNext = 100 - $currentLevelPoints;

            $employeePoints->update([
                'total_points' => $newTotalPoints,
                'total_experience' => $newTotalExp,
                'level' => $level,
                'current_level_points' => $currentLevelPoints,
                'points_to_next_level' => $pointsToNext,
            ]);

            // Create transaction records
            if ($challenge->points_reward > 0) {
                PointTransaction::create([
                    'employee_id' => $employeeId,
                    'company_id' => $companyId,
                    'type' => 'challenge',
                    'points' => $challenge->points_reward,
                    'experience' => 0,
                    'description' => "Desafío completado: {$challenge->name}",
                    'reference_type' => 'challenge',
                    'reference_id' => $challenge->id,
                ]);
            }

            if ($challenge->experience_reward > 0) {
                PointTransaction::create([
                    'employee_id' => $employeeId,
                    'company_id' => $companyId,
                    'type' => 'challenge',
                    'points' => 0,
                    'experience' => $challenge->experience_reward,
                    'description' => "Experiencia por desafío: {$challenge->name}",
                    'reference_type' => 'challenge',
                    'reference_id' => $challenge->id,
                ]);
            }
        }

        // Award badge if applicable
        if ($challenge->badge_reward_id) {
            $alreadyHasBadge = EmployeeBadge::where('badge_id', $challenge->badge_reward_id)
                ->where('employee_id', $employeeId)
                ->exists();

            if (!$alreadyHasBadge) {
                EmployeeBadge::create([
                    'badge_id' => $challenge->badge_reward_id,
                    'employee_id' => $employeeId,
                    'company_id' => $companyId,
                    'earned_at' => now(),
                ]);
            }
        }

        return response()->json([
            'message' => 'Desafío completado exitosamente. ¡Recompensas otorgadas!',
            'points_awarded' => $challenge->points_reward ?? 0,
            'experience_awarded' => $challenge->experience_reward ?? 0,
            'badge_awarded' => $challenge->badge_reward_id ? true : false,
        ]);
    }
}
