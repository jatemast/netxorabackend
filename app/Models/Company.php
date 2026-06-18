<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'nit', 'email', 'phone', 'address',
        'city', 'country', 'logo', 'is_active', 'settings',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'settings' => 'json',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function courseCategories()
    {
        return $this->hasMany(CourseCategory::class);
    }

    public function questionCategories()
    {
        return $this->hasMany(QuestionCategory::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    public function certificateTemplates()
    {
        return $this->hasMany(CertificateTemplate::class);
    }

    public function microlearningContents()
    {
        return $this->hasMany(MicrolearningContent::class);
    }
}
