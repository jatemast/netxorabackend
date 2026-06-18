<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChallengeParticipant extends Model
{
    use HasFactory;

    protected $fillable = [
        'challenge_id',
        'employee_id',
        'status',
        'progress',
        'completed_at',
        'metadata',
    ];

    protected $casts = [
        'progress' => 'integer',
        'completed_at' => 'datetime',
        'metadata' => 'json',
    ];

    public function challenge()
    {
        return $this->belongsTo(Challenge::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
