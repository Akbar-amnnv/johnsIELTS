<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>John's Ielts</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900 min-h-screen">

<header class="border-b bg-white">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-blue-700">John's Ielts</h1>
            <p class="text-sm text-gray-500">IELTS Reading Practice Platform</p>
        </div>

        <nav class="flex items-center gap-3">
            @auth
                <a href="{{ route('dashboard') }}"
                   class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}"
                   class="px-4 py-2 text-gray-700 hover:text-blue-700">
                    Log in
                </a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                       class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Register
                    </a>
                @endif
            @endauth
        </nav>
    </div>
</header>

<main class="max-w-7xl mx-auto px-6 py-16">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
        <div>
                <span class="inline-block px-3 py-1 text-sm bg-blue-100 text-blue-700 rounded-full mb-4">
                    Build confidence for IELTS
                </span>

            <h2 class="text-4xl lg:text-5xl font-bold leading-tight mb-6">
                Practice IELTS Reading with a clean, focused exam experience
            </h2>

            <p class="text-lg text-gray-600 mb-8 leading-8">
                John's Ielts helps learners practice reading passages, answer questions,
                review results, and improve step by step with a structured exam-style layout.
            </p>

            <div class="flex flex-wrap gap-4">
                @auth
                    <a href="{{ route('dashboard') }}"
                       class="px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700">
                        Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700">
                        Start Practicing
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="px-6 py-3 bg-white border border-gray-300 rounded-xl hover:bg-gray-100">
                            Create Account
                        </a>
                    @endif
                @endauth
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-200">
            <h3 class="text-2xl font-semibold mb-6">What you can do</h3>

            <div class="space-y-4">
                <div class="p-4 rounded-xl bg-gray-50 border">
                    <h4 class="font-semibold text-gray-800">Reading Tests</h4>
                    <p class="text-sm text-gray-600 mt-1">
                        Practice full reading tests with passages and structured questions.
                    </p>
                </div>

                <div class="p-4 rounded-xl bg-gray-50 border">
                    <h4 class="font-semibold text-gray-800">Detailed Results</h4>
                    <p class="text-sm text-gray-600 mt-1">
                        View correct answers, band estimates, and your test history.
                    </p>
                </div>

                <div class="p-4 rounded-xl bg-gray-50 border">
                    <h4 class="font-semibold text-gray-800">Focused Learning</h4>
                    <p class="text-sm text-gray-600 mt-1">
                        Improve accuracy through review mode and future question-type practice.
                    </p>
                </div>
            </div>
        </div>
    </div>
</main>

</body>
</html>