@extends('layouts.admin')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Passages</h2>
            <p class="text-sm text-gray-500 mt-1">
                Reading Test: {{ $reading_test->title }}
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('reading-tests.index') }}"
               class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                Back to Tests
            </a>

            <a href="{{ route('reading-tests.passages.create', $reading_test) }}"
               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                + Add Passage
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
            <tr>
                <th class="p-4 text-left text-sm font-semibold text-gray-600">#</th>
                <th class="p-4 text-left text-sm font-semibold text-gray-600">Title</th>
                <th class="p-4 text-left text-sm font-semibold text-gray-600">Display Mode</th>
                <th class="p-4 text-left text-sm font-semibold text-gray-600">Order</th>
                <th class="p-4 text-left text-sm font-semibold text-gray-600">Actions</th>
            </tr>
            </thead>

            <tbody>
            @forelse($passages as $passage)
                <tr class="border-b last:border-b-0 hover:bg-gray-50">
                    <td class="p-4 text-sm text-gray-700">{{ $passage->id }}</td>
                    <td class="p-4">
                        <div class="font-medium text-gray-800">{{ $passage->title }}</div>
                        @if($passage->instruction)
                            <div class="text-sm text-gray-500 mt-1">
                                {{ \Illuminate\Support\Str::limit($passage->instruction, 80) }}
                            </div>
                        @endif
                    </td>
                    <td class="p-4 text-sm text-gray-700">
                        {{ ucfirst($passage->display_mode) }}
                    </td>
                    <td class="p-4 text-sm text-gray-700">
                        {{ $passage->sort_order }}
                    </td>
                    <td class="p-4">
                        <div class="flex items-center gap-3 flex-wrap">

                            <a href="{{ route('reading-tests.passages.show', [$reading_test, $passage]) }}"
                               class="text-indigo-600 hover:underline text-sm">
                                View
                            </a>

                            <a href="{{ route('reading-tests.passages.paragraphs.index', [$reading_test, $passage]) }}"
                               class="text-green-600 hover:underline text-sm">
                                Paragraphs
                            </a>

                            <a href="{{ route('reading-tests.passages.question-groups.index', [$reading_test, $passage]) }}"
                               class="text-purple-600 hover:underline text-sm">
                                Questions
                            </a>

                            <a href="{{ route('reading-tests.passages.edit', [$reading_test, $passage]) }}"
                               class="text-blue-600 hover:underline text-sm">
                                Edit
                            </a>

                            <form method="POST"
                                  action="{{ route('reading-tests.passages.destroy', [$reading_test, $passage]) }}"
                                  onsubmit="return confirm('Delete this passage?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="text-red-600 hover:underline text-sm">
                                    Delete
                                </button>

                            </form>

                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-8 text-center text-gray-500">
                        No passages found for this reading test.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection