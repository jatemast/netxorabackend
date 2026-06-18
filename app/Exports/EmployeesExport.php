<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EmployeesExport implements FromCollection, WithHeadings, WithMapping
{
    private int $companyId;
    private array $filters;

    public function __construct(int $companyId, array $filters = [])
    {
        $this->companyId = $companyId;
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Employee::byCompany($this->companyId);

        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }
        if (!empty($this->filters['area'])) {
            $query->where('area', $this->filters['area']);
        }
        if (!empty($this->filters['department'])) {
            $query->where('department', $this->filters['department']);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Nombre', 'Apellido', 'Tipo Documento', 'Número Documento',
            'Email', 'Teléfono', 'Cargo', 'Departamento', 'Área',
            'Estado', 'Fecha Contratación', 'Ciudad',
        ];
    }

    public function map($employee): array
    {
        return [
            $employee->first_name,
            $employee->last_name,
            $employee->document_type,
            $employee->document_number,
            $employee->email,
            $employee->phone,
            $employee->position,
            $employee->department,
            $employee->area,
            $employee->status,
            $employee->hire_date?->format('Y-m-d'),
            $employee->city,
        ];
    }
}
