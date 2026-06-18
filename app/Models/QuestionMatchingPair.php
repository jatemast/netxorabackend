<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionMatchingPair extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'left_text',
        'right_text',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
