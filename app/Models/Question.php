<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id', 'category_id', 'type', 'difficulty',
        'question_text', 'explanation', 'image_url', 'points', 'is_active', 'metadata',
    ];

    protected $casts = [
        'points' => 'integer',
        'is_active' => 'boolean',
        'metadata' => 'json',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function category()
    {
        return $this->belongsTo(QuestionCategory::class, 'category_id');
    }

    public function options()
    {
        return $this->hasMany(QuestionOption::class)->orderBy('sort_order');
    }

    public function correctOptions()
    {
        return $this->hasMany(QuestionOption::class)->where('is_correct', true);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
