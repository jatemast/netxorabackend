<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionOrderingItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'item_text',
        'correct_order',
        'sort_order',
    ];

    protected $casts = [
        'correct_order' => 'integer',
        'sort_order' => 'integer',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
