<?php

namespace App\Http\Controllers;

use App\Models\Attempt;
use App\Models\AttemptAnswer;
use App\Models\Question;
use App\Models\ReadingTest;
use App\Services\ReadingScoreService;
use Illuminate\Http\Request;

class ReadingExamController extends Controller
{
    public function index()
    {
        $readingTests = ReadingTest::query()
            ->where('is_published', true)
            ->withCount('passages')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('reading.index', compact('readingTests'));
    }

    public function start(ReadingTest $reading_test)
    {
        abort_unless($reading_test->is_published, 404);

        $reading_test->loadCount('passages');

        return view('reading.start', compact('reading_test'));
    }

    public function begin(ReadingTest $reading_test)
    {
        abort_unless($reading_test->is_published, 404);

        $sessionKey = 'current_attempt_' . $reading_test->id;

        $existingAttempt = Attempt::query()
            ->where('user_id', auth()->id())
            ->where('reading_test_id', $reading_test->id)
            ->whereNull('submitted_at')
            ->latest()
            ->first();

        if ($existingAttempt) {
            session([$sessionKey => $existingAttempt->id]);

            return redirect()->route('reading.exam', $reading_test);
        }

        $attempt = Attempt::create([
            'user_id' => auth()->id(),
            'reading_test_id' => $reading_test->id,
            'started_at' => now(),
        ]);

        session([$sessionKey => $attempt->id]);

        return redirect()->route('reading.exam', $reading_test);
    }

    public function show(ReadingTest $reading_test)
    {
        abort_unless($reading_test->is_published, 404);

        $sessionKey = 'current_attempt_' . $reading_test->id;
        $attemptId = session($sessionKey);

        $attempt = Attempt::query()
            ->where('id', $attemptId)
            ->where('user_id', auth()->id())
            ->where('reading_test_id', $reading_test->id)
            ->whereNull('submitted_at')
            ->first();

        if (!$attempt) {
            return redirect()
                ->route('reading.start', $reading_test)
                ->with('error', 'Please start the test first.');
        }

        $reading_test->load([
            'passages.paragraphs',
            'passages.questionGroups.questions.options',
        ]);

        return view('reading.exam', compact('reading_test', 'attempt'));
    }

    public function submit(Request $request, ReadingTest $reading_test)
    {
        $sessionKey = 'current_attempt_' . $reading_test->id;
        $attemptId = session($sessionKey);

        $attempt = Attempt::query()
            ->where('id', $attemptId)
            ->where('user_id', auth()->id())
            ->where('reading_test_id', $reading_test->id)
            ->whereNull('submitted_at')
            ->firstOrFail();

        $answers = $request->input('answers', []);
        $correct = 0;

        foreach ($answers as $questionId => $userAnswer) {
            $question = Question::query()
                ->where('id', $questionId)
                ->whereHas('questionGroup.passage', function ($query) use ($reading_test) {
                    $query->where('reading_test_id', $reading_test->id);
                })
                ->first();

            if (!$question) {
                continue;
            }

            $userAnswer = trim($userAnswer);

            $isCorrect = strtolower($userAnswer) === strtolower(trim($question->correct_answer));

            AttemptAnswer::updateOrCreate(
                [
                    'attempt_id' => $attempt->id,
                    'question_id' => $question->id,
                ],
                [
                    'answer' => $userAnswer,
                    'is_correct' => $isCorrect,
                ]
            );

            if ($isCorrect) {
                $correct++;
            }
        }

        $band = ReadingScoreService::band($correct);

        $attempt->update([
            'total_correct' => $correct,
            'band_score' => $band,
            'submitted_at' => now(),
        ]);

        $attempt->load([
            'readingTest',
            'answers.question.questionGroup',
        ]);

        session()->forget($sessionKey);

        return view('reading.result', compact('attempt', 'correct', 'band'));
    }
}