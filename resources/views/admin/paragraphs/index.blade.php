@extends('layouts.admin')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Passage Paragraphs</h2>
            <p class="text-sm text-gray-500 mt-1">
                Reading Test: {{ $reading_test->title }}
            </p>
            <p class="text-sm text-gray-500">
                Passage: {{ $passage->title }}
            </p>
        </div>

        <div class="flex items-center gap-3 flex-wrap">
            <a href="{{ route('reading-tests.passages.index', $reading_test) }}"
               class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                Back to Passages
            </a>

            <a href="{{ route('reading-tests.passages.paragraphs.create', [$reading_test, $passage]) }}"
               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Add / Paste Paragraphs
            </a>
        </div>
    </div>

    <div class="space-y-4">
        @forelse($paragraphs as $paragraph)
            <div class="bg-white rounded-xl shadow p-5">
                <div class="flex items-start justify-between gap-4 mb-4">
                    <div class="flex items-center gap-3">
                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-100 text-blue-700 font-bold">
                            {{ $paragraph->label ?: '-' }}
                        </span>

                        <div>
                            <p class="font-semibold text-gray-800">
                                Paragraph {{ $paragraph->label ?: '#' . $paragraph->id }}
                            </p>
                            <p class="text-sm text-gray-500">
                                Order: {{ $paragraph->sort_order }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <a href="{{ route('reading-tests.passages.paragraphs.edit', [$reading_test, $passage, $paragraph]) }}"
                           class="text-blue-600 hover:underline text-sm">
                            Edit
                        </a>

                        <form method="POST"
                              action="{{ route('reading-tests.passages.paragraphs.destroy', [$reading_test, $passage, $paragraph]) }}"
                              onsubmit="return confirm('Delete this paragraph?')">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="text-red-600 hover:underline text-sm">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>

                <div class="text-gray-700 leading-7 whitespace-pre-line">
                    {{ $paragraph->content }}
                </div>
            </div>
        @empty
            <div class="bg-white rounded-xl shadow p-8 text-center text-gray-500">
                No paragraphs yet.
            </div>
        @endforelse
    </div>
@endsection
