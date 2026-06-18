<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CertificateTemplate extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id', 'name', 'title', 'subtitle', 'body_text',
        'logo', 'background_image', 'background_color', 'primary_color',
        'secondary_color', 'accent_color', 'text_color', 'font_family',
        'orientation', 'paper_size', 'show_logo', 'show_qr',
        'show_signature', 'signature_image', 'signature_name',
        'signature_title', 'custom_styles', 'is_default', 'is_active',
    ];

    protected $casts = [
        'show_logo' => 'boolean',
        'show_qr' => 'boolean',
        'show_signature' => 'boolean',
        'is_default' => 'boolean',
        'is_active' => 'boolean',
        'custom_styles' => 'json',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class, 'template_id');
    }
}
