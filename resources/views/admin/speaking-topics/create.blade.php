@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Create Speaking Topic</h1>

        <form action="{{ route('admin.speaking-topics.store') }}" method="POST">
            @csrf
            @include('admin.speaking-topics._form', ['buttonText' => 'Create Topic'])
        </form>
    </div>
@endsection