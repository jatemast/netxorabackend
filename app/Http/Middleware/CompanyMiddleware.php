<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CompanyMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        // Super Admin can access all companies
        if ($user->hasRole('Super Administrador')) {
            $companyId = $request->header('X-Company-Id') ?? $request->input('company_id');

            if ($companyId) {
                $request->merge(['company_id' => (int) $companyId]);
            }

            return $next($request);
        }

        // For other users, use their assigned company
        if ($user->company_id) {
            $request->merge(['company_id' => $user->company_id]);
        } else {
            return response()->json(['message' => 'No company assigned to user.'], 403);
        }

        return $next($request);
    }
}
