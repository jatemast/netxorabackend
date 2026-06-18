<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MicrolearningAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'microlearning_content_id', 'company_id', 'assign_type',
        'assignee_id', 'assignee_value', 'assigned_at',
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
    ];

    public function content()
    {
        return $this->belongsTo(MicrolearningContent::class, 'microlearning_content_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
