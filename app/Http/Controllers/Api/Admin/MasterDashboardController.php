<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MasterDashboardController extends Controller
{
    /**
     * Master dashboard — platform-wide stats across all companies.
     */
    public function index(Request $request): JsonResponse
    {
        $totalCompanies = Company::count();
        $activeCompanies = Company::where('is_active', true)->count();
        $inactiveCompanies = Company::where('is_active', false)->count();

        $totalUsers = \App\Models\User::count();
        $totalEmployees = \App\Models\Employee::count();
        $totalCourses = \App\Models\Course::count();
        $totalEvaluations = \App\Models\Evaluation::count();
        $totalCertificates = \App\Models\Certificate::count();

        // Top companies by employees
        $topCompanies = Company::where('is_active', true)
            ->withCount(['users', 'employees', 'courses', 'certificates'])
            ->orderBy('employees_count', 'desc')
            ->limit(5)
            ->get()
            ->map(fn($c) => [
                'id' => $c->id,
                'name' => $c->name,
                'slug' => $c->slug,
                'logo' => $c->logo,
                'users_count' => $c->users_count,
                'employees_count' => $c->employees_count,
                'courses_count' => $c->courses_count,
                'certificates_count' => $c->certificates_count,
            ]);

        // Companies registered per month (last 12 months)
        $registrationsByMonth = Company::where('created_at', '>=', now()->subMonths(12))
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count")
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month');

        return response()->json([
            'kpis' => [
                'total_companies' => $totalCompanies,
                'active_companies' => $activeCompanies,
                'inactive_companies' => $inactiveCompanies,
                'total_users' => $totalUsers,
                'total_employees' => $totalEmployees,
                'total_courses' => $totalCourses,
                'total_evaluations' => $totalEvaluations,
                'total_certificates' => $totalCertificates,
            ],
            'top_companies' => $topCompanies,
            'registrations_by_month' => $registrationsByMonth,
        ]);
    }
}
