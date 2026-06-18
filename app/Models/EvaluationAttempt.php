<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'evaluation_id', 'employee_id', 'company_id', 'attempt_number',
        'score', 'total_points', 'percentage', 'is_passed', 'status',
        'time_spent_seconds', 'started_at', 'completed_at',
        'questions_snapshot', 'metadata',
    ];

    protected $casts = [
        'attempt_number' => 'integer',
        'score' => 'decimal:2',
        'total_points' => 'decimal:2',
        'percentage' => 'decimal:2',
        'is_passed' => 'boolean',
        'time_spent_seconds' => 'integer',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'questions_snapshot' => 'json',
        'metadata' => 'json',
    ];

    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function answers()
    {
        return $this->hasMany(EvaluationAnswer::class, 'attempt_id');
    }
}
