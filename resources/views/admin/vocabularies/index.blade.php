@extends('layouts.admin')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <div>
            <a href="{{ route('vocabulary-categories.index') }}"
               class="text-sm text-gray-500 hover:text-gray-700">← Back to Categories</a>

            <h2 class="text-xl font-semibold text-gray-800 mt-1">
                {{ $vocabulary_category->name }} Words
            </h2>
            <p class="text-sm text-gray-500">Manage vocabulary items in this category.</p>
        </div>

        <a href="{{ route('vocabulary-categories.vocabularies.create', $vocabulary_category) }}"
           class="px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700">
            + Add Word
        </a>
    </div>

    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
            <tr>
                <th class="p-4 text-left">Word</th>
                <th class="p-4 text-left">Translation</th>
                <th class="p-4 text-left">Difficulty</th>
                <th class="p-4 text-left">Status</th>
                <th class="p-4 text-center">Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($vocabularies as $vocabulary)
                <tr class="border-b align-top">
                    <td class="p-4">
                        <div class="font-semibold text-gray-800">{{ $vocabulary->word }}</div>
                        <div class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $vocabulary->definition }}</div>
                    </td>
                    <td class="p-4">{{ $vocabulary->translation }}</td>
                    <td class="p-4">
                        {{ $vocabulary->difficulty ? ucfirst($vocabulary->difficulty) : '-' }}
                    </td>
                    <td class="p-4">
                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $vocabulary->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                            {{ $vocabulary->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="p-4">
                        <div class="flex items-center justify-center gap-4">
                            <a href="{{ route('vocabulary-categories.vocabularies.edit', [$vocabulary_category, $vocabulary]) }}"
                               class="text-blue-600 hover:underline">
                                Edit
                            </a>

                            <form method="POST"
                                  action="{{ route('vocabulary-categories.vocabularies.destroy', [$vocabulary_category, $vocabulary]) }}">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline"
                                        onclick="return confirm('Delete this word?')">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-6 text-center text-gray-500">
                        No vocabulary words yet in this category.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $vocabularies->links() }}
    </div>

@endsection