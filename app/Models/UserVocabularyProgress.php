<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserVocabularyProgress extends Model
{
    protected $table = 'user_vocabulary_progress';

    protected $fillable = [
        'user_id',
        'vocabulary_id',
        'status',
        'translation_correct_streak',
        'meaning_correct_streak',
        'times_seen',
        'times_correct',
        'times_wrong',
        'last_quizzed_at',
        'mastered_at',
    ];

    protected $casts = [
        'last_quizzed_at' => 'datetime',
        'mastered_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function vocabulary(): BelongsTo
    {
        return $this->belongsTo(Vocabulary::class);
    }
}