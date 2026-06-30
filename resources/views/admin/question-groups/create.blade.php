@php

        use App\Enums\QuestionGroupType;

@endphp
@extends('layouts.admin')

@section('content')

    <h2 class="text-xl font-semibold mb-4">
        Create Question Group
    </h2>

    <form method="POST"
          action="{{ route('reading-tests.passages.question-groups.store',[$reading_test,$passage]) }}"
          class="bg-white p-6 rounded shadow space-y-4">

        @csrf

        <div>

            <label>Question Type

            <select name="type" class="w-full border rounded-lg p-2">
                @foreach(\App\Enums\QuestionGroupType::cases() as $type)

                    <option value="{{ $type->value }}"
                            {{ old('type', $questionGroup->type ?? '') === $type->value ? 'selected' : '' }}>

                        {{ $type->label() }}

                    </option>

                @endforeach
            </select>
            </label>
        </div>

        <div>

            <label>Instruction</label>

            <textarea name="instruction"
                      class="w-full border p-2 rounded"></textarea>

        </div>

        <div class="grid grid-cols-2 gap-4">

            <div>

                <label>Start Number</label>

                <input type="number"
                       name="start_number"
                       class="w-full border p-2 rounded">

            </div>

            <div>

                <label>End Number</label>

                <input type="number"
                       name="end_number"
                       class="w-full border p-2 rounded">

            </div>

        </div>

        <button class="px-4 py-2 bg-green-600 text-white rounded">

            Save

        </button>

    </form>

@endsection
