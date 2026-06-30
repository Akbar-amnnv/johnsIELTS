<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Passage;
use App\Models\Question;
use App\Models\QuestionGroup;
use App\Models\ReadingTest;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index(
        ReadingTest $reading_test,
        Passage $passage,
        QuestionGroup $question_group
    ) {
        $this->ensurePassageBelongsToTest($reading_test, $passage);
        $this->ensureQuestionGroupBelongsToPassage($passage, $question_group);

        $questions = $question_group->questions()
            ->orderBy('question_number')
            ->get();

        return view('admin.questions.index', compact(
            'reading_test',
            'passage',
            'question_group',
            'questions'
        ));
    }

    public function generate(
        ReadingTest $reading_test,
        Passage $passage,
        QuestionGroup $question_group
    ) {
        $this->ensurePassageBelongsToTest($reading_test, $passage);
        $this->ensureQuestionGroupBelongsToPassage($passage, $question_group);

        $start = $question_group->start_number;
        $end = $question_group->end_number;

        for ($i = $start; $i <= $end; $i++) {
            Question::firstOrCreate(
                [
                    'question_group_id' => $question_group->id,
                    'question_number' => $i,
                ],
                [
                    'sort_order' => $i,
                ]
            );
        }

        return redirect()
            ->route('questions.index', [$reading_test, $passage, $question_group])
            ->with('success', 'Questions generated.');
    }

    public function edit(
        ReadingTest $reading_test,
        Passage $passage,
        QuestionGroup $question_group,
        Question $question
    ) {
        $this->ensurePassageBelongsToTest($reading_test, $passage);
        $this->ensureQuestionGroupBelongsToPassage($passage, $question_group);
        $this->ensureQuestionBelongsToGroup($question_group, $question);

        $paragraphs = $passage->paragraphs()->orderBy('sort_order')->get();

        return view('admin.questions.edit', compact(
            'reading_test',
            'passage',
            'question_group',
            'question',
            'paragraphs'
        ));
    }

    public function update(
        Request $request,
        ReadingTest $reading_test,
        Passage $passage,
        QuestionGroup $question_group,
        Question $question
    ) {
        $this->ensurePassageBelongsToTest($reading_test, $passage);
        $this->ensureQuestionGroupBelongsToPassage($passage, $question_group);
        $this->ensureQuestionBelongsToGroup($question_group, $question);

        $data = $request->validate([
            'question_text' => ['nullable', 'string'],
            'correct_answer' => ['nullable', 'string'],
            'paragraph_id' => ['nullable', 'integer'],
        ]);

        if (!empty($data['paragraph_id'])) {
            $paragraphExists = $passage->paragraphs()
                ->where('id', $data['paragraph_id'])
                ->exists();

            abort_if(!$paragraphExists, 404);
        }

        $question->update($data);

        return redirect()
            ->route('questions.index', [$reading_test, $passage, $question_group])
            ->with('success', 'Question updated.');
    }

    private function ensurePassageBelongsToTest(ReadingTest $reading_test, Passage $passage): void
    {
        abort_if($passage->reading_test_id !== $reading_test->id, 404);
    }

    private function ensureQuestionGroupBelongsToPassage(Passage $passage, QuestionGroup $question_group): void
    {
        abort_if($question_group->passage_id !== $passage->id, 404);
    }

    private function ensureQuestionBelongsToGroup(QuestionGroup $question_group, Question $question): void
    {
        abort_if($question->question_group_id !== $question_group->id, 404);
    }
}
