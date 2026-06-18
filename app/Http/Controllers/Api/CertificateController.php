<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\CertificateTemplate;
use App\Models\Employee;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CertificateController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $companyId = $request->input('company_id');

        $query = Certificate::where('company_id', $companyId)
            ->with(['employee:id,first_name,last_name,document_number', 'course:id,title']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('certificate_code', 'like', "%{$search}%")
                    ->orWhere('title', 'like', "%{$search}%")
                    ->orWhereHas('employee', fn($e) => $e->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $perPage = $request->input('per_page', 15);
        $certificates = $query->latest()->paginate($perPage);

        return response()->json($certificates);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'course_id' => 'nullable|exists:courses,id',
            'evaluation_id' => 'nullable|exists:evaluations,id',
            'template_id' => 'nullable|exists:certificate_templates,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'issue_date' => 'required|date',
            'expiry_date' => 'nullable|date|after:issue_date',
            'score' => 'nullable|numeric|min:0',
        ]);

        $data['company_id'] = $request->input('company_id');
        $data['certificate_code'] = 'NEX-' . strtoupper(Str::random(4)) . '-' . date('Y') . '-' . strtoupper(Str::random(6));
        $data['status'] = 'active';

        $certificate = Certificate::create($data);

        return response()->json([
            'message' => 'Certificado creado exitosamente.',
            'certificate' => $certificate->load(['employee', 'course']),
        ], 201);
    }

    public function show(Request $request, Certificate $certificate): JsonResponse
    {
        if ($certificate->company_id !== (int)$request->input('company_id')) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        return response()->json([
            'certificate' => $certificate->load(['employee', 'course', 'evaluation', 'template']),
        ]);
    }

    public function revoke(Request $request, Certificate $certificate): JsonResponse
    {
        if ($certificate->company_id !== (int)$request->input('company_id')) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        $certificate->update(['status' => 'revoked']);

        return response()->json([
            'message' => 'Certificado revocado exitosamente.',
            'certificate' => $certificate,
        ]);
    }

    public function download(Request $request, Certificate $certificate)
    {
        $certificate->load(['employee', 'course', 'template']);

        $template = $certificate->template;
        $employee = $certificate->employee;
        $course = $certificate->course;

        $data = [
            'certificate' => $certificate,
            'template' => $template,
            'employee_name' => $employee->full_name,
            'employee_document' => $employee->document_number,
            'course_title' => $course?->title ?? $certificate->title,
            'issue_date' => $certificate->issue_date->format('d/m/Y'),
            'certificate_code' => $certificate->certificate_code,
            'score' => $certificate->score,
            'primary_color' => $template?->primary_color ?? '#1E40AF',
            'secondary_color' => $template?->secondary_color ?? '#3B82F6',
            'accent_color' => $template?->accent_color ?? '#06B6D4',
            'text_color' => $template?->text_color ?? '#0F172A',
            'background_color' => $template?->background_color ?? '#FFFFFF',
            'show_logo' => $template?->show_logo ?? true,
            'show_qr' => $template?->show_qr ?? true,
            'show_signature' => $template?->show_signature ?? false,
            'signature_name' => $template?->signature_name,
            'signature_title' => $template?->signature_title,
            'title' => $template?->title ?? 'Certificate of Completion',
            'subtitle' => $template?->subtitle ?? 'Otorgado a',
            'body_text' => $template?->body_text ?? 'Por haber completado satisfactoriamente el curso.',
        ];

        $pdf = Pdf::loadView('certificates.pdf', $data)
            ->setPaper($template?->paper_size ?? 'letter', $template?->orientation ?? 'landscape');

        return $pdf->download("certificado_{$certificate->certificate_code}.pdf");
    }

    public function verify(string $code): JsonResponse
    {
        $certificate = Certificate::where('certificate_code', $code)
            ->with(['employee', 'course'])
            ->first();

        if (!$certificate) {
            return response()->json(['message' => 'Certificado no encontrado.'], 404);
        }

        $isValid = $certificate->status === 'active';

        return response()->json([
            'is_valid' => $isValid,
            'certificate' => [
                'code' => $certificate->certificate_code,
                'title' => $certificate->title,
                'employee_name' => $certificate->employee?->full_name,
                'course' => $certificate->course?->title,
                'issue_date' => $certificate->issue_date->format('Y-m-d'),
                'status' => $certificate->status,
            ],
        ]);
    }
}

