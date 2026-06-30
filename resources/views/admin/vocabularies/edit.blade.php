@extends('layouts.admin')

@section('content')

    <div class="mb-4">
        <a href="{{ route('vocabulary-categories.vocabularies.index', $vocabulary_category) }}"
           class="text-sm text-gray-500 hover:text-gray-700">← Back to Words</a>
        <h2 class="text-xl font-semibold mt-1">Edit Vocabulary Word</h2>
    </div>

    <form method="POST"
          action="{{ route('vocabulary-categories.vocabularies.update', [$vocabulary_category, $vocabulary]) }}"
          class="bg-white p-6 rounded-xl shadow space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label class="block mb-1 font-medium">Word</label>
            <input type="text"
                   name="word"
                   value="{{ old('word', $vocabulary->word) }}"
                   class="w-full border rounded-lg p-3"
                   required>
        </div>

        <div>
            <label class="block mb-1 font-medium">Translation</label>
            <input type="text"
                   name="translation"
                   value="{{ old('translation', $vocabulary->translation) }}"
                   class="w-full border rounded-lg p-3"
                   required>
        </div>

        <div>
            <label class="block mb-1 font-medium">Definition</label>
            <textarea name="definition"
                      rows="4"
                      class="w-full border rounded-lg p-3"
                      required>{{ old('definition', $vocabulary->definition) }}</textarea>
        </div>

        <div>
            <label class="block mb-1 font-medium">Example Sentence</label>
            <textarea name="example"
                      rows="3"
                      class="w-full border rounded-lg p-3">{{ old('example', $vocabulary->example) }}</textarea>
        </div>

        <div>
            <label class="block mb-1 font-medium">Difficulty</label>
            <select name="difficulty" class="w-full border rounded-lg p-3">
                <option value="">Select difficulty</option>
                <option value="easy" {{ old('difficulty', $vocabulary->difficulty) === 'easy' ? 'selected' : '' }}>Easy</option>
                <option value="medium" {{ old('difficulty', $vocabulary->difficulty) === 'medium' ? 'selected' : '' }}>Medium</option>
                <option value="hard" {{ old('difficulty', $vocabulary->difficulty) === 'hard' ? 'selected' : '' }}>Hard</option>
            </select>
        </div>

        <div class="flex items-center gap-2">
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $vocabulary->is_active) ? 'checked' : '' }}>
            <label>Active</label>
        </div>

        <div class="flex gap-3">
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg">Update</button>
            <a href="{{ route('vocabulary-categories.vocabularies.index', $vocabulary_category) }}"
               class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg">
                Cancel
            </a>
        </div>
    </form>

@endsection