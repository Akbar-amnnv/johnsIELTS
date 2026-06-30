@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Edit Speaking Topic</h1>

        <form action="{{ route('admin.speaking-topics.update', $speakingTopic) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.speaking-topics._form', ['buttonText' => 'Update Topic'])
        </form>
    </div>
@endsection