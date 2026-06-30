@extends('layouts.admin')

@section('content')

    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-semibold">
                Question Options
            </h2>

            <p class="text-gray-500 mt-1">
                Question #{{ $question->question_number }}
            </p>

            <p class="text-gray-600">
                {{ $question->question_text ?: '-' }}
            </p>
        </div>

        <a href="{{ route('options.create', $question) }}"
           class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
            Add Option
        </a>
    </div>

    <div class="bg-white shadow rounded overflow-hidden">
        <table class="w-full">
            <thead>
            <tr class="border-b bg-gray-50">
                <th class="p-3 text-left">Label</th>
                <th class="p-3 text-left">Content</th>
                <th class="p-3 text-left">Actions</th>
            </tr>
            </thead>

            <tbody>
            @forelse($options as $option)
                <tr class="border-b">
                    <td class="p-3">{{ $option->label }}</td>
                    <td class="p-3">{{ $option->content }}</td>
                    <td class="p-3">
                        <div class="flex gap-3">
                            <form method="POST" action="{{ route('options.copyToGroup', $question) }}">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">
                                    Copy Options to All Questions in This Group
                                </button>
                            </form>
                            <a href="{{ route('options.edit', $option) }}"
                               class="text-blue-600 hover:underline">
                                Edit
                            </a>

                            <form method="POST"
                                  action="{{ route('options.destroy', $option) }}"
                                  onsubmit="return confirm('Delete this option?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="text-red-600 hover:underline">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="p-4 text-center text-gray-500">
                        No options added yet.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

@endsection
