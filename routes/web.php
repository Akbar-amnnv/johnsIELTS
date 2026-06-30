<?php

use App\Http\Controllers\Admin\PassageController;
use App\Http\Controllers\Admin\PassageParagraphController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\QuestionGroupController;
use App\Http\Controllers\Admin\QuestionOptionController;
use App\Http\Controllers\Admin\ReadingTestController;
use App\Http\Controllers\Admin\VocabularyCategoryController;
use App\Http\Controllers\Admin\VocabularyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReadingExamController;
use App\Http\Controllers\ReadingResultController;
use App\Http\Controllers\VocabularyQuizController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PracticeController;
/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('vocabulary/{category}/restore', [VocabularyQuizController::class, 'restore'])
    ->name('vocabulary.restore');
/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Student Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/reading-tests', [ReadingExamController::class, 'index'])
        ->name('reading.tests.index');

    Route::get('/reading/{reading_test}/start', [ReadingExamController::class, 'start'])
        ->name('reading.start');

    Route::get('/reading/{reading_test}', [ReadingExamController::class, 'show'])
        ->name('reading.exam');

    Route::post('/reading/{reading_test}/begin', [ReadingExamController::class, 'begin'])
        ->name('reading.begin');

    Route::post('/reading/{reading_test}/submit', [ReadingExamController::class, 'submit'])
        ->name('reading.submit');

    Route::get('/my-results', [ReadingResultController::class, 'index'])
        ->name('reading.results.index');

    Route::get('/my-results/{attempt}', [ReadingResultController::class, 'show'])
        ->name('reading.results.show');
    Route::get('/vocabulary', [VocabularyQuizController::class, 'index'])->name('vocabulary.index');

    Route::get('/vocabulary/{category:slug}/translation', [VocabularyQuizController::class, 'translation'])
        ->name('vocabulary.translation');

    Route::post('/vocabulary/{category:slug}/translation', [VocabularyQuizController::class, 'submitTranslation'])
        ->name('vocabulary.translation.submit');

    Route::get('/vocabulary/{category:slug}/meaning', [VocabularyQuizController::class, 'meaning'])
        ->name('vocabulary.meaning');

    Route::post('/vocabulary/{category:slug}/meaning', [VocabularyQuizController::class, 'submitMeaning'])
        ->name('vocabulary.meaning.submit');

    Route::get('/vocabulary/results/{attempt}', [VocabularyQuizController::class, 'result'])
        ->name('vocabulary.results.show');

});

/*
|--------------------------------------------------------------------------
| Profile Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('admin')->group(function () {
    /*
    |--------------------------------------------------------------------------
    | Reading Tests
    |--------------------------------------------------------------------------
    */
    Route::resource('reading-tests', ReadingTestController::class);

    /*
    |--------------------------------------------------------------------------
    | Passages
    |--------------------------------------------------------------------------
    */
    Route::resource('reading-tests.passages', PassageController::class);

    /*
    |--------------------------------------------------------------------------
    | Passage Paragraphs
    |--------------------------------------------------------------------------
    */
    Route::get(
        'reading-tests/{reading_test}/passages/{passage}/paragraphs',
        [PassageParagraphController::class, 'index']
    )->name('reading-tests.passages.paragraphs.index');

    Route::get(
        'reading-tests/{reading_test}/passages/{passage}/paragraphs/create',
        [PassageParagraphController::class, 'create']
    )->name('reading-tests.passages.paragraphs.create');

    Route::post(
        'reading-tests/{reading_test}/passages/{passage}/paragraphs',
        [PassageParagraphController::class, 'store']
    )->name('reading-tests.passages.paragraphs.store');

    Route::get(
        'reading-tests/{reading_test}/passages/{passage}/paragraphs/{paragraph}/edit',
        [PassageParagraphController::class, 'edit']
    )->name('reading-tests.passages.paragraphs.edit');

    Route::put(
        'reading-tests/{reading_test}/passages/{passage}/paragraphs/{paragraph}',
        [PassageParagraphController::class, 'update']
    )->name('reading-tests.passages.paragraphs.update');

    Route::delete(
        'reading-tests/{reading_test}/passages/{passage}/paragraphs/{paragraph}',
        [PassageParagraphController::class, 'destroy']
    )->name('reading-tests.passages.paragraphs.destroy');

    Route::post(
        'reading-tests/{reading_test}/passages/{passage}/paragraphs/store-split',
        [PassageParagraphController::class, 'storeSplit']
    )->name('reading-tests.passages.paragraphs.store-split');

    /*
    |--------------------------------------------------------------------------
    | Question Groups
    |--------------------------------------------------------------------------
    */
    Route::resource(
        'reading-tests.passages.question-groups',
        QuestionGroupController::class
    );

    /*
    |--------------------------------------------------------------------------
    | Questions
    |--------------------------------------------------------------------------
    */
    Route::get(
        'reading-tests/{reading_test}/passages/{passage}/question-groups/{question_group}/questions',
        [QuestionController::class, 'index']
    )->name('questions.index');

    Route::post(
        'reading-tests/{reading_test}/passages/{passage}/question-groups/{question_group}/generate',
        [QuestionController::class, 'generate']
    )->name('questions.generate');

    Route::get(
        'reading-tests/{reading_test}/passages/{passage}/question-groups/{question_group}/questions/{question}/edit',
        [QuestionController::class, 'edit']
    )->name('questions.edit');

    Route::put(
        'reading-tests/{reading_test}/passages/{passage}/question-groups/{question_group}/questions/{question}',
        [QuestionController::class, 'update']
    )->name('questions.update');

    /*
    |--------------------------------------------------------------------------
    | Question Options
    |--------------------------------------------------------------------------
    */
    Route::get(
        'questions/{question}/options',
        [QuestionOptionController::class, 'index']
    )->name('options.index');

    Route::get(
        'questions/{question}/options/create',
        [QuestionOptionController::class, 'create']
    )->name('options.create');

    Route::post(
        'questions/{question}/options',
        [QuestionOptionController::class, 'store']
    )->name('options.store');

    Route::get(
        'options/{option}/edit',
        [QuestionOptionController::class, 'edit']
    )->name('options.edit');

    Route::put(
        'options/{option}',
        [QuestionOptionController::class, 'update']
    )->name('options.update');

    Route::delete(
        'options/{option}',
        [QuestionOptionController::class, 'destroy']
    )->name('options.destroy');
    Route::post('/questions/{question}/options/copy-to-group', [QuestionOptionController::class, 'copyToGroup'])
        ->name('options.copyToGroup');
});
/*
   |--------------------------------------------------------------------------
   | Vocabulary Categories
   |--------------------------------------------------------------------------
   */
    Route::resource('vocabulary-categories', VocabularyCategoryController::class);

/*
|--------------------------------------------------------------------------
| Vocabularies
|--------------------------------------------------------------------------
*/
    Route::resource('vocabulary-categories.vocabularies', VocabularyController::class);

    Route::middleware(['auth'])->group(function () {
    Route::get('/practice', [PracticeController::class, 'index'])
        ->name('practice.index');

    Route::get('/practice/{type}', [PracticeController::class, 'groups'])
        ->name('practice.groups');

    Route::get('/practice/{type}/{group}', [PracticeController::class, 'show'])
        ->name('practice.show');

    Route::post('/practice/{type}/{group}/submit', [PracticeController::class, 'submit'])
        ->name('practice.submit');
});
require __DIR__ . '/auth.php';
