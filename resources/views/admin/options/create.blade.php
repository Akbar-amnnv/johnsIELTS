@extends('layouts.admin')

@section('content')

    <h2 class="text-xl font-semibold mb-4">

        Create Option

    </h2>

    <form method="POST"
          action="{{ route('options.store',$question) }}"
          class="bg-white p-6 rounded shadow space-y-4">

        @csrf

        <div>

            <label>Label</label>

            <input type="text"
                   name="label"
                   class="w-full border p-2 rounded"
                   placeholder="A / B / C / D">

        </div>

        <div>

            <label>Content</label>

            <textarea name="content"
                      class="w-full border p-2 rounded"></textarea>

        </div>

        <button class="px-4 py-2 bg-green-600 text-white rounded">

            Save

        </button>

    </form>

@endsection
