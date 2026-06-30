
@extends('layouts.app')

@section('content')

    <div class="max-w-4xl mx-auto py-12 px-6">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="p-8 border-b border-gray-200">
            <span class="inline-block px-3 py-1 text-sm bg-blue-100 text-blue-700 rounded-full mb-4">
                IELTS Reading Test
            </span>

                <h1 class="text-3xl font-bold text-gray-800 mb-3">
                    {{ $reading_test->title }}
                </h1>

                <p class="text-gray-600 leading-7">
                    Please read the instructions carefully before starting the test.
                    Once you begin, the timer will start and you should complete the reading test within the given time.
                </p>
            </div>

            <div class="p-8 grid md:grid-cols-3 gap-6 bg-gray-50 border-b border-gray-200">
                <div class="bg-white rounded-xl p-5 border">
                    <p class="text-sm text-gray-500 mb-2">Module Type</p>
                    <p class="text-xl font-semibold text-gray-800">
                        {{ ucfirst($reading_test->module_type) }}
                    </p>
                </div>

                <div class="bg-white rounded-xl p-5 border">
                    <p class="text-sm text-gray-500 mb-2">Duration</p>
                    <p class="text-xl font-semibold text-gray-800">
                        {{ $reading_test->duration_minutes }} minutes
                    </p>
                </div>

                <div class="bg-white rounded-xl p-5 border">
                    <p class="text-sm text-gray-500 mb-2">Passages</p>
                    <p class="text-xl font-semibold text-gray-800">
                        {{ $reading_test->passages_count }}
                    </p>
                </div>
            </div>

            <div class="p-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">
                    Instructions
                </h2>

                <ul class="space-y-3 text-gray-600 leading-7 list-disc pl-5">
                    <li>Read each passage carefully before answering the questions.</li>
                    <li>You can move between questions during the test.</li>
                    <li>The timer will begin as soon as you start the exam.</li>
                    <li>Make sure to submit your answers before the time runs out.</li>
                </ul>

                <div class="mt-8 flex items-center gap-4">
                    <a href="{{ route('dashboard') }}"
                       class="px-5 py-3 bg-gray-200 text-gray-800 rounded-xl hover:bg-gray-300">
                        Back
                    </a>

                    <form method="POST" action="{{ route('reading.begin', $reading_test) }}">
                        @csrf
                        <button type="submit"
                                class="px-6 py-3 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition">
                            Start Test
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection