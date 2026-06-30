<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Passage extends Model
{
    protected $fillable = [
        'reading_test_id',
        'title',
        'instruction',
        'display_mode',
        'sort_order',
    ];

    public function readingTest(): BelongsTo
    {
        return $this->belongsTo(ReadingTest::class);
    }

    public function paragraphs(): HasMany
    {
        return $this->hasMany(PassageParagraph::class)->orderBy('sort_order');
    }

    public function questionGroups(): HasMany
    {
        return $this->hasMany(QuestionGroup::class)->orderBy('sort_order');
    }
}