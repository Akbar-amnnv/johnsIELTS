<?php

namespace App\Http\Controllers\Admin;

use App\Enums\QuestionGroupType;
use App\Http\Controllers\Controller;
use App\Models\Passage;
use App\Models\QuestionGroup;
use App\Models\ReadingTest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class QuestionGroupController extends Controller
{
    public function index(ReadingTest $reading_test, Passage $passage)
    {
        $this->ensurePassageBelongsToTest($reading_test, $passage);

        $groups = $passage->questionGroups()
            ->orderBy('sort_order')
            ->get();

        return view('admin.question-groups.index', compact(
            'reading_test',
            'passage',
            'groups'
        ));
    }

    public function create(ReadingTest $reading_test, Passage $passage)
    {
        $this->ensurePassageBelongsToTest($reading_test, $passage);

        return view('admin.question-groups.create', compact(
            'reading_test',
            'passage'
        ));
    }

    public function store(Request $request, ReadingTest $reading_test, Passage $passage)
    {
        $this->ensurePassageBelongsToTest($reading_test, $passage);

        $data = $request->validate([
            'type' => ['required', 'string', Rule::in(QuestionGroupType::all())],
            'instruction' => ['required', 'string'],
            'start_number' => ['required', 'integer', 'min:1'],
            'end_number' => ['required', 'integer', 'min:1', 'gte:start_number'],
            'sort_order' => ['nullable', 'integer', 'min:1'],
        ]);

        $startNumber = (int) $data['start_number'];
        $endNumber = (int) $data['end_number'];

        $overlapExists = $passage->questionGroups()
            ->where(function ($query) use ($startNumber, $endNumber) {
                $query->where('start_number', '<=', $endNumber)
                    ->where('end_number', '>=', $startNumber);
            })
            ->exists();

        if ($overlapExists) {
            return back()
                ->withInput()
                ->withErrors([
                    'start_number' => 'This question number range overlaps with an existing group in the same passage.',
                ]);
        }

        $data['sort_order'] = $data['sort_order']
            ?? (($passage->questionGroups()->max('sort_order') ?? 0) + 1);

        $passage->questionGroups()->create($data);

        return redirect()
            ->route('reading-tests.passages.question-groups.index', [$reading_test, $passage])
            ->with('success', 'Question group created.');
    }

    public function edit(ReadingTest $reading_test, Passage $passage, QuestionGroup $question_group)
    {
        $this->ensurePassageBelongsToTest($reading_test, $passage);
        $this->ensureQuestionGroupBelongsToPassage($passage, $question_group);

        return view('admin.question-groups.edit', compact(
            'reading_test',
            'passage',
            'question_group'
        ));
    }

    public function update(Request $request, ReadingTest $reading_test, Passage $passage, QuestionGroup $question_group)
    {
        $this->ensurePassageBelongsToTest($reading_test, $passage);

        if ($question_group->passage_id !== $passage->id) {
            abort(404);
        }

        $data = $request->validate([
            'type' => ['required', 'string', Rule::in(QuestionGroupType::all())],
            'instruction' => ['required', 'string'],
            'start_number' => ['required', 'integer', 'min:1'],
            'end_number' => ['required', 'integer', 'min:1', 'gte:start_number'],
            'sort_order' => ['nullable', 'integer', 'min:1'],
        ]);

        $startNumber = (int) $data['start_number'];
        $endNumber = (int) $data['end_number'];

        $overlapExists = $passage->questionGroups()
            ->where('id', '!=', $question_group->id)
            ->where(function ($query) use ($startNumber, $endNumber) {
                $query->where('start_number', '<=', $endNumber)
                    ->where('end_number', '>=', $startNumber);
            })
            ->exists();

        if ($overlapExists) {
            return back()
                ->withInput()
                ->withErrors([
                    'start_number' => 'This question number range overlaps with an existing group in the same passage.',
                ]);
        }

        $data['sort_order'] = $data['sort_order']
            ?? $question_group->sort_order
            ?? (($passage->questionGroups()->max('sort_order') ?? 0) + 1);

        $question_group->update($data);

        return redirect()
            ->route('reading-tests.passages.question-groups.index', [$reading_test, $passage])
            ->with('success', 'Question group updated.');
    }

    public function destroy(ReadingTest $reading_test, Passage $passage, QuestionGroup $question_group)
    {
        $this->ensurePassageBelongsToTest($reading_test, $passage);
        $this->ensureQuestionGroupBelongsToPassage($passage, $question_group);

        $question_group->delete();

        return redirect()
            ->route('reading-tests.passages.question-groups.index', [$reading_test, $passage])
            ->with('success', 'Question group deleted.');
    }

    private function ensurePassageBelongsToTest(ReadingTest $reading_test, Passage $passage): void
    {
        abort_if($passage->reading_test_id !== $reading_test->id, 404);
    }

    private function ensureQuestionGroupBelongsToPassage(Passage $passage, QuestionGroup $question_group): void
    {
        abort_if($question_group->passage_id !== $passage->id, 404);
    }
}