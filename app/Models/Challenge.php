<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Challenge extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'name',
        'slug',
        'description',
        'type',
        'criteria',
        'points_reward',
        'experience_reward',
        'badge_reward_id',
        'starts_at',
        'ends_at',
        'is_active',
    ];

    protected $casts = [
        'criteria' => 'json',
        'points_reward' => 'integer',
        'experience_reward' => 'integer',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function badge()
    {
        return $this->belongsTo(Badge::class, 'badge_reward_id');
    }

    public function participants()
    {
        return $this->hasMany(ChallengeParticipant::class);
    }

    public function scopeByCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }
}
