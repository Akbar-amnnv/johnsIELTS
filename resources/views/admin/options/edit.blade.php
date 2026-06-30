@extends('layouts.admin')

@section('content')

    <h2 class="text-xl font-semibold mb-4">

        Edit Option

    </h2>

    <form method="POST"
          action="{{ route('options.update',$option) }}"
          class="bg-white p-6 rounded shadow space-y-4">

        @csrf
        @method('PUT')

        <div>

            <label>Label</label>

            <input type="text"
                   name="label"
                   value="{{ $option->label }}"
                   class="w-full border p-2 rounded">

        </div>

        <div>

            <label>Content</label>

            <textarea name="content"
                      class="w-full border p-2 rounded">

{{ $option->content }}

</textarea>

        </div>

        <button class="px-4 py-2 bg-green-600 text-white rounded">

            Update

        </button>

    </form>

@endsection
