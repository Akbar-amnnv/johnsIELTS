<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuestionGroup extends Model
{
    protected $fillable = [
        'passage_id',
        'type',
        'instruction',
        'start_number',
        'end_number',
        'sort_order',
    ];

    public function passage(): BelongsTo
    {
        return $this->belongsTo(Passage::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class)->orderBy('question_number');
    }
    public function getTypeLabelAttribute(): string
    {
        return \App\Enums\QuestionGroupType::labels()[$this->type] ?? $this->type;
    }
}