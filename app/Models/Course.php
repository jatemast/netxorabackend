<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id', 'category_id', 'instructor_id', 'title', 'slug',
        'description', 'objectives', 'requirements', 'thumbnail', 'cover_image',
        'duration_hours', 'duration_minutes', 'level', 'status',
        'is_featured', 'has_certificate', 'passing_score', 'max_attempts',
        'sort_order', 'metadata', 'published_at',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'has_certificate' => 'boolean',
        'passing_score' => 'decimal:2',
        'max_attempts' => 'integer',
        'sort_order' => 'integer',
        'metadata' => 'json',
        'published_at' => 'datetime',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function category()
    {
        return $this->belongsTo(CourseCategory::class, 'category_id');
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function modules()
    {
        return $this->hasMany(CourseModule::class)->orderBy('sort_order');
    }

    public function enrollments()
    {
        return $this->hasMany(CourseEnrollment::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
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
