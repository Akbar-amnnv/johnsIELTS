@extends('layouts.admin')

@section('content')

    <div class="max-w-3xl">

        <h2 class="text-xl font-semibold mb-4">

            Edit Question #{{ $question->question_number }}

        </h2>

        <form method="POST"
              action="{{ route('questions.update',[
$reading_test,
$passage,
$question_group,
$question
]) }}"
              class="bg-white p-6 rounded shadow space-y-4">

            @csrf
            @method('PUT')

            <div>

                <label class="block mb-2">Question Text</label>

                <textarea name="question_text"
                          rows="5"
                          class="w-full border p-2 rounded">

{{ old('question_text',$question->question_text) }}

</textarea>

            </div>

            <div>

                <label class="block mb-2">Paragraph</label>

                <select name="paragraph_id"
                        class="w-full border p-2 rounded">

                    <option value="">None</option>

                    @foreach($paragraphs as $p)

                        <option value="{{ $p->id }}"
                            {{ $question->paragraph_id == $p->id ? 'selected' : '' }}>

                            Paragraph {{ $p->label }}

                        </option>

                    @endforeach

                </select>

            </div>

            <div>

                <label class="block mb-2">Correct Answer</label>

                <input type="text"
                       name="correct_answer"
                       value="{{ old('correct_answer',$question->correct_answer) }}"
                       class="w-full border p-2 rounded">

            </div>

            <button class="px-4 py-2 bg-green-600 text-white rounded">

                Save

            </button>

        </form>

    </div>

@endsection
