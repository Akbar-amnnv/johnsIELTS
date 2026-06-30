@extends('layouts.admin')

@section('content')

    <h2 class="text-xl font-semibold mb-4">Create Reading Test</h2>

    <form method="POST" action="{{ route('reading-tests.store') }}"
          class="bg-white p-6 rounded shadow space-y-4">
        @csrf

        <div>
            <label class="block mb-1">Title</label>
            <input type="text"
                   name="title"
                   class="w-full border p-2 rounded"
                   required>
        </div>

        <div>
            <label class="block mb-1">Module Type</label>

            <select name="module_type"
                    class="w-full border p-2 rounded">
                <option value="academic">Academic</option>
                <option value="general">General</option>
            </select>
        </div>

        <div>
            <label class="block mb-1">Duration (minutes)</label>

            <input type="number"
                   name="duration_minutes"
                   value="60"
                   class="w-full border p-2 rounded"
                   required>
        </div>

        <div class="flex items-center gap-2">
            <input type="checkbox"
                   name="is_published"
                   value="1">

            <label>Published</label>
        </div>

        <button class="px-4 py-2 bg-green-600 text-white rounded">
            Save
        </button>
    </form>

@endsection