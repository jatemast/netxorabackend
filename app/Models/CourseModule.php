<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseModule extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'course_id', 'title', 'description', 'sort_order',
        'duration_minutes', 'is_published', 'metadata',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'duration_minutes' => 'integer',
        'is_published' => 'boolean',
        'metadata' => 'json',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function lessons()
    {
        return $this->hasMany(CourseLesson::class, 'module_id')->orderBy('sort_order');
    }
}
