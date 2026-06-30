<?php

namespace App\Http\Controllers;

use App\Models\Attempt;
use Illuminate\Http\Request;

class ReadingResultController extends Controller
{
    public function index()
    {
        $attempts = Attempt::with('readingTest')
            ->where('user_id', auth()->id())
            ->whereNotNull('submitted_at')
            ->latest('submitted_at')
            ->paginate(10);

        return view('reading.results.index', compact('attempts'));
    }

    public function show(Attempt $attempt)
    {
        abort_if($attempt->user_id !== auth()->id(), 403);

        $attempt->load([
            'readingTest',
            'answers.question.questionGroup',
        ]);

        return view('reading.results.show', compact('attempt'));
    }
}