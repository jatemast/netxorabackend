<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'company_id',
        'type',
        'points',
        'experience',
        'description',
        'reference_type',
        'reference_id',
    ];

    protected $casts = [
        'points' => 'integer',
        'experience' => 'integer',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
