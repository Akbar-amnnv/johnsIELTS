@extends('layouts.admin')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-800">Vocabulary Categories</h2>
            <p class="text-sm text-gray-500">Manage vocabulary groups like Business, Academic, IELTS Speaking.</p>
        </div>

        <a href="{{ route('vocabulary-categories.create') }}"
           class="px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700">
            + Create Category
        </a>
    </div>

    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
            <tr>
                <th class="p-4 text-left">Name</th>
                <th class="p-4 text-left">Slug</th>
                <th class="p-4 text-left">Words</th>
                <th class="p-4 text-left">Status</th>
                <th class="p-4 text-center">Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($categories as $category)
                <tr class="border-b">
                    <td class="p-4 font-medium text-gray-800">{{ $category->name }}</td>
                    <td class="p-4 text-gray-600">{{ $category->slug }}</td>
                    <td class="p-4">{{ $category->vocabularies_count }}</td>
                    <td class="p-4">
                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $category->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                            {{ $category->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="p-4">
                        <div class="flex items-center justify-center gap-4">
                            <a href="{{ route('vocabulary-categories.vocabularies.index', $category) }}"
                               class="text-purple-600 hover:underline">
                                Words
                            </a>

                            <a href="{{ route('vocabulary-categories.edit', $category) }}"
                               class="text-blue-600 hover:underline">
                                Edit
                            </a>

                            <form method="POST" action="{{ route('vocabulary-categories.destroy', $category) }}">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline"
                                        onclick="return confirm('Delete this category?')">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-6 text-center text-gray-500">
                        No vocabulary categories yet.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $categories->links() }}
    </div>

@endsection