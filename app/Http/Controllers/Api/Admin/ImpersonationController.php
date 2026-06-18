<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ImpersonationController extends Controller
{
    /**
     * Impersonate a company — generate a token scoped to that company.
     * The master user gets a new token with the target company_id embedded
     * so all subsequent requests are filtered to that company's data.
     */
    public function impersonate(Request $request, Company $company): JsonResponse
    {
        $master = $request->user();

        if (!$master->isSuperAdmin()) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        if (!$company->is_active) {
            return response()->json(['message' => 'La empresa está desactivada.'], 422);
        }

        // Generate a new impersonation token
        $token = $master->createToken('impersonation-' . $company->slug)->plainTextToken;

        // Build the user response with the target company context
        $userData = [
            'id' => $master->id,
            'name' => $master->name,
            'lastname' => $master->lastname,
            'full_name' => $master->full_name,
            'email' => $master->email,
            'phone' => $master->phone,
            'position' => $master->position,
            'avatar' => $master->avatar,
            'company_id' => $company->id,
            'is_active' => $master->is_active,
            'roles' => $master->getRoleNames(),
            'permissions' => $master->getAllPermissions()->pluck('name'),
        ];

        return response()->json([
            'message' => "Ahora estás operando como {$company->name}.",
            'token' => $token,
            'user' => $userData,
            'impersonating' => [
                'company_id' => $company->id,
                'company_name' => $company->name,
                'company_slug' => $company->slug,
                'company_logo' => $company->logo,
            ],
        ]);
    }

    /**
     * Stop impersonating — return to master view.
     * Revoke the impersonation token and issue a fresh master token.
     */
    public function stopImpersonating(Request $request): JsonResponse
    {
        $master = $request->user();

        // Revoke current impersonation token
        $request->user()->currentAccessToken()->delete();

        // Issue a fresh master token
        $token = $master->createToken('auth-token')->plainTextToken;

        $userData = [
            'id' => $master->id,
            'name' => $master->name,
            'lastname' => $master->lastname,
            'full_name' => $master->full_name,
            'email' => $master->email,
            'phone' => $master->phone,
            'position' => $master->position,
            'avatar' => $master->avatar,
            'company_id' => null,
            'is_active' => $master->is_active,
            'roles' => $master->getRoleNames(),
            'permissions' => $master->getAllPermissions()->pluck('name'),
        ];

        return response()->json([
            'message' => 'Has vuelto al panel maestro.',
            'token' => $token,
            'user' => $userData,
        ]);
    }
}
