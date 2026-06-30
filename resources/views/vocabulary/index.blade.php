@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto py-10 px-4">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Vocabulary Practice</h1>
            <p class="text-gray-600 mt-2">
                Practice by category, build memory through repetition, and stop seeing words once they are mastered.
            </p>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 rounded-xl bg-green-100 text-green-800">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-4 rounded-xl bg-red-100 text-red-800">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-6">
            @forelse($categories as $category)
                <div class="bg-white rounded-2xl shadow-sm border p-6 hover:shadow-md transition">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">{{ $category->name }}</h2>
                            <p class="text-sm text-gray-500 mt-1">
                                {{ $category->description ?: 'Vocabulary category for quiz practice.' }}
                            </p>
                        </div>

                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">
                        {{ $category->progress_percent }}%
                    </span>
                    </div>

                    <div class="mb-4">
                        <div class="w-full h-3 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-amber-500 rounded-full" style="width: {{ $category->progress_percent }}%"></div>
                        </div>
                    </div>

                 <div class="grid grid-cols-3 gap-3 mb-4 text-center">
         <div class="bg-gray-50 rounded-xl p-3">
            <p class="text-xs text-gray-500">Total</p>
            <p class="text-lg font-bold text-gray-900">{{ $category->total_words }}</p>
        </div>
        <div class="bg-green-50 rounded-xl p-3">
            <p class="text-xs text-green-600">Mastered</p>
            <p class="text-lg font-bold text-green-700">{{ $category->mastered_words }}</p>
        </div>
        <div class="bg-blue-50 rounded-xl p-3">
            <p class="text-xs text-blue-600">Remaining</p>
            <p class="text-lg font-bold text-blue-700">{{ $category->remaining_words }}</p>
        </div>
</div>

    @if($category->mastered_words > 0)
        <form action="{{ route('vocabulary.restore', $category) }}" method="POST"
            class="mb-4"
            onsubmit="return confirm('Restore all {{ $category->mastered_words }} mastered words? They will return to the quiz pool.')">
        @csrf
        <button type="submit"
                class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl border border-red-200 bg-red-50 text-red-600 font-medium hover:bg-red-100 transition text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/>
                <path d="M3 3v5h5"/>
            </svg>
            Restore {{ $category->mastered_words }} mastered words
        </button>
    </form>
    @endif

                    <div class="flex flex-col gap-3">
                        <a href="{{ route('vocabulary.translation', $category) }}"
                           class="w-full inline-flex items-center justify-center px-4 py-3 rounded-xl bg-amber-600 text-white font-medium hover:bg-amber-700 transition">
                            Translation Quiz
                        </a>

                        <a href="{{ route('vocabulary.meaning', $category) }}"
                           class="w-full inline-flex items-center justify-center px-4 py-3 rounded-xl bg-slate-900 text-white font-medium hover:bg-slate-800 transition">
                            Meaning Quiz
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-2xl border p-8 text-center text-gray-500">
                    No vocabulary categories available yet.
                </div>
            @endforelse

        </div>
        <div class="mt-8">
            {{ $categories->links() }}
        </div>
    </div>

@endsection
