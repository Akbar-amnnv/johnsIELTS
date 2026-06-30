@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto py-10 px-4">

        <div class="bg-white p-8 rounded-xl shadow mb-8 text-center">
            <h1 class="text-3xl font-bold mb-6">Reading Result</h1>

            <p class="text-lg text-gray-600 mb-2">Correct Answers</p>
            <p class="text-4xl font-bold text-blue-600 mb-6">
                {{ $correct }}
            </p>

            <p class="text-lg text-gray-600 mb-2">Estimated IELTS Band</p>
            <p class="text-5xl font-bold text-green-600">
                {{ $band }}
            </p>
        </div>

        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="p-6 border-b">
                <h2 class="text-2xl font-semibold">Answer Review</h2>
            </div>

            <div class="divide-y">
                @forelse($attempt->answers->sortBy(fn($a) => $a->question->question_number) as $answer)
                    <div class="p-6">
                        <div class="flex items-start justify-between gap-4 mb-3">
                            <div>
                                <h3 class="font-semibold text-lg">
                                    Question {{ $answer->question->question_number }}
                                </h3>

                                @if($answer->question->question_text)
                                    <p class="text-gray-700 mt-1">
                                        {{ $answer->question->question_text }}
                                    </p>
                                @endif
                            </div>

                            <div>
                                @if($answer->is_correct)
                                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm font-medium">
                                    Correct
                                </span>
                                @else
                                    <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-sm font-medium">
                                    Incorrect
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="p-4 rounded-lg bg-gray-50">
                                <p class="text-sm text-gray-500 mb-1">Your Answer</p>
                                <p class="font-medium text-gray-800">
                                    {{ $answer->answer ?: 'No answer' }}
                                </p>
                            </div>

                            <div class="p-4 rounded-lg bg-gray-50">
                                <p class="text-sm text-gray-500 mb-1">Correct Answer</p>
                                <p class="font-medium text-gray-800">
                                    {{ $answer->question->correct_answer ?: '-' }}
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-gray-500">
                        No answers found.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection