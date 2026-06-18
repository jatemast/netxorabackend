<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeBadge extends Model
{
    use HasFactory;

    protected $fillable = [
        'badge_id',
        'employee_id',
        'company_id',
        'earned_at',
        'metadata',
    ];

    protected $casts = [
        'earned_at' => 'datetime',
        'metadata' => 'json',
    ];

    public function badge()
    {
        return $this->belongsTo(Badge::class);
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
