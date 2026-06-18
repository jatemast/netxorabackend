<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\CertificateTemplate;
use Illuminate\Database\Seeder;

class CertificateTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $company1 = Company::where('slug', 'nexora-technologies')->first();

        $templates = [
            [
                'company_id' => $company1->id,
                'name' => 'Certificado Estándar Nexora',
                'title' => 'Certificate of Completion',
                'subtitle' => 'Otorgado a',
                'body_text' => 'Por haber completado satisfactoriamente el curso y demostrado los conocimientos requeridos.',
                'background_color' => '#FFFFFF',
                'primary_color' => '#1E40AF',
                'secondary_color' => '#3B82F6',
                'accent_color' => '#06B6D4',
                'text_color' => '#0F172A',
                'font_family' => 'Helvetica',
                'orientation' => 'landscape',
                'paper_size' => 'letter',
                'show_logo' => true,
                'show_qr' => true,
                'show_signature' => true,
                'signature_name' => 'María Gómez',
                'signature_title' => 'Directora de Formación',
                'is_default' => true,
                'is_active' => true,
            ],
            [
                'company_id' => $company1->id,
                'name' => 'Certificado Premium',
                'title' => 'Certificado de Excelencia',
                'subtitle' => 'Se certifica que',
                'body_text' => 'Ha demostrado un desempeño excepcional completando el programa de formación avanzada.',
                'background_color' => '#F8FAFC',
                'primary_color' => '#1E40AF',
                'secondary_color' => '#10B981',
                'accent_color' => '#F59E0B',
                'text_color' => '#0F172A',
                'font_family' => 'Helvetica',
                'orientation' => 'landscape',
                'paper_size' => 'letter',
                'show_logo' => true,
                'show_qr' => true,
                'show_signature' => true,
                'signature_name' => 'Javier Teherán',
                'signature_title' => 'CEO',
                'is_default' => false,
                'is_active' => true,
            ],
        ];

        foreach ($templates as $data) {
            CertificateTemplate::firstOrCreate(
                ['name' => $data['name'], 'company_id' => $company1->id],
                $data
            );
        }
    }
}
