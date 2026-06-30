<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SpeakingQuestion extends Model
{
    protected $fillable = [
        'speaking_topic_id',
        'part_number',
        'question_text',
        'cue_card_data',
        'difficulty',
        'is_active',
    ];

    protected $casts = [
        'cue_card_data' => 'array',
        'is_active' => 'boolean',
    ];

    public function topic(): BelongsTo
    {
        return $this->belongsTo(SpeakingTopic::class, 'speaking_topic_id');
    }
}