<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'attempt_id', 'question_id', 'selected_options',
        'text_answer', 'is_correct', 'points_earned',
    ];

    protected $casts = [
        'selected_options' => 'json',
        'is_correct' => 'boolean',
        'points_earned' => 'decimal:2',
    ];

    public function attempt()
    {
        return $this->belongsTo(EvaluationAttempt::class, 'attempt_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
