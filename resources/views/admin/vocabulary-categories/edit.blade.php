@extends('layouts.admin')

@section('content')

    <h2 class="text-xl font-semibold mb-4">Edit Vocabulary Category</h2>

    <form method="POST"
          action="{{ route('vocabulary-categories.update', $vocabulary_category) }}"
          class="bg-white p-6 rounded-xl shadow space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label class="block mb-1 font-medium">Name</label>
            <input type="text"
                   name="name"
                   value="{{ old('name', $vocabulary_category->name) }}"
                   class="w-full border rounded-lg p-3"
                   required>
        </div>

        <div>
            <label class="block mb-1 font-medium">Slug</label>
            <input type="text"
                   name="slug"
                   value="{{ old('slug', $vocabulary_category->slug) }}"
                   class="w-full border rounded-lg p-3">
        </div>

        <div>
            <label class="block mb-1 font-medium">Description</label>
            <textarea name="description"
                      rows="4"
                      class="w-full border rounded-lg p-3">{{ old('description', $vocabulary_category->description) }}</textarea>
        </div>

        <div class="flex items-center gap-2">
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $vocabulary_category->is_active) ? 'checked' : '' }}>
            <label>Active</label>
        </div>

        <div class="flex gap-3">
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg">Update</button>
            <a href="{{ route('vocabulary-categories.index') }}"
               class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg">
                Cancel
            </a>
        </div>
    </form>

@endsection