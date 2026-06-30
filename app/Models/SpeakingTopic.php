<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SpeakingTopic extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'is_active',
    ];

    public function questions(): HasMany
    {
        return $this->hasMany(SpeakingQuestion::class);
    }
}