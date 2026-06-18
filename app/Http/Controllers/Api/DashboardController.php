<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\Employee;
use App\Models\Evaluation;
use App\Models\EvaluationAttempt;
use App\Models\MicrolearningContent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $companyId = $request->input('company_id');

        $totalEmployees = Employee::byCompany($companyId)->count();
        $activeEmployees = Employee::byCompany($companyId)->active()->count();
        $totalCourses = Course::byCompany($companyId)->published()->count();
        $totalEvaluations = Evaluation::byCompany($companyId)->published()->count();
        $totalCertificates = Certificate::where('company_id', $companyId)->active()->count();
        $totalMicrolearning = MicrolearningContent::where('company_id', $companyId)->published()->count();

        // Enrollment stats
        $totalEnrollments = CourseEnrollment::where('company_id', $companyId)->count();
        $completedEnrollments = CourseEnrollment::where('company_id', $companyId)
            ->where('status', 'completed')->count();
        $inProgressEnrollments = CourseEnrollment::where('company_id', $companyId)
            ->where('status', 'in_progress')->count();

        // Evaluation stats
        $totalAttempts = EvaluationAttempt::where('company_id', $companyId)->count();
        $passedAttempts = EvaluationAttempt::where('company_id', $companyId)
            ->where('is_passed', true)->count();
        $averageScore = EvaluationAttempt::where('company_id', $companyId)
            ->where('status', 'completed')
            ->avg('percentage') ?? 0;

        // Monthly enrollments for chart (last 6 months)
        $monthlyEnrollments = CourseEnrollment::where('company_id', $companyId)
            ->where('created_at', '>=', now()->subMonths(6))
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count")
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month');

        // Course completion by category
        $completionsByCategory = DB::table('course_enrollments')
            ->join('courses', 'course_enrollments.course_id', '=', 'courses.id')
            ->join('course_categories', 'courses.category_id', '=', 'course_categories.id')
            ->where('course_enrollments.company_id', $companyId)
            ->where('course_enrollments.status', 'completed')
            ->select('course_categories.name', DB::raw('COUNT(*) as count'))
            ->groupBy('course_categories.name')
            ->get()
            ->pluck('count', 'name');

        // Evaluation score distribution
        $scoreDistribution = EvaluationAttempt::where('company_id', $companyId)
            ->where('status', 'completed')
            ->selectRaw("
                CASE
                    WHEN percentage >= 90 THEN '90-100'
                    WHEN percentage >= 80 THEN '80-89'
                    WHEN percentage >= 70 THEN '70-79'
                    WHEN percentage >= 60 THEN '60-69'
                    ELSE '<60'
                END as range,
                COUNT(*) as count
            ")
            ->groupBy('range')
            ->orderBy('range')
            ->get()
            ->pluck('count', 'range');

        // Recent activities
        $recentEnrollments = CourseEnrollment::where('company_id', $companyId)
            ->with(['employee:id,first_name,last_name', 'course:id,title'])
            ->latest()
            ->limit(5)
            ->get()
            ->map(fn($e) => [
                'type' => 'enrollment',
                'message' => "{$e->employee?->full_name} se inscribió en {$e->course?->title}",
                'date' => $e->created_at->toISOString(),
            ]);

        $recentCertificates = Certificate::where('company_id', $companyId)
            ->with(['employee:id,first_name,last_name', 'course:id,title'])
            ->latest()
            ->limit(5)
            ->get()
            ->map(fn($c) => [
                'type' => 'certificate',
                'message' => "{$c->employee?->full_name} obtuvo certificado en {$c->course?->title}",
                'date' => $c->created_at->toISOString(),
            ]);

        $activities = $recentEnrollments->merge($recentCertificates)
            ->sortByDesc('date')
            ->take(10)
            ->values();

        return response()->json([
            'kpis' => [
                'total_employees' => $totalEmployees,
                'active_employees' => $activeEmployees,
                'total_courses' => $totalCourses,
                'total_evaluations' => $totalEvaluations,
                'total_certificates' => $totalCertificates,
                'total_microlearning' => $totalMicrolearning,
                'total_enrollments' => $totalEnrollments,
                'completed_enrollments' => $completedEnrollments,
                'in_progress_enrollments' => $inProgressEnrollments,
                'completion_rate' => $totalEnrollments > 0
                    ? round(($completedEnrollments / $totalEnrollments) * 100, 1)
                    : 0,
                'total_attempts' => $totalAttempts,
                'passed_attempts' => $passedAttempts,
                'pass_rate' => $totalAttempts > 0
                    ? round(($passedAttempts / $totalAttempts) * 100, 1)
                    : 0,
                'average_score' => round($averageScore, 1),
            ],
            'charts' => [
                'monthly_enrollments' => $monthlyEnrollments,
                'completions_by_category' => $completionsByCategory,
                'score_distribution' => $scoreDistribution,
            ],
            'recent_activities' => $activities,
        ]);
    }
}
