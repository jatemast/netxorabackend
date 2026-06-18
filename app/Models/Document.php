<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'uploaded_by',
        'title',
        'slug',
        'description',
        'type',
        'category',
        'file_path',
        'file_url',
        'file_type',
        'file_size',
        'thumbnail',
        'version',
        'status',
        'is_public',
        'tags',
        'metadata',
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'tags' => 'json',
        'metadata' => 'json',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function documentAssignments()
    {
        return $this->hasMany(DocumentAssignment::class);
    }

    public function documentTracking()
    {
        return $this->hasMany(DocumentTracking::class);
    }

    public function scopeByCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }
}
