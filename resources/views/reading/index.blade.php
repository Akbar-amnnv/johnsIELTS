@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto py-10 px-6">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Available Reading Tests</h1>
                <p class="text-gray-600 mt-2">
                    Choose a published IELTS reading test and start practicing.
                </p>
            </div>

            <a href="{{ route('dashboard') }}"
               class="px-4 py-2 bg-gray-200 text-gray-800 rounded-xl hover:bg-gray-300">
                Back
            </a>
        </div>

        @if($readingTests->isEmpty())
            <div class="bg-white rounded-2xl shadow border p-10 text-center">
                <h2 class="text-xl font-semibold text-gray-800 mb-2">No tests available</h2>
                <p class="text-gray-600">
                    There are no published reading tests yet.
                </p>
            </div>
        @else
            <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($readingTests as $test)
                    <div class="bg-white border rounded-2xl shadow hover:shadow-lg transition p-6">
                        <div class="mb-4">
                            <span class="inline-block px-3 py-1 text-xs font-medium bg-blue-100 text-blue-700 rounded-full">
                                {{ ucfirst($test->module_type) }}
                            </span>
                        </div>

                        <h2 class="text-xl font-bold text-gray-800 mb-3">
                            {{ $test->title }}
                        </h2>

                        <div class="space-y-2 text-sm text-gray-600 mb-6">
                            <p><span class="font-semibold text-gray-800">Duration:</span> {{ $test->duration_minutes }} minutes</p>
                            <p><span class="font-semibold text-gray-800">Passages:</span> {{ $test->passages_count }}</p>
                        </div>

                        <a href="{{ route('reading.start', $test) }}"
                           class="inline-block w-full text-center px-5 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700">
                            View & Start
                        </a>
                    </div>
                @endforeach
            </div>
            @if($readingTests->hasPages())
                <div class="mt-8 flex flex-wrap gap-2">
                    @for($page = 1; $page <= $readingTests->lastPage(); $page++)
                        @php
                            $start = (($page - 1) * $readingTests->perPage()) + 1;
                            $end = min($page * $readingTests->perPage(), $readingTests->total());
                        @endphp

                        <a href="{{ $readingTests->url($page) }}"
                           class="px-4 py-2 rounded-xl border text-sm font-medium transition
                      {{ $readingTests->currentPage() === $page
                          ? 'bg-blue-600 text-white border-blue-600'
                          : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50' }}">
                            {{ $start }}-{{ $end }}
                        </a>
                    @endfor
                </div>
            @endif
        @endif
    </div>
@endsection