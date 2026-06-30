@extends('layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto py-10 px-6">
        <div class="bg-white rounded-2xl shadow border p-8 mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Practice Result</h1>
            <p class="text-gray-600 mb-4">
                {{ $group->passage->readingTest->title }} • {{ $group->passage->title }}
            </p>

            <p class="text-lg text-gray-700">
                Correct Answers:
                <span class="font-bold text-green-600">{{ $correctCount }}</span>
                / {{ $totalQuestions }}
            </p>
        </div>

        <div class="space-y-4">
            @foreach($results as $item)
                <div class="bg-white border rounded-2xl shadow p-5">
                    <p class="font-semibold text-gray-900 mb-3">
                        {{ $item['question']->question_number }}.
                        {{ $item['question']->question_text }}
                    </p>

                    <p class="text-gray-700">
                        <span class="font-medium">Your Answer:</span>
                        {{ $item['user_answer'] !== '' ? $item['user_answer'] : 'No answer' }}
                    </p>

                    <p class="text-gray-700 mt-1">
                        <span class="font-medium">Correct Answer:</span>
                        {{ $item['correct_answer'] }}
                    </p>

                    <p class="mt-3 font-semibold {{ $item['is_correct'] ? 'text-green-600' : 'text-red-600' }}">
                        {{ $item['is_correct'] ? 'Correct' : 'Wrong' }}
                    </p>
                </div>
            @endforeach
        </div>

        <div class="mt-8 flex flex-wrap gap-3">
            <a href="{{ route('practice.show', [$type, $group]) }}"
               class="px-5 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition">
                Practice Again
            </a>

            <a href="{{ route('practice.groups', $type) }}"
               class="px-5 py-3 bg-gray-200 text-gray-800 rounded-xl hover:bg-gray-300 transition">
                Back to Sets
            </a>
        </div>
    </div>
@endsection