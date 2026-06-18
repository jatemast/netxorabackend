<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MicrolearningTracking extends Model
{
    use HasFactory;

    protected $fillable = [
        'microlearning_content_id', 'employee_id', 'company_id',
        'status', 'delivered_at', 'seen_at', 'completed_at',
        'time_spent_seconds', 'metadata',
    ];

    protected $casts = [
        'delivered_at' => 'datetime',
        'seen_at' => 'datetime',
        'completed_at' => 'datetime',
        'time_spent_seconds' => 'integer',
        'metadata' => 'json',
    ];

    public function content()
    {
        return $this->belongsTo(MicrolearningContent::class, 'microlearning_content_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
