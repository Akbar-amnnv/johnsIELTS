@extends('layouts.admin')

@section('content')

    <h2 class="text-xl font-semibold mb-4">Create Vocabulary Category</h2>

    <form method="POST"
          action="{{ route('vocabulary-categories.store') }}"
          class="bg-white p-6 rounded-xl shadow space-y-5">
        @csrf

        <div>
            <label class="block mb-1 font-medium">Name</label>
            <input type="text"
                   name="name"
                   value="{{ old('name') }}"
                   class="w-full border rounded-lg p-3"
                   placeholder="Business"
                   required>
        </div>

        <div>
            <label class="block mb-1 font-medium">Slug</label>
            <input type="text"
                   name="slug"
                   value="{{ old('slug') }}"
                   class="w-full border rounded-lg p-3"
                   placeholder="business">
            <p class="text-xs text-gray-500 mt-1">Leave blank to auto-generate.</p>
        </div>

        <div>
            <label class="block mb-1 font-medium">Description</label>
            <textarea name="description"
                      rows="4"
                      class="w-full border rounded-lg p-3"
                      placeholder="Short description about this category...">{{ old('description') }}</textarea>
        </div>

        <div class="flex items-center gap-2">
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
            <label>Active</label>
        </div>

        <div class="flex gap-3">
            <button class="px-4 py-2 bg-green-600 text-white rounded-lg">Save</button>
            <a href="{{ route('vocabulary-categories.index') }}"
               class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg">
                Cancel
            </a>
        </div>
    </form>

@endsection