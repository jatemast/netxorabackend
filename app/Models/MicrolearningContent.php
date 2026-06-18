<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MicrolearningContent extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id', 'title', 'description', 'content_type', 'content',
        'image_url', 'video_url', 'file_url', 'external_url',
        'read_time_minutes', 'frequency', 'custom_cron', 'status',
        'tags', 'metadata', 'scheduled_at',
    ];

    protected $casts = [
        'read_time_minutes' => 'integer',
        'tags' => 'json',
        'metadata' => 'json',
        'scheduled_at' => 'datetime',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function assignments()
    {
        return $this->hasMany(MicrolearningAssignment::class);
    }

    public function tracking()
    {
        return $this->hasMany(MicrolearningTracking::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}
