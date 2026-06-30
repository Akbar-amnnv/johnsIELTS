@extends('layouts.admin')

@section('content')
    <div class="max-w-5xl space-y-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Create Paragraphs</h2>
            <p class="text-sm text-gray-500 mt-1">
                Reading Test: {{ $reading_test->title }}
            </p>
            <p class="text-sm text-gray-500">
                Passage: {{ $passage->title }}
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- FULL SPLIT --}}
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    Paste Full Content
                </h3>

                <form method="POST"
                      action="{{ route('reading-tests.passages.paragraphs.store-split', [$reading_test, $passage]) }}"
                      class="space-y-4">
                    @csrf

                    <div>
                        <label for="full_content" class="block text-sm font-medium text-gray-700 mb-2">
                            Full Passage Content
                        </label>

                        <textarea id="full_content"
                                  name="full_content"
                                  rows="14"
                                  class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring focus:ring-blue-200"
                                  placeholder="Paste full passage here. Leave empty lines between paragraphs...">{{ old('full_content') }}</textarea>

                        @error('full_content')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror

                        <p class="text-xs text-gray-500 mt-2">
                            The system will split paragraphs using empty lines.
                        </p>
                    </div>

                    <button type="submit"
                            class="px-5 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                        Split and Save
                    </button>
                </form>
            </div>

            {{-- SINGLE PARAGRAPH --}}
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    Add Single Paragraph
                </h3>

                <form method="POST"
                      action="{{ route('reading-tests.passages.paragraphs.store', [$reading_test, $passage]) }}"
                      class="space-y-4">
                    @csrf

                    <div>
                        <label for="label" class="block text-sm font-medium text-gray-700 mb-2">
                            Label
                        </label>
                        <input type="text"
                               id="label"
                               name="label"
                               value="{{ old('label') }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2"
                               placeholder="A, B, C ...">
                    </div>

                    <div>
                        <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">
                            Sort Order
                        </label>
                        <input type="number"
                               id="sort_order"
                               name="sort_order"
                               min="1"
                               value="{{ old('sort_order') }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2"
                               placeholder="Optional">
                    </div>

                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                            Paragraph Content
                        </label>
                        <textarea id="content"
                                  name="content"
                                  rows="8"
                                  class="w-full border border-gray-300 rounded-lg px-4 py-3"
                                  placeholder="Write one paragraph...">{{ old('content') }}</textarea>

                        @error('content')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                            class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Save Paragraph
                    </button>
                </form>
            </div>
        </div>

        <div>
            <a href="{{ route('reading-tests.passages.paragraphs.index', [$reading_test, $passage]) }}"
               class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                Back
            </a>
        </div>
    </div>
@endsection
