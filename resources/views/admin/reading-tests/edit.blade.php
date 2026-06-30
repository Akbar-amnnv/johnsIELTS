@extends('layouts.admin')

@section('content')

    <h2 class="text-xl font-semibold mb-4">Edit Reading Test</h2>

    <form method="POST"
          action="{{ route('reading-tests.update',$reading_test) }}"
          class="bg-white p-6 rounded shadow space-y-4">

        @csrf
        @method('PUT')

        <div>
            <label class="block mb-1">Title</label>

            <input type="text"
                   name="title"
                   value="{{ $reading_test->title }}"
                   class="w-full border p-2 rounded"
                   required>
        </div>

        <div>
            <label class="block mb-1">Module Type</label>

            <select name="module_type"
                    class="w-full border p-2 rounded">

                <option value="academic"
                        {{ $reading_test->module_type == 'academic' ? 'selected' : '' }}>
                    Academic
                </option>

                <option value="general"
                        {{ $reading_test->module_type == 'general' ? 'selected' : '' }}>
                    General
                </option>

            </select>
        </div>

        <div>
            <label class="block mb-1">Duration (minutes)</label>

            <input type="number"
                   name="duration_minutes"
                   value="{{ $reading_test->duration_minutes }}"
                   class="w-full border p-2 rounded">
        </div>

        <div class="flex items-center gap-2">
            <input type="checkbox"
                   name="is_published"
                   value="1"
                    {{ $reading_test->is_published ? 'checked' : '' }}>

            <label>Published</label>
        </div>

        <button class="px-4 py-2 bg-green-600 text-white rounded">
            Update
        </button>

    </form>

@endsection