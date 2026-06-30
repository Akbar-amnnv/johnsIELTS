<?php

namespace App\Http\Controllers;

use App\Models\UserVocabularyProgress;
use App\Models\Vocabulary;
use App\Models\VocabularyAttempt;
use App\Models\VocabularyAttemptAnswer;
use App\Models\VocabularyCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VocabularyQuizController extends Controller
{
    protected int $questionLimit = 19;
    protected int $masteredStreak = 8;
    public function index()
    {
        $userId = Auth::id();
        

        $categories = VocabularyCategory::query()
            ->where('is_active', true)
            ->withCount([
                'vocabularies as total_words' => function ($query) {
                    $query->where('is_active', true);
                },
                'vocabularies as mastered_words' => function ($query) use ($userId) {
                    $query->where('is_active', true)
                        ->whereHas('progresses', function ($q) use ($userId) {
                            $q->where('user_id', $userId)
                                ->where('status', 'mastered');
                        });
                },
            ])
            ->paginate(6);

        $categories->getCollection()->transform(function ($category) {
            $category->remaining_words = max($category->total_words - $category->mastered_words, 0);
            $category->progress_percent = $category->total_words > 0
                ? round(($category->mastered_words / $category->total_words) * 100)
                : 0;

            return $category;
        });

        return view('vocabulary.index', compact('categories'));
    }

    public function translation(VocabularyCategory $category)
    {
        $questions = $this->generateQuiz($category, 'translation');

        if (empty($questions)) {
            return redirect()
                ->route('vocabulary.index')
                ->with('error', 'No available words left in this category. Everything may already be mastered.');
        }

        session([
            $this->sessionKey($category->id, 'translation') => $questions,
        ]);

        return view('vocabulary.quiz', [
            'category' => $category,
            'quizType' => 'translation',
            'questions' => $questions,
        ]);
    }

    public function meaning(VocabularyCategory $category)
    {
        $questions = $this->generateQuiz($category, 'meaning');

        if (empty($questions)) {
            return redirect()
                ->route('vocabulary.index')
                ->with('error', 'No available words left in this category. Everything may already be mastered.');
        }

        session([
            $this->sessionKey($category->id, 'meaning') => $questions,
        ]);

        return view('vocabulary.quiz', [
            'category' => $category,
            'quizType' => 'meaning',
            'questions' => $questions,
        ]);
    }

    public function submitTranslation(Request $request, VocabularyCategory $category)
    {
        return $this->submitQuiz($request, $category, 'translation');
    }

    public function submitMeaning(Request $request, VocabularyCategory $category)
    {
        return $this->submitQuiz($request, $category, 'meaning');
    }

    public function result(VocabularyAttempt $attempt)
    {
        abort_unless($attempt->user_id === Auth::id(), 403);

        $attempt->load(['category', 'answers.vocabulary']);

        return view('vocabulary.result', compact('attempt'));
    }

    protected function submitQuiz(Request $request, VocabularyCategory $category, string $quizType)
    {
        $questions = session($this->sessionKey($category->id, $quizType), []);

        if (empty($questions)) {
            return redirect()
                ->route('vocabulary.index')
                ->with('error', 'Quiz session expired. Please start again.');
        }

        $submittedAnswers = $request->input('answers', []);
        $userId = Auth::id();

        $attempt = DB::transaction(function () use ($category, $quizType, $questions, $submittedAnswers, $userId) {
            $attempt = VocabularyAttempt::create([
                'user_id' => $userId,
                'vocabulary_category_id' => $category->id,
                'quiz_type' => $quizType,
                'total_questions' => count($questions),
                'correct_answers' => 0,
                'score_percent' => 0,
                'started_at' => now(),
                'submitted_at' => now(),
            ]);

            $correctCount = 0;

            foreach ($questions as $question) {
                $selectedAnswer = $submittedAnswers[$question['vocabulary_id']] ?? null;
                $isCorrect = $selectedAnswer === $question['correct_answer'];

                if ($isCorrect) {
                    $correctCount++;
                }

                VocabularyAttemptAnswer::create([
                    'vocabulary_attempt_id' => $attempt->id,
                    'vocabulary_id' => $question['vocabulary_id'],
                    'prompt_text' => $question['prompt'],
                    'correct_answer' => $question['correct_answer'],
                    'selected_answer' => $selectedAnswer,
                    'options_json' => $question['options'],
                    'is_correct' => $isCorrect,
                    'answered_at' => now(),
                ]);

                $this->updateProgress($question['vocabulary_id'], $quizType, $isCorrect, $userId);
            }

            $attempt->update([
                'correct_answers' => $correctCount,
                'score_percent' => count($questions) > 0
                    ? round(($correctCount / count($questions)) * 100, 2)
                    : 0,
            ]);

            return $attempt;
        });

        session()->forget($this->sessionKey($category->id, $quizType));

        return redirect()->route('vocabulary.results.show', $attempt);
    }

    protected function generateQuiz(VocabularyCategory $category, string $quizType): array
    {
        $userId = Auth::id();

        $candidateWords = Vocabulary::query()
            ->where('vocabulary_category_id', $category->id)
            ->where('is_active', true)
            ->whereDoesntHave('progresses', function ($query) use ($userId) {
                $query->where('user_id', $userId)
                    ->where('status', 'mastered');
            })
            ->inRandomOrder()
            ->limit($this->questionLimit)
            ->get();

        if ($candidateWords->isEmpty()) {
            return [];
        }

        $allCategoryWords = Vocabulary::query()
            ->where('vocabulary_category_id', $category->id)
            ->where('is_active', true)
            ->get();

        $questions = [];

        foreach ($candidateWords as $word) {
            if ($quizType === 'translation') {
                $wrongOptions = $allCategoryWords
                    ->where('id', '!=', $word->id)
                    ->pluck('translation')
                    ->filter()
                    ->unique()
                    ->shuffle()
                    ->take(3)
                    ->values()
                    ->toArray();

                $options = collect(array_merge([$word->translation], $wrongOptions))
                    ->unique()
                    ->shuffle()
                    ->values()
                    ->toArray();

                $questions[] = [
                    'vocabulary_id' => $word->id,
                    'prompt' => $word->word,
                    'correct_answer' => $word->translation,
                    'options' => $options,
                    'meta' => [
                        'word' => $word->word,
                        'definition' => $word->definition,
                    ],
                ];
            }

            if ($quizType === 'meaning') {
                $wrongOptions = $allCategoryWords
                    ->where('id', '!=', $word->id)
                    ->pluck('word')
                    ->filter()
                    ->unique()
                    ->shuffle()
                    ->take(3)
                    ->values()
                    ->toArray();

                $options = collect(array_merge([$word->word], $wrongOptions))
                    ->unique()
                    ->shuffle()
                    ->values()
                    ->toArray();

                $questions[] = [
                    'vocabulary_id' => $word->id,
                    'prompt' => $word->definition,
                    'correct_answer' => $word->word,
                    'options' => $options,
                    'meta' => [
                        'word' => $word->word,
                        'translation' => $word->translation,
                    ],
                ];
            }
        }

        return array_values(array_filter($questions, function ($question) {
            return count($question['options']) >= 2;
        }));
    }

    protected function updateProgress(int $vocabularyId, string $quizType, bool $isCorrect, int $userId): void
    {
        $progress = UserVocabularyProgress::firstOrCreate(
            [
                'user_id' => $userId,
                'vocabulary_id' => $vocabularyId,
            ],
            [
                'status' => 'new',
                'translation_correct_streak' => 0,
                'meaning_correct_streak' => 0,
                'times_seen' => 0,
                'times_correct' => 0,
                'times_wrong' => 0,
            ]
        );

        $progress->times_seen += 1;
        $progress->last_quizzed_at = now();

        if ($isCorrect) {
            $progress->times_correct += 1;

            if ($quizType === 'translation') {
                $progress->translation_correct_streak += 1;
            }

            if ($quizType === 'meaning') {
                $progress->meaning_correct_streak += 1;
            }

            $progress->status = 'learning';
        } else {
            $progress->times_wrong += 1;

            if ($quizType === 'translation') {
                $progress->translation_correct_streak = 0;
            }

            if ($quizType === 'meaning') {
                $progress->meaning_correct_streak = 0;
            }

            $progress->status = 'reviewing';
        }

        if (
            $progress->translation_correct_streak >= $this->masteredStreak &&
            $progress->meaning_correct_streak >= $this->masteredStreak
        ) {
            $progress->status = 'mastered';
            $progress->mastered_at = now();
        }

        $progress->save();
    }

    public function restore(VocabularyCategory $category)
{
    $userId = Auth::id();

    UserVocabularyProgress::query()
        ->where('user_id', $userId)
        ->whereHas('vocabulary', function ($query) use ($category) {
            $query->where('vocabulary_category_id', $category->id);
        })
        ->where('status', 'mastered')
        ->update([
            'status'                     => 'new',
            'translation_correct_streak' => 0,
            'meaning_correct_streak'     => 0,
            'mastered_at'                => null,
        ]);

    return redirect()
        ->route('vocabulary.index')
        ->with('success', 'All mastered words in "' . $category->name . '" have been restored.');
}

    protected function sessionKey(int $categoryId, string $quizType): string
    {
        return "vocabulary_quiz_{$quizType}_category_{$categoryId}";
    }
}
