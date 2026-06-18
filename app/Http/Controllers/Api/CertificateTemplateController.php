<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CertificateTemplate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CertificateTemplateController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $templates = CertificateTemplate::where('company_id', $request->input('company_id'))
            ->where('is_active', true)->get();
        return response()->json(['templates' => $templates]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'body_text' => 'nullable|string',
            'logo' => 'nullable|string|max:500',
            'background_image' => 'nullable|string|max:500',
            'background_color' => 'nullable|string|max:7',
            'primary_color' => 'nullable|string|max:7',
            'secondary_color' => 'nullable|string|max:7',
            'accent_color' => 'nullable|string|max:7',
            'text_color' => 'nullable|string|max:7',
            'font_family' => 'nullable|string|max:100',
            'orientation' => 'nullable|in:portrait,landscape',
            'paper_size' => 'nullable|in:letter,a4',
            'show_logo' => 'nullable|boolean',
            'show_qr' => 'nullable|boolean',
            'show_signature' => 'nullable|boolean',
            'signature_image' => 'nullable|string|max:500',
            'signature_name' => 'nullable|string|max:255',
            'signature_title' => 'nullable|string|max:255',
            'is_default' => 'nullable|boolean',
        ]);
        $data['company_id'] = $request->input('company_id');
        $data['is_active'] = true;
        if (($data['is_default'] ?? false)) {
            CertificateTemplate::where('company_id', $request->input('company_id'))->update(['is_default' => false]);
        }
        $template = CertificateTemplate::create($data);
        return response()->json(['message' => 'Plantilla creada exitosamente.', 'template' => $template], 201);
    }

    public function update(Request $request, CertificateTemplate $template): JsonResponse
    {
        if ($template->company_id !== (int)$request->input('company_id')) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }
        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'body_text' => 'nullable|string',
            'logo' => 'nullable|string|max:500',
            'background_image' => 'nullable|string|max:500',
            'background_color' => 'nullable|string|max:7',
            'primary_color' => 'nullable|string|max:7',
            'secondary_color' => 'nullable|string|max:7',
            'accent_color' => 'nullable|string|max:7',
            'text_color' => 'nullable|string|max:7',
            'font_family' => 'nullable|string|max:100',
            'orientation' => 'nullable|in:portrait,landscape',
            'paper_size' => 'nullable|in:letter,a4',
            'show_logo' => 'nullable|boolean',
            'show_qr' => 'nullable|boolean',
            'show_signature' => 'nullable|boolean',
            'signature_image' => 'nullable|string|max:500',
            'signature_name' => 'nullable|string|max:255',
            'signature_title' => 'nullable|string|max:255',
            'is_default' => 'nullable|boolean',
        ]);
        if ($data['is_default'] ?? false) {
            CertificateTemplate::where('company_id', $request->input('company_id'))->where('id', '!=', $template->id)->update(['is_default' => false]);
        }
        $template->update($data);
        return response()->json(['message' => 'Plantilla actualizada exitosamente.', 'template' => $template->fresh()]);
    }

    public function destroy(Request $request, CertificateTemplate $template): JsonResponse
    {
        if ($template->company_id !== (int)$request->input('company_id')) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }
        $template->delete();
        return response()->json(['message' => 'Plantilla eliminada exitosamente.']);
    }
}
