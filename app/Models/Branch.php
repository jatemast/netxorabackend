<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id', 'name', 'slug', 'code', 'address',
        'city', 'phone', 'email', 'manager_name', 'is_active', 'metadata',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'metadata' => 'json',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function areas()
    {
        return $this->hasMany(Area::class)->orderBy('sort_order');
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function scopeByCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
