<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PassageParagraph extends Model
{
    protected $fillable = [
        'passage_id',
        'label',
        'content',
        'sort_order',
    ];

    public function passage(): BelongsTo
    {
        return $this->belongsTo(Passage::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class, 'paragraph_id');
    }
}