<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        $companies = [
            [
                'name' => 'Nexora Technologies',
                'slug' => 'nexora-technologies',
                'nit' => '900.123.456-1',
                'email' => 'contacto@nexora.com.co',
                'phone' => '+57 601 234 5678',
                'address' => 'Carrera 15 #93-60, Torre B',
                'city' => 'Bogotá',
                'country' => 'Colombia',
                'logo' => null,
                'is_active' => true,
                'settings' => json_encode([
                    'timezone' => 'America/Bogota',
                    'language' => 'es',
                    'date_format' => 'd/m/Y',
                ]),
            ],
            [
                'name' => 'Innovación Digital SAS',
                'slug' => 'innovacion-digital',
                'nit' => '800.987.654-2',
                'email' => 'info@innovaciondigital.com',
                'phone' => '+57 604 345 6789',
                'address' => 'Calle 10 #43E-25, Edificio Inteligente',
                'city' => 'Medellín',
                'country' => 'Colombia',
                'logo' => null,
                'is_active' => true,
                'settings' => json_encode([
                    'timezone' => 'America/Bogota',
                    'language' => 'es',
                    'date_format' => 'd/m/Y',
                ]),
            ],
            [
                'name' => 'Aprendizaje Global Ltda',
                'slug' => 'aprendizaje-global',
                'nit' => '700.555.333-3',
                'email' => 'hola@aprendizajeglobal.co',
                'phone' => '+57 602 456 7890',
                'address' => 'Avenida 6N #17-40, Centro Empresarial',
                'city' => 'Cali',
                'country' => 'Colombia',
                'logo' => null,
                'is_active' => true,
                'settings' => json_encode([
                    'timezone' => 'America/Bogota',
                    'language' => 'es',
                    'date_format' => 'd/m/Y',
                ]),
            ],
        ];

        foreach ($companies as $company) {
            Company::firstOrCreate(['slug' => $company['slug']], $company);
        }
    }
}
