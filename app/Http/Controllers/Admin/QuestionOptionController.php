<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Http\Request;

class QuestionOptionController extends Controller
{
    public function index(Question $question)
    {
        $options = $question->options()
            ->orderBy('sort_order')
            ->get();

        return view('admin.options.index', compact('question', 'options'));
    }

    public function create(Question $question)
    {
        return view('admin.options.create', compact('question'));
    }

    public function store(Request $request, Question $question)
    {
        $data = $request->validate([
            'label' => ['required', 'string', 'max:10'],
            'content' => ['required', 'string'],
        ]);

        QuestionOption::create([
            'question_id' => $question->id,
            'label' => $data['label'],
            'content' => $data['content'],
        ]);

        return redirect()
            ->route('options.index', $question)
            ->with('success', 'Option created.');
    }

    public function edit(QuestionOption $option)
    {
        $option->load('question');

        return view('admin.options.edit', compact('option'));
    }

    public function update(Request $request, QuestionOption $option)
    {
        $data = $request->validate([
            'label' => ['required', 'string', 'max:10'],
            'content' => ['required', 'string'],
        ]);

        $option->update($data);

        return redirect()
            ->route('options.index', $option->question)
            ->with('success', 'Option updated.');
    }

    public function destroy(QuestionOption $option)
    {
        $question = $option->question;

        $option->delete();

        return redirect()
            ->route('options.index', $question)
            ->with('success', 'Option deleted.');
    }
    public function copyToGroup(Question $question)
    {
        $question->load(['options', 'questionGroup.questions']);

        $sourceOptions = $question->options;

        if ($sourceOptions->isEmpty()) {
            return redirect()
                ->route('options.index', $question)
                ->with('error', 'Please add options to this question first.');
        }

        $questions = $question->questionGroup->questions()
            ->where('id', '!=', $question->id)
            ->get();

        foreach ($questions as $targetQuestion) {
            // old optionsni o‘chirib tashlaymiz
            $targetQuestion->options()->delete();

            foreach ($sourceOptions as $option) {
                $targetQuestion->options()->create([
                    'label' => $option->label,
                    'content' => $option->content,
                    'sort_order' => $option->sort_order,
                ]);
            }
        }

        return redirect()
            ->route('options.index', $question)
            ->with('success', 'Options copied to all questions in this group.');
    }
}
