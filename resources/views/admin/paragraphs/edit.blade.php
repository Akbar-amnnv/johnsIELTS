@extends('layouts.admin')

@section('content')
    <div class="max-w-4xl">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Edit Paragraph</h2>
            <p class="text-sm text-gray-500 mt-1">
                Reading Test: {{ $reading_test->title }}
            </p>
            <p class="text-sm text-gray-500">
                Passage: {{ $passage->title }}
            </p>
        </div>

        <form method="POST"
              action="{{ route('reading-tests.passages.paragraphs.update', [$reading_test, $passage, $paragraph]) }}"
              class="bg-white rounded-xl shadow p-6 space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="label" class="block text-sm font-medium text-gray-700 mb-2">
                        Label
                    </label>
                    <input type="text"
                           id="label"
                           name="label"
                           value="{{ old('label', $paragraph->label) }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2">
                    @error('label')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">
                        Sort Order
                    </label>
                    <input type="number"
                           id="sort_order"
                           name="sort_order"
                           min="1"
                           value="{{ old('sort_order', $paragraph->sort_order) }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2">
                    @error('sort_order')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                    Paragraph Content
                </label>
                <textarea id="content"
                          name="content"
                          rows="12"
                          class="w-full border border-gray-300 rounded-lg px-4 py-3">{{ old('content', $paragraph->content) }}</textarea>
                @error('content')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('reading-tests.passages.paragraphs.index', [$reading_test, $passage]) }}"
                   class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                    Cancel
                </a>

                <button type="submit"
                        class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Update Paragraph
                </button>
            </div>
        </form>
    </div>
@endsection
