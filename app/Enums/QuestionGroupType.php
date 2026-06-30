<?php

namespace App\Enums;

enum QuestionGroupType: string
{
    case TRUE_FALSE_NOT_GIVEN = 'true_false_not_given';
    case YES_NO_NOT_GIVEN = 'yes_no_not_given';
    case MULTIPLE_CHOICE = 'multiple_choice';
    case MATCHING_HEADINGS = 'matching_headings';
    case SENTENCE_COMPLETION = 'sentence_completion';
    case SUMMARY_COMPLETION = 'summary_completion';
    case SHORT_ANSWER = 'short_answer';

    public function label(): string
    {
        return match ($this) {
            self::TRUE_FALSE_NOT_GIVEN => 'True / False / Not Given',
            self::YES_NO_NOT_GIVEN => 'Yes / No / Not Given',
            self::MULTIPLE_CHOICE => 'Multiple Choice',
            self::MATCHING_HEADINGS => 'Matching Headings',
            self::SENTENCE_COMPLETION => 'Sentence Completion',
            self::SUMMARY_COMPLETION => 'Summary Completion',
            self::SHORT_ANSWER => 'Short Answer',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
    public static function all(): array
    {
        return array_column(self::cases(), 'value');
    }
}