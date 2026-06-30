<?php

namespace App\Http\Controllers;

use App\Enums\QuestionGroupType;
use App\Models\QuestionGroup;
use Illuminate\Http\Request;

class PracticeController extends Controller
{
    public function index()
    {
        $types = [
            [
                'value' => QuestionGroupType::TRUE_FALSE_NOT_GIVEN->value,
                'label' => QuestionGroupType::TRUE_FALSE_NOT_GIVEN->label(),
                'description' => 'Practice True / False / Not Given question sets.',
            ],
            [
                'value' => QuestionGroupType::YES_NO_NOT_GIVEN->value,
                'label' => QuestionGroupType::YES_NO_NOT_GIVEN->label(),
                'description' => 'Practice Yes / No / Not Given question sets.',
            ],
            [
                'value' => QuestionGroupType::MULTIPLE_CHOICE->value,
                'label' => QuestionGroupType::MULTIPLE_CHOICE->label(),
                'description' => 'Practice Multiple Choice question sets.',
            ],
            [
                'value' => QuestionGroupType::MATCHING_HEADINGS->value,
                'label' => QuestionGroupType::MATCHING_HEADINGS->label(),
                'description' => 'Practice Matching Headings question sets.',
            ],
            [
                'value' => QuestionGroupType::SENTENCE_COMPLETION->value,
                'label' => QuestionGroupType::SENTENCE_COMPLETION->label(),
                'description' => 'Practice Sentence Completion question sets.',
            ],
            [
                'value' => QuestionGroupType::SUMMARY_COMPLETION->value,
                'label' => QuestionGroupType::SUMMARY_COMPLETION->label(),
                'description' => 'Practice Summary Completion question sets.',
            ],
            [
                'value' => QuestionGroupType::SHORT_ANSWER->value,
                'label' => QuestionGroupType::SHORT_ANSWER->label(),
                'description' => 'Practice Short Answer question sets.',
            ],
        ];

        return view('practice.index', compact('types'));
    }

    public function groups(string $type)
    {
        abort_unless(in_array($type, QuestionGroupType::all()), 404);

        $groups = QuestionGroup::query()
            ->where('type', $type)
            ->with([
                'passage.readingTest',
            ])
            ->orderBy('passage_id')
            ->orderBy('sort_order')
            ->paginate(10)
            ->withQueryString();

        return view('practice.groups', [
            'type' => $type,
            'typeLabel' => QuestionGroupType::from($type)->label(),
            'groups' => $groups,
        ]);
    }

    public function show(string $type, QuestionGroup $group)
    {
        abort_unless(in_array($type, QuestionGroupType::all()), 404);

        if ($group->type !== $type) {
            abort(404);
        }

        $group->load([
            'passage.readingTest',
            'passage.paragraphs',
            'questions.options',
            'questions.paragraph',
        ]);

        $paragraphIds = $group->questions
            ->pluck('paragraph_id')
            ->filter()
            ->unique()
            ->values();

        $practiceParagraphs = $group->passage->paragraphs
            ->whereIn('id', $paragraphIds)
            ->sortBy('sort_order')
            ->values();

        return view('practice.show', [
            'type' => $type,
            'typeLabel' => QuestionGroupType::from($type)->label(),
            'group' => $group,
            'practiceParagraphs' => $practiceParagraphs,
        ]);
    }

    public function submit(Request $request, string $type, QuestionGroup $group)
    {
        abort_unless(in_array($type, QuestionGroupType::all()), 404);

        if ($group->type !== $type) {
            abort(404);
        }

        $group->load([
            'passage.readingTest',
            'passage.paragraphs',
            'questions.options',
            'questions.paragraph',
        ]);

        $answers = $request->input('answers', []);
        $results = [];
        $correctCount = 0;

        foreach ($group->questions as $question) {
            $userAnswer = trim($answers[$question->id] ?? '');
            $correctAnswer = trim($question->correct_answer ?? '');

            $isCorrect = strtolower($userAnswer) === strtolower($correctAnswer);

            $results[] = [
                'question' => $question,
                'user_answer' => $userAnswer,
                'correct_answer' => $correctAnswer,
                'is_correct' => $isCorrect,
            ];

            if ($isCorrect) {
                $correctCount++;
            }
        }

        $totalQuestions = $group->questions->count();

        return view('practice.result', [
            'type' => $type,
            'typeLabel' => QuestionGroupType::from($type)->label(),
            'group' => $group,
            'results' => $results,
            'correctCount' => $correctCount,
            'totalQuestions' => $totalQuestions,
        ]);
    }
}