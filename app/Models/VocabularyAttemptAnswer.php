<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VocabularyAttemptAnswer extends Model
{
    protected $fillable = [
        'vocabulary_attempt_id',
        'vocabulary_id',
        'prompt_text',
        'correct_answer',
        'selected_answer',
        'options_json',
        'is_correct',
        'answered_at',
    ];

    protected $casts = [
        'options_json' => 'array',
        'is_correct' => 'boolean',
        'answered_at' => 'datetime',
    ];

    public function attempt(): BelongsTo
    {
        return $this->belongsTo(VocabularyAttempt::class, 'vocabulary_attempt_id');
    }

    public function vocabulary(): BelongsTo
    {
        return $this->belongsTo(Vocabulary::class);
    }
}