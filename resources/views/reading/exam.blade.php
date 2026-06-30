@extends('layouts.app')

@section('content')
    <style>
        .highlight-yellow {
            background-color: rgba(250, 204, 21, 0.35);
            padding: 0 3px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .highlight-green {
            background-color: rgba(74, 222, 128, 0.28);
            padding: 0 3px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .highlight-pink {
            background-color: rgba(244, 114, 182, 0.28);
            padding: 0 3px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .highlight-yellow:hover,
        .highlight-green:hover,
        .highlight-pink:hover {
            filter: brightness(1.08);
        }

        .question-card-active {
            border-color: rgba(96, 165, 250, 0.7) !important;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.16);
        }

        .navigator-active {
            box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.22);
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
            <form method="POST" action="{{ route('reading.submit', $reading_test) }}" id="examForm">
                @csrf
                <input type="hidden" name="time_left" id="time_left">

                <div class="grid grid-cols-1 2xl:grid-cols-[1.08fr_1.42fr] xl:grid-cols-[1fr_1.25fr] gap-5">

                    {{-- LEFT SIDE: PASSAGE --}}
                    <div class="glass-panel rounded-3xl border border-white/10 shadow-[0_20px_60px_rgba(0,0,0,0.45)] h-[88vh] overflow-hidden flex flex-col">
                        <div class="sticky top-0 z-10 bg-slate-900/85 backdrop-blur-xl border-b border-white/10 px-6 py-4">
                            <div class="flex flex-col gap-4">
                                <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-3">
                                    <div>
                                        <h2 class="text-[30px] leading-none font-bold text-white">Reading Passage</h2>
                                        <p class="text-sm text-slate-400 mt-2">
                                            Focus mode enabled. Highlight key clues as you read.
                                        </p>
                                    </div>

                                    <div class="flex flex-wrap items-center gap-2">
                                        <button type="button"
                                                onclick="highlightSelection('yellow')"
                                                class="inline-flex items-center px-4 py-2 rounded-full bg-yellow-400/20 text-yellow-200 border border-yellow-300/20 text-sm font-semibold hover:bg-yellow-400/30 transition">
                                            Yellow
                                        </button>

                                        <button type="button"
                                                onclick="highlightSelection('green')"
                                                class="inline-flex items-center px-4 py-2 rounded-full bg-emerald-400/20 text-emerald-200 border border-emerald-300/20 text-sm font-semibold hover:bg-emerald-400/30 transition">
                                            Green
                                        </button>

                                        <button type="button"
                                                onclick="highlightSelection('pink')"
                                                class="inline-flex items-center px-4 py-2 rounded-full bg-pink-400/20 text-pink-200 border border-pink-300/20 text-sm font-semibold hover:bg-pink-400/30 transition">
                                            Pink
                                        </button>

                                        <button type="button"
                                                onclick="clearAllHighlights()"
                                                class="inline-flex items-center px-4 py-2 rounded-full bg-white/10 text-slate-200 border border-white/10 text-sm font-semibold hover:bg-white/15 transition">
                                            Clear All
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="passage-content" class="flex-1 overflow-y-auto custom-scroll px-7 py-6 text-slate-200 select-text">
                            @foreach($reading_test->passages as $passage)
                                <div class="mb-10">
                                    <div class="mb-5">
                                        <h3 class="text-[26px] font-bold text-white mb-3 leading-tight">
                                            {{ $passage->title }}
                                        </h3>

                                        @if($passage->instruction)
                                            <p class="text-[15px] text-slate-400 leading-7">
                                                {{ $passage->instruction }}
                                            </p>
                                        @endif
                                    </div>

                                    <div class="space-y-5">
                                        @foreach($passage->paragraphs as $paragraph)
                                            <div class="rounded-2xl border border-white/10 bg-white/5 px-6 py-5">
                                                <p class="text-[20px] leading-10 text-slate-200">
                                                    <span class="inline-flex items-center justify-center min-w-[38px] h-9 px-3 mr-3 rounded-full bg-sky-500/20 text-sky-200 border border-sky-300/20 text-sm font-bold align-middle">
                                                        {{ $paragraph->label }}
                                                    </span>
                                                    {{ $paragraph->content }}
                                                </p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- RIGHT SIDE: QUESTIONS --}}
                    <div class="glass-panel rounded-3xl border border-white/10 shadow-[0_20px_60px_rgba(0,0,0,0.45)] h-[88vh] overflow-hidden flex flex-col">
                        <div class="sticky top-0 z-10 bg-slate-900/90 backdrop-blur-xl border-b border-white/10 px-6 py-4">
                            <div class="flex flex-col gap-4">
                                <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-3">
                                    <div>
                                        <h2 class="text-[30px] leading-none font-bold text-white">Reading Exam</h2>
                                        <p class="text-sm text-slate-400 mt-2">
                                            Stay sharp. Move fast, but answer precisely.
                                        </p>
                                    </div>

                                    <div class="flex flex-wrap items-center gap-2">
                                        <div id="timer-box"
                                             class="px-4 py-2 bg-rose-500/15 text-rose-200 rounded-xl border border-rose-400/20 font-bold text-base w-fit shadow-sm">
                                            <span class="text-xs uppercase tracking-wide opacity-80 mr-1">Time</span>
                                            <span id="timer"></span>
                                        </div>

                                        <div class="px-4 py-2 rounded-xl border border-emerald-400/15 bg-emerald-500/10 text-emerald-200 font-semibold text-sm">
                                            Answered: <span id="answered-count">0</span>
                                        </div>

                                        <div class="px-4 py-2 rounded-xl border border-amber-400/15 bg-amber-500/10 text-amber-200 font-semibold text-sm">
                                            Left: <span id="remaining-count">0</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="rounded-2xl border border-white/10 bg-white/5 p-3">
                                    <div class="flex items-center justify-between gap-3 mb-3">
                                        <h3 class="text-xs font-bold uppercase tracking-[0.18em] text-slate-300">
                                            Question Navigator
                                        </h3>
                                        <div class="text-xs text-slate-400">
                                            Total: <span id="total-count">0</span>
                                        </div>
                                    </div>

                                    <div class="flex flex-wrap gap-2">
                                        @foreach($reading_test->passages as $passage)
                                            @foreach($passage->questionGroups as $group)
                                                @foreach($group->questions as $question)
                                                    <button type="button"
                                                            onclick="scrollToQuestion({{ $question->id }})"
                                                            id="nav-{{ $question->id }}"
                                                            class="w-9 h-9 rounded-lg bg-white/10 text-slate-200 border border-white/10 text-sm font-bold hover:bg-white/15 transition">
                                                        {{ $question->question_number }}
                                                    </button>
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex-1 overflow-y-auto custom-scroll px-6 py-5">
                            @foreach($reading_test->passages as $passage)
                                @foreach($passage->questionGroups as $group)
                                    <div class="mb-8">
                                        <div class="mb-4 p-4 rounded-2xl bg-sky-500/10 border border-sky-400/15">
                                            <p class="font-semibold text-sky-100 leading-7 text-[15px]">
                                                {{ $group->instruction }}
                                            </p>
                                        </div>

                                        <div class="space-y-4">
                                            @foreach($group->questions as $question)
                                                <div id="question-{{ $question->id }}"
                                                     class="question-card border border-white/10 rounded-2xl p-5 bg-white/5 shadow-sm scroll-mt-28 transition"
                                                     data-question-id="{{ $question->id }}">
                                                    <div class="flex items-start gap-4 mb-4">
                                                        <div class="shrink-0 w-11 h-11 rounded-xl bg-sky-500/15 text-sky-200 border border-sky-300/20 flex items-center justify-center text-sm font-bold">
                                                            {{ $question->question_number }}
                                                        </div>

                                                        <div class="flex-1">
                                                            <label class="block font-semibold text-white leading-8 text-[20px]">
                                                                {{ $question->question_text }}
                                                            </label>
                                                        </div>
                                                    </div>

                                                    @if(in_array($group->type, ['true_false_not_given', 'true-false-not-given', 'tfng']))
                                                        <div class="mt-3 flex flex-wrap gap-3">
                                                            <label class="inline-flex items-center gap-2 px-4 py-3 rounded-2xl border border-white/10 bg-white/5 text-slate-200 cursor-pointer hover:bg-white/10 transition">
                                                                <input type="radio"
                                                                       name="answers[{{ $question->id }}]"
                                                                       value="TRUE"
                                                                       onchange="markAnswered({{ $question->id }})">
                                                                <span class="font-medium">TRUE</span>
                                                            </label>

                                                            <label class="inline-flex items-center gap-2 px-4 py-3 rounded-2xl border border-white/10 bg-white/5 text-slate-200 cursor-pointer hover:bg-white/10 transition">
                                                                <input type="radio"
                                                                       name="answers[{{ $question->id }}]"
                                                                       value="FALSE"
                                                                       onchange="markAnswered({{ $question->id }})">
                                                                <span class="font-medium">FALSE</span>
                                                            </label>

                                                            <label class="inline-flex items-center gap-2 px-4 py-3 rounded-2xl border border-white/10 bg-white/5 text-slate-200 cursor-pointer hover:bg-white/10 transition">
                                                                <input type="radio"
                                                                       name="answers[{{ $question->id }}]"
                                                                       value="NOT GIVEN"
                                                                       onchange="markAnswered({{ $question->id }})">
                                                                <span class="font-medium">NOT GIVEN</span>
                                                            </label>
                                                        </div>
                                                    @elseif($group->type === 'multiple_choice')
                                                        <select name="answers[{{ $question->id }}]"
                                                                class="border border-white/10 bg-white/5 text-slate-100 rounded-2xl w-full p-4 text-[16px] focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
                                                                onchange="markAnswered({{ $question->id }})">
                                                            <option value="" class="text-slate-900">Select an option</option>
                                                            @foreach($question->options->sortBy('sort_order') as $option)
                                                                <option value="{{ $option->label }}" class="text-slate-900">
                                                                    {{ $option->label }}. {{ $option->content }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    @elseif($group->type === 'summary_completion')
                                                        <select name="answers[{{ $question->id }}]"
                                                                class="border border-white/10 bg-white/5 text-slate-100 rounded-2xl w-full p-4 text-[16px] focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
                                                                onchange="markAnswered({{ $question->id }})">
                                                            <option value="" class="text-slate-900">Select an option</option>
                                                            @foreach($question->options->sortBy('sort_order') as $option)
                                                                <option value="{{ $option->label }}" class="text-slate-900">
                                                                    {{ $option->label }}. {{ $option->content }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    @elseif($group->type === 'yes_no_not_given')
                                                        <div class="mt-3 flex flex-wrap gap-3">
                                                            <label class="inline-flex items-center gap-2 px-4 py-3 rounded-2xl border border-white/10 bg-white/5 text-slate-200 cursor-pointer hover:bg-white/10 transition">
                                                                <input type="radio"
                                                                       name="answers[{{ $question->id }}]"
                                                                       value="YES"
                                                                       onchange="markAnswered({{ $question->id }})">
                                                                <span class="font-medium">YES</span>
                                                            </label>

                                                            <label class="inline-flex items-center gap-2 px-4 py-3 rounded-2xl border border-white/10 bg-white/5 text-slate-200 cursor-pointer hover:bg-white/10 transition">
                                                                <input type="radio"
                                                                       name="answers[{{ $question->id }}]"
                                                                       value="NO"
                                                                       onchange="markAnswered({{ $question->id }})">
                                                                <span class="font-medium">NO</span>
                                                            </label>

                                                            <label class="inline-flex items-center gap-2 px-4 py-3 rounded-2xl border border-white/10 bg-white/5 text-slate-200 cursor-pointer hover:bg-white/10 transition">
                                                                <input type="radio"
                                                                       name="answers[{{ $question->id }}]"
                                                                       value="NOT GIVEN"
                                                                       onchange="markAnswered({{ $question->id }})">
                                                                <span class="font-medium">NOT GIVEN</span>
                                                            </label>
                                                        </div>
                                                    @else
                                                        <input type="text"
                                                               name="answers[{{ $question->id }}]"
                                                               class="border border-white/10 bg-white/5 text-slate-100 rounded-2xl w-full p-4 text-[16px] placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
                                                               placeholder="Write your answer here..."
                                                               oninput="markAnswered({{ $question->id }})">
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            @endforeach

                            <div class="sticky bottom-0 pt-5 bg-gradient-to-t from-slate-950 via-slate-950/95 to-transparent">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 p-4 rounded-2xl border border-white/10 bg-slate-900/80 backdrop-blur-xl shadow-sm">
                                    <p class="text-sm text-slate-400">
                                        Review your answers before locking in the final submission.
                                    </p>

                                    <button type="submit"
                                            class="w-full sm:w-auto px-8 py-3.5 bg-sky-600 text-white rounded-2xl font-semibold hover:bg-sky-700 transition shadow-[0_10px_30px_rgba(14,165,233,0.25)]">
                                        Submit Test
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <script>
        let totalTime = {{ $reading_test->duration_minutes * 60 }};

        const timerEl = document.getElementById('timer');
        const timerBox = document.getElementById('timer-box');
        const hiddenTimeEl = document.getElementById('time_left');
        const examForm = document.getElementById('examForm');

        function updateTimerDisplay() {
            const minutes = Math.floor(totalTime / 60);
            const seconds = totalTime % 60;

            timerEl.textContent =
                String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');

            hiddenTimeEl.value = totalTime;

            timerBox.classList.remove(
                'bg-rose-500/15', 'text-rose-200', 'border-rose-400/20',
                'bg-amber-500/15', 'text-amber-200', 'border-amber-400/20',
                'bg-red-500/20', 'text-red-100', 'border-red-400/25'
            );

            if (totalTime <= 60) {
                timerBox.classList.add('bg-red-500/20', 'text-red-100', 'border-red-400/25');
            } else if (totalTime <= 300) {
                timerBox.classList.add('bg-amber-500/15', 'text-amber-200', 'border-amber-400/20');
            } else {
                timerBox.classList.add('bg-rose-500/15', 'text-rose-200', 'border-rose-400/20');
            }
        }

        updateTimerDisplay();

        const countdown = setInterval(() => {
            totalTime--;

            if (totalTime <= 0) {
                totalTime = 0;
                updateTimerDisplay();
                clearInterval(countdown);

                alert('Time is up! Your test will be submitted automatically.');
                examForm.submit();
                return;
            }

            updateTimerDisplay();
        }, 1000);

        function scrollToQuestion(id) {
            const el = document.getElementById('question-' + id);

            document.querySelectorAll('.question-card').forEach((card) => {
                card.classList.remove('question-card-active');
            });

            document.querySelectorAll('[id^="nav-"]').forEach((nav) => {
                nav.classList.remove('navigator-active');
            });

            if (el) {
                el.classList.add('question-card-active');

                const nav = document.getElementById('nav-' + id);
                if (nav) {
                    nav.classList.add('navigator-active');
                }

                el.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }
        }

        function updateProgress() {
            const totalQuestions = document.querySelectorAll('[id^="nav-"]').length;
            let answeredQuestions = 0;

            document.querySelectorAll('[id^="nav-"]').forEach((nav) => {
                if (nav.classList.contains('bg-emerald-500')) {
                    answeredQuestions++;
                }
            });

            document.getElementById('total-count').textContent = totalQuestions;
            document.getElementById('answered-count').textContent = answeredQuestions;
            document.getElementById('remaining-count').textContent = totalQuestions - answeredQuestions;
        }

        function markAnswered(id) {
            const nav = document.getElementById('nav-' + id);
            if (!nav) return;

            const inputs = document.querySelectorAll('[name="answers[' + id + ']"]');
            let answered = false;

            inputs.forEach((input) => {
                if ((input.type === 'radio' || input.type === 'checkbox') && input.checked) {
                    answered = true;
                } else if (input.type !== 'radio' && input.type !== 'checkbox' && input.value.trim() !== '') {
                    answered = true;
                }
            });

            nav.classList.remove(
                'bg-white/10', 'text-slate-200', 'border-white/10',
                'bg-emerald-500', 'text-white', 'border-emerald-400'
            );

            if (answered) {
                nav.classList.add('bg-emerald-500', 'text-white', 'border-emerald-400');
            } else {
                nav.classList.add('bg-white/10', 'text-slate-200', 'border-white/10');
            }

            updateProgress();
        }

        function highlightSelection(color) {
            const selection = window.getSelection();

            if (!selection.rangeCount) return;

            const range = selection.getRangeAt(0);

            if (selection.toString().trim() === '') return;

            const span = document.createElement('span');

            if (color === 'yellow') {
                span.className = 'highlight-yellow';
            } else if (color === 'green') {
                span.className = 'highlight-green';
            } else if (color === 'pink') {
                span.className = 'highlight-pink';
            }

            span.setAttribute('onclick', 'removeHighlight(this)');

            try {
                range.surroundContents(span);
                selection.removeAllRanges();
            } catch (e) {
                alert('Please select text within a single paragraph only.');
            }
        }

        function removeHighlight(element) {
            const parent = element.parentNode;

            while (element.firstChild) {
                parent.insertBefore(element.firstChild, element);
            }

            parent.removeChild(element);
            parent.normalize();
        }

        function clearAllHighlights() {
            const container = document.getElementById('passage-content');

            const highlights = container.querySelectorAll(
                '.highlight-yellow, .highlight-green, .highlight-pink'
            );

            highlights.forEach((el) => {
                const parent = el.parentNode;

                while (el.firstChild) {
                    parent.insertBefore(el.firstChild, el);
                }

                parent.removeChild(el);
                parent.normalize();
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            updateProgress();
        });
    </script>
@endsection