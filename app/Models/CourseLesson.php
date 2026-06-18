<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseLesson extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'module_id', 'title', 'description', 'content_type', 'content',
        'video_url', 'audio_url', 'file_url', 'external_url',
        'duration_minutes', 'sort_order', 'is_published', 'is_preview',
        'attachments', 'metadata',
    ];

    protected $casts = [
        'duration_minutes' => 'integer',
        'sort_order' => 'integer',
        'is_published' => 'boolean',
        'is_preview' => 'boolean',
        'attachments' => 'json',
        'metadata' => 'json',
    ];

    public function module()
    {
        return $this->belongsTo(CourseModule::class, 'module_id');
    }

    public function progress()
    {
        return $this->hasMany(LessonProgress::class, 'lesson_id');
    }
}
