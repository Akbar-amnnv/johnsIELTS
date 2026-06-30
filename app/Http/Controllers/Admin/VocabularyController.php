<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vocabulary;
use App\Models\VocabularyCategory;
use Illuminate\Http\Request;

class VocabularyController extends Controller
{
    public function index(VocabularyCategory $vocabulary_category)
    {
        $vocabularies = Vocabulary::query()
            ->where('vocabulary_category_id', $vocabulary_category->id)
            ->latest()
            ->paginate(15);

        return view('admin.vocabularies.index', compact('vocabulary_category', 'vocabularies'));
    }

    public function create(VocabularyCategory $vocabulary_category)
    {
        return view('admin.vocabularies.create', compact('vocabulary_category'));
    }

    public function store(Request $request, VocabularyCategory $vocabulary_category)
    {
        $data = $request->validate([
            'word' => ['required', 'string', 'max:255'],
            'translation' => ['required', 'string', 'max:255'],
            'definition' => ['required', 'string'],
            'example' => ['nullable', 'string'],
            'difficulty' => ['nullable', 'in:easy,medium,hard'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['vocabulary_category_id'] = $vocabulary_category->id;
        $data['is_active'] = $request->boolean('is_active');

        $exists = Vocabulary::query()
            ->where('vocabulary_category_id', $vocabulary_category->id)
            ->whereRaw('LOWER(word) = ?', [mb_strtolower($data['word'])])
            ->exists();

        if ($exists) {
            return back()
                ->withErrors(['word' => 'This word already exists in this category.'])
                ->withInput();
        }

        Vocabulary::create($data);

        return redirect()
            ->route('vocabulary-categories.vocabularies.index', $vocabulary_category)
            ->with('success', 'Vocabulary word created successfully.');
    }

    public function show(VocabularyCategory $vocabulary_category, Vocabulary $vocabulary)
    {
        return redirect()->route('vocabulary-categories.vocabularies.edit', [$vocabulary_category, $vocabulary]);
    }

    public function edit(VocabularyCategory $vocabulary_category, Vocabulary $vocabulary)
    {
        abort_unless($vocabulary->vocabulary_category_id === $vocabulary_category->id, 404);

        return view('admin.vocabularies.edit', compact('vocabulary_category', 'vocabulary'));
    }

    public function update(Request $request, VocabularyCategory $vocabulary_category, Vocabulary $vocabulary)
    {
        abort_unless($vocabulary->vocabulary_category_id === $vocabulary_category->id, 404);

        $data = $request->validate([
            'word' => ['required', 'string', 'max:255'],
            'translation' => ['required', 'string', 'max:255'],
            'definition' => ['required', 'string'],
            'example' => ['nullable', 'string'],
            'difficulty' => ['nullable', 'in:easy,medium,hard'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $exists = Vocabulary::query()
            ->where('vocabulary_category_id', $vocabulary_category->id)
            ->where('id', '!=', $vocabulary->id)
            ->whereRaw('LOWER(word) = ?', [mb_strtolower($data['word'])])
            ->exists();

        if ($exists) {
            return back()
                ->withErrors(['word' => 'This word already exists in this category.'])
                ->withInput();
        }

        $data['is_active'] = $request->boolean('is_active');

        $vocabulary->update($data);

        return redirect()
            ->route('vocabulary-categories.vocabularies.index', $vocabulary_category)
            ->with('success', 'Vocabulary word updated successfully.');
    }

    public function destroy(VocabularyCategory $vocabulary_category, Vocabulary $vocabulary)
    {
        abort_unless($vocabulary->vocabulary_category_id === $vocabulary_category->id, 404);

        $vocabulary->delete();

        return redirect()
            ->route('vocabulary-categories.vocabularies.index', $vocabulary_category)
            ->with('success', 'Vocabulary word deleted successfully.');
    }
}