<?php

/**
 * @OA\Info(
 *     title="Nexora Learning API",
 *     version="1.0.0",
 *     description="API REST para la plataforma Nexora Learning LMS",
 *     @OA\Contact(email="admin@nexora.com")
 * )
 * @OA\Server(url="http://127.0.0.1:8000/api")
 * @OA\SecurityScheme(
 *     securityScheme="sanctum",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\CourseCategoryController;
use App\Http\Controllers\Api\QuestionController;
use App\Http\Controllers\Api\QuestionCategoryController;
use App\Http\Controllers\Api\EvaluationController;
use App\Http\Controllers\Api\CertificateController;
use App\Http\Controllers\Api\CertificateTemplateController;
use App\Http\Controllers\Api\MicrolearningController;

/*
|--------------------------------------------------------------------------
| API Routes - Nexora Learning Platform
|--------------------------------------------------------------------------
*/

// Public routes
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/auth/reset-password', [AuthController::class, 'resetPassword']);

// Certificate public verification
Route::get('/certificates/verify/{code}', [CertificateController::class, 'verify']);

// Authenticated routes
Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/user', [AuthController::class, 'user']);
    Route::put('/auth/profile', [AuthController::class, 'updateProfile']);
    Route::put('/auth/change-password', [AuthController::class, 'changePassword']);

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Employees
    Route::apiResource('employees', EmployeeController::class);
    Route::post('/employees/import', [EmployeeController::class, 'import']);
    Route::get('/employees/export/download', [EmployeeController::class, 'export']);
    Route::get('/employees/areas/list', [EmployeeController::class, 'areas']);
    Route::get('/employees/departments/list', [EmployeeController::class, 'departments']);

    // Course Categories
    Route::get('/course-categories', [CourseCategoryController::class, 'index']);
    Route::post('/course-categories', [CourseCategoryController::class, 'store']);
    Route::put('/course-categories/{category}', [CourseCategoryController::class, 'update']);
    Route::delete('/course-categories/{category}', [CourseCategoryController::class, 'destroy']);

    // Courses
    Route::apiResource('courses', CourseController::class);

    // Question Categories
    Route::get('/question-categories', [QuestionCategoryController::class, 'index']);
    Route::post('/question-categories', [QuestionCategoryController::class, 'store']);
    Route::put('/question-categories/{category}', [QuestionCategoryController::class, 'update']);
    Route::delete('/question-categories/{category}', [QuestionCategoryController::class, 'destroy']);

    // Questions
    Route::apiResource('questions', QuestionController::class);

    // Evaluations
    Route::apiResource('evaluations', EvaluationController::class);
    Route::post('/evaluations/{evaluation}/start', [EvaluationController::class, 'start']);
    Route::post('/evaluations/attempts/{attempt}/submit', [EvaluationController::class, 'submit']);
    Route::get('/evaluations/attempts/{attempt}/results', [EvaluationController::class, 'results']);
    Route::get('/evaluations/my-attempts', [EvaluationController::class, 'employeeAttempts']);

    // Certificates
    Route::apiResource('certificates', CertificateController::class)->except(['update', 'destroy']);
    Route::post('/certificates/{certificate}/revoke', [CertificateController::class, 'revoke']);
    Route::get('/certificates/{certificate}/download', [CertificateController::class, 'download']);

    // Certificate Templates
    Route::get('/certificate-templates', [CertificateTemplateController::class, 'index']);
    Route::post('/certificate-templates', [CertificateTemplateController::class, 'store']);
    Route::put('/certificate-templates/{template}', [CertificateTemplateController::class, 'update']);
    Route::delete('/certificate-templates/{template}', [CertificateTemplateController::class, 'destroy']);

    // Microlearning
    Route::apiResource('microlearning', MicrolearningController::class);
    Route::post('/microlearning/{content}/assign', [MicrolearningController::class, 'assign']);
    Route::get('/microlearning-tracking', [MicrolearningController::class, 'tracking']);
    Route::post('/microlearning-tracking/status', [MicrolearningController::class, 'markStatus']);
});
