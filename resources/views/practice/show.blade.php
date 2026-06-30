@extends('layouts.app')

@section('content')
    <style>
        .question-card-active {
            border-color: rgba(96, 165, 250, 0.7) !important;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.16);
        }

        .glass-panel {
            background: rgba(15, 23, 42, 0.78);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
        }

        .custom-scroll::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        .custom-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scroll::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, 0.45);
            border-radius: 9999px;
        }

        .custom-scroll::-webkit-scrollbar-thumb:hover {
            background: rgba(148, 163, 184, 0.7);
        }
    </style>

    <div class="min-h-screen bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950 py-4">
        <div class="max-w-[1800px] mx-auto px-4 sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('practice.submit', [$type, $group]) }}">
                @csrf

                <div class="grid grid-cols-1 2xl:grid-cols-[1.05fr_1.45fr] xl:grid-cols-[1fr_1.25fr] gap-5">

                    {{-- LEFT SIDE: PASSAGE --}}
                    <div class="glass-panel rounded-3xl border border-white/10 shadow-[0_20px_60px_rgba(0,0,0,0.45)] h-[88vh] overflow-hidden flex flex-col">
                        <div class="sticky top-0 z-10 bg-slate-900/85 backdrop-blur-xl border-b border-white/10 px-6 py-4">
                            <div>
                                <h2 class="text-[30px] leading-none font-bold text-white">Practice Passage</h2>
                                <p class="text-sm text-slate-400 mt-2">
                                    {{ $group->passage->readingTest->title }} • {{ $group->passage->title }}
                                </p>
                            </div>
                        </div>

                        <div class="flex-1 overflow-y-auto custom-scroll px-7 py-6 text-slate-200">
                            @forelse($practiceParagraphs as $paragraph)
                                <div class="mb-5 rounded-2xl border border-white/10 bg-white/5 px-6 py-5">
                                    <p class="text-[20px] leading-10 text-slate-200">
                                        <span class="inline-flex items-center justify-center min-w-[38px] h-9 px-3 mr-3 rounded-full bg-sky-500/20 text-sky-200 border border-sky-300/20 text-sm font-bold align-middle">
                                            {{ $paragraph->label }}
                                        </span>
                                        {{ $paragraph->content }}
                                    </p>
                                </div>
                            @empty
                                <div class="rounded-2xl border border-yellow-400/20 bg-yellow-500/10 px-5 py-4 text-yellow-200">
                                    No linked paragraphs found for this practice set.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- RIGHT SIDE: QUESTIONS --}}
                    <div class="glass-panel rounded-3xl border border-white/10 shadow-[0_20px_60px_rgba(0,0,0,0.45)] h-[88vh] overflow-hidden flex flex-col">
                        <div class="sticky top-0 z-10 bg-slate-900/90 backdrop-blur-xl border-b border-white/10 px-6 py-4">
                            <div class="flex flex-col gap-4">
                                <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-3">
                                    <div>
                                        <h2 class="text-[30px] leading-none font-bold text-white">{{ $typeLabel }}</h2>
                                        <p class="text-sm text-slate-400 mt-2">
                                            Questions {{ $group->start_number }}–{{ $group->end_number }}
                                        </p>
                                    </div>

                                    <div class="px-4 py-2 rounded-xl border border-sky-400/20 bg-sky-500/10 text-sky-200 font-semibold text-sm w-fit">
                                        Practice Mode
                                    </div>
                                </div>

                                <div class="rounded-2xl border border-sky-400/15 bg-sky-500/10 p-4">
                                    <p class="font-semibold text-sky-100 leading-7 text-[15px]">
                                        {{ $group->instruction }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="flex-1 overflow-y-auto custom-scroll px-6 py-5">
                            <div class="space-y-4">
                                @foreach($group->questions as $question)
                                    <div id="question-{{ $question->id }}"
                                         class="question-card border border-white/10 rounded-2xl p-5 bg-white/5 shadow-sm transition">
                                        <div class="flex items-start gap-4 mb-4">
                                            <div class="shrink-0 w-11 h-11 rounded-xl bg-sky-500/15 text-sky-200 border border-sky-300/20 flex items-center justify-center text-sm font-bold">
                                                {{ $question->question_number }}
                                            </div>

                                            <div class="flex-1">
                                                <p class="font-semibold text-white leading-8 text-[20px]">
                                                    {{ $question->question_text }}
                                                </p>
                                            </div>
                                        </div>

                                        @if($type === \App\Enums\QuestionGroupType::TRUE_FALSE_NOT_GIVEN->value)
                                            <div class="flex flex-wrap gap-3">
                                                <label class="inline-flex items-center gap-2 px-4 py-3 rounded-2xl border border-white/10 bg-white/5 text-slate-200 cursor-pointer hover:bg-white/10 transition">
                                                    <input type="radio" name="answers[{{ $question->id }}]" value="TRUE">
                                                    <span class="font-medium">TRUE</span>
                                                </label>

                                                <label class="inline-flex items-center gap-2 px-4 py-3 rounded-2xl border border-white/10 bg-white/5 text-slate-200 cursor-pointer hover:bg-white/10 transition">
                                                    <input type="radio" name="answers[{{ $question->id }}]" value="FALSE">
                                                    <span class="font-medium">FALSE</span>
                                                </label>

                                                <label class="inline-flex items-center gap-2 px-4 py-3 rounded-2xl border border-white/10 bg-white/5 text-slate-200 cursor-pointer hover:bg-white/10 transition">
                                                    <input type="radio" name="answers[{{ $question->id }}]" value="NOT GIVEN">
                                                    <span class="font-medium">NOT GIVEN</span>
                                                </label>
                                            </div>
                                        @elseif($type === \App\Enums\QuestionGroupType::YES_NO_NOT_GIVEN->value)
                                            <div class="flex flex-wrap gap-3">
                                                <label class="inline-flex items-center gap-2 px-4 py-3 rounded-2xl border border-white/10 bg-white/5 text-slate-200 cursor-pointer hover:bg-white/10 transition">
                                                    <input type="radio" name="answers[{{ $question->id }}]" value="YES">
                                                    <span class="font-medium">YES</span>
                                                </label>

                                                <label class="inline-flex items-center gap-2 px-4 py-3 rounded-2xl border border-white/10 bg-white/5 text-slate-200 cursor-pointer hover:bg-white/10 transition">
                                                    <input type="radio" name="answers[{{ $question->id }}]" value="NO">
                                                    <span class="font-medium">NO</span>
                                                </label>

                                                <label class="inline-flex items-center gap-2 px-4 py-3 rounded-2xl border border-white/10 bg-white/5 text-slate-200 cursor-pointer hover:bg-white/10 transition">
                                                    <input type="radio" name="answers[{{ $question->id }}]" value="NOT GIVEN">
                                                    <span class="font-medium">NOT GIVEN</span>
                                                </label>
                                            </div>
                                        @else
                                            <input type="text"
                                                   name="answers[{{ $question->id }}]"
                                                   class="border border-white/10 bg-white/5 text-slate-100 rounded-2xl w-full p-4 text-[16px] placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
                                                   placeholder="Write your answer here...">
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            <div class="sticky bottom-0 pt-5 bg-gradient-to-t from-slate-950 via-slate-950/95 to-transparent">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 p-4 rounded-2xl border border-white/10 bg-slate-900/80 backdrop-blur-xl shadow-sm">
                                    <p class="text-sm text-slate-400">
                                        Complete all practice answers before submitting.
                                    </p>

                                    <button type="submit"
                                            class="w-full sm:w-auto px-8 py-3.5 bg-sky-600 text-white rounded-2xl font-semibold hover:bg-sky-700 transition shadow-[0_10px_30px_rgba(14,165,233,0.25)]">
                                        Submit Practice
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection