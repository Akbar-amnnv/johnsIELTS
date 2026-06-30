@extends('layouts.admin')

@section('content')

    <div class="mb-4">
        <a href="{{ route('vocabulary-categories.vocabularies.index', $vocabulary_category) }}"
           class="text-sm text-gray-500 hover:text-gray-700">← Back to Words</a>
        <h2 class="text-xl font-semibold mt-1">Add Vocabulary Word</h2>
    </div>

    <form method="POST"
          action="{{ route('vocabulary-categories.vocabularies.store', $vocabulary_category) }}"
          class="bg-white p-6 rounded-xl shadow space-y-5">
        @csrf

        <div>
            <label class="block mb-1 font-medium">Word</label>
            <input type="text"
                   name="word"
                   value="{{ old('word') }}"
                   class="w-full border rounded-lg p-3"
                   placeholder="Genome"
                   required>
        </div>

        <div>
            <label class="block mb-1 font-medium">Translation</label>
            <input type="text"
                   name="translation"
                   value="{{ old('translation') }}"
                   class="w-full border rounded-lg p-3"
                   placeholder="tarjimasi"
                   required>
        </div>

        <div>
            <label class="block mb-1 font-medium">Definition</label>
            <textarea name="definition"
                      rows="4"
                      class="w-full border rounded-lg p-3"
                      placeholder="English meaning / definition"
                      required>{{ old('definition') }}</textarea>
        </div>

        <div>
            <label class="block mb-1 font-medium">Example Sentence</label>
            <textarea name="example"
                      rows="3"
                      class="w-full border rounded-lg p-3"
                      placeholder="Optional example...">{{ old('example') }}</textarea>
        </div>

        <div>
            <label class="block mb-1 font-medium">Difficulty</label>
            <select name="difficulty" class="w-full border rounded-lg p-3">
                <option value="">Select difficulty</option>
                <option value="easy" {{ old('difficulty') === 'easy' ? 'selected' : '' }}>Easy</option>
                <option value="medium" {{ old('difficulty') === 'medium' ? 'selected' : '' }}>Medium</option>
                <option value="hard" {{ old('difficulty') === 'hard' ? 'selected' : '' }}>Hard</option>
            </select>
        </div>

        <div class="flex items-center gap-2">
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
            <label>Active</label>
        </div>

        <div class="flex gap-3">
            <button class="px-4 py-2 bg-green-600 text-white rounded-lg">Save</button>
            <a href="{{ route('vocabulary-categories.vocabularies.index', $vocabulary_category) }}"
               class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg">
                Cancel
            </a>
        </div>
    </form>

@endsection