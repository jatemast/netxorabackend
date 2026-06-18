<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Evaluation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id', 'course_id', 'title', 'description', 'instructions',
        'total_questions', 'time_limit_minutes', 'passing_score', 'max_attempts',
        'randomize_questions', 'randomize_options', 'show_results',
        'show_correct_answers', 'status', 'question_categories',
        'difficulty_distribution', 'available_from', 'available_until', 'metadata',
    ];

    protected $casts = [
        'total_questions' => 'integer',
        'time_limit_minutes' => 'integer',
        'passing_score' => 'decimal:2',
        'max_attempts' => 'integer',
        'randomize_questions' => 'boolean',
        'randomize_options' => 'boolean',
        'show_results' => 'boolean',
        'show_correct_answers' => 'boolean',
        'question_categories' => 'json',
        'difficulty_distribution' => 'json',
        'available_from' => 'datetime',
        'available_until' => 'datetime',
        'metadata' => 'json',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function attempts()
    {
        return $this->hasMany(EvaluationAttempt::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeByCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }
}
