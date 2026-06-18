<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeePoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'company_id',
        'total_points',
        'total_experience',
        'level',
        'current_level_points',
        'points_to_next_level',
        'metadata',
    ];

    protected $casts = [
        'total_points' => 'integer',
        'total_experience' => 'integer',
        'level' => 'integer',
        'current_level_points' => 'integer',
        'points_to_next_level' => 'integer',
        'metadata' => 'json',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
