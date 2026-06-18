<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WhatsAppSchedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'name',
        'type',
        'microlearning_content_id',
        'message_template',
        'frequency',
        'custom_cron',
        'scheduled_time',
        'target_filters',
        'is_active',
        'last_sent_at',
        'next_send_at',
    ];

    protected $casts = [
        'target_filters' => 'json',
        'is_active' => 'boolean',
        'scheduled_time' => 'datetime',
        'last_sent_at' => 'datetime',
        'next_send_at' => 'datetime',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function microlearningContent()
    {
        return $this->belongsTo(MicrolearningContent::class);
    }

    public function messages()
    {
        return $this->hasMany(WhatsAppMessage::class, 'schedule_id');
    }

    public function scopeByCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }
}
