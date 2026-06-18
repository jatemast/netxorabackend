<?php

namespace App\Imports;

use App\Models\Employee;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EmployeesImport implements ToCollection, WithHeadingRow
{
    private int $companyId;
    private array $errors = [];
    private int $rowCount = 0;

    public function __construct(int $companyId)
    {
        $this->companyId = $companyId;
    }

    public function collection(Collection $rows): void
    {
        foreach ($rows as $index => $row) {
            try {
                if (empty($row['document_number']) || empty($row['first_name'])) {
                    $this->errors[] = "Fila " . ($index + 2) . ": Falta documento o nombre.";
                    continue;
                }

                Employee::updateOrCreate(
                    ['document_number' => $row['document_number']],
                    [
                        'company_id' => $this->companyId,
                        'first_name' => $row['first_name'] ?? '',
                        'last_name' => $row['last_name'] ?? '',
                        'document_type' => $row['document_type'] ?? 'CC',
                        'email' => $row['email'] ?? null,
                        'phone' => $row['phone'] ?? null,
                        'position' => $row['position'] ?? null,
                        'department' => $row['department'] ?? null,
                        'area' => $row['area'] ?? null,
                        'status' => $row['status'] ?? 'active',
                    ]
                );

                $this->rowCount++;
            } catch (\Exception $e) {
                $this->errors[] = "Fila " . ($index + 2) . ": " . $e->getMessage();
            }
        }
    }

    public function getRowCount(): int
    {
        return $this->rowCount;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
