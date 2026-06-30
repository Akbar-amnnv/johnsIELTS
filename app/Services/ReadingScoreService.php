<?php

namespace App\Services;

class ReadingScoreService
{
    public static function band(int $correct): float
    {
        return match(true) {

            $correct >= 39 => 9,
            $correct >= 37 => 8.5,
            $correct >= 35 => 8,
            $correct >= 33 => 7.5,
            $correct >= 30 => 7,
            $correct >= 27 => 6.5,
            $correct >= 23 => 6,
            $correct >= 19 => 5.5,
            $correct >= 15 => 5,
            $correct >= 13 => 4.5,
            $correct >= 10 => 4,

            default => 3
        };
    }
}
