@extends('layouts.admin')

@section('content')
    <div class="max-w-4xl">
        <div class="flex items-start justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">{{ $passage->title }}</h2>
                <p class="text-sm text-gray-500 mt-1">
                    Reading Test: {{ $reading_test->title }}
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('reading-tests.passages.index', $reading_test) }}"
                   class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                    Back
                </a>

                <a href="{{ route('reading-tests.passages.edit', [$reading_test, $passage]) }}"
                   class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Edit
                </a>

                <a href="{{ route('reading-tests.passages.paragraphs.index', [$reading_test, $passage]) }}"
                   class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    Manage Paragraphs
                </a>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-6 space-y-6">
            <div>
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Title</h3>
                <p class="mt-2 text-gray-800">{{ $passage->title }}</p>
            </div>

            <div>
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Instruction</h3>
                <div class="mt-2 text-gray-800 whitespace-pre-line">
                    {{ $passage->instruction ?: 'No instruction provided.' }}
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Display Mode</h3>
                    <p class="mt-2 text-gray-800">{{ ucfirst($passage->display_mode) }}</p>
                </div>

                <div>
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Sort Order</h3>
                    <p class="mt-2 text-gray-800">{{ $passage->sort_order }}</p>
                </div>
            </div>

            <div>
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Created At</h3>
                <p class="mt-2 text-gray-800">{{ $passage->created_at?->format('Y-m-d H:i') }}</p>
            </div>
        </div>
    </div>
@endsection