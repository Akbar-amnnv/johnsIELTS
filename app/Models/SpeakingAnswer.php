<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SpeakingAnswer extends Model
{
    protected $fillable = [
        'speaking_session_id',
        'speaking_question_id',
        'answer_text',
        'transcript',
        'audio_path',
        'duration_seconds',
    ];

    public function session(): BelongsTo
    {
        return $this->belongsTo(SpeakingSession::class, 'speaking_session_id');
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(SpeakingQuestion::class, 'speaking_question_id');
    }
}