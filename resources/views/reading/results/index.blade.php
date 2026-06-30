@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto py-10 px-4">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">My Results</h1>
            <p class="text-gray-500 mt-2">
                Here you can view your completed reading test history.
            </p>
        </div>

        <div class="bg-white rounded-xl shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="p-4 text-left text-sm font-semibold text-gray-600">Test</th>
                    <th class="p-4 text-left text-sm font-semibold text-gray-600">Correct</th>
                    <th class="p-4 text-left text-sm font-semibold text-gray-600">Band</th>
                    <th class="p-4 text-left text-sm font-semibold text-gray-600">Submitted</th>
                    <th class="p-4 text-left text-sm font-semibold text-gray-600">Action</th>
                </tr>
                </thead>

                <tbody>
                @forelse($attempts as $attempt)
                    <tr class="border-b last:border-b-0 hover:bg-gray-50">
                        <td class="p-4 text-gray-800 font-medium">
                            {{ $attempt->readingTest->title ?? 'Reading Test' }}
                        </td>

                        <td class="p-4 text-gray-700">
                            {{ $attempt->total_correct ?? 0 }}
                        </td>

                        <td class="p-4 text-gray-700">
                            {{ $attempt->band_score ?? '-' }}
                        </td>

                        <td class="p-4 text-gray-700">
                            {{ $attempt->submitted_at?->format('Y-m-d H:i') }}
                        </td>

                        <td class="p-4">
                            <a href="{{ route('reading.results.show', $attempt) }}"
                               class="text-blue-600 hover:underline text-sm">
                                View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-gray-500">
                            No completed results yet.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6 text-center">
            <a href="{{ route('reading.results.index') }}"
               class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                View My Results
            </a>
        </div>
        <div class="mt-6">
            {{ $attempts->links() }}
        </div>
    </div>
@endsection