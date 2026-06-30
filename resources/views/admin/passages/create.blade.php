@extends('layouts.admin')

@section('content')
    <div class="max-w-3xl">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Create Passage</h2>
            <p class="text-sm text-gray-500 mt-1">
                Reading Test: {{ $reading_test->title }}
            </p>
        </div>

        <form method="POST"
              action="{{ route('reading-tests.passages.store', $reading_test) }}"
              class="bg-white rounded-xl shadow p-6 space-y-5">
            @csrf

            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Title
                </label>
                <input type="text"
                       id="title"
                       name="title"
                       value="{{ old('title') }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-blue-200"
                       placeholder="Enter passage title">
                @error('title')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="instruction" class="block text-sm font-medium text-gray-700 mb-2">
                    Instruction
                </label>
                <textarea id="instruction"
                          name="instruction"
                          rows="4"
                          class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-blue-200"
                          placeholder="Optional instruction...">{{ old('instruction') }}</textarea>
                @error('instruction')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="display_mode" class="block text-sm font-medium text-gray-700 mb-2">
                    Display Mode
                </label>
                <select id="display_mode"
                        name="display_mode"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-blue-200">
                    <option value="plain" {{ old('display_mode') === 'plain' ? 'selected' : '' }}>Plain</option>
                    <option value="labeled" {{ old('display_mode') === 'labeled' ? 'selected' : '' }}>Labeled</option>
                    <option value="smart" {{ old('display_mode') === 'smart' ? 'selected' : '' }}>Smart</option>
                </select>
                @error('display_mode')
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
                       value="{{ old('sort_order') }}"
                       min="1"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-blue-200"
                       placeholder="Optional order number">
                @error('sort_order')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('reading-tests.passages.index', $reading_test) }}"
                   class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                    Cancel
                </a>

                <button type="submit"
                        class="px-5 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    Save Passage
                </button>
            </div>
        </form>
    </div>
@endsection