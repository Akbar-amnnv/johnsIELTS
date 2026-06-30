<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VocabularyCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VocabularyCategoryController extends Controller
{
    public function index()
    {
        $categories = VocabularyCategory::withCount('vocabularies')
            ->latest()
            ->paginate(10);

        return view('admin.vocabulary-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.vocabulary-categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:vocabulary_categories,name'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:vocabulary_categories,slug'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active');

        VocabularyCategory::create($data);

        return redirect()
            ->route('vocabulary-categories.index')
            ->with('success', 'Vocabulary category created successfully.');
    }

    public function show(VocabularyCategory $vocabulary_category)
    {
        return redirect()->route('vocabulary-categories.vocabularies.index', $vocabulary_category);
    }

    public function edit(VocabularyCategory $vocabulary_category)
    {
        return view('admin.vocabulary-categories.edit', compact('vocabulary_category'));
    }

    public function update(Request $request, VocabularyCategory $vocabulary_category)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:vocabulary_categories,name,' . $vocabulary_category->id],
            'slug' => ['nullable', 'string', 'max:255', 'unique:vocabulary_categories,slug,' . $vocabulary_category->id],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active');

        $vocabulary_category->update($data);

        return redirect()
            ->route('vocabulary-categories.index')
            ->with('success', 'Vocabulary category updated successfully.');
    }

    public function destroy(VocabularyCategory $vocabulary_category)
    {
        if ($vocabulary_category->vocabularies()->exists()) {
            return redirect()
                ->route('vocabulary-categories.index')
                ->with('error', 'This category has words. Delete words first.');
        }

        $vocabulary_category->delete();

        return redirect()
            ->route('vocabulary-categories.index')
            ->with('success', 'Vocabulary category deleted successfully.');
    }
}