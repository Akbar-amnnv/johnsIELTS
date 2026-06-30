@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto py-10 px-6">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Practice Mode</h1>
            <p class="text-gray-600 mt-2">
                Choose a question type and practice focused sets.
            </p>
        </div>

        <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach($types as $practiceType)
                <div class="bg-white border rounded-2xl shadow p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">
                        {{ $practiceType['label'] }}
                    </h2>

                    <p class="text-gray-600 mb-5">
                        {{ $practiceType['description'] }}
                    </p>

                    <a href="{{ route('practice.groups', $practiceType['value']) }}"
                       class="inline-block w-full text-center px-5 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition">
                        View Practice Sets
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection