<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseEnrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id', 'employee_id', 'company_id', 'progress',
        'status', 'enrolled_at', 'started_at', 'completed_at',
        'score', 'attempts', 'metadata',
    ];

    protected $casts = [
        'progress' => 'decimal:2',
        'score' => 'decimal:2',
        'enrolled_at' => 'datetime',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'metadata' => 'json',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
